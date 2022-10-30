<?php

namespace Ibis117\CrudActions\Traits;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

trait CreateAction
{
    use AsAction;

    abstract public function rules(): array;

    public function handle(array $data)
    {
        return $this->model::create($data);
    }

    public function asController(ActionRequest $request)
    {
        $data = $this->handle($request->all());

        return response($data, 201);
    }
}
