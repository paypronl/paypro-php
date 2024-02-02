<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/lib')
    ->in(__DIR__ . '/tests')
    ->name('*.php')
    ->notPath('vendor');

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true);
$config->setRules([
    '@PSR2' => true,
    '@PhpCsFixer' => true,
    '@PhpCsFixer:risky' => true,
    'fopen_flags' => true,
    'phpdoc_align' => false,
    'concat_space' => ['spacing' => 'one'],

    // Disable coverage annotations
    'php_unit_test_class_requires_covers' => false,
    'php_unit_internal_class' => false
]);

$config->setFinder($finder);
return $config;
