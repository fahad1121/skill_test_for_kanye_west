<?php

namespace App\Http\Controllers;

use App\Models\User_favourite_quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;

/**
 * @OA\Info(
 *     title="Dashboard API",
 *     version="1.0.0",
 *     description="API for managing user dashboard and favorite quotes."
 * )
 */

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with random quotes.
     *
     * @return Response
     *
     * @OA\Get(
     *     path="/dashboard",
     *     summary="Display the user dashboard with 5 random quotes",
     *     @OA\Response(response=200, description="User dashboard displayed with 5 random quotes"),
     * )
     */

    public function dashboard(){
//        dd(Auth::user());
        $quotes = [];

        for($i=0;$i<5;$i++){
            $api_response= Http::get(config('app.KANYE_API_URL'));
            if(!$api_response->failed()){
                $quote = $api_response->json();
                $quotes[] = $quote['quote'];
            }
        }

        if(!empty($quotes)){
            return Inertia::render('Dashboard/Index',[
                'quotes'    =>  $quotes
            ]);
        }
        return Inertia::render('Dashboard/Index',[
            'quotes'    =>  []
        ]);
    }

    /**
     * Save a quote to the user's favorites.
     *
     * @param string $quote
     * @return RedirectResponse
     *
     * @OA\Post(
     *     path="/favorite/{quote}",
     *     summary="Save a quote to the user's favorites",
     *     @OA\Parameter(
     *         name="quote",
     *         in="path",
     *         description="The quote to be saved to favorites",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response=200, description="Quote marked as favorite"),
     *     @OA\Response(response=422, description="Error in marking as favorite")
     * )
     */

    public function saveToFavourite(string $quote){
        $favourite_quote = new User_favourite_quote();
        $favourite_quote->user_id = Auth::user()->id;
        $favourite_quote->quote = $quote;
        $favourite_quote->save();

        if($favourite_quote->id){
            return redirect()->route('dashboard')->with('success','Quote has been marked as favourite');
        }
        return redirect()->route('dashboard')->with('error','Quote could not marked as favourite');
    }

    /**
     * Get a list of user's favorite quotes.
     *
     * @return Response
     *
     * @OA\Get(
     *     path="/favorites",
     *     summary="Get a list of user's favorite quotes",
     *     @OA\Response(response=200, description="List of user's favorite quotes"),
     * )
     */

    public function getFavourites()
    {
        $favourites = User_favourite_quote::all();

        if($favourites){
            return Inertia::render('Favourite/Index',[
                'favourites'    =>  $favourites
            ]);
        }
        return Inertia::render('Favourite/Index',[
            'favourites'    =>  []
        ]);
    }

    /**
     * Delete a user's favorite quote by ID.
     *
     * @param int $id
     * @return RedirectResponse|JsonResponse
     *
     * @OA\Delete(
     *     path="/api/favorite/{id}",
     *     summary="Delete a user's favorite quote by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the favorite quote to be deleted",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Favorite quote removed"),
     *     @OA\Response(response=404, description="Favorite quote not found")
     * )
     */

    public function getFavouriteDelete(int $id)
    {
        $favouriteQuote = User_favourite_quote::find($id);

        if (!$favouriteQuote) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $favouriteQuote->delete();

        return redirect()->route('favourites')->with('success','Favourite has been removed');

    }
}
