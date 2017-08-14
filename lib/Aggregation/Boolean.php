<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Boolean;

const OP_AND = '$and';
const OP_OR = '$or';
const OP_NOT = '$not';

function opAnd($expressions) {
    return [OP_AND => $expressions];
}

function opOr($expressions) {
    return [OP_OR => $expressions];
}

function opNot($expressions) {
    return [OP_NOT => $expressions];
}
