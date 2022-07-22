<?php 

namespace App\Http\Components;

class ResponseComponents {
    
    public static function success($msg, $result = null)
    {
        return response()->json([
            'code' => 200,
            'message' => 'Berhasil ' . $msg,
            'data' => $result,
        ], 200);
    }

    public static function created($msg, $result = null)
    {
        return response()->json([
            'code' => 201,
            'message' => 'Berhasil membuat ' . $msg,
            'data' => $result,
        ], 201);
    }

    public static function badRequest($error, $result = null)
    {
        return response()->json([
            'code' => 400,
            'message' => $error,
            'data' => $result,
        ], 400);
    }

    public static function validationFail($error, $result = null)
    {
        return response()->json([
            'code' => 403,
            'message' => $error,
            'data' => $result,
        ], 403);
    }

    public static function unauthorized()
    {
        return response()->json([
            'code' => 401,
            'message' => "Token anda tidak sesuai. Harap login kembali !",
            'data' => null,
        ], 401);
    }

    public static function upgradeRequired($result = null)
    {
        return response()->json([
            'code' => 426,
            'message' => 'Error harap untuk melakukan update aplikasi ke versi terbaru !',
            'data' => $result,
        ], 426);
    }

    public function error($msg, $result = null)
    {
        return response()->json([
            'code' => 500,
            'message' => $msg,
            'data' => $result,
        ], 500);
    }
}