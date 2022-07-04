<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Telefone extends Model
{
    use HasFactory, SoftDeletes, CreatedUpdatedBy;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'telefones';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'tel_codigo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pac_codigo',
        'tel_descricao'
    ];

    /* Relationships area */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pac_codigo');
    }
}
