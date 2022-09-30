<?php

namespace Ibis117\CrudActions\Utils;

use Illuminate\Support\Str;

trait CommandHelper
{

    /**
     * @param mixed $path
     * @return void
     */
    public function findOrCreatePath(mixed $path): void
    {
        if (!$this->files->exists($path)) {
            $this->makeDirectory($path);
        }
    }

    /**
     * @param string $prefix
     * @return array
     */
    public function stubVariables(string $prefix): array
    {
        $name = Str::studly($this->argument('name'));
        $namespace = join('\\', [$this->namespace, $name]);

        $singular = Str::singular(strtolower($name));
        $plural = Str::plural($singular);
        $class = $prefix . ucfirst($singular);
        $model = $name;
        return [$name, $namespace, $singular, $plural, $class, $model];
    }

    /**
     * @param string $stub
     * @param mixed $namespace
     * @param mixed $class
     * @param mixed $singular
     * @param mixed $plural
     * @param mixed $model
     * @return string
     */
    public function replaceWithStub(string $stub, mixed $namespace, mixed $class, mixed $singular, mixed $plural, mixed $model): string
    {
        $this->replaceNamespace($stub, $namespace)
            ->replaceClassName($stub, $class)
            ->replaceSingular($stub, $singular)
            ->replacePlural($stub, $plural)
            ->replaceModel($stub, $model);
        return $stub;
    }

    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }
    protected function replaceNamespace(&$stub, $with)
    {
        $for = '{{ namespace }}';
        $stub = $this->replace($stub, $for, $with);
        return $this;
    }

    protected function replaceClassName(&$stub, $with)
    {
        $for = '{{ class }}';
        $stub = $this->replace($stub, $for, $with);
        return $this;
    }

    protected function replaceModel(&$stub, $with)
    {
        $for = '{{ model }}';
        $stub = $this->replace($stub, $for, $with);
        return $this;
    }

    protected function replaceSingular(&$stub, $with)
    {
        $for = '{{ singular }}';
        $stub = $this->replace($stub, $for, $with);
        return $this;
    }

    protected function replacePlural(&$stub, $with)
    {
        $for = '{{ plural }}';
        $stub = $this->replace($stub, $for, $with);
        return $this;
    }

    protected function replace(&$stub, $for, $with)
    {
        return str_replace($for, $with, $stub);
    }
}
