@extends('voyager::master')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href=""> Back</a>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('pagamentos.pagamento.store') }}" accept-charset="UTF-8" id="create_pagamento_form" name="create_pagamento_form" class="form-horizontal">
    @csrf

     <div class="row">

<div class="form-group {{ $errors->has('CodDizimista') ? 'has-error' : '' }}">
    <label for="CodDizimista" class="col-md-2 control-label">Cod Dizimista</label>
    <div class="col-md-10">
        <select class="form-control" id="CodDizimista" name="CodDizimista" required="true">
        	    <option value="" style="display: none;" >Enter cod dizimista here...</option>
        	@foreach ($Dizimistas as $key => $Dizimista)
			    <option value="{{ $key }}" >
			    	{{ $Dizimista }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('CodDizimista', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('DataPagamento') ? 'has-error' : '' }}">
    <label for="DataPagamento" class="col-md-2 control-label">Data Pagamento</label>
    <div class="col-md-10">
        <input class="form-control" name="DataPagamento" type="date" id="DataPagamento" value="" required="true" placeholder="Enter data pagamento here...">
        {!! $errors->first('DataPagamento', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('Valor') ? 'has-error' : '' }}">
    <label for="Valor" class="col-md-2 control-label">Valor</label>
    <div class="col-md-10">
        <input class="form-control" name="Valor" type="number" id="Valor" value="0.00" min="-1000000000000000" max="1000000000000000" required="true" placeholder="Enter valor here..." step="0.01">
        {!! $errors->first('Valor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('MesReferencia') ? 'has-error' : '' }}">
    <label for="MesReferencia" class="col-md-2 control-label">Mes Referencia</label>
    <div class="col-md-10">
        <input class="form-control" name="MesReferencia" type="number" id="MesReferencia" value="" min="1" max="12" required="true" placeholder="Enter mes referencia here...">
        {!! $errors->first('MesReferencia', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('AnoReferencia') ? 'has-error' : '' }}">
    <label for="AnoReferencia" class="col-md-2 control-label">Ano Referencia</label>
    <div class="col-md-10">
        <input class="form-control" name="AnoReferencia" type="number" id="AnoReferencia" value="" min="2000" max="3000" required="true" placeholder="Enter ano referencia here...">
        {!! $errors->first('AnoReferencia', '<p class="help-block">:message</p>') !!}
    </div>
</div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>

</form>
@endsection
