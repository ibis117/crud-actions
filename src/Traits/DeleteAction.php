<?php

namespace Ibis117\CrudActions\Traits;

use App\Models\Project;
use Lorisleiva\Actions\Concerns\AsAction;

trait DeleteAction
{
    use AsAction;

    public function handle($id, $deleteFromDatabase = false): bool
    {
        $model = $this->model::find($id);
        if ($deleteFromDatabase) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    public function asController($id)
    {
        return response($this->handle($id), 204);
    }
}
