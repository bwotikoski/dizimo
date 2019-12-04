
<div class="form-group ">
    <label for="Num_Diz" class="col-md-2 control-label">N° Dizimista</label>
    <div class="col-md-10">
        <input class="form-control" name="Num_Diz" type="text" id="Num_Diz" autofocus>

    </div>
</div>

<div class="form-group {{ $errors->has('coddizimista') ? 'has-error' : '' }}">
    <label for="coddizimista" class="col-md-2 control-label">Dizimista</label>
    <div class="col-md-10">
        <select class="form-control" id="coddizimista" name="coddizimista" required="true">
        	    <option value="" style="display: none;" {{ old('coddizimista', optional($pagamento)->coddizimista ?: '') == '' ? 'selected' : '' }} disabled selected></option>
        	@foreach ($Dizimistas as $key => $Dizimista)
			    <option value="{{ $key }}" {{ old('coddizimista', optional($pagamento)->coddizimista) == $key ? 'selected' : '' }}>
			    	{{ $Dizimista }}
			    </option>
			@endforeach
        </select>

        {!! $errors->first('coddizimista', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('DataPagamento') ? 'has-error' : '' }}">
    <label for="DataPagamento" class="col-md-2 control-label">Data do Pagamento</label>
    <div class="col-md-10">
        <input class="form-control" name="DataPagamento" type="date" id="DataPagamento" value="{{ old('DataPagamento', optional($pagamento)->DataPagamento) }}" required="true" placeholder="">
        {!! $errors->first('DataPagamento', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('Valor') ? 'has-error' : '' }}">
    <label for="Valor" class="col-md-2 control-label">Valor</label>
    <div class="col-md-10">
        <input class="form-control" name="Valor" type="number" id="Valor" value="{{ old('Valor', optional($pagamento)->Valor) }}" min="-1000000000000000" max="1000000000000000" required="true" placeholder="" step="any">
        {!! $errors->first('Valor', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('MesReferencia') ? 'has-error' : '' }}">
    <label for="MesReferencia" class="col-md-2 control-label">Mês de Referência</label>
    <div class="col-md-10">
        <input class="form-control" name="MesReferencia" type="text" id="MesReferencia" value="{{ old('MesReferencia', optional($pagamento)->MesReferencia) }}" minlength="1" maxlength="2" required="true" placeholder="">
        {!! $errors->first('MesReferencia', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<div class="form-group {{ $errors->has('AnoReferencia') ? 'has-error' : '' }}">
    <label for="AnoReferencia" class="col-md-2 control-label">Ano de Refêrencia</label>
    <div class="col-md-10">
        <input class="form-control" name="AnoReferencia" type="text" id="AnoReferencia" value="{{ old('AnoReferencia', optional($pagamento)->AnoReferencia) }}" minlength="1" maxlength="4" required="true" placeholder="">
        {!! $errors->first('AnoReferencia', '<p class="help-block">:message</p>') !!}
    </div>
</div>

<script>

   window.addEventListener("load",function(){
   $('#coddizimista').select2();

   var d = new Date();
   var mm = (d.getMonth()+1).toString();
   var strDate = d.getFullYear() + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (d.getDate().toString()[1]?d.getDate().toString():"0"+d.getDate().toString()[0]);

   if($('#DataPagamento').val() == ''){
        $('#DataPagamento').val('2019-11-25');
   }

});

window.addEventListener("load",function(){

   $('#coddizimista').change(function(e) {
   $.ajax({
            url: "{{ route('pagamentos.pagamento.searchajax') }}",
            data: {

                    search_diz : $('#coddizimista').val()
             },
            dataType: "json",
            success: function(data){
               var resp = $.map(data,function(obj){

                    $('#Valor').val(obj.valor);
                    $('#AnoReferencia').val(obj.ano);
                    switch(obj.mes){
                        case '01': $('#MesReferencia').val('02');
                        break;
                        case '02': $('#MesReferencia').val('03');
                        break;
                        case '03': $('#MesReferencia').val('04');
                        break;
                        case '04': $('#MesReferencia').val('05');
                        break;
                        case '05': $('#MesReferencia').val('06');
                        break;
                        case '06': $('#MesReferencia').val('07');
                        break;
                        case '07': $('#MesReferencia').val('08');
                        break;
                        case '08': $('#MesReferencia').val('09');
                        break;
                        case '09': $('#MesReferencia').val('10');
                        break;
                        case '10': $('#MesReferencia').val('11');
                        break;
                        case '11': $('#MesReferencia').val('12');
                        break;
                        case '12': $('#MesReferencia').val('01');
                        break;

                    }
                    $('#incluir').focus();
                    //return obj.name;
               });

               //response(resp);
            }
            });
   });

    $('#Num_Diz').focusout(function(e) {
        if($('#Num_Diz').val() != ''){
            $.ajax({
                    url: "{{ route('pagamentos.pagamento.searchajax') }}",
                    data: {
                            numDiz : $('#Num_Diz').val()
                    },
                    dataType: "json",
                    success: function(data){
                    var resp = $.map(data,function(obj){
                            $('#coddizimista').val(obj.coddizimista).change();
                            //return obj.name;
                    });

                    //response(resp);
                    }
                    });
        }
   });
});
</script>
