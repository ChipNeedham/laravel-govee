<?php

namespace Chipneedham\LaravelGovee\Models;

// Represents a single device

use Chipneedham\LaravelGovee\GoveeApiClient;
use GuzzleHttp\Exception\GuzzleException;

class Device
{
    protected GoveeApiClient $client; // To make API calls
    public string $deviceId;  // API: "device"
    public string $name;      // API: "deviceName"
    public string $model;     // API: "model"
    public bool $controllable; // API: "controllable"
    public bool $retrievable;  // API: "retrievable"
    public array $supportedCommands; // API: "supportCmds"

    public function __construct(GoveeApiClient $client, array $data)
    {
        $this->client = $client;
        $this->deviceId = $data['device'] ?? null;
        $this->name = $data['deviceName'] ?? null;
        $this->model = $data['model'] ?? null;
        $this->controllable = $data['controllable'] ?? false;
        $this->retrievable = $data['retrievable'] ?? false;
        $this->supportedCommands = $data['supportCmds'] ?? [];
    }

    public function setPowerState(bool $on)
    {
        if (!$this->controllable || !in_array('turn', $this->supportedCommands)) {
            throw new \Exception("Device {$this->deviceId} cannot be turned ".$on ? 'on.' : 'off.');
        }

        return $this->client->controlDevice($this, [
            'name' => 'turn',
            'value' => $on ? 'on' : 'off',
        ]);
    }
}