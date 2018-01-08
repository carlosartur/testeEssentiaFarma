<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
	/**
	 * Retorna o endereço formatado para impressão
	 */
	public function paraImprimir()
	{
		return "{$this->rua}, {$this->numero}, {$this->cidade} / {$this->estado} - {$this->pais}";
	}
}
