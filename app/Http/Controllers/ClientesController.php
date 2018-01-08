<?php

namespace App\Http\Controllers;

use App\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientesController extends Controller
{
	/**
	 * Lista todos os clientes.
	 * @return view
	 */
    public function listar()
	{
		$Clientes = Cliente::with('endereco')->get();
		return view('clientes.listar')->with(compact('Clientes'));
	}
	
	/**
	 * Chama o formulário de edição
	 */
	public function formEditar($id)
	{
		$Cliente = Cliente::with('endereco')->find($id);
		return view('clientes.adicionar_modificar')->with(compact('Cliente'));
	}
	
	/**
	 * Chama o formulário de edição
	 */
	public function formAdicionar()
	{
		return view('clientes.adicionar_modificar');
	}
	
	/**
	 * Realiza a edição conforme formulário
	 */
	public function editar(Request $request, $id)
	{
		$this->validate($request, [
			'nome' => 'required|max:255',
			'telefone' => 'required|max:255',
			'email' => 'required|email|max:255',
			'foto' => 'required|mimes:jpeg,bmp,png',
		]);
		return $this->salvar($request, $id);
	}
	
	/**
	 * Realiza a adição conforme formulário
	 */
	public function novo(Request $request)
	{
		$this->validate($request, [
			'nome' => 'required|unique:clientes|max:255',
			'telefone' => 'required|unique:clientes|max:255',
			'email' => 'required|email|unique:clientes|max:255',
			'foto' => 'required|mimes:jpeg,bmp,png',
		]);
		return $this->salvar($request);
	}
	
	/**
	 * Efetivamente salva no banco as modificações do cliente
	 */
	private function salvar(Request $request, $id = false) 
	{
		$Cliente = $id ? Cliente::find($id) : new Cliente();
		$Cliente->nome = $request->nome;
		$Cliente->telefone = $request->telefone;
		$Cliente->email = $request->email;
		try {
			$Cliente->foto = Storage::disk('local')->put('avatar', $request->foto);
			DB::beginTransaction();
			$Cliente->save();
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			return back()->withInput();
		}
		return back();
	}
}
