<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public static function getActionPath(string $action): string
    {
        $callClass = static::class;

        return "$callClass@$action";
    }

    public function response($message = null, $artifacts = [], $status = 200)
    {
        return response()->json([
            'message'   => $message ?? 'Success',
            'artifacts' => $artifacts
        ], $status);
    }

    protected function throwValidationException(HttpRequest $request, $validator): void
    {
        $error =  [
            'shortMessage'       => 'invalidData',
            'message'            => trans('validation.invalidData'),
            'description'        => [],
        ];

        foreach ($validator->errors()->all() as $message) {
            $error['description'][] = $message;
        }

        $response = response()->json($error, Response::HTTP_UNPROCESSABLE_ENTITY);
        throw new ValidationException($validator, $response);
    }
}
