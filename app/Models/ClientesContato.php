<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientesContato extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_cliente_contato';

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
  protected $fillable = ['Codigo_cliente', 'Nome', 'Contato_Emp', 'Endereco', 'Numero', 'Bairro', 'Cidade', 'UF', 'IE', 'Telefone', 'Celular', 'Email', 'CEP'];
}