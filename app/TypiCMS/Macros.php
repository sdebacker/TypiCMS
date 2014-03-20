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

HTML::macro('languagesMenu', function ($attributes)
{
    $attributes['id'] = 'nav-languages';
    return with(new TypiCMS\Services\ListBuilder)->languagesMenuHtml($attributes);
});

HTML::macro('menu', $builtMenu = function ($items = array(), $ulAttr = array()) use (&$builtMenu)
{
    // dd($items);
    $menuList = array('<ul ' . HTML::attributes($ulAttr) . '>');

    foreach ($items as $item) {

        $liAttr = array();
        $item->class and $liAttr['class'] = $item->class;
        $liAttr['role'] = 'menuitem';

        // item
        $menuList[] = '<li ' . HTML::attributes($liAttr) . '>';

        $aAttr = array();
        if ($item->children) {
            $aAttr['class'] = 'dropdown-toggle';
            $aAttr['data-toggle'] = 'dropdown';
        }
        $item->target and $aAttr['target'] = $item->target;
        $aAttr['href'] = $item->page_uri;

        $menuList[] = '<a ' . HTML::attributes($aAttr) . '>';
        $menuList[] = $item->title;
        $item->children and $menuList[] = '<span class="caret"></span>';
        $menuList[] = '</a>';

        // nested list
        if ($item->children) {
            $menuList[] = $builtMenu($item->children, array('class' => 'dropdown-menu'));
        }

        $menuList[] = '</li>';
    }
    $menuList[] = '</ul>';

    return implode("\r\n", $menuList);

});


