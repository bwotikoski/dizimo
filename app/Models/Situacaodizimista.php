<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Situacaodizimista extends Model
{
    protected $primaryKey = 'codsituacaodizimista';

    protected $fillable = [
        "CodSituacaoDizimista",
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
        return url('/admin/situacaodizimistas/'.$this->getKey());
    }


}
