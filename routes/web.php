<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/relDiz', function () {
    $Dizimistas = App\Models\Dizimista::orderBy('nome')->paginate(400);
    return view('/reports/dizimistas',compact('Dizimistas'));
});

Route::group([
    'prefix' => 'dizimistas',
], function () {
    Route::get('/searchDizimista', 'ReportsController@searchDizimista');
    Route::get('/relatorioDizimista', 'ReportsController@reportDizimista')
         ->name('reports.dizimistas');
    Route::get('/relatorioDizimistaEmAberto', 'ReportsController@reportDizimistaEmAberto')
         ->name('reports.meses_em_aberto');
    Route::get('/relatorioAniversariante', 'ReportsController@reportAniversariante')
         ->name('reports.aniversariantes');
});

Route::group([
    'prefix' => 'pagamentos',
], function () {
    Route::get('/searchPagamento', 'ReportsController@searchPagamento');
    Route::get('/relatorioPagamento', 'ReportsController@reportPagamento')
         ->name('reports.pagamentos');
    Route::get('/searchajax', 'PagamentosController@autoComplete')->name('pagamentos.pagamento.searchajax');;
    Route::get('/search', 'PagamentosController@search');
    Route::get('/', 'PagamentosController@index')
         ->name('pagamentos.pagamento.index');
    Route::get('/create','PagamentosController@create')
         ->name('pagamentos.pagamento.create');
    Route::get('/show/{pagamento}','PagamentosController@show')
         ->name('pagamentos.pagamento.show');
    Route::get('/{pagamento}/edit','PagamentosController@edit')
         ->name('pagamentos.pagamento.edit');
    Route::post('/', 'PagamentosController@store')
         ->name('pagamentos.pagamento.store');
    Route::put('pagamento/{pagamento}', 'PagamentosController@update')
         ->name('pagamentos.pagamento.update');
    Route::delete('/pagamento/{pagamento}','PagamentosController@destroy')
         ->name('pagamentos.pagamento.destroy');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
