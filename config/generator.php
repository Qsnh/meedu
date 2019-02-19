<?php

/**
 * request = ${model} + Request
 * controllerName = ${model} + Controller
 */

return [
    [
        'name' => '首页导航',
        'model' => 'Nav',
        'request' => [
            'rules' => [
                'sort' => 'required',
                'name' => 'required',
                'url' => 'required',
            ],
            'messages' => [
                'sort.required' => '请输入排序值',
                'name.required' => '请输入链接名',
                'url.required' => '请输入链接地址',
            ],
            'filldata' => [
                'sort',
                'name',
                'url',
            ],
        ],
        'template' => [
            'edit' => [
                'fields' => [
                    'sort' => '排序值',
                    'name' => '链接名',
                    'url' => '链接地址',
                ],
            ],
            'index' => [
                'fields' => [
                    'sort' => '排序值',
                    'name' => '链接名',
                    'url' => '链接地址',
                ],
            ],
        ],
    ]
];