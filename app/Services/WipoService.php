<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WipoService {
    public function fetchByApplication($appNo){
        $url = "https://patentscope.wipo.int/search/en/detail.jsf?docId=$appNo"; 
        // Real API needs credentials – or scrape. (placeholder)
        $response = Http::get($url);

        // parse fields (title, applicant, etc.)
        return [
            'title' => 'Demo Invention Title',
            'applicant' => 'Demo Applicant Ltd',
            'priority_date' => '2025-01-01',
            'filing_date' => '2025-02-01'
        ];
    }
}
