<?php

namespace App\Http\Controllers;

use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GameKeyController extends Controller
{
    /**
     * @OA\Get(
     * path="api/v1/gamekey",
     * summary="List of GameKeys",
     * description="To show the list of available game keys",
     * operationId="gamekeyList",
     * tags={"GameKeys"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="key_id", type="int", example="1", description="id of game key" ),
     *       @OA\Property(property="game_title", type="string", example="Game 1"),
     *       @OA\Property(property="description", type="string", example="Eum repudiandae sapiente qui rerum ipsa ut."),
     *       @OA\Property(property="key", type="string", example="CrWXdQDGytidRxQPxh0y"),
     *       @OA\Property(property="price", type="int", example="1000"),
     *       @OA\Property(property="currency", type="string", example="MYR"),
     *       @OA\Property(property="formatted_price", type="string", example="10.00"),
     *        )
     *     ),
     * @OA\Response(
     *    response=404,
     *    description="Failed",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Out of stock", description="id of game key" )
     *        )
     *     )
     * )
     *
     */
    public function index()
    {

        $list = Key::whereNull('sold_at')
            ->join('games', 'keys.game_id', '=', 'games.id')
            ->get(['keys.id as key_id', 'games.title as game_title', 'description', 'key', 'price', 'currency']);

        if ( count($list) ){
            return response()->json($list->toArray());
        }else{
            return response()->json(['status'=>'Out of stock'], 404);
        }
    }

    /**
     * @OA\Post(
     * path="api/v1/gamekey",
     * summary="Add a new key",
     * description="Add a new key with price in cents",
     * operationId="gamekeyCreate",
     * tags={"GameKeys"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Append a key to a game created previously with price",
     *    @OA\JsonContent(
     *       required={"game_id","key","price"},
     *       @OA\Property(property="game_id", type="int", example="1"),
     *       @OA\Property(property="key", type="string", example="STEAM-10000"),
     *       @OA\Property(property="price", type="int", example="10000", description="price value in cents"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/Key")
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Validation Failed",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Key attribute is needed")
     *        )
     *     ),
     * @OA\Response(
     *    response=400,
     *    description="Failed, Invalid Game ID",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Invalid Game ID")
     *        )
     *     )
     * )
     *
     */

    public function store(Request $request)
    {

        $request->validate([
            'key' => 'required|max:80',
            'price' => 'required|integer|min:1',
        ]);

        // check if the game belongs to user
        try{
            Auth::user()->game()->findOrFail($request->input('game_id'));
        }catch (\Exception $e) {
            return response()->json(['message' => 'Invalid Game ID'],400);
        }

        // all good
        $key = Key::create([
            'game_id' => $request->input('game_id'),
            'key' => $request->input('key'),
            'currency' => 'MYR',
            'price' => $request->input('price'),
        ]);

        return response()->json([
            'game_id' => $key->game_id,
            'key' => $key->key,
            'currency' => $key->currency,
            'price' => $key->price,
            'formatted_price' => $key->formatted_price,
            ]);

    }
}
