<?php

declare(strict_types=1);

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */

namespace App\Base\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Undocumented class
 * php version 7.2.10.
 *
 * @category Model
 * @author   Albert <me@albertcito.com>
 * @license  no LICENSE
 * @link     http://www.inspiracion.cl
 */
class BaseModel extends Model
{
    /**
     * Return the column of the current table visible to the user
     * in the format schema.table.column.
     *
     * @return array
     */
    public function getPublicColumns() : array
    {
        $fillables = $this->fillable;
        $fillables[] = $this->primaryKey;
        $columns = preg_filter('/^/', $this->table.'.', $fillables);
        $columns[] = $this->table.'.'.$this->primaryKey;

        return $columns;
    }

    //end getPublicColumns()

    /**
     * Save the user to created or update the row in the DB.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        if (\Auth::check()) {
            static::updating(
                function ($model) {
                    $model->updated_by = \Auth::User()->user_id;
                }
            );

            static::creating(
                function ($model) {
                    $model->created_by = \Auth::User()->user_id;
                }
            );
        }
    }

    //end boot()
}//end class
