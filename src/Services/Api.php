<?php

namespace MoneyPot\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;

class Api
{
    const GET_METHOD = 'GET';

    const POST_METHOD = 'POST';

    const BASE_URI = 'https://api.moneypot.com/v2/';

    const TIMEOUT = 3.0;

    /** @var string $appSecret */
    private $appSecret;

    /** @var int|null $authId */
    private $authId;

    /** @var Client $client */
    private $client;

    /**
     * @param string $appSecret
     * @param int|null $authId
     */
    public function __construct(string $appSecret, ?int $authId = null)
    {
        $this->appSecret = $appSecret;
        $this->authId = $authId;

        $this->client = new Client([
            'base_uri' => self::BASE_URI,
            'timeout'  => self::TIMEOUT,
        ]);
    }

    /**
     * @param int $authId
     * @return void
     */
    public function setAuthId(int $authId): void
    {
        $this->authId = $authId;
    }

    /**
     * @param string $route
     * @param array $payload
     * @return array
     */
    public function post(string $route, array $payload = []): array
    {
        return $this->sendPayload($route, self::POST_METHOD, $payload);
    }

    /**
     * @param string $route
     * @param array $payload
     * @return array
     */
    public function get(string $route, array $payload = []): array
    {
        return $this->sendPayload($route, self::GET_METHOD, $payload);
    }

    /**
     * @param string $route
     * @param string $method
     * @param array $payload
     * @return array
     */
    private function sendPayload(string $route, string $method, array $payload): array
    {
        $queryData = ['app_secret' => $this->appSecret];

        if ($this->authId) {
            $queryData['auth_id'] = $this->authId;
        }

        try {
            $response = $this->client->request($method, $route, [
                'query' => $queryData,
                'json' => $payload,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch(BadResponseException $e) {
            $response = $e->getResponse();

            if (is_null($response)) {
                $response = ['error' => $e->getMessage()];

                return $response;
            };

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $response = ['error' => $e->getMessage()];

            return $response;
        }
    }
}