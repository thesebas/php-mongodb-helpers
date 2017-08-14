<?php


use PHPUnit\Framework\TestCase;

use function Thesebas\MongoDB\Helpers\Aggregation\Arithmetic\add;
use function Thesebas\MongoDB\Helpers\Aggregation\ArrayOperator\filter;
use function Thesebas\MongoDB\Helpers\Aggregation\ArrayOperator\reduce;
use function Thesebas\MongoDB\Helpers\Aggregation\Comaprison\eq;
use function Thesebas\MongoDB\Helpers\Aggregation\Pipeline\project;
use function Thesebas\MongoDB\Helpers\Misc\path;
use function Thesebas\MongoDB\Helpers\Misc\variable;

class MixedTest extends TestCase {

    /**
     * @test
     */
    public function complex1() {

        $arrayField = ['aaa', 'bb'];
        $filterField = ['ccc', 'ddd'];

        $filterValue = 'abc';
        $sumField = 'def';


        $expected = ['$project' => [
            'field' => ['$reduce' => [
                'input' => ['$filter' => [
                    'input' => '$' . join('.', $arrayField),
                    'as' => 'tmp',
                    'cond' => ['$eq' => ["\$\$tmp." . join('.', $filterField), $filterValue]]
                ]],
                'initialValue' => 0,
                'in' => [
                    '$add' => ['$$value', '$$this.' . $sumField]
                ]
            ]]
        ]];

        $actual = project([
            'field' => reduce(
                filter(
                    path(...$arrayField),
                    'tmp',
                    eq(variable("tmp", ...$filterField), $filterValue)
                ),
                0,
                add(variable('value'), variable("this", $sumField))
            )
        ]);


        $this->assertEquals($expected, $actual, 'should be the same');

    }
}
