<?php

namespace App\Http\Controllers\Base;

use App\Utils\HTTPCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param String $field
     * @return String
     */
    public function requestHas(Request $request, $field)
    {
        return $request->has($field) && $request->get($field) != null  && $request->get($field) != "" ? $request->get($field) : null;
    }


    // ===================================================================================================
    // Response
    /**
     * Set JSON Response
     *
     * @param String $statusKey
     * @param String $statusCode
     * @param String $objectKey
     * @param String $objectData
     * @param int $responseStatus
     *
     * @return JsonResponse
     */
    public function response(string $statusKey, string $statusCode, string $objectKey, $objectData, int $responseStatus = 200)
    {
        $headers = ["Content-Type" => "application/json"];
        return response()->json([$statusKey => $statusCode, $objectKey => $objectData], $responseStatus
            , $headers, JSON_UNESCAPED_UNICODE);
    }

    public function responseStatusWithObjectKeyValue(string $statusCode, string $objectKey, $objectData, $status = 200)
    {
        return $this->response(HTTPCode::StatusKey, $statusCode, $objectKey, $objectData, $status);
    }

    public function responseStatusMessageWithObject(string $statusCode, $objectData, $status = 200)
    {
        return $this->response(HTTPCode::StatusKey, $statusCode,
            HTTPCode::MessageKey, $objectData, $status);
    }

    public function responseStatusErrorsWithObject(string $statusCode, $objectData, $status = 200)
    {
        return $this->response(HTTPCode::StatusKey, $statusCode,
            HTTPCode::ErrorKey, $objectData, $status);
    }

    // ===================================================================================================
    // Success
    public function responseSuccessObject($objectKey, $objectData, $status = 200)
    {
        return self::responseStatusWithObjectKeyValue(HTTPCode::Success, $objectKey, $objectData, $status);
    }

    public function responseSuccessMessage($message = "", $status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::Success, $message, $status);
    }
    public function responseSuccessNoContent($message = "", $status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::NoContent, $message, $status);
    }


    // ===================================================================================================
    // Error - BadRequest
    public function responseErrorMessage($message = "", $status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::BadRequest, $message, $status);
    }

    public function responseErrorCanNotSaveData($status = 200)
    {
        return self::responseErrorMessage(trans('Can not save this data'), $status);
    }

    public function responseErrorCanNotDeleteData($status = 200)
    {
        return self::responseErrorMessage(trans('Can\'t delete this record'), $status);
    }

    public function responseErrorThereIsNoData($status = 200)
    {
        return self::responseErrorMessage(trans('There is no data found'), $status);
    }

    // ===================================================================================================
    // Unauthorized - Forbidden
    public function responseUnauthorized($status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::Unauthorized, trans('Access Denied!'), $status);
    }
    public function responseForbidden($status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::Forbidden, trans('Access Denied!'), $status);
    }


    // ===================================================================================================
    // Catch Error - Exception
    public function responseCatchError($catchMessage, $status = 200)
    {
        return self::responseStatusMessageWithObject(HTTPCode::Exception, $catchMessage, $status);
    }

    // ===================================================================================================
    // Validator Error
    public function responseValidatorObject($validatorError, $status = 200)
    {
        return self::responseStatusErrorsWithObject(HTTPCode::ValidatorError, $validatorError, $status);
    }

    public function responseValidatorObjectKeyValue($validatorKey, $validatorMessage, $status = 200)
    {
        return self::responseValidatorObject([$validatorKey => [$validatorMessage]], $status);
    }
}
