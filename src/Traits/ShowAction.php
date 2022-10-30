<?php

namespace Ibis117\CrudActions\Traits;

use Lorisleiva\Actions\Concerns\AsAction;

trait ShowAction
{
    use AsAction;

    public function handle($id)
    {
        return $this->model::findOrFail($id);
    }

    public function asController($id)
    {
        return response($this->handle($id), 200);
    }
}
