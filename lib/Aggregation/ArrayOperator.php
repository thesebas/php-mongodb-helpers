<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\ArrayOperator;


const ARRAY_ELEM_AT = '$arrayElemAt';
const ARRAY_TO_OBJECT = '$arrayToObject';
const CONCAT_ARRAYS = '$concatArrays';
const FILTER = '$filter';
const IN = '$in';
const INDEX_OF_ARRAY = '$indexOfArray';
const IS_ARRAY = '$isArray';
const MAP = '$map';
const OBJECT_TO_ARRAY = '$objectToArray';
const RANGE = '$range';
const REDUCE = '$reduce';
const REVERSE_ARRAY = '$reverseArray';
const SIZE = '$size';
const SLICE = '$slice';
const ZIP = '$zip';


function filter($input, $as, $condition) {
    return [FILTER => [
        'input' => $input,
        'as' => $as,
        'cond' => $condition
    ]];
}

function reduce($input, $initialValue, $in) {
    return [REDUCE => [
        'input' => $input,
        'initialValue' => $initialValue,
        'in' => $in
    ]];
}


