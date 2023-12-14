<?php

declare(strict_types=1);

$rules = [
    '@PER-CS2.0' => true,
    '@PER-CS2.0:risky' => true,
    'multiline_whitespace_before_semicolons' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_whitespace_before_comma_in_array' => true,
    'object_operator_without_whitespace' => true,
    'space_after_semicolon' => true,
    'cast_spaces' => true,
    'class_attributes_separation' => true,
    'single_quote' => true,
    'whitespace_after_comma_in_array' => true,
    'array_syntax' => ['syntax' => 'short'],
    'array_indentation' => true,
    'no_trailing_comma_in_singleline' => true,
    'method_chaining_indentation' => true,
    'trim_array_spaces' => true,
    'trailing_comma_in_multiline' => true,
    'include' => true,
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => true,
    'braces' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_extra_blank_lines' => true,
    'declare_strict_types' => true,
];

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setUsingCache(true);
