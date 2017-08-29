# php-mongodb-helpers
MongoDB php helpers to build queries. ![BUILD STATUS](https://api.travis-ci.org/thesebas/php-mongodb-helpers.svg?branch=master)

Write this:
```php
$collection->aggregate([

  project([
      'field' => reduce(
          filter(
              path(...$arrayField),
              'tmp',
              eq(variable("tmp", ...$filterField), $filterValue)
          ),
          0,
          add(variable('value'), variable("this", $sumField))
      )
  ])

]);
```

instead of this:
```php
$collection->aggregate([
  ['$project' => [
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
  ]]
]);
```
