@extends('voyager::master')

@section('content')

    @if(Session::has('success_message'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok"></span>
            {!! session('success_message') !!}

            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>

        </div>
    @endif

    <div class="panel panel-default">

        <div class="panel-heading clearfix">

            <div class="pull-left">
                <h4 class="mt-5 mb-5">Pagamentos</h4>
            </div>


                <div class="col-md-2">
                    <form action="/pagamentos/search" method="get">
                        <div class="form-group">
                            <input type="search" name="search_mes_ref" placeholder="Mês" class="form-control">
                            <input type="search" name="search_ano_ref" placeholder="Ano" class="form-control">
                            <span class="form-group-btn">
                                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true">
                                    </span> Referência
                                </button>
                            </span>
                        </div>
                    </form>
                </div>

                <div class="col-md-2">
                    <form action="/pagamentos/search" method="get">
                        <div class="form-group">
                            <input type="search" name="search_mes_pag" placeholder="Mês" class="form-control">
                            <input type="search" name="search_ano_pag" placeholder="Ano" class="form-control">
                            <span class="form-group-btn"><button type="submit" class="btn btn-primary">  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Pagamento</button></span>
                        </div>
                    </form>
                </div>

                    <div class="col-md-2">
                    <form action="/pagamentos/search" method="get">
                        <div class="form-group">

                                <select class="form-control" id="CodDizimista" name="search_diz" required="true">
                                        <option value="" style="display: none;" disabled selected>Dizimista</option>
                                    @foreach ($Dizimistas as $key => $Dizimista)
                                        <option value="{{ $key }}" >
                                            {{ $Dizimista }}
                                        </option>
                                    @endforeach
                                </select>

                                {!! $errors->first('CodDizimista', '<p class="help-block">:message</p>') !!}

                            <span class="form-group-btn"><button type="submit" class="btn btn-primary">  <span class="glyphicon glyphicon-search" aria-hidden="true"></span> Dizimista</button></span>
                        </div>
                    </form>
                </div>


            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('pagamentos.pagamento.create') }}" style="font-size:18px;" class="btn btn-success" title="Adicionar Novo Pagamento">
                    <span class="glyphicon glyphicon-plus" style="font-size:18px;" aria-hidden="true"></span> Novo Pagamento
                </a>
            </div>

        </div>

        @if(count($pagamentos) == 0)
            <div class="panel-body text-center">
                <h4>No Pagamentos Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Dizimista</th>
                            <th>Dt. Pagamento</th>
                            <th>Valor</th>
                            <th>Mês Referência</th>
                            <th>Ano Referência</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pagamentos as $pagamento)
                        <tr>
                            <td>{{ optional($pagamento->Dizimista)->nome }}</td>
                            <td>{{ date('d/m/Y', strtotime($pagamento->DataPagamento)) }}</td>
                            <td>{{ $pagamento->Valor }}</td>
                            <td>{{ $pagamento->MesReferencia }}</td>
                            <td>{{ $pagamento->AnoReferencia }}</td>

                            <td>

                                <form method="POST" action="{!! route('pagamentos.pagamento.destroy', $pagamento->CodPagamento) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('pagamentos.pagamento.edit', $pagamento->CodPagamento ) }}" style="margin-right:5px;" class="btn btn-primary" title="Edit Pagamento">
                                            <span class="glyphicon glyphicon-pencil" style="font-size: 18px; padding: 5px;" aria-hidden="true"></span>
                                        </a>
                                        <button type="submit" class="btn btn-danger" title="Delete Pagamento" onclick="return confirm(&quot;Click Ok to delete Pagamento.&quot;)">
                                            <span class="glyphicon glyphicon-trash" style="font-size: 18px; padding: 5px;" aria-hidden="true"></span>
                                        </button>
                                    </div>

                                </form>

                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $pagamentos->appends($_GET)->links() !!}
        </div>

        @endif

    </div>
@endsection
