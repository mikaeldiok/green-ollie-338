<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Transaction\database\factories\TransactionFactory::new();
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
