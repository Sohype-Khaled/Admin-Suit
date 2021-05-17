<?php

namespace Codtail\AdminSuit\Console;

use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;
use Symfony\Component\Console\Input\InputOption;

class FormMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adsu-make:form {name} {module} {--model=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Form Class';


    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'form';

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    protected function replaceModel($stub, $model)
    {

        $modelClass = $this->parseModel($model);

        $replace = [
            '{{ model }}' => $modelClass,
            '{{ modelVariable }}' => class_basename($modelClass),
        ];

        return str_replace(
            array_keys($replace), array_values($replace), $stub
        );
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param string $model
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    protected function parseModel($model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

     /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/form.php.stub';
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
        return $rootNamespace . "\AdminSuit\\$module\\Forms";
    }

    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the observer applies to.'],
        ];
    }
}
