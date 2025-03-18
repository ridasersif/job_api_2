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
    /**
     * Display a listing of the resource.
     */
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
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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
            ], Response::HTTP_CREATED); 

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création de l\'offre.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR); 
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Offer $offer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer)
    {
        //
    }
}
