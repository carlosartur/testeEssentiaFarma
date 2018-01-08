<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ClientesController extends Controller
{
	/**
	 * Lista todos os clientes.
	 * @return view
	 */
    public function listar(Request $request)
	{
		$busca = $request->has('busca') ? $request->busca : false;
		$request->flash();
		$Clientes = Cliente
			::with('endereco')
			->when($busca, function ($query) use ($busca){
				return $query->where('nome', 'LIKE', "%$busca%")->orWhere('email', 'LIKE', "%$busca%");
			})
			->get();
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
		$request->flash();
		$this->validate($request, [
			'nome' => 'required|max:255',
			'telefone' => 'required|max:255',
			'email' => 'required|email|max:255',
		]);
		return $this->salvar($request, $id);
	}
	
	/**
	 * Realiza a adição conforme formulário
	 */
	public function novo(Request $request)
	{
		$request->flash();
		$this->validate($request, [
			'nome' => 'required|unique:clientes|max:255',
			'telefone' => 'required|unique:clientes|max:255',
			'email' => 'required|email|unique:clientes|max:255',
		]);
		return $this->salvar($request);
	}
	/**
	 * Realiza a exclusão conforme formulário
	 */
	public function delete(Request $request, $id)
	{
		$Cliente = Cliente::find($id);
		try {
			DB::beginTransaction();
			$Cliente->delete();
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
		}
		return redirect()->route('home');
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
			if ($request->rua ||
				$request->numero ||
				$request->cidade ||
				$request->estado ||
				$request->pais) 
			{
				$this->salvaEndereco($request, $Cliente->id);
			}
			DB::commit();
		} catch (Exception $e) {
			DB::rollBack();
			return back()->withInput();
		}
		return redirect()->route('home');
	}
	
	private function salvaEndereco(Request $request, $id)
	{
		$Endereco = Endereco::where('cliente_id', $id)->first();
		if(!$Endereco) {
			$Endereco = new Endereco();
		}
		$Endereco->cliente_id = $id;
		$Endereco->rua = $request->rua;
		$Endereco->numero = $request->numero;
		$Endereco->cidade = $request->cidade;
		$Endereco->estado = $request->estado;
		$Endereco->pais = $request->pais;
		$Endereco->save();
	}
}
