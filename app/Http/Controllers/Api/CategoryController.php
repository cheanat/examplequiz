<?php

namespace App\Http\Controllers\Api;

use App\Models\Api\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;
use App\Http\Controllers\Api\ApiController;


class CategoryController extends ApiController
{

    /**
     * @OA\Get (
     *     path="/api/category",
     *     tags={"QuizCategory"},
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
     *                         property="name",
     *                         type="string",
     *                         example="example title"
     *                     ),
     *                     @OA\Property(
     *                         property="image_url",
     *                         type="string",
     *                         example="example content"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $category = Category::get();
        $res = new CategoryCollection($category);
        return $this->sendSuccess($res,'Category List');
    }

    /**
     * @OA\Get (
     *     path="/api/category/category={id}",
     *     tags={"QuizCategory"},
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
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="image_url", type="string", example="image_url"),
     *
     *          )
     *     )
     * )
     */
    public function show($id)
    {
        $category = Category::find($id);
        if($category){
            $all_quiz = $category->getAllQuiz;
            return $this->sendSuccess( $all_quiz,'Category List');
        }else
           return $this->sendError('Category not found',[]);
    }


    /**
     * @OA\Post (
     *     path="/api/category/store",
     *     tags={"QuizCategory"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image_url",
     *                          type="string"
     *                      )
     *                 ),
     *                 example={
     *                     "name":"Sport",
     *                     "image_url":"put the link of url_image",
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="Sport"),
     *              @OA\Property(property="image_url", type="string", example="link of image"),
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
        $category = Category::create($request->all());
            return $this->sendSuccess($category,'Category was store successfully');
    }

    /**
     * Update Quiz
     * @OA\Put (
     *     path="/api/category/update/{id}",
     *     tags={"QuizCategory"},
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
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="image_url",
     *                          type="string"
     *                      )
     *
     *                 ),
     *                example={
     *                     "name":"name",
     *                     "image_url":"linkofurl",
     *
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
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="image_url", type="string", example="linkofImage"),
     *           )
     *      )
     * )
     */
    public function update(Request $request,$id)
    {
        $category = Category::find($id);
        if($category){
            $category->name = $request->get('name');
            $category->image_url = $request->get('image_url');

            $category->save();
            $res = new CategoryResource($category);
            return $this->sendSuccess($res,'Category is updated');
        }else{
            return $this->sendError('Category is not found');
        }
    }

    /**
     * @OA\Delete (
     *     path="/api/category/delete/{id}",
     *     tags={"QuizCategory"},
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
        $category = Category::find($id);

        if($category){
            $category->delete();
            return $this->sendSuccess([],'Category was delete');
        }else{
            return $this->sendError('Category not found');
        }

    }

    //search
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        $category = Category::where('name', 'LIKE', "%$query%")
                            ->get();

        return response()->json($category);
    }
}
