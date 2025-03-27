<?php

namespace Chipneedham\LaravelGovee;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GoveeApiClient
{
    protected Client $client;
    protected string $apiKey;
    protected string $baseUrl = 'https://developer-api.govee.com/';

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => [
                    'Govee-API-Key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function getDevices()
    {
        $response = $this->client->get('v1/devices');
        return json_decode($response->getBody()->getContents());
    }
}