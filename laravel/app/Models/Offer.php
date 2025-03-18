<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    /** @use HasFactory<\Database\Factories\OfferFactory> */
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'contract_type', 'location', 'salary'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function applicants() {
        return $this->belongsToMany(User::class, 'applications')
            ->withPivot('cv')
            ->withTimestamps();
    }
}
