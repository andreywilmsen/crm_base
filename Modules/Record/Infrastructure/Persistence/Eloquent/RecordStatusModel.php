<?php

namespace Modules\Record\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Record\Infrastructure\Persistence\Eloquent\RecordModel;

class RecordStatusModel extends Model
{
    use HasFactory;

    protected $table = 'records_status';

    protected $fillable = [
        'name',
    ];

    public function records()
    {
        return $this->hasMany(RecordModel::class, 'status_id');
    }
}
