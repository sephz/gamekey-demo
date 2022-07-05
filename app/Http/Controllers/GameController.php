<?php

namespace App\Http\Controllers;

use App\Models\Game;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


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
     * path="api/v1/game/create",
     * summary="Create a new game",
     * description="Add a new game, all the gamekeys belong to a game",
     * operationId="gameCreate",
     * tags={"Games"},
     * security={ {"bearer": {} }},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass game with title and description",
     *    @OA\JsonContent(
     *       required={"title","description"},
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
     *    response=400,
     *    description="Failed, missing merchant profile",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="There is no merchant profile for this account")
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

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:200',
            'description' => 'sometimes|min:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->getMessageBag()->first()], 422);
        }

        // check if user has merchant

        $merchant = Auth::user()->merchant()->first();

        if ( $merchant === null ){

            return response()->json(['message' => 'There is no merchant profile for this account'],400);

        }else{

            $game = Game::create([
                'merchant_id' => $merchant->id,
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'id' => $game->id,
                'title' => $game->title,
                'description' => $game->description,
            ]);
        }
    }

    /**
     *
     * @OA\Get(
     * path="api/v1/game/{gameId}",
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

    public function show($game)
    {

        try{
            $data = Auth::user()->game()->findOrFail($game);
        }catch (\Exception $e) {
            return response()->json(['message' => 'There is no game profile for this user'],400);
        }

        return response()->json([
            'id' => $data->id,
            'title' => $data->title,
            'description' => $data->description,
        ]);
    }

}
