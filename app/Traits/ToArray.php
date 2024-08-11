<?php

namespace App\Traits;

use DragonCode\Support\Facades\Helpers\Str;

trait ToArray
{
    public function toArray(): array
    {
        $result = [];

        $reflectionClass = new \ReflectionClass($this);

        $properties = $reflectionClass->getProperties();

        foreach ($properties as $property) {
            $key = $property->getName();

            $value = $property->getValue($this);

            $result[$key] = $value;
        }

        return $result;
    }
    public function toArrayAsSnakeCase(): array
    {
        $result = [];

        foreach ($this->toArray() as $key => $value) {
            $result[Str::snake($key)] = $value;
        }

        return $result;
    }
}
