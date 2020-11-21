<?php

return [
    '' => [
        'controller' => 'test',
        'action'     => 'index'
    ],
    '/' => [
        'controller' => 'test',
        'action'     => 'index'
    ],
    'test' => [
        'controller' => 'test',
        'action'     => 'index'
    ],
    'test/page/{int_id}' => [
        'controller' => 'test',
        'action'     => 'index'
    ],
    'test/create' => [
        'controller' => 'test',
        'action'     => 'create'
    ],
    'test/store' => [
        'controller' => 'test',
        'action'     => 'store'
    ],
    'test/{int_id}' => [
        'controller' => 'test',
        'action'     => 'show'
    ],
    'test/{int_id}/edit' => [
        'controller' => 'test',
        'action'     => 'edit'
    ],
    'test/{int_id}/update' => [
        'controller' => 'test',
        'action'     => 'update'
    ],
    'test/{int_id}/delete' => [
        'controller' => 'test',
        'action'     => 'delete'
    ],
];