<?php

namespace Chipneedham\LaravelGovee;

use Chipneedham\LaravelGovee\Models\Device;
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
     * @return Device[]
     */
    public function getDevices(): array
    {
        $response = $this->client->get('v1/devices');
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['code'] !== 200 || !isset($data['data']['devices'])) {
            throw new \Exception('Failed to fetch devices: ' . ($data['message'] ?? 'Unknown error'));
        }

        return array_map(function ($deviceData) {
            return new Device($this, $deviceData);
        }, $data['data']['devices']);
    }

    /**
     * @throws GuzzleException
     */
    public function controlDevice(Device $device, array $command)
    {
        $response = $this->client->put('v1/devices/control', [
            'json' => [
                'device' => $device->deviceId,
                'model' => $device->model,
                'cmd' => $command,
            ],
        ]);
        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['code'] !== 200) {
            throw new \Exception('Control failed: ' . ($data['message'] ?? 'Unknown error'));
        }

        return $data;
    }
}