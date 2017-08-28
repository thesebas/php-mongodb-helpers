<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Comparison;

const CMP = '$cmp';
const EQ = '$eq';
const GT = '$gt';
const GTE = '$gte';
const LT = '$lt';
const LTE = '$lte';
const NE = '$ne';

function cmp($left, $right) {
    return [CMP => [$left, $right]];
}

function eq($left, $right) {
    return [EQ => [$left, $right]];
}

function gt($left, $right) {
    return [GT => [$left, $right]];
}

function gte($left, $right) {
    return [GTE => [$left, $right]];
}

function lt($left, $right) {
    return [LT => [$left, $right]];
}

function lte($left, $right) {
    return [LTE => [$left, $right]];
}

function ne($left, $right) {
    return [NE => [$left, $right]];
}
