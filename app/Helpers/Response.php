<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Throwable;

class Response
{
    const HTTP_CODES = ['100', '101', '102', '103', '200', '201', '202', '203', '204', '205', '206', '207', '208', '300', '301', '302', '303', '304', '305', '306', '307', '308', '400', '401', '402', '403', '404', '405', '406', '407', '408', '409', '410', '411', '412', '413', '414', '415', '416', '417', '418', '422', '423', '424', '425', '426', '428', '429', '431', '449', '451', '500', '501', '502', '503', '504', '505', '506', '507', '508', '509', '510', '511', '512', '521'];

    public static function json($object, $codeStatus = 200)
    {
        if ($object instanceof Throwable) {
            if (! null == ($object->getCode() && in_array($object->getCode(), self::HTTP_CODES))) {
                $code = $object->getCode();
                $message = json_decode($object->getMessage(), true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $message = $object->getMessage();
                }

                return Response::json($message, $code);
            }

            $codeStatus = 500;
            Log::critical($object);
            $object = Lang::get('api.oops');
        }

        $result = [
            'status' => $codeStatus < 300,
            'data' => $object,
        ];

        if (! $result['status']) {
            if (! is_array($object) || strval(array_keys($object)[0]) != '0') {
                $object = $object;
            }
            $result['error'] = $object;
            unset($result['data']);
        }

        return response()->json($result, $codeStatus);
    }
}
