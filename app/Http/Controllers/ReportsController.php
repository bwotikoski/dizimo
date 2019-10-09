<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dizimista;
use App\Models\pagamento;
use Illuminate\Http\Request;
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
        $Dizimistas = Dizimista::orderBy('nome')->paginate(400);
        if ($request->filled('search_nome')) {
            $search_nome = $request->get('search_nome');
            $Dizimistas = Dizimista::where('nome','like','%'.$search_nome.'%')->orderBy('Numero')->orderBy('nome')->paginate(400);
        }
       if ($request->filled('search_num')) {
            $search_num = $request->get('search_num');
            $Dizimistas = Dizimista::where('Numero',$search_num)->orderBy('Numero')->orderBy('nome')->paginate(400);
        }
        if ($request->filled('search_dt_nasc')) {
            $search_dt_nasc = $request->get('search_dt_nasc');
            $Dizimistas = Dizimista::where('DataNascimento',$search_dt_nasc)->orderBy('Numero')->orderBy('nome')->paginate(400);
        }


        return view('/reports/dizimistas',compact('Dizimistas'));
    }

    public function reportPagamento(Request $request)
    {
        $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();
        $Pagamentos = pagamento::with('dizimista')->orderBy('datapagamento', 'DESC')->orderBy('coddizimista')->paginate(4000);
        if ($request->filled('search_nome')) {
            $search_nome = $request->get('search_nome');
            $Pagamentos = Pagamento::where('nome','like','%'.$search_nome.'%')->orderBy('Numero')->orderBy('nome')->paginate(400);
        }
       if ($request->filled('search_num')) {
            $search_num = $request->get('search_num');
            $Pagamentos = Pagamento::where('Numero',$search_num)->orderBy('Numero')->orderBy('nome')->paginate(400);
        }
        if ($request->filled('search_dt_nasc')) {
            $search_dt_nasc = $request->get('search_dt_nasc');
            $Pagamentos = Pagamento::where('DataNascimento',$search_dt_nasc)->orderBy('Numero')->orderBy('nome')->paginate(400);
        }


        return view('/reports/pagamentos',compact('Pagamentos'));
    }
}
