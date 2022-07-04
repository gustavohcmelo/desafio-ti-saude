<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Plano extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'planos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'plano_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plano_descricao',
        'plano_telefone'
    ];

    /* Relationships area */
    public function paciente_plano()
    {
        return $this->hasMany(Paciente_plano::class, 'plano_codigo');
    }
}
