<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dizimista;
use App\Models\pagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use PDF;
class ReportsController extends Controller
{

    public function searchDizimista(Request $request)
    {
         $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();
        if ($request->has('search_ano_ref') && $request->has('search_mes_ref')) {
            $search_ano_ref = $request->get('search_ano_ref');
            $search_mes_ref = $request->get('search_mes_ref');
            $pagamentos = pagamento::with('dizimista')->where('anoreferencia',$search_ano_ref)->where('mesreferencia',$search_mes_ref)->orderBy('datapagamento', 'DESC')->orderBy('coddizimista')->paginate(15);
        }
       if ($request->has('search_ano_pag') && $request->has('search_mes_pag')) {
            $search_ano_ref = $request->get('search_ano_pag');
            $search_mes_ref = $request->get('search_mes_pag');
            $pagamentos = pagamento::with('dizimista')->whereYear('datapagamento',$search_ano_ref)->whereMonth('datapagamento',$search_mes_ref)->paginate(15);
        }
        if ($request->has('search_diz')) {
            $search_diz = $request->get('search_diz');
            $pagamentos = pagamento::with('dizimista')->where('CodDizimista',$search_diz)->orderBy('datapagamento', 'DESC')->orderBy('coddizimista')->paginate(15);
        }

        return view('pagamentos.index', compact('pagamentos','Dizimistas'));
    }

    public function reportDizimista(Request $request)
    {
        $array_where = array();
        $Dizimistas = Dizimista::orderBy('nome')->paginate(400);
        if ($request->filled('search_nome')) {
            $search_nome = $request->get('search_nome');
            $array_where[] = ['nome','like','%'.$search_nome.'%'];
        }
       if ($request->filled('search_num')) {
            $search_num = $request->get('search_num');
            $array_where[] = ['Numero',$search_num];
        }
        if ($request->filled('search_dt_nasc')) {
            $search_dt_nasc = $request->get('search_dt_nasc');
            $array_where[] = ['DataNascimento',$search_dt_nasc];
        }
         if ($request->filled('search_ativo') && !$request->filled('search_inativo')) {
            $search_ativo = $request->get('search_ativo');
            $array_where[] = ['codsituacaodizimista',$search_ativo];
        }
         if ($request->filled('search_inativo') && !$request->filled('search_ativo')) {
            $search_inativo = $request->get('search_inativo');
            $array_where[] = ['codsituacaodizimista',$search_inativo];
        }
        if($request->filled('ordem')){
            $Dizimistas = Dizimista::where($array_where)->orderBy($request->get('ordem'));
        }else{
            $Dizimistas = Dizimista::where($array_where)->orderBy('nome');
        }

        if($request->filled('n_reg')){
            $Dizimistas = $Dizimistas->paginate($request->get('n_reg'));
        }else{
            $Dizimistas = $Dizimistas->paginate(20);
        }
        $CountDizimistas = $Dizimistas->total();
        return view('/reports/dizimistas',compact('Dizimistas'));
    }

    public function reportDizimistaEmAberto(Request $request)
    {
        $array_where = array();
        $Dizimistas =  DB::table('dizimistas')
                                        ->select(DB::raw("DataNascimento,
                                                                        Numero,
                                                                        nome,
                                                                        Telefone1,
                                                                        DATE_FORMAT((SELECT MAX(DataPagamento) FROM pagamentos where pagamentos.coddizimista = dizimistas.coddizimista ), '%d/%m/%Y') as DtUltPag,
                                                                        TIMESTAMPDIFF(MONTH,(SELECT MAX(DataPagamento) FROM pagamentos where pagamentos.coddizimista = dizimistas.coddizimista ),CURDATE()) as Meses"));
        if ($request->filled('search_nome')) {
            $search_nome = $request->get('search_nome');
            $array_where[] = ['nome','like','%'.$search_nome.'%'];
        }
       if ($request->filled('search_num')) {
            $search_num = $request->get('search_num');
            $array_where[] = ['Numero',$search_num];
        }
        if ($request->filled('search_meses')) {
            $search_meses = $request->get('search_meses');
            $Dizimistas = $Dizimistas->whereRaw('TIMESTAMPDIFF(MONTH,(SELECT MAX(DataPagamento) FROM pagamentos where pagamentos.coddizimista = dizimistas.coddizimista ),CURDATE())
                                                                        >= '.$search_meses);
        }
        if ($request->filled('search_ativo') && !$request->filled('search_inativo')) {
            $search_ativo = $request->get('search_ativo');
            $array_where[] = ['codsituacaodizimista',$search_ativo];
        }
         if ($request->filled('search_inativo') && !$request->filled('search_ativo')) {
            $search_inativo = $request->get('search_inativo');
            $array_where[] = ['codsituacaodizimista',$search_inativo];
        }
        if($request->filled('ordem')){
            $Dizimistas = $Dizimistas->where($array_where)->orderBy($request->get('ordem'));
        }else{
            $Dizimistas = $Dizimistas->where($array_where)->orderBy('nome');
        }

        if($request->filled('n_reg')){
            $Dizimistas = $Dizimistas->paginate($request->get('n_reg'));
        }else{
            $Dizimistas = $Dizimistas->paginate(20);
        }
        $CountDizimistas = $Dizimistas->total();
        return view('/reports/meses_em_aberto',compact('Dizimistas'));
    }

    public function reportAniversariante(Request $request)
    {
        $array_where = '';
        $Dizimistas = Dizimista::orderBy('nome')->paginate(400);
        $Dizimistas =  DB::table('dizimistas')
                                        ->select(DB::raw("DataNascimento,
                                                                        Numero,
                                                                        nome,
                                                                        Telefone1,
                                                                        CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0')),
                                                                        WEEK(CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0'))) as n_semana,
                                                                        CONCAT(
	DATE_FORMAT(date_add(CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0')), INTERVAL -(DAYOFWEEK(CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0')))-1) DAY), '%d/%m/%Y') ,
	' à ',
	DATE_FORMAT(date_add(date_add(CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0')), interval -DAYOFWEEK(CONCAT(YEAR(CURDATE()),'-',lpad(month(dataNascimento),2,'0'),'-',lpad(day(dataNascimento),2,'0')))+1 day), INTERVAL 6 DAY), '%d/%m/%Y') ) as semana
                                                                        "))
                                        ->whereRaw('datanascimento IS NOT NULL')
                                        ->whereRaw("datanascimento <> '0900-01-01'")
                                        ->whereRaw("datanascimento <> '1900-01-01'");
       if ($request->filled('search_mes_ini') && $request->filled('search_mes_fim')) {
            $search_mes_ini = $request->get('search_mes_ini');
            $search_mes_fim = $request->get('search_mes_fim');
            $array_where = 'MONTH(DataNascimento) between '.$search_mes_ini.' and '.$search_mes_fim;
            $Dizimistas = $Dizimistas->whereRaw($array_where);
        }

        $Dizimistas = $Dizimistas->orderByRaw(5)
                                                 ->get();

       /* if($request->filled('n_reg')){
            $Dizimistas = $Dizimistas->paginate($request->get('n_reg'));
        }else{
            $Dizimistas = $Dizimistas->paginate(20);
        }
        $CountDizimistas = $Dizimistas->total();*/
        //echo $Dizimistas;
        return view('/reports/aniversariantes',compact('Dizimistas'));
    }

    public function reportPagamento(Request $request)
    {
        $array_where = array();
        $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();
        $Pagamentos = pagamento::with('dizimista')->orderBy('datapagamento', 'DESC')->orderBy('coddizimista');
        if ($request->filled('search_nome')) {
            $search_nome = $request->get('search_nome');
            $array_where[] = ['dizimistas.nome','like','%'.$search_nome.'%'];
        }
       if ($request->filled('search_num')) {
            $search_num = $request->get('search_num');
            $array_where[] = ['dizimistas.Numero',$search_num];
        }
        if ($request->filled('search_dt_pag')) {
            $search_dt_nasc = $request->get('search_dt_pag');
            $array_where[] = ['DataPagamento',$search_dt_nasc];
        }
        $Pagamentos = Pagamento::join('dizimistas','pagamentos.coddizimista','=','dizimistas.coddizimista')->where($array_where)->orderBy('dizimistas.nome');
        $TotalPagamentos = $Pagamentos->sum('Valor');
        if($request->filled('n_reg')){
            $Pagamentos = $Pagamentos->paginate($request->get('n_reg'));
        }else{
            $Pagamentos = $Pagamentos->paginate(20);
        }
        $CountPagamentos = $Pagamentos->total();

        return view('/reports/pagamentos',compact('Pagamentos','TotalPagamentos','CountPagamentos','Dizimistas'));
    }
}
