<?php

namespace Octopush\Api;

use Octopush\Api\Exception\RequestException;
use Octopush\Api\Exception\ResponseException;

/**
 * Octopush API client.
 */
class Client
{
    const BASE_URL = 'www.octopush-dm.com';

    const SMS_TYPE_LOWCOST = 'XXX';
    const SMS_TYPE_PREMIUM = 'FR';
    const SMS_TYPE_GLOBAL = 'WWW';

    const REQUEST_MODE_REAL = 'real';
    const REQUEST_MODE_SIMU = 'simu';

    /**
     * @var string
     */
    private $userLogin;

    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string self::SMS_TYPE_*
     */
    private $smsType = self::SMS_TYPE_GLOBAL;

    /**
     * @var array
     */
    private $smsRecipients = [];

    /**
     * @var int unix timestamp
     */
    private $sendingTime;

    /**
     * @var string
     */
    private $smsSender = 'OneSender';

    /**
     * @var string self::REQUEST_MODE_*
     */
    private $requestMode = self::REQUEST_MODE_REAL;

    /**
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

    public function setSimulationMode()
    {
        $this->requestMode = self::REQUEST_MODE_SIMU;
    }

    public function setRequestKeys($requestKeys)
    {
        $this->requestKeys = $requestKeys;
    }

    public function send($smsText)
    {
        $data = [
            'user_login' => $this->userLogin,
            'api_key' => $this->apiKey,
            'sms_text' => $smsText,
            'sms_recipients' => implode(',', $this->smsRecipients),
            'sms_type' => $this->smsType,
            'sms_sender' => $this->smsSender,
            'request_mode' => $this->requestMode,
        ];
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

        return $this->xml2array($result);
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
