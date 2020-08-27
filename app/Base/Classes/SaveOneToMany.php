<?php

declare(strict_types=1);

namespace App\Base\Classes;

class SaveOneToMany
{
    //Items to be saved
    private $items;
    //Model to save it
    private $model;
    //The FK column name from the parent table
    private $fkColumnName;
    //The PK column name from the current table and model
    private $pkColumnName;

    public function __construct(
        array $items,
        string $model,
        string $fkColumnName,
        string $pkColumnName
    ) {
        $this->items = $items;
        $this->model = $model;
        $this->fkColumnName = $fkColumnName;
        $this->pkColumnName = $pkColumnName;
    }

    public function save(int $id)
    {
        $arrayIDs = new ArrayIDs($this->items);
        // Delete options that are not in the new symbol array
        $this->model::where([$this->fkColumnName => $id])
            ->whereNotIn($this->pkColumnName, $arrayIDs->ids($this->pkColumnName))
            ->delete();

        //Save options array
        foreach ($this->items as $item) {
            if (array_key_exists($this->pkColumnName, $item)) {
                $this->model::find($item[$this->pkColumnName])->update($item);
            } else {
                $item[$this->fkColumnName] = $id;
                $this->model::create($item)->fresh();
            }
        }
    }
}
