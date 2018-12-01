<?php

/**
 * request = ${model} + Request
 * controllerName = ${model} + Controller
 */

return [
    [
        'name' => '推广链接',
        'model' => 'AdFrom',
        'request' => [
            'rules' => [
                'from_name' => 'required',
                'from_key' => 'required',
            ],
            'messages' => [
                'from_name.required' => '请输入推广链接名',
                'from_key.required' => '请输入推广链接特征值',
            ],
            'filldata' => [
                'from_name',
                'from_key',
            ],
        ],
        'template' => [
            'edit' => [
                'fields' => [
                    'from_name' => '推广链接名',
                    'from_key' => '推广链接特征值',
                ],
            ],
            'index' => [
                'fields' => [
                    'from_name' => '推广链接名',
                    'from_key' => '推广链接特征值',
                ],
            ],
        ],
    ]
];