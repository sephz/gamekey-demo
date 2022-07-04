<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Key;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class GameKeyController extends Controller
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
     * @OA\Post(
     * path="/v1/game/create",
     * summary="Create a new game",
     * description="Add a new game, all the gamekeys belong to a game",
     * operationId="gameCreate",
     * tags={"Games"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass game with title and description",
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
     *     ),
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


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
