<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;

class AuthController extends ApiController
{
    /**
     * @OA\Post (
     *     path="/api/user/register",
     *     tags={"User"},
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
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *
     *                 ),
     *                 example={
     *                     "name":"mark",
     *                     "email":"mark2202@gmail.com",
     *                     "password":"1234567"
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
     *              @OA\Property(property="name", type="string", example="title"),
     *              @OA\Property(property="email", type="string", example="title@gmail.com"),
     *              @OA\Property(property="password", type="string", example=123456),
     *
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
    public function register(Request $request){

        $request->validate([
                "name" => "required",
                "email" => "required",
                "password"=>"required",
        ]);

        $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),

        ]);

        if($user){
            return response()->json([
                'message' => 'User Registerd succussefuly',
                'user'=>$user
            ]);
        }else{
            return response([
                'message' => 'User Regiter not  succussefuly',
                'user'=>[]
            ]);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/user/login",
     *     tags={"User"},
     *     summary="User login",
     *     description="Logs in a user and returns a token",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string", format="password")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                    'msg'=>'Invalid credentials',
                    'status'=>401
            ]);
        }
        if(!(Hash::check($request->password,$user->password))){
                return response()->json([
                    'msg'=>'Invalid credentials',
                    'status'=>401

            ]);
        }
        $token = $user->createToken($user->email);
        return response()->json([
            'user'=>$user,
            'token' => $token->plainTextToken,
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/user/logout",
     *     tags={"User"},
     *     summary="Logout the user",
     *     description="Logs out the user and invalidates the token",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
        {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Successfully logged out'], 200);
        }

    /**
     * @OA\Get (
     *     path="/api/user",
     *     tags={"User"},
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
     *                         example="oshihen"
     *                     ),
     *                     @OA\Property(
     *                         property="email",
     *                         type="string",
     *                         example="oshen@gmail.com"
     *                     ),
     *                      @OA\Property(
     *                         property="password",
     *                         type="number",
     *                         example="123456789"
     *                     )
     *
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(){
        $user = User::get();
        return $this->sendSuccess(
            $user,
            'User List'
        );
    }
        // Method to get the authenticated user's details
        public function myself(Request $request)
        {
            return response()->json(Auth::user());
        }


    /**
     * Get Detail User
     * @OA\Get (
     *     path="/api/user/{id}",
     *     tags={"User"},
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
     *              @OA\Property(property="name", type="string", example="mark"),
     *              @OA\Property(property="email", type="string", example="mark22@gmail.com"),
     *              @OA\Property(property="password", type="string", example="1234567"),
     *         )
     *     )
     * )
     */
    public function show($id){
        $user = User::find($id);
        if($user){
            return $this->sendSuccess([$user],'User Detail');
        }
    }



    /**
     * Update Username
     * @OA\Put (
     *     path="/api/user/update/{id}",
     *     tags={"User"},
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
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      )
     *                 ),
     *                example={
     *                     "name":"mark",
     *                     "email":"mark22@gmail.com",
     *                     "password":"123456",
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
     *              @OA\Property(property="name", type="string", example="mark"),
     *              @OA\Property(property="email", type="string", example="mark@gmail.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *         )
     *      )
     * )
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string', // Password field
            // Add validation rules for other fields
        ]);

        $data = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        if($user ){
            // $user ->name = $request->get('name');
            // $user ->email = $request->get('email');
            // $user ->password = $request->get('password');

            // $user ->save();
            // $res = new CategoryResource($category);

            return $this->sendSuccess($user,'User is updated');
        }else{
            return $this->sendError('User`Id is not found');
        }
    }



    /**
     * @OA\Delete (
     *     path="/api/user/delete/{id}",
     *     tags={"User"},
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
     *             @OA\Property(property="msg", type="string", example="Username deleted success")
     *         )
     *     )
     * )
    */
    public function delete($id)
    {
        $user = User::find($id);
        if($user ){
            $user ->delete();
            return $this->sendSuccess([],'User is deleted');
        }else{
            return $this->sendError('User`Id is not found');
        }
    }


}
