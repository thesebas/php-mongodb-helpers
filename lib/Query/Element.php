<?php

namespace Thesebas\MongoDB\Helpers\Query\Element;

const EXISTS = '$exists';
const TYPE = '$type';

function exists($boolean) {
    return [EXISTS => $boolean];
}

function type($numberOrAlias) {
    return [TYPE => $numberOrAlias];
}
