<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Quiz;
use App\Models\Api\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Resources\QuizCollection;
use App\Http\Controllers\Api\ApiController;
/**
 * @OA\OpenApi(
 *     @OA\Info(
 *         title="Quiz API Documentation",
 *         version="1.0.0",
 *         description="API documentation for the Laravel application",
 *         @OA\Contact(
 *             email="soycheanat2202@gmail.com"
 *         )
 *     ),
 *     @OA\Server(
 *         url="http://localhost:8000",
 *         description="Local server"
 *     )
 * )
 */


class QuizController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/api/quiz",
     *     tags={"Quiz"},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="number",
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="type",
     *                         type="string",
     *                         example="example title"
     *                     ),
     *                     @OA\Property(
     *                         property="difficulty",
     *                         type="string",
     *                         example="example content"
     *                     ),
     *                      @OA\Property(
     *                         property="category",
     *                         type="number",
     *                         example="example content"
     *                     ),
     *                      @OA\Property(
     *                         property="question",
     *                         type="string",
     *                         example="example content"
     *                     ),
     *      *                @OA\Property(
     *                         property="correct_answer",
     *                         type="string",
     *                         example="example content"
     *                     ),
     *                      @OA\Property(
     *                         property="incorrect_answers",
     *                         type="json",
     *                         example="example content"
     *                     ),
     *                 )
     *             )
     *         )
     *     )
     * )
     */
   public function index(){
    $quiz = Quiz::get();
    $res = new QuizCollection($quiz);
    return $this->sendSuccess($res,'Quiz List');
   }

   /**
     * @OA\Post (
     *     path="/api/quiz/store",
     *     tags={"Quiz"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="type",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="difficulty",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="category",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="question",
     *                          type="string"
     *                      ),
     *                        @OA\Property(
     *                          property="correct_answer",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="incorrect_answers",
     *                          type="json"
     *                      ),
     *                       @OA\Property(
     *                          property="category_id",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "type":"multiple",
     *                     "difficulty":"medium",
     *                     "category":"travelling",
     *                     "question":"example content",
     *                     "correct_answer":"example title",
     *                     "incorrect_answers":"example content",
     *                      "category_id":1
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="type", type="string", example="title"),
     *              @OA\Property(property="difficulty", type="string", example="content"),
     *              @OA\Property(property="category", type="number", example=1),
     *              @OA\Property(property="question", type="string", example="title"),
     *              @OA\Property(property="correct_answer", type="string", example="content"),
     *              @OA\Property(property="incorrect_answer", type="json", example="incorrect_answer=[]"),
     *              @OA\Property(property="category_id", type="number", example="1"),
     *              )
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
        // Validate incoming request data if needed
        $validatedData = $request->validate([
            'type' => 'required|string',
            'difficulty' => 'required|string',
            'category' => 'required',
            'category_id' => 'required',
            'question' => 'required|string',
            'correct_answer' => 'required|string',
            'incorrect_answers' => 'required|array',
        ]);

        // Create a new Quiz instance
        $quiz = new Quiz();

        // Assign values from the request to the Quiz instance
        $quiz->type = $validatedData['type'];
        $quiz->difficulty = $validatedData['difficulty'];
        $quiz->category = $validatedData['category'];
        $quiz->category_id = $validatedData['category_id'];
        $quiz->question = $validatedData['question'];
        $quiz->correct_answer =json_encode($validatedData['incorrect_answers']);


        $quiz = Quiz::create($validatedData);


        if($quiz){
            $res = new QuizResource($quiz);
            return $this->sendSuccess($res,"Quiz was created Successfully");
        }
        else
        return $this->sendSuccess("Quiz was created not Success",[]);
    }

    /**
     * Get Detail Todo
     * @OA\Get (
     *     path="/api/quiz/{id}",
     *     tags={"Quiz"},
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
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="type", type="string", example="type"),
     *              @OA\Property(property="category", type="string", example="category"),
     *              @OA\Property(property="question", type="string", example="question"),
     *              @OA\Property(property="correct_answer", type="string", example="correct_answer"),
     *              @OA\Property(property="incorrect_answer", type="json", example="incorrect_answer"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *         )
     *     )
     * )
     */
    public function show($id){
        $quiz = Quiz::find($id);
        if(!(empty($quiz))){
            $res = new QuizResource($quiz);
            return $this->sendSuccess($res,"QuizDetail");
        }
        return $this->sendError("Quiz not found",[]);

    }

    /**
     * Update Quiz
     * @OA\Put (
     *     path="/api/quiz/update/{id}",
     *     tags={"Quiz"},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                       @OA\Property(
     *                          property="type",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="difficulty",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="category",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="question",
     *                          type="string"
     *                      ),
     *                        @OA\Property(
     *                          property="correct_answer",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="incorrect_answers",
     *                          type="json"
     *                      ),
     *                       @OA\Property(
     *                          property="category_id",
     *                          type="number"
     *                      )
     *                 ),
     *                example={
     *                     "type":"multiple",
     *                     "difficulty":"medium",
     *                     "category":"travelling",
     *                     "question":"example content",
     *                     "correct_answer":"example title",
     *                     "incorrect_answers":"example content",
     *                      "category_id":1
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="type", type="string", example="type"),
     *              @OA\Property(property="category", type="string", example="category"),
     *              @OA\Property(property="question", type="string", example="question"),
     *              @OA\Property(property="correct_answer", type="string", example="correct_answer"),
     *              @OA\Property(property="incorrect_answer", type="json", example="incorrect_answer"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *           )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        // Validate incoming request data if needed
        $validatedData = $request->validate([
            'type' => 'string',
            'difficulty' => 'string',
            'category' => 'string',
            'question' => 'string',
            'correct_answer' => 'string',
            'incorrect_answers' => 'array',
            'category_id' => 'integer',
        ]);

        // Update the quiz with validated data
        $quiz->update($validatedData);

        $res = new QuizResource($quiz);

        if($quiz)
        return $this->sendSuccess($res,"Quiz was Update Success");
        else
        return $this->sendSuccess("Quiz was Update not Success",[]);
    }

    /**
     * @OA\Delete (
     *     path="/api/quiz/delete/{id}",
     *     tags={"Quiz"},
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
     *             @OA\Property(property="msg", type="string", example="quiz deleted success")
     *         )
     *     )
     * )
    */
    public function destroy($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();
        return response()->json(null, 204);
    }
}
