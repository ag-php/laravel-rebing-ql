<?php

declare(strict_types=1);

namespace App\Base\Classes\Save;

use Illuminate\Support\Facades\DB;

class TransactionSave
{
    private IData $data;

    public function __construct(IData $data)
    {
        $this->data = $data;
    }

    public function saveMessage(): array
    {
        try {
            DB::beginTransaction();
            $this->data->save();
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        return [
            'data' => $this->data->data(),
            'messages' => $this->data->messages(),
        ];
    }
}
