<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const API_SUCCESS = 'Success';
    const API_FAILED = 'Failed';
    const API_ERROR = 'Error';

    public function CleanString($string) {
        return addslashes(str_replace("'", '', trim($string)));
    }

    public function ApiResponse($type, $message, $data = []) {
        /*
         * The type ('Success', 'Failed', 'Error') and message parameters must be string
         * while data must be an array
         */
        $response = [
            'status' => $type,
            'message' => 'Request ' . $type . ': ' . $message,
        ];

        if ($type == 'Success') {
            $response['payload'] = $data;
        }
        return response()->json($response);
    }

    public function HasDuplicateValuesInArray(Array $arr) {
        $filtered_items = [];
        $hasDuplicate = false;
        foreach ($arr as $item) {
            if (in_array($item, $filtered_items)) {
                $hasDuplicate = true;
            } else {
                array_push($filtered_items, $item);
            }
        }
        return $hasDuplicate;
    }

    public function HasEmptyValuesInArray(Array $arr) {
        $filtered_items = [];
        $hasDuplicate = false;
        foreach ($arr as $item) {
            if (in_array($item, $filtered_items)) {
                $hasDuplicate = true;
            } else {
                array_push($filtered_items, $item);
            }
        }
        return $hasDuplicate;
    }

    public function convertStringDateToPHPDateTime($date_string) {
        return date_format(date_create($date_string), 'Y-m-d h:i:s');
    }
}
