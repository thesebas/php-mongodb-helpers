<?php

namespace Thesebas\MongoDB\Helpers\Tests\Aggregation;

use PHPUnit\Framework\TestCase;
use const Thesebas\MongoDB\Helpers\Aggregation\Pipeline\BUCKET_AUTO_GRANULARITY_125;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\bucketAuto;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\unwind;
use function Thesebas\MongoDB\Helpers\Misc\path;

class PipelineTest extends TestCase {

    /**
     * @test
     */
    public function unwind() {

        $expected = <<<'END'
{
"$unwind": "$some.path"
}
END;

        $actual = unwind('$some.path');

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function unwindWithInclude() {

        $expected = <<<'END'
{
"$unwind": {
    "path":"$some.path",
    "includeArrayIndex":"idx"
    }
}
END;

        $actual = unwind('$some.path', 'idx');

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function unwindWithPreserve() {

        $expected = <<<'END'
{
"$unwind": {
    "path":"$some.path",
    "preserveNullAndEmptyArrays":true
    }
}
END;

        $actual = unwind('$some.path', null, true);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function unwindWithIncludeAndPreserve() {

        $expected = <<<'END'
{
"$unwind": {
    "path":"$some.path",
    "includeArrayIndex":"idx",
    "preserveNullAndEmptyArrays":true
    }
}
END;

        $actual = unwind('$some.path', 'idx', true);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function bucketAutoWithOutputAndGranularity() {

        $expected = <<<'END'
{
    "$bucketAuto":{
        "groupBy":"$some.path",
        "buckets":3,
        "output":{
            "f1":"some", "f2":"value"
        },
        "granularity":"1-2-5"
    }

}
END;

        $actual = bucketAuto('$some.path', 3, ['f1' => 'some', 'f2' => 'value'], BUCKET_AUTO_GRANULARITY_125);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function bucketAutoWithOutput() {

        $expected = <<<'END'
{
    "$bucketAuto":{
        "groupBy":"$some.path",
        "buckets":3,
        "output":{
            "f1":"some", "f2":"value"
        }
    }

}
END;

        $actual = bucketAuto('$some.path', 3, ['f1' => 'some', 'f2' => 'value']);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function bucketAutoWithGranularity() {

        $expected = <<<'END'
{
    "$bucketAuto":{
        "groupBy":"$some.path",
        "buckets":3,
        "granularity":"1-2-5"
    }

}
END;

        $actual = bucketAuto('$some.path', 3, null, BUCKET_AUTO_GRANULARITY_125);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function bucketAuto() {

        $expected = <<<'END'
{
    "$bucketAuto":{
        "groupBy":"$some.path",
        "buckets":3
    }

}
END;

        $actual = bucketAuto('$some.path', 3);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }
}
