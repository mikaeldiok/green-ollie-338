<?php

namespace Modules\Menu\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'foods';

}
