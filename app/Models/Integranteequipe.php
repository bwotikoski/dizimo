<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Integranteequipe extends Model
{
    protected $primaryKey = 'codintegrante';

    protected $fillable = [
        "CodIntegrante",
        "Nome",
        "Aniversario",
        "EMail",
        "Telefone1",
        "Telefone2",
        "CodSituacaoIntegrante",
        "CodNivelAcesso",
        "Login",
        "Senha",

    ];

    protected $hidden = [

    ];

    protected $dates = [

    ];


    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/integranteequipes/'.$this->getKey());
    }


}
