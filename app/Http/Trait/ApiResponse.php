<?php
namespace App\Http\Trait;
trait ApiResponse
{
    public  function successResponse($data,$statusCode)
    {
        return response()->json(['data'=>$data],$statusCode);
    }
    public  function errorResponse($message,$statusCode)
    {
        return response()->json(['message'=>$message],$statusCode);
    }
}
