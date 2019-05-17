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
        // 遵循PSR2
        '@PSR2' => true,
        // 设置数组格式为[]这种格式
        'array_syntax' => ['syntax' => 'short'],
        // !后面的没有空格
        'not_operator_with_space' => false,
        // 类的use按长度由小到大排序
        'ordered_imports' => [
            'sort_algorithm' => 'length',
        ],
        // 删除无用的else
        'no_useless_else' => true,
        // 删除无用的return
        'no_useless_return' => true,
        // 自增样式[放在后面，如：$i++]
        'increment_style' => ['style' => 'post'],
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/app')
    );