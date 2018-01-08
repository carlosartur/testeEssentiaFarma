{{ dd($Clientes) }}

<table>
	<thead>
		<th>#</th>
		<th>Nome</th>
		<th>Email</th>
		<th>Foto</th>
		<th>Endereço</th>
	</thead>
	@foreach ($Clientes as $cliente)
		<tr>
			<td>{{ $cliente->id }}</td>
			<td>{{ $cliente->nome }}</td>
			<td>{{ $cliente->email }}</td>
			<td><img src='{{ $cliente->foto }}'></img></td>
		</tr>
	@endforeach
</table>