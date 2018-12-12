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

    /** @var int|null $appId */
    private $appId;

    /** @var int|null $authId */
    private $authId;

    /** @var Client $client */
    private $client;

    /**
     * @param string $appSecret
     * @param int|null $appId
     * @param int|null $authId
     */
    public function __construct(string $appSecret, ?int $authId = null, ?int $appId = null)
    {
        $this->appSecret = $appSecret;
        $this->appId = $appId;
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
    public function setAuthId(int $authId)
    {
        $this->authId = $authId;
    }

    /**
     * @param int $appId
     * @return void
     */
    public function setAppId(int $appId)
    {
        $this->appId = $appId;
    }

    /**
     * @param string $route
     * @param array $payload
     * @return mixed
     */
    public function post(string $route, array $payload = [])
    {
        return $this->sendPayload($route, self::POST_METHOD, $payload);
    }

    /**
     * @param string $route
     * @param array $payload
     * @return mixed
     */
    public function get(string $route, array $payload = [])
    {
        return $this->sendPayload($route, self::GET_METHOD, $payload);
    }

    /**
     * @param string $route
     * @param string $method
     * @param array $payload
     * @return mixed
     */
    private function sendPayload(string $route, string $method, array $payload)
    {
        $queryData = ['app_secret' => $this->appSecret];

        if ($this->authId) {
            $queryData['auth_id'] = $this->authId;
        }

        if ($this->appId) {
            $queryData['app_id'] = $this->appId;
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
                return $e->getMessage();
            };

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}