@extends('app')
@section('content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{ isset($Cliente) ? route('editar', $Cliente->id) : route('novo') }}">
	<fieldset>
	{{ csrf_field() }}
	<!-- Form Name -->
	<legend>Cliente</legend>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="nome">Nome</label>  
	  <div class="col-md-4">
	  <input value="{{ isset($Cliente) ? $Cliente->nome : '' }}" id="nome" name="nome" type="text" placeholder="Nome" class="form-control input-md" required="">
	  <span class="help-block">Nome completo do cliente</span>  
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="email">Email</label>  
	  <div class="col-md-4">
	  <input value="{{ isset($Cliente) ? $Cliente->email : '' }}" id="email" name="email" type="email" placeholder="Email" class="form-control input-md" required="">
	  <span class="help-block">O email tem que ser válido</span>  
	  </div>
	</div>

	<!-- Text input-->
	<div class="form-group">
	  <label class="col-md-4 control-label" for="telefone">Telefone</label>  
	  <div class="col-md-4">
	  <input value="{{ isset($Cliente) ? $Cliente->telefone : '' }}"  id="telefone" name="telefone" type="text" placeholder="Telefone" class="form-control input-md" required="">
	  <span class="help-block">Telefone do cliente</span>  
	  </div>
	</div>
	@if(isset($Cliente) && !empty($Cliente->foto))
		<img src="data:image/png;base64, {{ base64_encode(Storage::get($Cliente->foto)) }}"></img>
	@endif
	<!-- File Button --> 
	<div class="form-group">
	  <label class="col-md-4 control-label" for="foto">Foto</label>
	  <div class="col-md-4">
		<input value="{{ isset($Cliente) ? $Cliente->foto : '' }}"  id="foto" name="foto" class="input-file" type="file">
	  </div>
	</div>
	<!-- Button -->

	<div class="form-group">
	  <label class="col-md-4 control-label" for=""></label>
	  <div class="col-md-4">
		<button class="btn btn-success">Button</button>
	  </div>
	</div>
	</fieldset>
</form>
@endsection