<?php

namespace Octopush\Api;

use Octopush\Api\Exception\RequestException;
use Octopush\Api\Exception\ResponseException;
use Octopush\Api\Exception\ResponseCodeException;

/**
 * Octopush API client.
 */
class Client
{
    const BASE_URL = 'www.octopush-dm.com';

    const SMS_TYPE_LOWCOST = 'XXX';
    const SMS_TYPE_PREMIUM = 'FR';
    const SMS_TYPE_GLOBAL = 'WWW';

    const SMS_MODE_INSTANT = 1;
    const SMS_MODE_DELAYED = 2;

    const REQUEST_MODE_REAL = 'real';
    const REQUEST_MODE_SIMU = 'simu';

    /**
     * User login (email address).
     *
     * @var string
     */
    private $userLogin;

    /**
     * API key available on your manager.
     *
     * @var string
     */
    private $apiKey;

    /**
     * @var string self::SMS_TYPE_*
     */
    private $smsType = self::SMS_TYPE_GLOBAL;

    /**
     * Numbers in international format + XXZZZZZ.
     *
     * @var array
     */
    private $smsRecipients = [];

    /**
     * @var int unix timestamp
     */
    private $sendingTime;

    /**
     * Sender of the message (if the user allows it), 3-11 alphanumeric characters (a-zA-Z).
     *
     * @var string
     */
    private $smsSender = 'OneSender';

    /**
     * Sending profile:
     *
     * self::SMS_MODE_INSTANT = Instant sending
     * self::SMS_MODE_DELAYED = Delayed sending (you must specify the date)
     *
     * @var int self::SMS_MODE_*
     */
    private $smsMode = self::SMS_MODE_INSTANT;

    /**
     * @var bool
     */
    private $withReplies = false;

    /**
     * Allows you to choose simulation mode.
     *
     * @var string self::REQUEST_MODE_*
     */
    private $requestMode = self::REQUEST_MODE_REAL;

    /**
     * Lists the key fields of the application you want to add in the sha1 hash.
     *
     * Example: 'TRYS' (for fields sms_text, sms_recipients, sms_type, sms_sender).
     *
     * @see SHA1 Request Codes on http://www.octopush.com/en/api-sms-doc/parameters
     *
     * @var string
     */
    private $requestKeys;

    public function __construct($userLogin, $apiKey)
    {
        $this->userLogin = $userLogin;
        $this->apiKey = $apiKey;
        $this->sendingTime = time();
    }

    public function setSmsType($smsType)
    {
        $this->smsType = $smsType;
    }

    public function setSmsRecipients(array $smsRecipients)
    {
        $this->smsRecipients = $smsRecipients;
    }

    public function setSendingTime($sendingTime)
    {
        $this->sendingTime = $sendingTime;
    }

    public function setSmsSender($smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function setSmsMode($smsMode)
    {
        $this->smsMode = $smsMode;
    }

    public function setWithReplies($withReplies = true)
    {
        $this->withReplies = $withReplies;
    }

    public function setSimulationMode()
    {
        $this->requestMode = self::REQUEST_MODE_SIMU;
    }

    public function setRequestKeys($requestKeys)
    {
        $this->requestKeys = $requestKeys;
    }

    /**
     * Sends a simple SMS.
     *
     * @param string $smsText Message text (maximum 459 characters).
     *
     * @return array
     *
     * @see http://www.octopush.com/en/api-sms-doc/sms-sendings
     */
    public function send($smsText)
    {
        $data = [
            'user_login' => $this->userLogin,
            'api_key' => $this->apiKey,
            'sms_text' => $smsText,
            'sms_recipients' => implode(',', $this->smsRecipients),
            'sms_type' => $this->smsType,
            'sms_sender' => $this->smsSender,
            'sms_mode' => $this->smsMode,
            'request_mode' => $this->requestMode,
        ];

        if ($this->withReplies) {
            $data['with_replies'] = 1;
        }

        if ($this->sendingTime > time()) {
            // GMT + 1 (Europe/Paris)
            $data['sending_time'] = $this->sendingTime;
        }

        // If needed, key must be computed
        if (null !== $this->requestKeys) {
            $data['request_keys'] = $this->requestKeys;
            $data['request_sha1'] = $this->getRequestSha1String($data);
        }

        return $this->httpRequest('/api/sms', $data);
    }

    /**
     * Returns credit balance as a number of Euros left on account.
     *
     * @return array
     *
     * @see http://www.octopush.com/en/api-sms-doc/get-credit
     */
    public function getCredit()
    {
        $data = [
            'user_login' => $this->userLogin,
            'api_key' => $this->apiKey,
        ];

        return $this->httpRequest('/api/credit', $data);
    }

    private function getRequestSha1String(array $data)
    {
        $charToField = [
            'T' => 'sms_text',
            'R' => 'sms_recipients',
            'Y' => 'sms_type',
            'S' => 'sms_sender',
            'D' => 'sms_date',
            'a' => 'recipients_first_names',
            'b' => 'recipients_last_names',
            'c' => 'sms_fields_1',
            'd' => 'sms_fields_2',
            'e' => 'sms_fields_3',
            'W' => 'with_replies',
            'N' => 'transactional',
            'Q' => 'request_id',
        ];

        $requestString = '';
        for ($i = 0, $n = strlen($this->requestKeys); $i < $n; ++$i) {
            $char = $this->requestKeys[$i];

            if (!isset($charToField[$char]) || !isset($data[$charToField[$char]])) {
                continue;
            }
            $requestString .= $data[$charToField[$char]];
        }

        return sha1($requestString);
    }

    private function httpRequest($path, array $fields)
    {
        set_time_limit(0);

        $qs = [];
        foreach ($fields as $k => $v) {
            $qs[] = $k.'='.urlencode($v);
        }

        $request = implode('&', $qs);

        if (false === $ch = curl_init(self::BASE_URL.$path)) {
            throw new RequestException(sprintf('Request initialization to "%s" failed.', $path));
        }

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_PORT, 80);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if (false === $result = curl_exec($ch)) {
            curl_close($ch);

            throw new ResponseException(sprintf(
                'Failed to get response from "%s". Response: %s.',
                $path,
                $result
            ));
        }

        if (200 !== $code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            throw new ResponseException(sprintf(
                'Server returned "%s" status code. Response: %s.',
                $code,
                $result
            ));
        }

        curl_close($ch);

        $result = $this->xml2array($result);

        if ('000' !== $result['error_code']) {
            throw new ResponseCodeException(sprintf(
                'Server returned "%s" error code. See error code list on http://www.octopush.com/en/errors_list.',
                $result['error_code']
            ), $result['error_code']);
        }

        return $result;
    }

    private function xml2array($xml)
    {
        $simpleXMLElement = simplexml_load_string($xml, 'SimpleXMLElement');
        if (false === $simpleXMLElement) {
            throw new ResponseException(sprintf(
                'Failed to parse response. Response: %s.',
                $xml
            ));
        }

        return json_decode(json_encode($simpleXMLElement), true);
    }
}
