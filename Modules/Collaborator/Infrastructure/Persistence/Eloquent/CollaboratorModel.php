<?php

namespace Modules\Collaborator\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Collaborator\Infrastructure\Database\Factories\CollaboratorModelFactory;

class CollaboratorModel extends Model
{
    use HasFactory;

    protected $table = 'collaborators';

    protected $fillable = [
        'name',
        'description',
        'phone',
        'email',
    ];

    protected static function newFactory()
    {
        return CollaboratorModelFactory::new();
    }
}
