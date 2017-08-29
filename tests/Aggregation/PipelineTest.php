<?php

namespace Thesebas\MongoDB\Helpers\Tests\Aggregation;

use PHPUnit\Framework\TestCase;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\addFields;
use const Thesebas\MongoDB\Helpers\Aggregation\Pipeline\BUCKET_AUTO_GRANULARITY_125;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\bucketAuto;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\group;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\limit;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\out;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\project;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\sample;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\skip;
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

    /**
     * @test
     */
    public function group() {

        $expected = <<<'END'
{
    "$group":{
        "_id": "$some.path",
        "f1": "some_value"
    }
}
END;

        $actual = group('$some.path', ['f1' => 'some_value', '_id' => 'should-be-overriden']);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function project() {
        $expected = <<<'END'
{
    "$project":{
        "f1": "some_value",
        "f2": "other_value"
    }
}
END;

        $actual = project(['f1' => 'some_value', 'f2' => 'other_value']);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function addFields() {
        $expected = <<<'END'
{
    "$addFields":{
        "f1": "some_value",
        "f2": "other_value"
    }
}
END;

        $actual = addFields(['f1' => 'some_value', 'f2' => 'other_value']);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function sort() {
        $expected = <<<'END'
{
    "$sort": {
        "f1": 1,
        "f2": -1
    }
}
END;

        $actual = \Thesebas\MongoDB\Helpers\Aggregation\Pipeline\sort(['f1' => 1, 'f2' => -1]);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function skip() {
        $expected = <<<'END'
{
    "$skip": 5
}
END;

        $actual = skip(5);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function limit() {
        $expected = <<<'END'
{
    "$limit": 100
}
END;

        $actual = limit(100);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function sample() {
        $expected = <<<'END'
{
    "$sample": {"size": 100}
}
END;

        $actual = sample(100);

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }

    /**
     * @test
     */
    public function out() {
        $expected = <<<'END'
{
    "$out": "collection_name"
}
END;

        $actual = out('collection_name');

        $this->assertEquals(\json_decode($expected, true), $actual, 'should be the same');
    }
}
