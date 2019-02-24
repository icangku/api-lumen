<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model {
    
    protected $fillable = [
        'object_domain', 'object_id', 'description', 'completed_at', 'updated_by', 'due', 'due_interval', 'due_unit', 'urgency', 'template_id'
    ];

    public function getUpdatedAtAttribute($value){
        return date('c', strtotime($value));
    }

    public function getCreatedAtAttribute($value){
        return date('c', strtotime($value));
    }

    public function getCompletedAtAttribute($value){
        return date('c', strtotime($value));
    }

    public function getDueAttribute($value){
        return date('c', strtotime($value));
    }

    public function getIsCompletedAttribute($value){
        return (bool) $value;
    }

    public function items()
    {
        return $this->hasMany('App\Item');
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($checklist) { // before delete() method call this
             $checklist->items()->delete();
             // do the rest of the cleanup...
        });
    }
}