<?php

declare(strict_types=1);

namespace Octopush\Request\SmsCampaign;

use Octopush\Constant\HttpMethodEnum;
use Octopush\Request\BaseRequest;

class SendSmsCampaignRequest extends BaseRequest
{
    public const WHOLESALE_TRANSACTIONAL = 'wholesale';
    public const ALERT_TRANSACTIONAL = 'alert';

    private const URI = 'sms-campaign/send';

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

    /** @var bool */
    private $withReplies;

    /** @var string */
    private $sendAt;

    /** @var bool */
    private $simulationMode;

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
                'with_replies' => $this->withReplies,
                'send_at' => $this->sendAt,
                'simulation_mode' => $this->simulationMode
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
     * @return bool
     */
    public function isWithReplies(): bool
    {
        return $this->withReplies;
    }

    /**
     * @param bool $withReplies
     */
    public function setWithReplies(bool $withReplies): void
    {
        $this->withReplies = $withReplies;
    }

    /**
     * @return string
     */
    public function getSendAt(): string
    {
        return $this->sendAt;
    }

    /**
     * @param string $sendAt
     */
    public function setSendAt(string $sendAt): void
    {
        $this->sendAt = $sendAt;
    }

    /**
     * @return bool
     */
    public function getSimulationMode(): bool
    {
        return $this->simulationMode;
    }

    /**
     * @param bool $simulationMode
     */
    public function setSimulationMode(bool $simulationMode): void
    {
        $this->simulationMode = $simulationMode;
    }
}
