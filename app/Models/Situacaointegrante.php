<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacaointegrante extends Model
{
    protected $primaryKey = 'codsituacaointegrante';

    protected $fillable = [
        "codsituacaointegrante",
        "descricao",

    ];

    protected $hidden = [

    ];

    protected $dates = [

    ];


    public $timestamps = false;

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/situacaointegrantes/'.$this->getKey());
    }


}
