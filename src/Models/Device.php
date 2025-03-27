<?php

namespace Chipneedham\LaravelGovee\Models;

// Represents a single device
class Device {
    public string $device;
    public string $model;
    public string $deviceName;
    public bool $controllable;
    public Properties $properties;
    public bool $retrievable;
    /** @var string[] */
    public array $supportCmds;

    public function __construct(
        string $device,
        string $model,
        string $deviceName,
        bool $controllable,
        Properties $properties,
        bool $retrievable,
        array $supportCmds
    ) {
        $this->device = $device;
        $this->model = $model;
        $this->deviceName = $deviceName;
        $this->controllable = $controllable;
        $this->properties = $properties;
        $this->retrievable = $retrievable;
        $this->supportCmds = $supportCmds;
    }
}