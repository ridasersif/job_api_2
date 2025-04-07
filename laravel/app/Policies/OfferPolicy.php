<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Offer;
use App\Models\User;

class OfferPolicy
{
    
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Offer $offer): bool
    {
        return $user->id===$offer->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Offer $offer): bool
    {
        return $user->id === $offer->user_id;
    }

   
}
