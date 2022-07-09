<?php

namespace App\Helper;
use Validator;

class AllHelper {
    public static function validation($validate) {
        $validator = Validator::make(request()->all(),$validate);
        if($validator->fails()){
            return response()->json([
                'status' => 500,
                'data' => $validator->errors()
            ]);
        }
        return true;
    }

    public static function responseJson($status,$message) {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ]);
    }
}
?>
