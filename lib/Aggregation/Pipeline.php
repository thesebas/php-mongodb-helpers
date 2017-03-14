<?php

namespace Thesebas\MongoDB\Helpers\Aggregation;

const SORT = '$sort';
const PROJECT = '$project';
const GROUP = '$group';
const UNWIND = '$unwind';
const LIMIT = '$limit';
const SKIP = '$skip';
const SAMPLE = '$sample';
const OUT = '$out';
const LOOKUP = '$lookup';
const GEO_NEAR = '$geoNear';
const REDACT = '$redact';

function sort($sortOrder) {
    return [SORT => $sortOrder];
}

function project($projection) {
    return [PROJECT => $projection];
}

function group($groupBy, $fields) {
    return [GROUP => ['_id' => $groupBy] + $fields];
}

function unwind($field) {
    return [UNWIND => $field];
}

function limit($number) {
    return [LIMIT => $number];
}

function skip($number) {
    return [SKIP => $number];
}

function sample($size) {
    return [SAMPLE => ['size' => $size]];
}

function out($outputCollection) {
    return [OUT => $outputCollection];
}

function lookup($localField, $foreignCollection, $foreignField, $output) {

    return [LOOKUP => [
        'from' => $foreignCollection,
        'localField' => $localField,
        'foreignField' => $foreignField,
        'as' => $output
    ]];

}

function geoNear($options) {
    return [GEO_NEAR => $options];
}

function redact($expression) {
    return [REDACT => $expression];
}
