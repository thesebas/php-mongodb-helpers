<?php

namespace Thesebas\MongoDB\Helpers\Tests\Aggregation;

use PHPUnit\Framework\TestCase;
use function Thesebas\MongoDB\Helpers\Aggregation\Arithmetic\add;
use function Thesebas\MongoDB\Helpers\Aggregation\Group\sum;
use function Thesebas\MongoDB\Helpers\Misc\path;

class ArithmeticTest extends TestCase {


    /**
     * @test
     */
    public function add() {
        $expected = <<<'END'
{
"$add": ["$some.path", "$some.other.path"]
}
END;

        $expected = \json_decode($expected, true);

        $actual = add(path('some', 'path'), path(...['some', 'other', 'path']));

        $this->assertEquals($expected, $actual, 'should be the same');

    }


    /**
     * @test
     */
    public function sum() {
        $expected = <<<'END'
{
"$sum": "$some.path"
}
END;
        $expected = \json_decode($expected, true);

        $actual = sum(path('some', 'path'));

        $this->assertEquals($expected, $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function sumWithManyArgs() {
        $expected = <<<'END'
{
"$sum": ["$some.path", "$some.other.path"]
}
END;
        $expected = \json_decode($expected, true);

        $actual = sum(path('some', 'path'), path(...['some', 'other', 'path']));

        $this->assertEquals($expected, $actual, 'should be the same');

    }
}
