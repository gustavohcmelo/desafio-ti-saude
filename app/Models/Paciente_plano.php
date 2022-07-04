<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Paciente_plano extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'paciente_plano';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'pac_plano_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pac_codigo',
        'plano_codigo',
        'nr_contrato'
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pac_codigo');
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class, 'plano_codigo');
    }
}
