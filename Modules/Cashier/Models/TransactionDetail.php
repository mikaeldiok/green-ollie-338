<?php

namespace Modules\Cashier\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transaction_details';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\TransactionDetail\database\factories\Transaction_detailFactory::new();
    }
}
