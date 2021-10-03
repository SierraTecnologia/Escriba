<?php

namespace Escritor\Models;

class Currency
{
    public $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString()
    {
        return $this->value;
    }

    public function toHtml(): string
    {
        return number_format($this->value * 0.01, 2, '.', '');
    }

    public function integer(): int
    {
        return (int) $this->value;
    }

    /**
     * @return static
     */
    public function add($money): self
    {
        $this->value += $money;

        return $this;
    }
}
