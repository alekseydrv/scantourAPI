<?php

namespace App\Http\Controllers;

use App\Models\Excursion;
use Illuminate\Http\Request;
use App\Http\Resources\ExcursionResource;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;


    /**
     * @OA\Get(
     *     path="/api/excursions",
     *     tags={"Excursions"},
     *     security={{"sanctum":{}}},
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
     *         description="Excursion not found",
     *     )
     * )
     */
class ExcursionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $excursions = Excursion::all();
        if (!$excursions) 
        {
            return response()->json(['success' => false, 'message' => 'Tours does not exist'], 404);
        }
        return response()->json(['success' => true, 'tours' => $excursions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * @OA\Get(
     *     path="/api/excursions/{id}",
     *     summary="Get excursion by id",
     *     tags={"Excursions"},
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *        description="ID of excursion",
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
     *         description="Excursion not found",
     *     )
     * 
     * )
     */
    public function getExcursion(Request $request, $id) {
        $excursions = Excursion::where('id', $id)->with('excursiondates.excursiontariffs')->first();
        if (!$excursions) {
            return response()->json([
                'message' => 'Excursion not found'
            ], 404);
        } else {
        return new ExcursionResource($excursions);
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
    public function show(Excursion $excursion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function edit(Excursion $excursion)
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
    public function update(Request $request, Excursion $excursion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tour  $tour
     * @return \Illuminate\Http\Response
     */
    public function destroy(Excursion $excursion)
    {
        //
    }
}
