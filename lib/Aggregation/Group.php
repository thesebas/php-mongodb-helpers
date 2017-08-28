<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Group;

const SUM = '$sum';
const AVG = '$avg';
const FIRST = '$first';
const LAST = '$last';
const MAX = '$max';
const MIN = '$min';
const PUSH = '$push';
const ADD_TO_SET = '$addToSet';
const STD_DEV_POP = '$stdDevPop';
const STD_DEV_SAMP = '$stdDevSamp';


function sum($expression/*, $expression2, ...*/) {

    $args = func_get_args();
    if (count($args) > 1) {
        return [SUM => $args];
    }

    return [SUM => $expression];
}

function push($expression) {
    return [PUSH => $expression];
}
