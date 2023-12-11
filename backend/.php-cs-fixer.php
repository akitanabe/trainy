<?php

$rules = [
    '@PSR12' => true,
    '@PSR12:risky' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
];

$finder = PhpCsFixer\Finder::create()
->in([
    __DIR__.'/app',
    __DIR__.'/config',
    __DIR__.'/database',
    __DIR__.'/resources',
    __DIR__.'/routes',
    __DIR__.'/tests',
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
