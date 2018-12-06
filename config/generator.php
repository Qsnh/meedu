<?php

/**
 * request = ${model} + Request
 * controllerName = ${model} + Controller
 */

return [
    [
        'name' => '课程章节',
        'model' => 'CourseChapter',
        'request' => [
            'rules' => [
                'course_id' => 'required',
                'title' => 'required',
            ],
            'messages' => [
                'course_id.required' => '请选择课程',
                'title.required' => '请输入章节名',
            ],
            'filldata' => [
                'course_id',
                'title',
            ],
        ],
        'template' => [
            'edit' => [
                'fields' => [
                    'course_id' => '课程',
                    'title' => '章节名',
                ],
            ],
            'index' => [
                'fields' => [
                    'title' => '章节名',
                ],
            ],
        ],
    ]
];