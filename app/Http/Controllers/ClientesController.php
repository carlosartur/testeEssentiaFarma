<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function listar()
	{
		$Clientes = Cliente::get();
		return view('clientes.listar')->with(compact('Clientes'));
	}
}
