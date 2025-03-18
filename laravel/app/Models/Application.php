<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    
    protected $fillable = ['user_id', 'offer_id', 'cv'];
   
   
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function offer() {
        return $this->belongsTo(Offer::class);
    }
}
