<?php

namespace Ibis117\CrudActions\Facades;

use Illuminate\Support\Facades\Facade;

class CrudActions extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'crud-actions';
    }
}
