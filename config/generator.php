<?php

/**
 * request = ${model} + Request
 * controllerName = ${model} + Controller
 */

return [
    [
        'name' => '测试',
        'model' => 'Test',
        'request' => [
            'rules' => [
                'name' => 'required',
            ],
            'messages' => [
                'name.required' => '需要',
            ],
            'filldata' => [
                'name',
            ],
        ],
        'template' => [
            'edit' => [
                'fields' => [
                    'name' => '姓名',
                ],
            ],
            'index' => [
                'fields' => [
                    'name' => '姓名',
                ],
            ],
        ],
    ]
];