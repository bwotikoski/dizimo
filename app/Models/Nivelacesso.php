<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivelacesso extends Model
{
    protected $primaryKey = 'codnivelacesso';

    protected $fillable = [
        "CodNivelAcesso",
        "Descricao",

    ];

    protected $hidden = [

    ];

    protected $dates = [

    ];


    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/nivelacessos/'.$this->getKey());
    }


}
