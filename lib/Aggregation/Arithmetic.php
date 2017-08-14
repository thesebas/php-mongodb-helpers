<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Arithmetic;

const ABS = '$abs';
const ADD = '$add';
const CEIL = '$ceil';
const DIVIDE = '$divide';
const EXP = '$exp';
const FLOOR = '$floor';
const LN = '$ln';
const LOG = '$log';
const LOG10 = '$log10';
const MOD = '$mod';
const MULTIPLY = '$multiply';
const POW = '$pow';
const SQRT = '$sqrt';
const SUBTRACT = '$subtract';
const TRUNC = '$trunc';

function abs($number) {
    return [ABS => $number];
}

function add($number1, $number2 /*, ..., $exprN*/) {
    return [ADD => func_get_args()];
}

function ceil($number) {
    return [CEIL => $number];
}

function divide($dividend, $divisor) {
    return [DIVIDE => [$dividend, $divisor]];
}

function exp($exponent) {
    return [EXP => $exponent];
}

function floor($number) {
    return [FLOOR => $number];
}

function ln($number) {
    return [LN => $number];
}

function log($number, $base) {
    return [LOG => [$number, $base]];
}

function log10($number) {
    return [LOG10 => $number];
}

function mod($dividend, $divisor) {
    return [MOD => [$dividend, $divisor]];
}

function multiply($number1, $number2 /*, ..., $exprN*/) {
    return [MULTIPLY => func_get_args()];
}

function pow($number, $exponent) {
    return [POW => [$number, $exponent]];
}

function sqrt($number) {
    return [SQRT => $number];
}

function subtract($expr1, $expr2) {
    return [SUBTRACT => [$expr1, $expr2]];
}

function trunc($number) {
    return [TRUNC => $number];
}
