<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model {

    protected $fillable = [
        'description', 'is_completed', 'completed_at', 'due', 'urgency', 'updated_by', 'user_id', 'checklist_id','due_interval', 'due_unit',
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

    public function checklist()
    {
        return $this->belongsTo('App\Checklist');
    }
}