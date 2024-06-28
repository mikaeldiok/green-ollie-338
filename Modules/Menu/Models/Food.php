<?php

namespace Modules\Menu\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cashier\Models\TransactionDetail;

class Food extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'foods';

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
