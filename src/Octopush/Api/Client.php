<?php

namespace Octopush\Api;

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

    public function setSmsSender($smsSender)
    {
        $this->smsSender = $smsSender;
    }

    public function set_date($y, $m, $d, $h, $i)
    {
        $sms_y = intval($y);
        $sms_d = intval($d);
        $sms_m = intval($m);
        $sms_h = intval($h);
        $sms_i = intval($i);

        $this->sendingTime = mktime($sms_h, $sms_i, 0, $sms_m, $sms_d, $sms_y);
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
            $data['request_sha1'] = $this->_get_request_sha1_string($data);
        }

        return trim($this->_httpRequest('/api/sms', $data));
    }

    public function getCredit()
    {
        $data = [
            'user_login' => $this->userLogin,
            'api_key' => $this->apiKey,
        ];

        return trim($this->_httpRequest('/api/credit', $data));
    }

    private function _get_request_sha1_string($data)
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

    private function _httpRequest($path, array $fields)
    {
        set_time_limit(0);
        $qs = [];
        foreach ($fields as $k => $v) {
            $qs[] = $k.'='.urlencode($v);
        }

        $request = implode('&', $qs);

        if (function_exists('curl_init') and $ch = curl_init(self::BASE_URL.$path)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_PORT, 80);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } elseif (ini_get('allow_url_fopen')) {
            $errno = $errstr = null;
            $fp = fsockopen(self::BASE_URL, 80, $errno, $errstr, 100);
            if ($errno != '' || $errstr != '') {
                echo 'errno : '.$errno;
                echo "\n";
                echo 'errstr : '.$errstr;
            }
            if (!$fp) {
                echo 'Unable to connect to host. Try again later.';

                return;
            }
            $header = 'POST '.$path." HTTP/1.1\r\n";
            $header .= 'Host: '.self::BASE_URL."\r\n";
            $header .= "Accept: text\r\n";
            $header .= "User-Agent: Octopush\r\n";
            $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $header .= 'Content-Length: '.strlen($request)."\r\n";
            $header .= "Connection: close\r\n\r\n";
            $header .= "{$request}\r\n\r\n";

            fputs($fp, $header);
            $result = '';
            while (!feof($fp)) {
                $result .= fgets($fp, 1024);
            }
            fclose($fp);

            $clear_result = substr($result, strpos($result, "\r\n\r\n") + 4);

            return $clear_result;
        } else {
            die('Server does not support HTTP(S) requests.');
        }
    }
}
