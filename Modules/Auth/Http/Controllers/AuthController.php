<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Auth\Helpers\AuthHelpers;

class AuthController extends Controller{

    public static function generateKey(){

        $arrayKey = [
            '0' => AuthHelpers::guidv4(),
            '1' => base64_encode(bin2hex(random_bytes(4))),
            '2' =>  base64_encode(openssl_random_pseudo_bytes(16))
        ];

        $coba2 = base64_encode(json_encode($arrayKey));
        $coba2x = base64_decode($coba2);

        $compressedData = AuthHelpers::Compress2Base64(json_encode($arrayKey));
        // $decompressData = AuthHelpers::deCompressBase64($compressedData);

        return $compressedData;


        // return AuthHelpers::AESEncrypted($arrayKey[0], base64_decode($arrayKey[1]), base64_decode($arrayKey[2]));
        // return AuthHelpers::AESDecrypted($aes, base64_decode($arrayKey[1]), base64_decode($arrayKey[2]));

    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'key_digest' => $this->generateKey()
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['error' => 400, 'message' => 'Unauthorized Access']);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json(['message' => 'success', 'key'=> $user->key_digest, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
