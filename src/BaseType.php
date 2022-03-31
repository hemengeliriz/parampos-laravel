<?php

namespace Hemengeliriz\ParamposLaravel;

abstract class BaseType
{
    /** @var array */
    protected array $properties = [];

    public function __construct(array $properties = [])
    {
        $this->properties = $properties;
    }

    public function setProperty(string $property, $value): static
    {
        if ($value !== null && $value !== '') {
            $this->properties[$property] = $value;
        }

        return $this;
    }

    public function addProperties(array $properties): static
    {
        foreach ($properties as $property => $value) {
            $this->setProperty($property, $value);
        }

        return $this;
    }

    public function getProperty(string $property, $default = null)
    {
        return $this->properties[$property] ?? $default;
    }

    public function getProperties($properties = []): array
    {
        if (empty($properties)) {
            return $this->properties;
        }

        $result = [];
        foreach ($properties as $property) {
            $result[$property] = $this->getProperty($property);
        }
        return $result;
    }
}
