<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeActionCommand extends GeneratorCommand
{
    protected $signature = 'make:action { name }';

    protected $description = 'Make a new action';

    protected function getStub(): string
    {
        return base_path('/stubs/action.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Actions';
    }
}
