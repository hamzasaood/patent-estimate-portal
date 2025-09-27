<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\WipoSample;

class WipoController extends Controller
{
    //
    public function fetchnew($application_number)
    {
        try {
            // Example: Fetch patent data from WIPO or EPO OPS
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get("https://ops.epo.org/rest-services/published-data/search", [
                'q' => "pn={$application_number}" // query by publication/application number
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'WIPO API request failed'], 500);
            }

            $data = $response->json();

            // Extract relevant info
            return [
                'title' => $data['exchange-documents'][0]['bibliographic-data']['invention-title'][0]['$'] ?? '',
                'applicant' => $data['exchange-documents'][0]['bibliographic-data']['parties']['applicants'][0]['applicant']['applicant-name']['name']['$'] ?? '',
                'filing_date' => $data['exchange-documents'][0]['bibliographic-data']['application-reference']['document-id'][0]['date'] ?? '',
                'jurisdiction' => $data['exchange-documents'][0]['bibliographic-data']['application-reference']['document-id'][0]['country'] ?? '',
                'application_number' => $application_number
            ];
        } catch (\Exception $e) {
            return response()->json(['error' => 'Exception: '.$e->getMessage()], 500);
        }
    }
    public function fetch(Request $request)

    {
        $appNo = $request->query('appNo');
        $record = WipoSample::where('application_number', $appNo)->first();

        if (!$record) {
            return response()->json(['error' => 'Not found']);
        }

        return response()->json([
            'application_number' => $record->application_number,
            'title'              => $record->title ?? null,
            'applicant'          => $record->applicant,
            'claims'             => $record->claims_count,
            'pages'              => $record->page_count,
            'language'           => $record->language,
            'drawings'           => $record->drawings_count,
            'region'             => $record->application_country,
            'filing_date'        => $record->application_date,
            'priority_date'      => $record->priority_date,
        ]);
    }
}
