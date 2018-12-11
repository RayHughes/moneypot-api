<?php

namespace MoneyPot\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\RequestException;

class Api
{
    CONST BASE_URI = 'https://api.moneypot.com/v2/';
    CONST TIMEOUT = 3.0;

    /** @var string $appSecret */
    private $appSecret;

    /** @var int $appId */
    private $appId;

    /** @var $int|null $authId */
    private $authId;

    /** @var Client $client */
    private $client;

    /**
     * @param string $appSecret
     * @param int $appId
     * @param int|null $authId
     */
    public function __construct(string $appSecret, int $appId, $authId = null)
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
     * @param string $route
     * @param string $method
     * @param array $payload
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function sendPayload(string $route, string $method = 'GET', array $payload = [])
    {
        try {
            $response = $this->client->request($method, $route, [
                'query' => [
                    'app_id' => $this->appId,
                    'app_secret' => $this->appSecret,
                    'auth_id' => $this->authId,
                ],
                'json' => $payload,
            ]);

            return json_decode($response->getBody()->getContents());
        } catch(BadResponseException $e) {
            $response = $e->getResponse();

            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            return $e->getMessage();
        }
    }
}