<?php
/**
 * Created by PhpStorm
 * User: Cap
 * Date: 2023/05/09 12:20
 */
namespace App\Http;
trait ApiResponseTrait {

    public function success($data = null)
    {
        $res = [
            'status' => 'success',
            'code' => 200,
            'data' => $data
        ];

        return response()->json($res);
    }

    public function failed($code = null, $message = '')
    {
        $res = [
            'status' => 'failed',
            'code' => $code,
            'message' => $message
        ];

        return response()->json($res);
    }
}
