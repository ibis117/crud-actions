<?php

namespace Ibis117\CrudActions\Commands;

use App\Models\User;
use App\Support\DripEmailer;
use Illuminate\Console\Command;

class CrudActionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud-action {name} {--m|migration} {--f|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate model and actions';

    /**
     * Execute the console command.
     * @return void
     */
    public function handle(): void
    {
        $name = $this->argument('name');
        $this->call('make:model', [
            'name' => $name,
            '--migration' => $this->option('migration'),
        ]);

        $isForce = $this->option('force');

        $this->call('crud-action:create', ['name' => $name, '--force' => $isForce]);
        $this->call('crud-action:list', ['name' => $name, '--force' => $isForce]);
        $this->call('crud-action:show', ['name' => $name, '--force' => $isForce]);
        $this->call('crud-action:update', ['name' => $name, '--force' => $isForce]);
        $this->call('crud-action:delete', ['name' => $name, '--force' => $isForce]);


    }
}
