<?php

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/bootstrap/app.php';

$finder = PhpCsFixer\Finder::create()
    ->in(app_path())
    ->in(config_path())
    ->in(database_path('factories'))
    ->in(database_path('seeds'))
    ->in(resource_path('lang'))
    ->in(base_path('routes'))
    ->in(base_path('tests'));

return (new MattAllan\LaravelCodeStyle\Config())
    ->setFinder($finder)
    ->setRules([
        '@Laravel' => true,
        '@Laravel:risky' => true,
            // Project specific
            'array_indentation' => true,
            'declare_strict_types' => true,
            'is_null' => true,
            'modernize_types_casting' => true,
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
            ],
    ])
    ->setRiskyAllowed(true);
