<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dizimista extends Model
{
    protected $primaryKey = 'coddizimista';

    protected $fillable = [
        "CodDizimista",
        "Numero",
        "Nome",
        "DataNascimento",
        "EMail",
        "CodIntegranteResponsavel",
        "Sexo",
        "CodSituacaoDizimista",
        "DataInscricao",
        "EndLogradouro",
        "EndNumero",
        "EndEdificio",
        "EndApto",
        "EndComplemento",
        "EndBairro",
        "EndMunicipio",
        "EndCEP",
        "Obs",
        "Telefone1",
        "DataAtualizacao",
        "DataCasamento",
        "DataNascimento2",
        "Telefone2",
        "Mirim",

    ];

    protected $hidden = [

    ];

    protected $dates = [
        "DataNascimento",
        "DataInscricao",
        "DataAtualizacao",
        "DataCasamento",
        "DataNascimento2",

    ];


    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/dizimistas/'.$this->getKey());
    }

     /* ************************ RELATIONS ************************* */

     public function situacaoDizimistas()
     {
         return $this->belongsTo(Situacaodizimista::class);
     }

}
