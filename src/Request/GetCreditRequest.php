<?php

declare(strict_types=1);

namespace Octopush\Request;

use Octopush\Constant\HttpMethodEnum;

class GetCreditRequest extends BaseRequest
{
    private const URI = 'wallet/check-balance';

    /** @var string */
    private $productName;

    /** @var string */
    private $countryCode;

    /** @var bool */
    private $withDetails;

    public function __construct()
    {
        $this->method = HttpMethodEnum::GET;
        $this->uri = self::URI;
    }

    /**
     * @return array
     */
    public function getQueryArray(): array
    {
        $parameters = [
            'query' => [
                'product_name' => $this->productName,
                'country_code' => $this->countryCode,
            ],
        ];

        if ($this->withDetails) {
            $parameters['query']['with_details'] = $this->withDetails;
        }

        return $this->filterQueryString($parameters);
    }

    /**
     * @return string
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     */
    public function setProductName(string $productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return bool
     */
    public function isWithDetails(): bool
    {
        return $this->withDetails;
    }

    /**
     * @param bool $withDetails
     */
    public function setWithDetails(bool $withDetails)
    {
        $this->withDetails = $withDetails;
    }
}