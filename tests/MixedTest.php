<?php


use PHPUnit\Framework\TestCase;

use Thesebas\MongoDB\Helpers\Aggregation\Arithmetic;
use Thesebas\MongoDB\Helpers\Aggregation\ArrayOperator;
use Thesebas\MongoDB\Helpers\Aggregation\Comparison;
use Thesebas\MongoDB\Helpers\Aggregation\Pipeline;
use Thesebas\MongoDB\Helpers\Aggregation\Group;
use Thesebas\MongoDB\Helpers\Misc;
use Thesebas\MongoDB\Helpers\Query;

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

        $actual = Pipeline\project([
            'field' => ArrayOperator\reduce(
                ArrayOperator\filter(
                    Misc\path(...$arrayField),
                    'tmp',
                    Comparison\eq(Misc\variable("tmp", ...$filterField), $filterValue)
                ),
                0,
                Arithmetic\add(Misc\variable('value'), Misc\variable("this", $sumField))
            )
        ]);


        $this->assertEquals($expected, $actual, 'should be the same');

    }

    /**
     * @test
     */
    public function complex2() {

        $expected = <<<END

  {
    "\$facet": {
      "categorizedByTags": [
        { "\$unwind": "\$tags" },
        { "\$sortByCount": "\$tags" }
      ],
      "categorizedByPrice": [
        { "\$match": { "price": { "\$exists": 1 } } },
        {
          "\$bucket": {
            "groupBy": "\$price",
            "boundaries": [  0, 150, 200, 300, 400 ],
            "default": "Other",
            "output": {
              "count": { "\$sum": 1 },
              "titles": { "\$push": "\$title" }
            }
          }
        }
      ],
      "categorizedByYears(Auto)": [
        {
          "\$bucketAuto": {
            "groupBy": "\$year",
            "buckets": 4
          }
        }
      ]
    }
  }
END;

        $expected = \json_decode($expected, true);

        $actual = Pipeline\facet([
            'categorizedByTags' => [
                Pipeline\unwind(Misc\path('tags')),
                Pipeline\sortByCount(Misc\path('tags'))
            ],
            'categorizedByPrice' => [
                Pipeline\match(['price' => Query\Element\exists(1)]),
                Pipeline\bucket(
                    Misc\path('price'),
                    [0, 150, 200, 300, 400],
                    'Other',
                    [
                        'count' => Group\sum(1),
                        'titles' => Group\push(Misc\path('title'))
                    ]
                )
            ],
            'categorizedByYears(Auto)' => [
                Pipeline\bucketAuto(Misc\path('year'), 4)
            ],
        ]);


        $this->assertEquals($expected, $actual, 'should be the same');

    }
}
