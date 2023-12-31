<?php

namespace App\Http\Api;

/**
 * Format response.
 */
class ResponseFormatter
{
    /**
     * API Response
     *
     * @var array
     */
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    /**
     * Give success response.
     */
    public static function success($data = null, $message = null)
    {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give success response datatables.
     */
    public static function datatables($data = null, $message = null)
    {
        unset(self::$response['data']);
        self::$response['meta']['message'] = $message;
        self::$response['draw'] = $data->original['draw'];
        self::$response['recordsTotal'] = $data->original['recordsTotal'];
        self::$response['recordsFiltered'] = $data->original['recordsFiltered'];
        self::$response['input'] = $data->original['input'];
        self::$response['data'] = $data->original['data'];

        return response()->json(self::$response, self::$response['meta']['code']);
    }

    /**
     * Give error response.
     */
    public static function error($data = null, $message = null, $code = 500)
    {
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['code'] = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(self::$response, self::$response['meta']['code']);
    }
}