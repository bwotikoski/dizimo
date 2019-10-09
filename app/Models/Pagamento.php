<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $primaryKey = 'CodPagamento';







    public $timestamps = false;

    protected $appends = ['resource_url'];

    /**
     * Get the Dizimista for this model.
     *
     * @return App\Models\Dizimista
     */
    public function Dizimista()
    {
        return $this->belongsTo('App\Models\Dizimista','coddizimista','coddizimista');
    }

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/pagamentos/'.$this->getKey());
    }


}
