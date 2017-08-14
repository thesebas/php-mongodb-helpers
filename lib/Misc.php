<?php

namespace Thesebas\MongoDB\Helpers\Misc;

function variable($name) {
    return '$$' . join('.', func_get_args());
}

function path($name) {
    return '$' . join('.', func_get_args());
}
