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
        '@Symfony' => true,
        'header_comment' => ['header' => $header],
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => [
            'sort_algorithm' => 'length',
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'yoda_style' => false,
        'not_operator_with_successor_space' => true,
        'increment_style' => ['style' => 'post'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/app')
    );