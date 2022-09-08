<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;
use App\Http\Resources\TourResource;
use App\Http\Resources\TourCollection;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;


    
class TourController extends Controller
{
    
     
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/api/tours",
     *     tags={"Tours"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Tours not found",
     *     )
     * )
     * 
     */
    public function index()
    {
        $tours = Tour::all();
        if (!$tours) {
            return response()->json(['success' => false, 'message' => 'Tours does not exist'],400);
        } else {
            return response()->json(['success' => true, 'tours' => $tours]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *     path="/api/tours/{id}",
     *     summary="Get tour by id",
     *     tags={"Tours"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *        description="ID of tour",
     *        in="path",
     *        name="id",
     *        required=true,
     *        example="7",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\Schema(ref="#/definitions/Tour")
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized user",
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Tour not found",
     *     )
     * 
     * )
     */
    public function getTour(Request $request, $id) {
        $tours = Tour::where('id', $id)->with('tourdate.tariffs')->first();
        if (!$tours) {
            return response()->json([
                'message' => 'Tour not found'
            ], 404);
        } else {
        return new TourResource($tours);
        }
    }
    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Tour $tour)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tour $tour)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        //
    }
}
