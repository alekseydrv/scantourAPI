<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tourist;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
     
     /**
     * @OA\Post(
     *     path="/api/orders",
     *     tags={"Orders"},
     *     security={{"sanctum":{}}},
     *     description="ДЛя передачи заказов, необходимо отправить POST запрос к методу api/orders . <br /> POST-запрос должен содержать ассоциативный массив.<br /><br /> <Strong>Пример реализации запроса на PHP:</strong>
     * <br />
     *  <pre class='hljs' style='display: block; overflow-x: auto; padding: 0.5em; background: rgb(240, 240, 240); color: rgb(68, 68, 68);'>$data = <span class='hljs-keyword' style='font-weight: 700;'>array</span>();</pre>
     * ",
     *      @OA\Parameter(
     *          name="login",
     *          in="query",
     *          required=true, 
     *          description="Login", 
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          required=true, 
     *          description="Password", 
     *     ),
     *     @OA\Parameter(
     *          name="tarif",
     *          in="query",
     *          required=true, 
     *          description="Number of tarif. Ex. 1 - Hotel Standart, 2 - Hotel Comfort etc.", 
     *     ),
     *     @OA\Parameter(
     *          name="raceID",
     *          in="query",
     *          required=true, 
     *          description="Race ID, Ex. 17255", 
     *     ),
     *     @OA\Parameter(
     *          name="comment",
     *          in="query",
     *          required=false, 
     *          description="Comment", 
     *     ),
     *     @OA\Parameter(
     *          name="sngl",
     *          in="query",
     *          required=true, 
     *          description="number of single placements, 0 - if not needed", 
     *     ),
     *     @OA\Parameter(
     *          name="dbl",
     *          in="query",
     *          required=true, 
     *          description="number of double placements, 0 - if not needed", 
     *     ),
     *     @OA\Parameter(
     *          name="trpl",
     *          in="query",
     *          required=true, 
     *          description="number of triple placements, 0 - if not needed", 
     *     ),
     *     @OA\Parameter(
     *          name="qdrpl",
     *          in="query",
     *          required=true, 
     *          description="number of quadriple placements, 0 - if not needed", 
     *     ),
     *      @OA\Parameter(
     *         name="arr[i]['passport']",
     *         in="query",
     *         required=true, 
     *         description="(i - tourist index) passport number", 
     *     ),
     *     @OA\Parameter(
     *         name="arr[i]['mail']",
     *         in="query",
     *         required=true, 
     *         description="tourist email", 
     *     ),
     *     @OA\Parameter(
     *         name="arr[i]['phone']",
     *         in="query",
     *         required=true, 
     *         description="tourist phone number", 
     *     ),
     *     @OA\Parameter(
     *         name="arr[i]['name']",
     *         in="query",
     *         required=true, 
     *         description="tourist name", 
     *     ),
     *     @OA\Parameter(
     *         name="arr[i]['category']",
     *         in="query",
     *         required=true, 
     *         description="tourist category", 
     *     ),
     *     @OA\Parameter(
     *         name="arr[i]['birth_date']",
     *         in="query",
     *         required=true, 
     *         description="tourist birth date", 
     *     ),
     * 
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
    public function store(OrderStoreRequest $request)
    {
            $data = array();
            
            try {
            // Create Order
            $order = Order::create([
                'login' => $request->login,
                'password' => $request->password,
                'tarif' => $request->tarif,
                'tourdate_id' => $request->raceId,
                'comment' => $request->comment,
                'sngl' => $request->sngl,
                'dbl' => $request->dbl,
                'twin' => $request->twin,
                'trpl' => $request->trpl,
                'qdrpl' => $request->qdrpl,
            ]);
            
            $data["login"] = $request->login;
            $data["password"] = md5(md5($request->password));
            $data["tarif"] = $request->tarif;
            $data["raceId"] = $request->raceId;
            $data["comment"] = $request->comment;
            $data["sngl"] = $request->sngl;
            $data["dbl"] = $request->dbl;
            $data["twin"] = $request->twin;
            $data["trpl"] = $request->trpl;
            $data["qdrpl"] = $request->qdrpl;
            
            $orderId = $order->id;
            $i=0;
            foreach($request->tourists as $tourist) {
                $data["tourist"][$i]["passport"] = $tourist["passport"];
                $data["tourist"][$i]["mail"] = $tourist["mail"];
                $data["tourist"][$i]["phone"] = $tourist["phone"];
                $data["tourist"][$i]["zakaz_name"] = $tourist["name"];
                $data["tourist"][$i]["category"] = $tourist["category"];
                $data["tourist"][$i]["date_rozhd"] = $tourist["birth_date"];
                $i++;
                Tourist::create([
                    'passport' => $tourist["passport"],
                    'mail' => $tourist["mail"],
                    'phone' => $tourist["phone"],
                    'name' => $tourist["name"],
                    'category' => $tourist["category"],
                    'birth_date' => $tourist["birth_date"],
                    'order_id' => $orderId
                ]);
            }
            $curl = curl_init("https://scantour.ru/agency/apiOrder.php");
            //$url = "http://scantour.ru/agency/apiOrder.php";
            //$curl->setReferer('http://scantour.ru/agency/apiOrder.php');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_REFERER, 'https://scantour.ru/agency/apiOrder.php');
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            $result = curl_exec($curl);
            // Return Json Response
            return response()->json([
                'message' => var_dump($result)."Order successfully created."
            ],200);
        } catch (\Exception $e) {
            // Return Json Response
            return response()->json([
                'message' => $e."Something went wrong!"
            ],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
