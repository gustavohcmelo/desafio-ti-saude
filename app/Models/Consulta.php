<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Consulta extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consultas';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cons_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pac_codigo',
        'med_codigo',
        'cons_data',
        'cons_hora',
        'cons_particular'
    ];

    public function paciente()
    {
        return $this->hasMany(Paciente::class, 'pac_codigo');
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'med_codigo');
    }
}
