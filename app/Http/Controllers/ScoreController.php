<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class ScoreController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/api/scores",
     *     tags={"Score"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="data",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="user_id",
     *                         type="number",
     *                         example="2"
     *                     ),
     *                     @OA\Property(
     *                         property="score",
     *                         type="number",
     *                         example=50
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $scores = Score::where('user_id', $request->user()->id)->orderBy('score', 'desc')->get();
        return $this->sendSuccess($scores,'Score Table');

    }

    /**
     * @OA\Post (
     *     path="/api/scores/store",
     *     tags={"Score"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="score",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "score":69
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="score", type="number", example=30),
     *              @OA\Property(property="user_id", type="number", example="2"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'score' => 'required|integer',
        ]);

        $scoreItem = Score::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'score' => $request->score,
            ],

        );

        return $this->sendSuccess([],'score added successfully!');

    }
    /**
     * @OA\Delete (
     *     path="/api/scores/delete/{id}",
     *     tags={"Score"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="Score was remove!")
     *         )
     *     )
     * )
    */
    public function destroy($id)
    {
        $score = Score::findOrFail($id);
        $score->delete();
        return $this->sendSuccess([],'Score deleted successfully');
    }
}
