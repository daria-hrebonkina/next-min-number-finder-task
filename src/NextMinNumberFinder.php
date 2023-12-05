<?php

namespace App;

use App\Enums\FinderMethod;

class NextMinNumberFinder
{
    private array $sortedDataset;
    public function __construct(private readonly array $dataset)
    {
    }

    public function __invoke(int $number, FinderMethod $method = FinderMethod::ExponentialSearch): int
    {
        $methodName = 'using' . $method->name;

        if ($method->needsSortedData()) {
            $this->sortedDataset = $this->dataset;
            sort($this->sortedDataset);
        }

        return $this->$methodName($number);
    }

    private function usingBinarySearch(int $number, int $left = null, int $right = null): int
    {
        $left ??= 0;
        $right ??= count($this->sortedDataset) - 1;
        $nextMin = -1;

        while ($left <= $right) {
            $mid = floor(($left + $right) / 2);

            if ($this->sortedDataset[$mid] < $number) {
                $nextMin = $this->sortedDataset[$mid];
                $left = $mid + 1;
            } else {
                $right = $mid - 1;
            }
        }

        return $nextMin;
    }

    private function usingTernarySearch(int $number): int
    {
        $left = 0;
        $right = count($this->sortedDataset) - 1;

        while ($left <= $right) {
            $mid1 = $left + intval(($right - $left) / 3);
            $mid2 = $right - intval(($right - $left) / 3);

            if ($this->sortedDataset[$mid1] >= $number) {
                $right = $mid1 - 1;
            } elseif ($this->sortedDataset[$mid2] >= $number) {
                $left = $mid1 + 1;
                $right = $mid2 - 1;
            } else {
                $left = $mid2 + 1;
            }
        }

        return $right >= 0 ? $this->sortedDataset[$right] : -1;
    }

    private function usingJumpSearch(int $number): int
    {
        $length = count($this->sortedDataset);

        if ($number > $this->sortedDataset[$length - 1]) {
            return $this->sortedDataset[$length - 1];
        }
        $blockSize = intval(sqrt($length));

        // Finding the block where the element may exist
        $prev = 0;
        while ($this->sortedDataset[min($blockSize, $length) - 1] < $number) {
            $prev = $blockSize;
            $blockSize += intval(sqrt($length));
            if ($prev >= $length) {
                return -1;
            }
        }

        // Performing a linear search within the identified block
        while ($this->sortedDataset[$prev] < $number) {
            $prev++;

            // If reached the end of the block or dataset, return the last element
            if ($prev == min($blockSize, $length)) {
                return $this->sortedDataset[$prev - 1];
            }
        }

        return $prev > 0 ? $this->sortedDataset[$prev - 1] : -1;
    }

    private function usingExponentialSearch(int $number): int
    {
        $length = count($this->sortedDataset);

        // If the input is smaller than the smallest value in the dataset
        if ($number < $this->sortedDataset[0]) {
            return -1; // There is no smaller value
        }

        // Find range for binary search by repeated doubling
        $bound = 1;
        while ($bound < $length && $this->sortedDataset[$bound] < $number) {
            $bound *= 2;
        }

        // Perform binary search within the identified range
        return $this->usingBinarySearch($number, intval($bound / 2), min($bound, $length - 1));
    }

    private function usingFor(int $number): int
    {
        $count = count($this->sortedDataset);
        $result = -1;

        for ($i = 0; $i < $count; $i++) {
            if ($this->sortedDataset[$i] >= $number) {
                return $result;
            }

            $result = $this->sortedDataset[$i];
        }

        return $result;
    }

    private function usingWhile(int $number): int
    {
        $count = count($this->sortedDataset);
        $i = 0;
        $result = -1;

        while ($i < $count && $this->sortedDataset[$i] < $number) {
            $result = $this->sortedDataset[$i];
            $i++;
        }

        return $result;
    }

    private function usingArrayFilter(int $number): int
    {
        $filtered = array_filter($this->dataset, function ($value) use ($number) {
            return $value < $number;
        });

        rsort($filtered);

        return $filtered ? $filtered[0] : -1;
    }

    private function usingArrayReduce(int $number): int
    {
        $nextMin = array_reduce($this->dataset, function ($carry, $value) use ($number) {
            if ($value < $number && ($carry === null || $value > $carry)) {
                return $value;
            }
            return $carry;
        });

        return $nextMin ?? -1;
    }

    private function usingArrayWalk(int $number): int
    {
        $result = -1;

        $dataset = $this->dataset;
        array_walk($dataset, function ($value) use ($number, &$result) {
            if ($value < $number && $value > $result) {
                $result = $value;
            }
        });

        return $result;
    }
}