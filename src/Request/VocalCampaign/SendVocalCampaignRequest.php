<?php

declare(strict_types=1);

namespace Octopush\Request\VocalCampaign;

use DateTime;
use DateTimeImmutable;
use Octopush\Constant\HttpMethodEnum;
use Octopush\Request\BaseRequest;

class SendVocalCampaignRequest extends BaseRequest
{
    public const WHOLESALE_TRANSACTIONAL = 'wholesale';
    public const ALERT_TRANSACTIONAL = 'alert';

    private const URI = 'vocal-campaign/send';

    /** @var array */
    private $recipients;

    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var string */
    private $purpose;

    /** @var string */
    private $sender;

    /** @var string */
    private $voiceGender;

    /** @var string */
    private $voiceLanguage;

    /** @var DateTimeImmutable */
    private $sendAt;

    public function __construct()
    {
        $this->method = HttpMethodEnum::POST;
        $this->uri = self::URI;
    }

    /**
     * @return array
     */
    public function getQueryArray(): array
    {
        $parameters = [
            'json' => [
                'recipients' => $this->recipients,
                'text' => $this->text,
                'type' => $this->type,
                'purpose' => $this->purpose,
                'sender' => $this->sender,
                'voice_gender' => $this->voiceGender,
                'voice_language' => $this->voiceLanguage,
                'send_at' => $this->sendAt->format(DateTime::ATOM),
            ],
        ];

        return $this->filterQueryString($parameters);
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     */
    public function setRecipients(array $recipients): void
    {
        $this->recipients = $recipients;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getPurpose(): string
    {
        return $this->purpose;
    }

    /**
     * @param string $purpose
     */
    public function setPurpose(string $purpose): void
    {
        $this->purpose = $purpose;
    }

    /**
     * @return string
     */
    public function getSender(): string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender): void
    {
        $this->sender = $sender;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getSendAt(): DateTimeImmutable
    {
        return $this->sendAt;
    }

    /**
     * @param DateTimeImmutable $sendAt
     */
    public function setSendAt(DateTimeImmutable $sendAt): void
    {
        $this->sendAt = $sendAt;
    }

    /**
     * @return string
     */
    public function getVoiceGender(): string
    {
        return $this->voiceGender;
    }

    /**
     * @param string $voiceGender
     */
    public function setVoiceGender(string $voiceGender): void
    {
        $this->voiceGender = $voiceGender;
    }

    /**
     * @return string
     */
    public function getVoiceLanguage(): string
    {
        return $this->voiceLanguage;
    }

    /**
     * @param string $voiceLanguage
     */
    public function setVoiceLanguage(string $voiceLanguage): void
    {
        $this->voiceLanguage = $voiceLanguage;
    }
}
