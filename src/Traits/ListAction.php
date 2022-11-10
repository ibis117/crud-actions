<?php

namespace Ibis117\CrudActions\Traits;

use Illuminate\Http\Request;
use Illuminate\Pagination\AbstractPaginator;
use Lorisleiva\Actions\Concerns\AsAction;

trait ListAction
{
    use AsAction;

    public function handle($count = 10, $filter = [])
    {
        $query = $this->select();
        $query = $this->filter($query, $filter);

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

    protected function filter($query, $filter)
    {
        return $query;
    }

    protected function pagination($data)
    {
        if($data instanceof AbstractPaginator) {
            return [
                'perPage' => $data->perPage(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
                'totalCount' => $data->total(),
                'data' => $data->items(),
            ];
        }

        return $data;
    }

    protected function response($result)
    {
        return response($result, 200);
    }

    public function asController(Request $request)
    {
        $count = $request['count'] ?? $this->perPage ?? 10;
        $result = $this->pagination($this->handle($count), $request->all());
        return $this->response($result);
    }
}
