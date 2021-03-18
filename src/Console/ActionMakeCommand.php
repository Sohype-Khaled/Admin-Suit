<?php

namespace Codtail\AdminSuit\Console;

use Illuminate\Console\GeneratorCommand;

class ActionMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adsu-make:action {name} {module} {--T|type=default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Action Class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'action';

     /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $type = $this->option('type');

        switch ($type) {
            case "boolean":
                return __DIR__ . '/stubs/BooleanAction.php.stub';
                break;
            default:
                return __DIR__ . '/stubs/DefaultAction.php.stub';
        }

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
        $module = $this->argument('module');
        return $rootNamespace . "\AdminSuit\\$module\\Actions";
    }
}
