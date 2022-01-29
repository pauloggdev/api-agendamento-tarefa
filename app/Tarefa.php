<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarefa extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id', 'descricao', 'arquivos', 'status', 'titulo', 'created_at', 'updated_at', 'deleted_at'
    ];
}
