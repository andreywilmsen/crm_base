<?php

namespace Modules\Record\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Record\Infrastructure\Database\Factories\RecordCategoryModelFactory;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class RecordCategoryModel extends Model
{
    use HasFactory;

    protected $table = 'records_categories';

    protected $fillable = [
        'name',
    ];

    public function records()
    {
        return $this->hasMany(RecordModel::class, 'category_id');
    }

    protected static function newFactory()
    {
        return RecordCategoryModelFactory::new();
    }
}
