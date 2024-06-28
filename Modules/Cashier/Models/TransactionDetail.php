<?php

namespace Modules\Cashier\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Menu\Models\Food;

class TransactionDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'food_id',
        'quantity',
        'total_price',
        // other fields...
    ];

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

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function transcation()
    {
        return $this->belongsTo(Transaction::class);
    }
}
