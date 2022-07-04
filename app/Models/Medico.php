<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Medico extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'medicos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'med_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'espec_codigo',
        'med_nome',
        'med_crm'
    ];

    /* Relationships area */
    public function especialidade()
    {
        return $this->belongsTo(Especialidade::class, 'espec_codigo');
    }

    public function procedimento()
    {
        return $this->hasMany(procedimento::class, 'med_codigo');
    }

    public function consulta()
    {
        return $this->hasMany(Consulta::class, 'med_codigo');
    }
}
