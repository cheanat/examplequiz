<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class WhishlistController extends ApiController
{
    /**
     * @OA\Get (
     *     path="/api/cart",
     *     tags={"Whishlist"},
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
     *                         example="1"
     *                     ),
     *                     @OA\Property(
     *                         property="category_id",
     *                         type="string",
     *                         example="1"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {

        $cartItems = Auth::user()->cartItems()
            ->with(['user', 'category'])
            ->get();

        return $this-> sendSuccess($cartItems,'All cartItem');
    }

    /**
     * @OA\Post (
     *     path="/api/cart/store",
     *     tags={"Whishlist"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="category_id",
     *                          type="number"
     *                      )
     *                 ),
     *                 example={
     *                     "category_id":2
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="category_id", type="number", example=3),
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
            'category_id' => 'required|exists:categories,id',
        ]);

        // Check if the category is already in the cart for the authenticated user
        $existingCartItem = Cart::where('user_id', Auth::id())
                                ->where('category_id', $request->category_id)
                                ->first();
        // $existingCartItem = Cart::where('category_id', $request->category_id)->first();

        if ($existingCartItem) {
            return $this->sendError('This category is already in your cart.');
        }else{

                $cartItem = Cart::updateOrCreate(
                    [
                    'user_id' => Auth::id(),
                    'category_id' => $request->category_id,
                    ]
                );

            return $this->sendSuccess([], "Category added to cart!");
        }
    }

    /**
     * @OA\Delete (
     *     path="/api/cart/delete/{id}",
     *     tags={"Whishlist"},
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
     *             @OA\Property(property="msg", type="string", example="Category was remove from cart")
     *         )
     *     )
     * )
    */
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        return $this->sendSuccess([],'Product removed from cart!');
    }
}
