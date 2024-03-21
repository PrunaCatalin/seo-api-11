<?php
/*
 * ${PROJECT_NAME} | LocationController.php
 * https://www.webdirect.ro/
 * Copyright 2023 Eugen Buiac
 * Email : office@webdirect.ro
 * Type  : PHP
 * Created on : 7/12/2023 9:10 AM
*/

namespace Modules\Tenants\App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Tenants\App\Http\Requests\Location\GetCitiesRequest;
use Modules\Tenants\App\Http\Requests\Location\GetCountiesRequest;
use Modules\Tenants\App\Models\Location\GenericCity;
use Modules\Tenants\App\Models\Location\GenericCounty;

class LocationController extends Controller
{
    /**
     * @param GetCountiesRequest $request
     * @return JsonResponse
     */
    public function getCounties(GetCountiesRequest $request): JsonResponse
    {
        $counties = GenericCounty::where(['id_country' => $request->id_country])->get();
        return response()->json([
            'status' => true,
            'counties' => $counties
        ]);
    }

    public function getAllCounties(): JsonResponse
    {
        $counties = GenericCounty::all();
        return response()->json([
            'status' => true,
            'listCounties' => $counties
        ]);
    }

    /**
     * @param GetCitiesRequest $request
     * @return JsonResponse
     */
    public function getCities(GetCitiesRequest $request): JsonResponse
    {
        $cities = GenericCity::with(['zones'])->where(['id_county' => $request->id_county])->get();
        return response()->json([
            'status' => true,
            'cities' => $cities
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getAllCities(): JsonResponse
    {
        $cities = GenericCity::all();
        return response()->json([
            'status' => true,
            'listCities' => $cities
        ]);
    }
}
