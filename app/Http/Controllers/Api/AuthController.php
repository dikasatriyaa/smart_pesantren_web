<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Helper\ResponseHelper;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register New USER
     * @param App\Request\RegisterRequest $request
     * @return JSONResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
           $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($user) {
                return ResponseHelper::success(
                    message: 'Pengguna berhasil ditambahkan', data: $user, statusCode:201
                );
            }
            return ResponseHelper::error(
                message: 'Pengguna Gagal ditambahkan, please try again', statusCode:400
            );
        } catch (Exception $e) {
            Log::error('Unable to Register User : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(
                message: 'Pengguna Gagal ditambahkan, please try again' . $e->getMessage(), statusCode:500
            );          
        }

    }

    /**
     * Function : Login User
     * @param App\Request\LoginRequest $request
     * @return JSONResponse
     */

     public function login(LoginRequest $request)
     {
         try {
             // Attempt to authenticate the user
             if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                 return ResponseHelper::error(message: 'Unable to login due to invalid credentials.', statusCode: 400);
             }
     
             // Retrieve the authenticated user
             $user = User::where('email', $request->email)->first();
     
             // Check if the authenticated user has santri_id
             if (empty($user->santri_id)) {
                 return ResponseHelper::error(message: 'Kamu tidak memiliki Akses untuk Masuk. Silahkan menghubungi Operator Pesantren.', statusCode: 403);
             }
     
             // Create API Token
             $token = $user->createToken('My API Token')->plainTextToken;
     
             $authUser = [
                 'user' => $user,
                 'token' => $token
             ];
     
             return ResponseHelper::success(
                 message: 'You are logged in successfully', data: $authUser, statusCode: 200
             );
     
         } catch (Exception $e) {
             Log::error('Unable to Login User : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
             return ResponseHelper::error(
                 message: 'Unable to Login User!, please try again' . $e->getMessage(), statusCode: 500
             );  
         }
     }
     

    public function userProfile() {
        try {
            $user = Auth::user();

            if ($user) {
                return ResponseHelper::success(
                    message: 'User profile fetched successfuly', data: $user, statusCode:200
                );
            }
            return ResponseHelper::error(message: 'Unable to user data due to invalid token.', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Gagal mengambil data user : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(
                message: 'Gagal mengambil data user!, please try again' . $e->getMessage(), statusCode:500
            );
        }
    }

    public function userLogout(Request $request)
    {
        try {
            $user = $request->user();

            if ($user) {
                $request->user()->currentAccessToken()->delete();
                return ResponseHelper::success(
                    message: 'User logged out successfully', data: null, statusCode: 200
                );
            }
            return ResponseHelper::error(message: 'Unable to logout due to invalid token.', statusCode: 400);
        } catch (Exception $e) {
            Log::error('Gagal logout user : ' . $e->getMessage() . ' - Line no. ' . $e->getLine());
            return ResponseHelper::error(
                message: 'Gagal logout user!, please try again: ' . $e->getMessage(), statusCode: 500
            );
        }
    }

   
}
