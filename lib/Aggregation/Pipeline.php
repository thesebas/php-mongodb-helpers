<?php

namespace Thesebas\MongoDB\Helpers\Aggregation\Pipeline;

const SORT = '$sort';
const MATCH = '$match';
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
const ADD_FIELDS = '$addFields';
const FACET = '$facet';
const BUCKET = '$bucket';
const BUCKET_AUTO = '$bucketAuto';
const SORT_BY_COUNT = '$sortByCount';


const BUCKET_AUTO_GRANULARITY_R5 = "R5";
const BUCKET_AUTO_GRANULARITY_R10 = "R10";
const BUCKET_AUTO_GRANULARITY_R20 = "R20";
const BUCKET_AUTO_GRANULARITY_R40 = "R40";
const BUCKET_AUTO_GRANULARITY_R80 = "R80";
const BUCKET_AUTO_GRANULARITY_125 = "1-2-5";
const BUCKET_AUTO_GRANULARITY_E6 = "E6";
const BUCKET_AUTO_GRANULARITY_E12 = "E12";
const BUCKET_AUTO_GRANULARITY_E24 = "E24";
const BUCKET_AUTO_GRANULARITY_E48 = "E48";
const BUCKET_AUTO_GRANULARITY_E96 = "E96";
const BUCKET_AUTO_GRANULARITY_E192 = "E192";
const BUCKET_AUTO_GRANULARITY_POWERSOF2 = "POWERSOF2";


function sort($sortOrder) {
    return [SORT => $sortOrder];
}

function project($projection) {
    return [PROJECT => $projection];
}

function addFields($fields) {
    return [ADD_FIELDS => $fields];
}

function group($groupBy, $fields) {
    return [GROUP => ['_id' => $groupBy] + $fields];
}

function match($query) {
    return [MATCH => $query];
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
        return [UNWIND => $op];
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

function bucket($groupBy, $boundaries, $default = null, $output = null) {
    $spec = [
        'groupBy' => $groupBy,
        'boundaries' => $boundaries,
    ];
    if (!is_null($default)) {
        $spec['default'] = $default;
    }
    if (!is_null($default)) {
        $spec['output'] = $output;
    }

    return [
        BUCKET => $spec
    ];
}

function bucketAuto($groupBy, $buckets, $output = null, $granularity = null) {
    $spec = [
        'groupBy' => $groupBy,
        'buckets' => $buckets,

    ];
    if (!is_null($output)) {
        $spec['output'] = $output;
    }
    if (!is_null($granularity)) {
        $spec['granularity'] = $granularity;
    }
    return [
        BUCKET_AUTO => $spec
    ];
}

function facet($fields) {
    return [FACET => $fields];
}

function sortByCount($expression) {
    return [SORT_BY_COUNT => $expression];
}
