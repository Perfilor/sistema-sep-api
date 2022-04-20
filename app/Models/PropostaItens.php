<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropostaItens extends Model
{
  protected $guarded = [];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_propitens';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = null;
  public $incrementing = false;
}