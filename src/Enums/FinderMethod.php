<?php

namespace App\Enums;

enum FinderMethod
{
    case For;
    case While;
    case ArrayFilter;
    case ArrayReduce;
    case ArrayWalk;
    case BinarySearch;
    case TernarySearch;
    case JumpSearch;
    case ExponentialSearch;

    public function needsSortedData(): bool
    {
        return match ($this) {
            self::ArrayFilter, self::ArrayReduce, self::ArrayWalk => false,
            default => true,
        };
    }
}
