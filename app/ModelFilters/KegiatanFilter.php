<?php namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class KegiatanFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [
        // 'perjadins' => ['perjalanan_id']
    ];

    public function user($user)
    {
        return $this->related('perjadins', 'user_id', $user);
    }

    public function keterangan($keterangan){
        return $this->related('perjadins', 'keterangan', '%'.$keterangan.'%');
    }

    public function tipe($tipe)
    {
        return $this->related('perjadins','tipe_pengeluaran', $tipe);
    }

    public function total($total){
        if($total['total'] != ''){
            return $this->related('perjadins','total', ($total['diatas'] == 1 ? '>' : '<') , $total['total']);
        }
    }

    public function perjalanan($perjalanan){
        return $this->related('perjadins', 'perjalanan_id', $perjalanan);
    }
}
