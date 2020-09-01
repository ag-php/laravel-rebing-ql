<?php

declare(strict_types=1);

namespace App\Base\Classes;

use Illuminate\Database\Eloquent\Model;

class ModelColumns
{

    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Return the column of the current table visible to the user
     * in the format schema.table.column.
     *
     * @return array
     */
    public function public(): array
    {
        $fillables = $this->model->getFillable();
        $fillables[] = $this->model->getKeyName();
        $columns = preg_filter('/^/', $this->model->getTable(). '.' , $fillables);
        $columns[] =$this->model->getTable(). '.' .$this->model->getKeyName();

        return $columns;
    }
}
