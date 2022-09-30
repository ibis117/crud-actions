<?php

namespace Ibis117\CrudActions\Commands;

use Ibis117\CrudActions\Utils\CommandHelper;
use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;


class DeleteActionCommand extends Command
{
    use CommandHelper;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-action:delete {name} {--f|force}';

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
        list($name, $namespace, $singular, $plural, $class, $model) = $this->stubVariables('Delete');
        $path = $this->getPath($class, $name);
        if (file_exists($path) && !$this->option('force')) {
            $this->error("Action already exits at {$path}");
            return 0;
        }
        $this->findOrCreatePath($path);
        $stub = $this->getStub();
        $stub = $this->replaceWithStub($stub, $namespace, $class, $singular, $plural, $model);
//        dd($stub);
        $this->files->put($path, $stub);
        $this->info("DeleteAction generated at {$path}");
        $this->call('crud-action:route', [
            'name' => $name,
            'method' => 'delete',
            'classname' => join('\\', [$namespace, "{$class}::class"]),
            'action' => 'delete'
        ]);
        return 0;
    }

    /**
     * @throws FileNotFoundException
     */
    private function getStub(): string
    {
        $stub_path = 'stubs/action-delete.stub';
        $path = $this->files->exists(base_path($stub_path)) ? base_path($stub_path) : __DIR__ . '/../../' . $stub_path;
        return $this->files->get($path);
    }

    /**
     * path where the code will be generated
     * @param string $class
     * @param string $name
     * @return string
     */
    private function getPath(string $class, string $name): string
    {
        $structure = array_filter(['app/Actions', $name, $class . '.php'], function ($value) {
            return $value != '';
        });
        $path = join(DIRECTORY_SEPARATOR, $structure);
        return base_path($path);
    }

}
