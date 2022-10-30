<?php

namespace Ibis117\CrudActions\Traits;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

trait ListAction
{
    use AsAction;

    public function handle($count = 10)
    {
        $query = $this->model::select();
        $query = $this->filter($query);

        return $query->paginate($count);
    }

    public function filter($query)
    {
        return $query;
    }

    public function asController(Request $request)
    {
        $count = $request['count'] ?? 10;
        $data = $this->handle($count);
        $result = [
            'perPage' => $data->perPage(),
            'currentPage' => $data->currentPage(),
            'lastPage' => $data->lastPage(),
            'data' => $data->items(),
        ];

        return response($result, 200);
    }
}
