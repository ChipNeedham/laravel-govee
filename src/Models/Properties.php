<?php

namespace Chipneedham\LaravelGovee\Models;

// Represents the "properties" object
class Properties {
    public ColorTemp $colorTem;

    public function __construct(ColorTemp $colorTem) {
        $this->colorTem = $colorTem;
    }
}