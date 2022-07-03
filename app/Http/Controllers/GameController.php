<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;


class GameController extends Controller
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
     *       required={"description"},
     *       @OA\Property(property="title", type="string", format="text", example="Steam"),
     *       @OA\Property(property="description", type="string", format="text", example="A cross platform gaming system."),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/Game")
     *        )
     *     ),
     * @OA\Response(
     *    response=422,
     *    description="Failed validation response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Tittle and Description are required")
     *        )
     *     )
     * )
     *
     */

    public function store(Request $request)
    {
        //
    }

    /**
     *
     * @OA\Get(
     * path="/v1/game/{gameId}",
     * summary="Retrieve game information",
     * description="Get game title and description",
     * operationId="gameShow",
     * tags={"Games"},
     * security={ {"bearer": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success",
     *    @OA\JsonContent(
     *       @OA\Property(property="data", type="object", ref="#/components/schemas/Game")
     *        )
     *     ),
     * @OA\Response(
     *    response=401,
     *    description="User should be authorized to get profile information",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="Not authorized"),
     *    )
     * )
     * )
     */

    public function show(Game $game)
    {
        //
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
