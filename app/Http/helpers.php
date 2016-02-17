<?php

function trends_arrow_html($value)
{
    if ($value > 0) {
        return '<span class="glyphicon glyphicon-arrow-up"></span>';
    } elseif ($value < 0) {
        return '<span class="glyphicon glyphicon-arrow-down"></span>';
    } else {
        return '<span class="glyphicon glyphicon-minus"></span>';
    }
}

function sort_direction_html($direction)
{
    if ($direction === 'asc') {
        return '<span class="glyphicon glyphicon-triangle-top"></span>';
    } else {
        return '<span class="glyphicon glyphicon-triangle-bottom" ></span>';
    }
}

function link_to_sortable_route($name, $parameters)
{
    $parameters['direction'] = ($parameters['direction'] === 'asc') ? 'desc' : 'asc';

    return route($name, $parameters);
}
