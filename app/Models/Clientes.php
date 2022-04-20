<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'tab_cliente';

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
  protected $fillable = ['Id', 'Tipo', 'Documento', 'RazaoSocial', 'Endereco', 'Numero', 'Bairro', 'Cidade', 'uf_clientefinal', 'UF', 'IE', 'Telefone', 'Celular', 'Email', 'Contribuinte', 'Cep', 'RespCadastro', 'Segmento'];
}