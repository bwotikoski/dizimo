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
    .panel-footer{
        padding-top:0px;
    }
    .table{
        margin-bottom:0px;
    }
    .panel-body{
        padding-bottom:0px;
    }
    .btn{
        margin-top:0px;
    }
    .table-striped>tbody>tr:nth-of-type(odd) {
    background-color: #feffd9;
}
.panel-heading {
    background-color: rgb(77, 43, 10) !important;
}
.pull-left h4{
    color:white !important;
}
.p1{
    color:white;
    margin-left:5px;
    margin-top: 3px;
}

.btn-primary{
    background: #f6e381 !important;
}
 thead>tr>th {
    font-weight:bold !important;
}
.total{
    font-weight:bold;
}
.page-link{
    color:rgb(77, 43, 10) !important;
}
.pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
    background-color: rgb(77, 43, 10) !important;
    border-color:rgb(77, 43, 10) !important;
    color:white !important;
}

    @media print {
        .form-control, .form-group-btn, .btn-primary, .panel-footer {
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
        <div class="panel-heading clearfix" >
            <div class="pull-left" >
                <img src="{{ asset('/img/SFLogoCantoRel.png') }}"  style=" height: 44px;">
            </div>
            <div class="pull-left p1" >
                <h4 >Pagamentos</h4>
            </div>
            <form action="/pagamentos/relatorioPagamento" method="get" style="margin-top: 5px;">
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
                                <input type="date" name="search_dt_pag" placeholder="Dt. Pagamento" class="form-control" style="float:left;width: auto;">
                                <span class="form-group-btn">
                                </span>
                            </div>

                    </div>
                    <button type="submit" class="btn btn-primary" >
                        <span class="glyphicon glyphicon-search" style="color:#CA742D;font-weight:bold;" aria-hidden="true"> Filtrar</span>
                    </button>
                    <button id="bt_print" class="btn btn-primary" onClick="window.print()">
                        <span class="glyphicon glyphicon-print" style="color:#CA742D;font-weight:bold;" aria-hidden="true"> Imprimir</span>
                    </button>

                    <div class="col-md-2" style="float:right;">

                            <div class="form-group" style="float:right;margin-bottom: 0px;">
                                <input type="number" name="n_reg" placeholder="N° Reg." class="form-control" style="float:left;width: 100px;">
                                <span class="form-group-btn">
                                </span>
                            </div>
                            <button type="submit" class="btn btn-primary" style="float:right;">
                                <span class="glyphicon glyphicon-search" style="color:#CA742D;font-weight:bold;" aria-hidden="true"> </span>
                            </button>

                    </div>
                </form>
        </div>

        @if(count($Pagamentos) == 0)
            <div class="panel-body text-center">
                <h4>No Dizimistas Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr class="columns">
                            <th>Dizimista</th><th>Dt. Pagamento</th><th>Valor</th><th>Mês Referência</th><th>Ano Referência</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($Pagamentos as $pagamento)
                        <tr >
                            <td>{{ $pagamento->Dizimista->nome }}</td><td>{{ date('d/m/Y', strtotime($pagamento->DataPagamento)) }}</td>
                            <td>{{ $pagamento->Valor }}</td>
                            <td>{{ $pagamento->MesReferencia }}</td><td>{{ $pagamento->AnoReferencia }}</td>
                        </tr>
                    @endforeach
                    <tr class="total">
                        <td>N° Registros: {{ $CountPagamentos }}</td>
                        <td></td>
                        <td>R${{ number_format($TotalPagamentos, 2, ',', '.') }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>

        <div class="panel-footer">
            {!! $Pagamentos->render() !!}
        </div>

        @endif

    </div>


        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>


