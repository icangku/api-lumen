<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {
    
    protected $fillable = [
        'name'
    ];

    public function checklist()
    {
        return $this->hasOne('App\Checklist');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($template) { // before delete() method call this
             $template->checklist()->delete();
             // do the rest of the cleanup...
        });
    }
}