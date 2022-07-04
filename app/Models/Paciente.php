<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
class Paciente extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pacientes';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pac_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pac_nome',
        'pac_dataNascimento'
    ];

    /* Relationships area */
    public function telefone()
    {
        return $this->hasMany(Telefone::class, 'pac_codigo');
    }

    public function paciente_plano()
    {
        return $this->hasMany(Paciente_plano::class, 'pac_codigo');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'pac_codigo');
    }
}
