<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;

class Consulta_procedimento extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consulta_procedimento';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'cons_proc_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'proc_codigo',
        'cons_codigo'
    ];

    /* Relationships area */
    public function procedimento()
    {
        return $this->belongsTo(Procedimento::class, 'proc_codigo');
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'cons_codigo');
    }
}
