<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Pipeline;

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

function unwind($path, $includeArrayIndex = null, $preserveNullAndEmptyArrays = null) {
    if (is_null($includeArrayIndex) && is_null($preserveNullAndEmptyArrays)) {
        return [UNWIND => $path];
    } else {
        $op = [
            'path' => $path
        ];
        if (!is_null($includeArrayIndex)) {
            $op['includeArrayIndex'] = $includeArrayIndex;
        }
        if (!is_null($preserveNullAndEmptyArrays)) {
            $op['preserveNullAndEmptyArrays'] = $preserveNullAndEmptyArrays;
        }
        return $op;
    }
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
