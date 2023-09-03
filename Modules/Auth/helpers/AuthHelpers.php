<?php

namespace Modules\Auth\Helpers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthHelpers
{

    public static function guidv4($data = null)
    {

        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function Compress2Base64($str, $gztype = 'deflate')
    {
        switch ($gztype) {
            case 'deflate':
                return base64_encode(gzdeflate($str, 9));
            case 'compress':
                return base64_encode(gzcompress($str, 9));
            case 'encode':
                return base64_encode(gzencode($str, 9));
            default:
                return base64_encode(gzdeflate($str, 9));
        }
    }

    public static function deCompressBase64($str, $gztype = 'deflate')
    {
        switch ($gztype) {
            case 'deflate':
                return @gzinflate(base64_decode($str));
            case 'compress':
                return @gzuncompress(base64_decode($str));
            case 'encode':
                return @gzdecode(base64_decode($str));
            default:
                return @gzinflate(base64_decode($str));
        }
    }
    public static function AESEncrypted($string, $key, $iv)
    {
        $cipher = "aes-256-cbc";
        $options = 0;

        $encrypted = openssl_encrypt($string, $cipher, $key, $options, $iv);

        return base64_encode($encrypted);
    }

    // Fungsi untuk mendekripsi string yang telah dienkripsi menggunakan AES
    public static function AESDecrypted($string, $key, $iv)
    {
        $cipher = "aes-256-cbc";
        $options = 0;

        $decrypted = openssl_decrypt(base64_decode($string), $cipher, $key, $options, $iv);

        return $decrypted;
    }

    public static function checkerParamsv1($request){
        if ($request->all() == null) {
            $data = 'false';
        }
        if ($request->key == null) {
            $data = 'falseKey';
        } else {
            $checkKey = User::where('key_digest', '=', $request->key)->select('key_digest')->first();
            if($checkKey == null){
                $data = 'falseKey';
            }else{
                $data = 'success';
            }

        }
        return $data;
    }
}
