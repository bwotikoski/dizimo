<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dizimista;
use App\Models\pagamento;
use Illuminate\Http\Request;
use Exception;
use PDF;
class PagamentosController extends Controller
{

    /**
     * Display a listing of the pagamentos.
     *
     * @return Illuminate\View\View
     */
    public function index(Request $request)
    {
        $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();
        $pagamentos = pagamento::with('dizimista')->orderBy('datapagamento', 'DESC')->orderBy('coddizimista')->paginate(15);

        return view('pagamentos.index', compact('pagamentos','Dizimistas'));
    }

    public function search(Request $request)
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
        $Dizimistas = Dizimista::orderBy('nome')->paginate(400);
        return view('/pagamentos/index',compact('pagamentos','Dizimistas'));

    }

public function autoComplete(Request $request) {
        $query = $request->get('search_diz','');

        $pagamentos=Pagamento::where('coddizimista',$query)->orderBy('AnoReferencia','desc')->orderBy('MesReferencia','desc')->take(1)->get();

        $data=array();
        foreach($pagamentos as $pagamento){
            $data[]=array('valor'=>$pagamento->Valor,'mes'=>$pagamento->MesReferencia,'ano'=>$pagamento->AnoReferencia);
        }
        if(count($data))
             return $data;
        else
            return ['value'=>'No Result Found','id'=>''];
    }

    /**
     * Show the form for creating a new pagamento.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();

        return view('pagamentos.create', compact('Dizimistas'));
    }

    /**
     * Store a new pagamento in the storage.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        try {

            // $data = $this->getData($request);
            // $data = $this->getData([ CodPagamento : 5555,
            //                 coddizimista : 2,
            //                 DataPagamento: '2019-09-02',
            //                 Valor: 100.000,
            //                 MesReferncia: "02",
            //                 AnoReferencia: "2019"
            // ]);
            // pagamento::create($data);
        $pagamento = new Pagamento;
        $pagamento->coddizimista = $request->coddizimista;
        $pagamento->DataPagamento = $request->DataPagamento;
        $pagamento->Valor = $request->Valor;
        $pagamento->MesReferencia = $request->MesReferencia;
        $pagamento->AnoReferencia = $request->AnoReferencia;

        $pagamento->save();
            return redirect()->route('pagamentos.pagamento.index')
                ->with('success_message', 'Pagamento was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'teste'.$exception]);
        }
    }

    /**
     * Display the specified pagamento.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $pagamento = pagamento::with('dizimista')->findOrFail($id);

        return view('pagamentos.show', compact('pagamento'));
    }

    /**
     * Show the form for editing the specified pagamento.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $pagamento = pagamento::findOrFail($id);
        $Dizimistas = Dizimista::pluck('nome','coddizimista')->all();

        return view('pagamentos.edit', compact('pagamento','Dizimistas'));
    }

    /**
     * Update the specified pagamento in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        try {

            $pagamento = pagamento::findOrFail($id);
            $pagamento->coddizimista = $request->coddizimista;
            $pagamento->DataPagamento = $request->DataPagamento;
            $pagamento->Valor = $request->Valor;
            $pagamento->MesReferencia = $request->MesReferencia;
            $pagamento->AnoReferencia = $request->AnoReferencia;
            $pagamento->save();

            return redirect()->route('pagamentos.pagamento.index')
                ->with('success_message', 'Pagamento was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'teste'.$exception]);
        }
    }

    /**
     * Remove the specified pagamento from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $pagamento = pagamento::findOrFail($id);
            $pagamento->delete();

            return redirect()->route('pagamentos.pagamento.index')
                ->with('success_message', 'Pagamento was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Illuminate\Http\Request\Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
                'CodDizimista' => 'required|string|min:1',
            'DataPagamento' => 'required|date_format:j/n/Y g:i A',
            'Valor' => 'required|numeric|min:-1.0E+15|max:1.0E+15',
            'MesReferencia' => 'required|string|min:1|max:2',
            'AnoReferencia' => 'required|string|min:1|max:4',
        ];


        $data = $request->validate($rules);




        return $data;
    }

}
