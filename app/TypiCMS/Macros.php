<?php
HTML::macro('th', function ($field = '', $defaultOrder = null, $sortable = true, $label = true) {
    $order = Input::get('order');
    if (! $order and $defaultOrder) {
        $order = $field;
    }
    $direction = Input::get('direction', $defaultOrder);
    $th[] = '<th class="' . $field . '">';
    if ($sortable) {
        $newDirection = 'asc';
        $iconDir = ' text-muted';
        if ($order == $field) {
            if ($direction == 'asc') {
                $newDirection = 'desc';
            }
            $iconDir = '-' . $newDirection;
        }
        $th[] = '<a href="?order=' . $field . '&direction=' . $newDirection . '">';
        $th[] = '<i class="fa fa-sort' . $iconDir . '"></i> ';
    }
    if ($label) {
        $th[] = trans('validation.attributes.' . $field);
    }
    if ($sortable) {
        $th[] = '</a>';
    }
    $th[] = '</th>';
    $th[] = "\r\n";

    return implode($th);
});
