<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory;
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'competence_user', 'skill_id', 'profil_id');
    }
}
