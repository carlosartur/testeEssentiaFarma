@extends('app')
@section('content')
	<table class"table table-striped">
		<thead>
			<th>#</th>
			<th>Nome</th>
			<th>Foto</th>
			<th>Email</th>
			<th>Endereço</th>
			<th>Ações</th>
		</thead>
		@foreach ($Clientes as $cliente)
			<tr>
				<td>{{ $cliente->id }}</td>
				<td>{{ $cliente->nome }}</td>
				<td>
					@if($cliente->foto)
						<img style="max-width: 50px; max-height: 50px;" src="data:image/png;base64, {{ base64_encode(Storage::get($cliente->foto)) }}"></img>
					@endif
				</td>
				<td>{{ $cliente->email }}</td>
				<td>{{ 
					$cliente->endereco 
						? $cliente->endereco->paraImprimir()
						: '-'
				}}</td>
				<td>
					<a class="btn btn-primary editar" href="{{ route('formEditar', $cliente->id) }}">
						Editar
					</a>
					<button class="btn btn-danger deletar" data-id="{{ $cliente->id }}">
						&times;
					</button>
				</td>
			</tr>
		@endforeach
	</table>
@endsection

@push('js')
<script>
	$(function() { 
		$('.deletar').click(function() {
			var $id = $(this).data('id');
			swal({
			  title: "Você tem certeza?",
			  text: "Isso não pode ser desfeito",
			  icon: "warning",
			  buttons: ['Cancelar', 'Sim, deletar'],
			  dangerMode: true
			})
			.then((willDelete) => {
			  if (willDelete) {
				window.location = '{{ route("delete") }}' + '/' + $id; 
			  } else {
				swal("Cliente mantido!");
			  }
			});
		});
	});
</script>
@endpush