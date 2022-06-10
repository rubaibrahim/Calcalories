<?php

namespace App\Http\Controllers\Base;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    const paginationRowCount = 10;

    public function hasAuth(): bool
    {
        return Auth::guard('api')->check();
    }

    // ===================================================================================================
    // Restful API Response
    public function getResponse($objectKey = "data", $objectValue = null): JsonResponse
    {
        try {
            if ($objectValue) {
                return $this->responseSuccessObject($objectKey, $objectValue);
            } else {
                return $this->responseErrorThereIsNoData();
            }
        } catch (\Exception $exception) {
            return $this->responseCatchError($exception->getMessage());
        }
    }

    public function postResponse($objectKey = "data", $objectValue = null): JsonResponse
    {
        try {
            if ($objectValue) {
                return $this->responseSuccessObject($objectKey, $objectValue);
            }
            return $this->responseErrorCanNotSaveData();
        } catch (\Exception $exception) {
            return $this->responseCatchError($exception->getMessage());
        }
    }

    public function deleteResponse($object = null): JsonResponse
    {
        try {
            if ($object) {
                if ($object->delete()) {
                    return $this->responseSuccessMessage(trans('api.Data deleted successfully'));
                }
                return $this->responseErrorCanNotDeleteData();
            }
            return $this->responseErrorThereIsNoData();
        } catch (\Exception $exception) {
            return $this->responseCatchError($exception->getMessage());
        }
    }
}
