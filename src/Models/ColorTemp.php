<?php
namespace Chipneedham\LaravelGovee\Models;

// Represents the "colorTem" object inside "properties"
class ColorTemp {
    public Range $range;

    public function __construct(Range $range) {
        $this->range = $range;
    }
}