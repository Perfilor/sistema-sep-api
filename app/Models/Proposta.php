<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model
{
  protected $guarded = [];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_propcliente';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = 'contador';
}