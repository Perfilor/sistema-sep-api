<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropostaSubItens extends Model
{
  protected $guarded = [];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_propsubitem';

  /**
   * The primary key associated with the table.
   *
   * @var string
   */
  protected $primaryKey = null;
  public $incrementing = false;
}