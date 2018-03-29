<?php
$finder = PhpCsFixer\Finder::create()->in(['config', 'src', 'tests']);
$header = <<< EOF
This file is part of Underscore.php

(c) Maxime Fabre <ehtnam6@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$fixer = new \PhpCsFixer\Fixer\Comment\HeaderCommentFixer;

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2' => true,
        // 'strict_param' => true,
        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => [
            'header' => $header
        ],
        'ordered_imports' => [],
        // 'ereg_to_preg' => true,
        'phpdoc_order' => true,
        // 'no_php4_constructor' => true,
    ])
    ->setUsingCache(true)
    ->setFinder($finder);
