<?php

namespace App\Http\Controllers;

use App\Models\Settlement;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SettlementController extends Controller
{
    public function find(Request $request)
    {
        $zipcode = $request->route('zipcode');

        $settlements = Settlement::query()
            ->where('zip_code', $zipcode)
            ->get();

        return $this->buildResponse($settlements);
    }

    private function buildResponse(Collection $settlements)
    {
        $settlement = $settlements->first();
        $response =  [
            'zip_code' => $settlement->zip_code,
            'locality' => $settlement->locality,
            'federal_entity' => [
                'key' => $settlement->federal_entity_key,
                'name' => $settlement->federal_entity_name,
                'code' => $settlement->federal_entity_code,
            ],
            'settlements' => array(),
            'municipality' => [
                'key' => $settlement->municipality_key,
                'name' => $settlement->municipality_name,
            ]
        ];

        $result = array();
        $settlements->each(function ($settlement) use (&$result) {
            $result[] = [
                'key' => $settlement->settlement_key,
                'name' => $settlement->settlement_name,
                'zone_type' => $settlement->settlement_zone_type,
                'settlement_type' => $settlement->settlement_type
            ];
        });

       $response['settlements'] = $result;

       return $response;
    }
}
