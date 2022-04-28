<?php
declare(strict_types=1);

namespace App\Catalog\Value;

use Exception;

final class Amount
{
    private int $cents;

    public function __construct(int $cents)
    {
        if ($cents < 0) {
            throw new Exception('Money amount cannot be below zero: ' . $cents);
        }
        $this->cents = $cents;
    }

    public function getCents(): int
    {
        return $this->cents;
    }
}
