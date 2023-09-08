<?php

$header = <<<EOF
This file is part of the Qsnh/meedu.

(c) 杭州白书科技有限公司
EOF;

$fixer = new PhpCsFixer\Config();

return $fixer
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
            ->exclude('public')
            ->exclude('resources')
            ->exclude('storage')
            ->exclude('vendor')
            ->exclude('bootstrap')
            ->in(__DIR__)
    )
    ->setUsingCache(false);