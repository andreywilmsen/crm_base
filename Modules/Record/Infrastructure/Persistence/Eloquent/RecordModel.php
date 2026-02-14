<?php

namespace Modules\Record\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RecordModel extends Model
{
    use HasFactory;

    protected $table = 'records';

    protected $fillable = [
        'title',
        'reference_date',
        'value',
        'description',
        'status',
        'user_id',
    ];

    protected $casts = [
        'value' => 'float',
        'user_id' => 'integer',
        'reference_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
