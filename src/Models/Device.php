<?php

namespace Chipneedham\LaravelGovee\Models;

// Represents a single device

use Chipneedham\LaravelGovee\GoveeApiClient;
use GuzzleHttp\Exception\GuzzleException;

class Device
{
    protected GoveeApiClient $client; // To make API calls
    public string $deviceId;  // API: "device"
    public ?string $name;      // API: "deviceName"
    public string $model;     // API: "model"
    public bool $controllable; // API: "controllable"
    public bool $retrievable;  // API: "retrievable"
    public array $supportedCommands; // API: "supportCmds"

    public function __construct(GoveeApiClient $client, array $data)
    {
        $this->client = $client;
        $this->deviceId = $data['device'];
        $this->name = $data['deviceName'] ?? null;
        $this->model = $data['model'];
        $this->controllable = $data['controllable'] ?? false;
        $this->retrievable = $data['retrievable'] ?? false;
        $this->supportedCommands = $data['supportCmds'] ?? [];
    }

    public function setPowerState(bool $on)
    {
        return $this->client->controlDevice($this, [
            'name' => 'turn',
            'value' => $on ? 'on' : 'off',
        ]);
    }

    public function setBrightness(int $level)
    {
        if($level < 1 || $level > 100) {
            throw new \Exception("Brightness level must be between 1 and 100");
        }
        return $this->client->controlDevice($this, [
            'name' => 'brightness',
            'value' => $level,
        ]);
    }
}