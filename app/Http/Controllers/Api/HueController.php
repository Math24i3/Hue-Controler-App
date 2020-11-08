<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class HueController extends Controller
{
    protected $username;
    protected $host;

    /**
     * HueController constructor.
     */
    public function __construct()
    {

        $this->username = 'WTetl8K9JuCWh59mUU30ln2MD4Jpee-Fs8jheuod';
        $this->host = '192.168.0.30';
    }

    /**
     * Returns all lights available.
     */
    public function lights() {
        $response = Http::get('http://' . $this->host . '/api/' . $this->username . '/lights');
        if (!$response) {
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } else {
            return $response;
        }

    }

    /**
     * Returns light byy id.
     * @param string $id
     * @return \Illuminate\Http\Client\Response|JsonResponse
     */
    public function light(string $id) {
        $response = Http::get('http://' . $this->host . '/api/' . $this->username . '/lights/'  . $id);
        if (!$response) {
            return response()->json($response, Response::HTTP_BAD_REQUEST);
        } else {
            return $response;
        }
    }

    /**
     * Set the state of a light.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Client\Response|JsonResponse
     */
    public function setState(Request $request, int $id) {
        $validFields = $request->only([
            'on',
            'bri',
            'hue',
            'sat',
            'xy',
            'alert',
            'effect',
        ]);

        if ($request['bri'] && $validFields['bri']) {
            $validFields['bri'] = intval($validFields['bri']);
        }

        $createValidator = Validator::make($validFields, [
            'on'        => [
                'boolean',
            ],
            'bri' => [
                'integer',
            ],
            'sat' => [
                'integer',
            ],
            'xy' => [
                'array',
            ],
            'alert' => [
                'string',
            ],
            'effect' => [
                'string',
            ]
        ]);

        if ($createValidator->fails()) {
            Log::error('Validation failed', [
                'errors' => $createValidator->errors()
                    ->all()
            ]);

            return response()->json($validFields, Response::HTTP_BAD_REQUEST);
        }


        $response = Http::put('http://' . $this->host . '/api/' . $this->username . '/lights/'  . $id . '/state', $validFields);
        if ($response->failed() || !$response) {
            return response()->json('failed to make  the post', Response::HTTP_BAD_REQUEST);
        } else {
            return $response;
        }
    }

    public function hueInfo() {

    }

}
