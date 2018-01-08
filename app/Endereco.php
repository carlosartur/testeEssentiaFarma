<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
	public function paraImprimir()
	{
		return "{$this->rua}, {$this->numero}, {$this->cidade} / {$this->estado} - {$this->pais}";
	}
}
