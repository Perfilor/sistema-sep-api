<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupoEmpresa extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_grupoempresa';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'Id';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'Id', 'Grupo_Empresa'
  ];
}