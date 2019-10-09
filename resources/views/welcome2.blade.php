<!DOCTYPE html>
<html>
  <head>
  <title>Paginação com Filtro</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
  <h1>Lista</h1>
  Filter:
  <a href="/teste?ano=2019">2019</a>
  <a href="/teste?ano=2018">2018</a>
  <a href="/teste">Reset</a>
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Dizimista</th>
            <th>Ano</th>
        </tr>
    </thead>
    <tbody>
    @foreach($pagamentos as $pagamento)
        <tr>
            <td>{{ $pagamento->coddizimista }}</td>
            <td>{{ $pagamento->AnoReferencia }}</td>
        </tr>
    @endforeach
    </tbody>
  </table>
  {{$pagamentos->links()}}
  </body>
</html>
