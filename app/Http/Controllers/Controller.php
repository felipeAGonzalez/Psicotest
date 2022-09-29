<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Helpers\Response;
use App\Exceptions\FieldsException;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Validator;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function response($object, $codeStatus = 200)
    {
        return Response::json($object, $codeStatus);
    }
    protected function validator(Request $request, $attribute)
    {
        $validator = Validator::make(array_merge($request->all(), $request->query()), $attribute);
        if ($validator->fails()) {
            throw new FieldsException($validator->errors());
        }

        return $validator->validated();
    }
}
