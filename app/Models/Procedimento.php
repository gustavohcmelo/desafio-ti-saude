<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Procedimento extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'procedimentos';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'proc_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'med_codigo',
        'proc_nome',
        'proc_valor'
    ];

    public function medico()
    {
        return $this->hasMany(Medico::class, 'med_codigo');
    }

    public function consulta_procedimento()
    {
        return $this->hasMany(Consulta_procedimento::class, 'proc_codigo');
    }
}
