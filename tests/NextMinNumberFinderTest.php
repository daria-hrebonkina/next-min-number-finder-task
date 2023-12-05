<?php

namespace Tests;

use App\Enums\FinderMethod;
use App\NextMinNumberFinder;
use PHPUnit\Framework\TestCase;

class NextMinNumberFinderTest extends TestCase
{
    private array $dataset = [3, 4, 6, 9, 10, 12, 14, 15, 17, 19, 21];

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingBinarySearch(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::BinarySearch));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingTernarySearch(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::TernarySearch));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingJumpSearch(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::JumpSearch));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingExponentialSearch(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::ExponentialSearch));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingFor(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::For));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingWhile(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::While));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingArrayFilter(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::ArrayFilter));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingArrayReduce(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::ArrayReduce));
    }

    /**
     * @dataProvider searchDataProvider
     */
    public function testUsingArrayWalk(int $input, $expectedResult): void
    {
        $finder = new NextMinNumberFinder($this->dataset);
        $this->assertEquals($expectedResult, $finder($input, FinderMethod::ArrayWalk));
    }

    public static function searchDataProvider(): array
    {
        return [
            [-100, -1],
            [0, -1],
            [2, -1],
            [3, -1],
            [4, 3],
            [10, 9],
            [13, 12],
            [19, 17],
            [21, 19],
            [100, 21],
        ];
    }
}