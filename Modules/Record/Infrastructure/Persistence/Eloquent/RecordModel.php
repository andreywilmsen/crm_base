<?php

namespace Modules\Record\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Infrastructure\Services\File\Persistence\Eloquent\Traits\HasAttachments;
use Modules\Record\Infrastructure\Database\Factories\RecordModelFactory;

class RecordModel extends Model
{
    use HasFactory, HasAttachments;

    protected $table = 'records';

    protected $fillable = [
        'title',
        'reference_date',
        'value',
        'description',
        'status_id',
        'category_id',
        'user_id',
    ];

    protected $casts = [
        'value' => 'float',
        'user_id' => 'integer',
        'reference_date' => 'date:Y-m-d',
    ];

    protected static function newFactory()
    {
        return RecordModelFactory::new();
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(RecordCategoryModel::class, 'category_id');
    }

    public function status()
    {
        return $this->belongsTo(RecordStatusModel::class, 'status_id');
    }
}
