<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    
 
    public function applyToOffer(Request $request, $offerId)
{
   
    $offer = Offer::find($offerId);

    if (!$offer) {
        return response()->json([
            'message' => 'Offer not found.'
        ], 404);
    }
    $user = Auth::user();
    $request->validate([
        'cv' => 'required|mimes:pdf|max:10240', 
    ]);
    $cvPath = $request->file('cv')->store('cv_uploads', 'public'); 
    $user->application()->attach($offer->id, [
        'cv' => $request->cvPath  
    ]);

    return response()->json([
        'message' => 'Successfully applied to the offer.'
    ], 200);
}

}
