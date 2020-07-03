<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{


    protected $abilityMap = [
        'index' => 'list',
        'create' => 'create',
        'store' => 'create',
        'edit' => 'update',
        'update' => 'update',
        'delete' => 'delete',
    ];


    protected function mergeAbilities($abilities = [])
    {
        $this->abilityMap = array_merge($this->abilityMap, $abilities);
    }


    public function sendResponse($result, $message)
    {
        $code = JsonResponse::HTTP_OK;
    	$response = [
            'success' => true,
            'code' => $code,
            'message' => $message,
            'data'    => $result,
        ];


        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessages = [], $code = JsonResponse::HTTP_NOT_FOUND)
    {

    	$response = [
            'success' => false,
            'code' => $code,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
