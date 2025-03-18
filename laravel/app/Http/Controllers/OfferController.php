<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();
        
      
        if ($offers->isEmpty()) {
            return response()->json([
                'message' => 'Aucune offre disponible actuellement.' 
            ], 404); 
        }
    
      
        return response()->json([
            'offers' => $offers 
        ], 200);
    }
    public function getMyOffers()
    {
        $offers = Offer::where('user_id', Auth::id())->get();
        if ($offers->isEmpty()) {
            return response()->json([
                'message' => 'Aucune offre disponible actuellement.' 
            ], 404); 
        }
    
      
        return response()->json([
            'offers' => $offers 
        ], 200);
    }
    
    public function store(StoreOfferRequest $request)
    {
       
        $data = $request->validated();

        try {
         
            $offer = Offer::create([
                'user_id' => Auth::id(), 
                'title' => $data['title'],
                'description' => $data['description'],
                'contract_type' => $data['contract_type'],
                'location' => $data['location'],
                'salary' => $data['salary'],
            ]);

           
            return response()->json([
                'message' => 'L\'offre a été créée avec succès.',
                'offer' => $offer
            ], 201); 

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création de l\'offre.',
                'error' => $e->getMessage()
            ], 500); 
        }
    }

    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        if ($offer->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à modifier cette offre.'
            ], 403);
        }

        try {
            $offer->update($request->validated());

            return response()->json([
                'message' => 'L\'offre a été mise à jour avec succès.',
                'offer' => $offer
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la mise à jour de l\'offre.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function destroy(Offer $offer)
    {

        if ($offer->user_id !== Auth::id()) {
            return response()->json([
                'message' => 'Vous n\'êtes pas autorisé à supprimer cette offre.'
            ], 401);
        }

        try {
            $offer->delete();

            return response()->json([
                'message' => 'L\'offre a été supprimée avec succès.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression de l\'offre.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
