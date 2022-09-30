<?php

namespace Ibis117\CrudActions\Commands;

use Ibis117\CrudActions\Utils\CommandHelper;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class RouteActionCommand extends Command
{
    use CommandHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-action:route {name} {method} {classname} {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates CreateAction Class With Opinionated functionality';

    protected Filesystem $files;
    protected string $namespace = "App\Actions";

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        $name = $this->argument('name');
        $method = $this->argument('method');
        $classname = $this->argument('classname');
        $action = $this->argument('action');
        $route_name = Str::plural(strtolower($name));
        $path = base_path('routes/api.php');
        $lines = $this->files->lines($path);
        $last_line_content = $lines->get($lines->count() - 1);
        if ($last_line_content != "") {
            File::append($path, "\n");
        }
        $classname = str_replace('/', '\\', $classname);
        $line_content = $this->getRouteContent($action, $method, $route_name, $classname);
        File::append($path, $line_content);
        $this->info("{$line_content} added to routes/api.php");
        return 0;
    }

    private function getRouteContent(string $action, $method, $route_name, $classname)
    {
        $singular = Str::singular($route_name);
        return match ($action) {
            'list', 'create' => "Route::{$method}('/{$route_name}', $classname);",
            'show', 'update', 'delete' => "Route::{$method}('/{$route_name}/{{$singular}}', $classname);",
            default => null
        };
    }

}
