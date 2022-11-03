<?php

namespace Ibis117\CrudActions\Traits;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

trait ListAction
{
    use AsAction;

    public function handle($count = 10)
    {
        $query = $this->select();
        $query = $this->filter($query);

        return $this->paginate($query, $count);
    }

    protected function select()
    {
        return $this->model::select();
    }

    protected function paginate($query, $count)
    {
        return $query->paginate($count);
    }

    protected function filter($query)
    {
        return $query;
    }

    protected function pagination($data)
    {
        return [
            'perPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'totalCount' => $data->total(),
            'data' => $data->items(),
        ];
    }

    protected function response($result)
    {
        return response($result, 200);
    }

    public function asController(Request $request)
    {
        $count = $request['count'] ?? $this->perPage ?? 10;
        $result = $this->pagination($this->handle($count));
        return $this->response($result);
    }
}
