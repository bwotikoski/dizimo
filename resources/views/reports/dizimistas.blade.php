<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->


    <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    .btn{
        margin-top:0px;
    }
    @media print {
        .form-control, .form-group-btn{
            display:none;
        }
        tr:nth-child(even) td {
            background-color: #f9f9f9 !important;
            -webkit-print-color-adjust: exact;
        }
    }
}
    </style>

</head>
<body>
    <div id="app">
     <main class="py-4">
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <div class="pull-left">
                <h4 >Dizimistas</h4>
            </div>
            <form action="/dizimistas/relatorioDizimista" method="get">
            <div class="col-md-2" style="float:left;">

                        <div class="form-group">
                            <input type="search" name="search_nome" placeholder="Nome" class="form-control" style="float:left;width: auto;">
                            <span class="form-group-btn" >
                            </span>
                        </div>

                </div>

                <div class="col-md-2" style="float:left;">

                        <div class="form-group">
                            <input type="search" name="search_num" placeholder="N°" class="form-control" style="float:left;width: auto;">
                            <span class="form-group-btn">
                            </span>
                        </div>

                </div>

                <div class="col-md-2" style="float:left;">

                        <div class="form-group">
                            <input type="date" name="search_dt_nasc" placeholder="Dt. Nascimento" class="form-control" style="float:left;width: auto;">
                            <span class="form-group-btn">
                            </span>
                        </div>

                </div>


                <div class="col-md-2" style="float:left; margin-top:5px;">
                    <input type="radio" id="search_ativo"
                    name="search_ativo" value="search_ativo">
                    <label for="search_ativo">Ativo</label>

                    <input type="radio" id="search_inativo"
                    name="search_inativo" value="search_inativo">
                    <label for="search_inativo">Inativo</label>

                    <input type="radio" id="search_ativo_inativo"
                    name="search_ativo_inativo" value="search_ativo_inativo">
                    <label for="search_ativo_inativo">Todos</label>

                </div>


                <button type="submit" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-search" aria-hidden="true"> Filtrar</span>
                                </button>
                      </form>
        </div>

        @if(count($Dizimistas) == 0)
            <div class="panel-body text-center">
                <h4>No Dizimistas Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>N°</th><th>Nome</th><th>Telefone</th><th>Dt. Nascimento</th>
                            <th>Sexo</th><th>Situação</th><th>Bairro</th>
                            <th>Município</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Dizimistas as $dizimista)
                        <tr>
                            <td>{{ $dizimista->Numero }}</td><td>{{ $dizimista->nome }}</td><td>{{ $dizimista->Telefone1 }}</td><td>{{ date('d/m/Y', strtotime($dizimista->DataNascimento)) }}</td>
                            <td>{{ $dizimista->Sexo }}</td><td>{{ $dizimista->codsituacaodizimista == 1 ? "Ativo" : "Inativo" }}</td>
                            <td>{{ $dizimista->EndBairro }}</td><td>{{ $dizimista->EndMunicipio }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $Dizimistas->render() !!}
        </div>

        @endif

    </div>


        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>


