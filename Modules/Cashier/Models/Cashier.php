<?php

namespace Modules\Cashier\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashier extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cashiers';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cashier\database\factories\CashierFactory::new();
    }
}
