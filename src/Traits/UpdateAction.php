<?php

namespace Ibis117\CrudActions\Traits;

use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

trait UpdateAction
{
    use AsAction;

    abstract public function rules(): array;

    public function handle($id, array $data)
    {
        $model = $this->model::find($id);

        return tap($model)->update($data);
    }

    public function asController($id, ActionRequest $request)
    {
        $data = $this->handle($id, $request->all());

        return response($data, 201);
    }
}
