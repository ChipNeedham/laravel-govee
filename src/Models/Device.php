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

    public function setColor(int $red, int $green, int $blue)
    {
        if($red < 0 || $red > 255 || $green < 0 || $green > 255 || $blue < 0 || $blue > 255) {
            throw new \Exception("Color values must be between 0 and 255");
        }
        return $this->client->controlDevice($this, [
            'name' => 'color',
            'value' => [
                'r' => $red,
                'g' => $green,
                'b' => $blue,
            ],
        ]);
    }

    public function setHexColor(string $hex)
    {
        $hex = ltrim($hex, '#');
        return $this->setColor(...$this->hexToRgb($hex));
    }

    private function hexToRgb(string $hex):array
    {
            // Remove the # if present
            $hex = ltrim($hex, '#');

            // Validate hex color format
            if (!preg_match('/^([0-9A-Fa-f]{3}){1,2}$/', $hex)) {
                throw new \Exception("Invalid hex color format");
            }

            // Handle 3-digit and 6-digit hex colors
            if (strlen($hex) === 3) {
                $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
            }

            // Convert hex to RGB
            return [
                hexdec(substr($hex, 0, 2)),   // Red
                hexdec(substr($hex, 2, 2)),   // Green
                hexdec(substr($hex, 4, 2))    // Blue
            ];


    }
}