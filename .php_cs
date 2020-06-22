<?php

$header = <<<EOF
This file is part of the Qsnh/meedu.

(c) XiaoTeng <616896861@qq.com>

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'header_comment' => ['header' => $header],
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => [
            'sort_algorithm' => 'length',
        ],
        'not_operator_with_successor_space' => false,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_unused_imports' => true,
        'yoda_style' => false,
        'single_quote' => true,
        'increment_style' => ['style' => 'post'],
        // 三元运算符的空格
        'ternary_operator_spaces' => true,
        // .连接符两边空格，!没有空格
        'unary_operator_spaces' => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('addons')
            ->exclude('docker')
            ->exclude('docs')
            ->exclude('library')
            ->exclude('node_modules')
            ->exclude('public')
            ->exclude('resources')
            ->exclude('storage')
            ->exclude('templates')
            ->exclude('vendor')
            ->in(__DIR__)
    );