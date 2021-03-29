<?php

namespace Codtail\AdminSuit\Console;

use Illuminate\Console\GeneratorCommand;

class FilterMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adsu-make:filter {name} {module} {--G|general}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Filter Class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'fillter';

     /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/filter.php.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $isGeneral = $this->option('general');

        $module = $this->argument('module');
        if ($isGeneral)
            return $rootNamespace . "\Filters\\$module";
        return $rootNamespace . "\AdminSuit\\$module\\Filters";
    }
}
