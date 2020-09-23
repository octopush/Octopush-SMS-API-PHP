<?php

declare(strict_types=1);

namespace Octopush;

use GuzzleHttp\Exception\GuzzleException;
use Octopush\Request\BaseRequest;
use Psr\Http\Message\ResponseInterface;

class Client
{
    const BASE_URI = 'https://backend.octopush.com/v1/public';

    /** @var string */
    private $apiLogin;

    /** @var string */
    private $apiKey;

    /**
     * @param string $apiLogin
     * @param string $apiKey
     */
    public function __construct(string $apiLogin, string $apiKey)
    {
        $this->apiLogin = $apiLogin;
        $this->apiKey = $apiKey;
    }

    /**
     * @param BaseRequest $request
     *
     * @throws GuzzleException
     *
     * @return array
     */
    public function send(BaseRequest $request): array
    {
        $client = new \GuzzleHttp\Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'api-key' => $this->apiKey,
                'api-login' => $this->apiLogin
            ]
        ]);

        $response = $client->request(
            $request->getMethod(),
            self::BASE_URI . '/' . $request->getUri(),
            $request->getQueryArray()
        );

        return $this->getResponseContent($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return array
     */
    private function getResponseContent(ResponseInterface $response): array
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
