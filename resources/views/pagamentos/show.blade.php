@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading clearfix">

        <span class="pull-left">
            <h4 class="mt-5 mb-5">{{ isset($title) ? $title : 'Pagamento' }}</h4>
        </span>

        <div class="pull-right">

            <form method="POST" action="{!! route('pagamentos.pagamento.destroy', $pagamento->CodPagamento) !!}" accept-charset="UTF-8">
            <input name="_method" value="DELETE" type="hidden">
            {{ csrf_field() }}
                <div class="btn-group btn-group-sm" role="group">
                    <a href="{{ route('pagamentos.pagamento.index') }}" class="btn btn-primary" title="Show All Pagamento">
                        <span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
                    </a>

                    <a href="{{ route('pagamentos.pagamento.create') }}" class="btn btn-success" title="Create New Pagamento">
                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    </a>
                    
                    <a href="{{ route('pagamentos.pagamento.edit', $pagamento->CodPagamento ) }}" class="btn btn-primary" title="Edit Pagamento">
                        <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                    </a>

                    <button type="submit" class="btn btn-danger" title="Delete Pagamento" onclick="return confirm(&quot;Click Ok to delete Pagamento.?&quot;)">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                </div>
            </form>

        </div>

    </div>

    <div class="panel-body">
        <dl class="dl-horizontal">
            <dt>Cod Dizimista</dt>
            <dd>{{ optional($pagamento->Dizimistum)->id }}</dd>
            <dt>Data Pagamento</dt>
            <dd>{{ $pagamento->DataPagamento }}</dd>
            <dt>Valor</dt>
            <dd>{{ $pagamento->Valor }}</dd>
            <dt>Mes Referencia</dt>
            <dd>{{ $pagamento->MesReferencia }}</dd>
            <dt>Ano Referencia</dt>
            <dd>{{ $pagamento->AnoReferencia }}</dd>

        </dl>

    </div>
</div>

@endsection