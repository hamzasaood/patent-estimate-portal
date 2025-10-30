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


/*

    public function searchepo(Request $request)
{
    $appNumber = trim($request->get('app_number'));

    if (empty($appNumber)) {
        return response()->json(['error' => 'Application number missing'], 400);
    }

    try {
        // Step 1: Get Access Token
        $clientId = env('EPO_CONSUMER_KEY');
        $clientSecret = env('EPO_CONSUMER_SECRET');
        $auth = base64_encode("$clientId:$clientSecret");

        $tokenResponse = Http::asForm()
            ->withHeaders(['Authorization' => "Basic $auth"])
            ->post('https://ops.epo.org/3.2/auth/accesstoken', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$tokenResponse->ok()) {
            return response()->json(['error' => 'Failed to get access token'], 500);
        }

        $accessToken = $tokenResponse->json()['access_token'] ?? null;
        if (!$accessToken) {
            return response()->json(['error' => 'Missing access token'], 500);
        }

        // Step 2: Call Register endpoint (main biblio info)
        $registerUrl = "https://ops.epo.org/3.2/rest-services/register/publication/epodoc/{$appNumber}/biblio";
        $registerResponse = Http::withHeaders([
            'Accept' => 'application/xml',
            'Authorization' => "Bearer $accessToken",
        ])->get($registerUrl);

        // Step 3: Call Published-data endpoint (for pages/claims)
        $publishedUrl = "https://ops.epo.org/3.2/rest-services/published-data/publication/epodoc/{$appNumber}/biblio";
        $publishedResponse = Http::withHeaders([
            'Accept' => 'application/xml',
            'Authorization' => "Bearer $accessToken",
        ])->get($publishedUrl);

        // Log if any fails
        if (!$registerResponse->ok() && !$publishedResponse->ok()) {
            \Log::error('EPO API Error: '.$registerResponse->status().' - '.$registerResponse->body());
            return response()->json([
                'error' => 'EPO request failed',
                'status' => $registerResponse->status(),
                'details' => $registerResponse->body()
            ], 500);
        }

        // Step 4: Parse XMLs
        $registerXml = simplexml_load_string($registerResponse->body());
        $registerXml->registerXPathNamespace('reg', 'http://www.epo.org/register');
        $publishedXml = simplexml_load_string($publishedResponse->body());
        $publishedXml->registerXPathNamespace('ep', 'http://www.epo.org/exchange');

        // Extract Data
        $data = [
            'application_number' => (string) ($registerXml->xpath('//reg:application-reference/reg:doc-number')[0] ?? ''),
            'publication_number' => (string) ($registerXml->xpath('//reg:publication-reference/reg:doc-number')[0] ?? ''),
            'title'              => (string) ($registerXml->xpath('//reg:invention-title[@lang="en"]')[0] ?? ''),
            'applicant'          => (string) ($registerXml->xpath('//reg:applicant/reg:name')[0] ?? ''),
            'inventor'           => (string) ($registerXml->xpath('//reg:inventor/reg:name')[0] ?? ''),
            'agent'              => (string) ($registerXml->xpath('//reg:agent/reg:name')[0] ?? ''),
            'ipc_classes'        => collect($registerXml->xpath('//reg:classifications-ipcr/reg:text'))->map(fn($n) => (string)$n)->implode(', '),
            'filing_date'        => (string) ($registerXml->xpath('//reg:application-reference/reg:date')[0] ?? ''),
            'priority_date'      => (string) ($registerXml->xpath('//reg:priority-claim/reg:date')[0] ?? ''),
            'priority_number'    => (string) ($registerXml->xpath('//reg:priority-claim/reg:doc-number')[0] ?? ''),
            'claims_count'       => (string) ($publishedXml->xpath('//ep:number-of-claims')[0] ?? ''),
            'pages_count'        => (string) ($publishedXml->xpath('//ep:number-of-pages')[0] ?? ''),
        ];

        return response()->json([
            'success' => true,
            'data' => $data
        ]);

    } catch (\Exception $e) {
        \Log::error('EPO Exception: '.$e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
-*/



public function searchepo(Request $request)
{
    $appNumber = $this->normalizeEpoAppNumber($request->get('app_number'));

    //dd($appNumber);


    try {
        // === STEP 1: Get Access Token ===
        $clientId = env('EPO_CONSUMER_KEY');
        $clientSecret = env('EPO_CONSUMER_SECRET');
        $auth = base64_encode("$clientId:$clientSecret");

        $tokenResponse = Http::asForm()
            ->withHeaders(['Authorization' => "Basic $auth"])
            ->post('https://ops.epo.org/3.2/auth/accesstoken', [
                'grant_type' => 'client_credentials',
            ]);

        if (!$tokenResponse->ok()) {
            return response()->json(['error' => 'Failed to get access token'], 500);
        }

        $accessToken = $tokenResponse->json()['access_token'] ?? null;
        if (!$accessToken) {
            return response()->json(['error' => 'Missing access token'], 500);
        }

        // === STEP 2: Fetch BIBLIO ===
        if (str_starts_with($appNumber, 'WO')) {
    // PCT/WO-based: Try application first
    $biblioUrls = "https://ops.epo.org/3.2/rest-services/published-data/application/epodoc/{$appNumber}/biblio";

} else {
    // EP-based: Try publication first
    $biblioUrls = "https://ops.epo.org/3.2/rest-services/published-data/publication/epodoc/{$appNumber}/biblio";
    
}



        $biblioResponse = null;
        $biblioResponse = Http::withHeaders([
            'Accept' => 'application/xml',
            'Authorization' => "Bearer $accessToken",
        ])->get($biblioUrls);

        //dd($biblioResponse->body());

        if (!$biblioResponse) {
            return response()->json(['error' => 'EPO biblio request failed'], 500);
        }

        $biblioXml = @simplexml_load_string($biblioResponse->body());
        if (!$biblioXml) {
            return response()->json(['error' => 'Failed to parse biblio XML'], 500);
        }
        $biblioXml->registerXPathNamespace('ep', 'http://www.epo.org/exchange');

        // Helper for English fields
        $getLangText = function ($nodes) {
            foreach ($nodes as $node) {
                $attrs = $node->attributes();
                if (isset($attrs['lang']) && strtolower((string)$attrs['lang']) === 'en') {
                    return trim((string)$node);
                }
            }
            return trim((string)($nodes[0] ?? ''));
        };

        // Extract bibliographic fields
        $title = $getLangText($biblioXml->xpath('//ep:invention-title'));
        $applicant = $getLangText($biblioXml->xpath('//ep:applicants/ep:applicant/ep:applicant-name/ep:name'));
        $inventor = $getLangText($biblioXml->xpath('//ep:inventors/ep:inventor/ep:inventor-name/ep:name'));
        $filingDate = (string)($biblioXml->xpath('//ep:application-reference/ep:document-id/ep:date')[0] ?? '');
        $priorityDate = (string)($biblioXml->xpath('//ep:priority-claims/ep:priority-claim/ep:document-id/ep:date')[0] ?? '');
        $priorityNumber = (string)($biblioXml->xpath('//ep:priority-claims/ep:priority-claim/ep:document-id/ep:doc-number')[0] ?? '');
        $publicationNumber = (string)($biblioXml->xpath('//ep:publication-reference/ep:document-id/ep:doc-number')[0] ?? '');
        $abstractNodes = $biblioXml->xpath('//ep:abstract[@lang="en"]/ep:p');
if (empty($abstractNodes)) {
    // Fallback: try without language filter
    $abstractNodes = $biblioXml->xpath('//ep:abstract/ep:p');
}
$abstract = '';
foreach ($abstractNodes as $node) {
    $abstract .= trim((string)$node) . ' ';
}
$abstract = trim($abstract);

// Calculate word count for abstract
$abstractWordCount = str_word_count($abstract);



        $ipcClasses = implode(', ', array_map('strval', $biblioXml->xpath('//ep:classification-ipcr/ep:text') ?: []));
        

        // === STEP 3: FETCH CLAIMS + PAGES ===
$claimsCount = '';
$pagesCount = '';
$wordcount = '';
$claimsWordCount = 0;

// --- Get claims count directly from /claims endpoint ---
if (str_starts_with($appNumber, 'WO')) {
$claimsUrl = "https://ops.epo.org/3.2/rest-services/published-data/application/epodoc/{$appNumber}/claims";
} else {
$claimsUrl = "https://ops.epo.org/3.2/rest-services/published-data/publication/epodoc/{$appNumber}/claims";
}
$claimsResponse = Http::withHeaders([
    'Accept' => 'application/xml',
    'Authorization' => "Bearer $accessToken",
])->get($claimsUrl);

$claimsXml = $claimsResponse->body();



//dd($claimsXml);
if ($claimsResponse->ok()) {
    $xmlString = $claimsXml;
    
    // Simple check: count occurrences of <claim-text>...</claim-text> in English section only
    if (preg_match('/<claims[^>]*lang="EN"[^>]*>(.*?)<\/claims>/is', $xmlString, $match)) {
        $englishClaimsBlock = $match[1];
        preg_match_all('/<claim-text\b[^>]*>.*?<\/claim-text>/is', $englishClaimsBlock, $claimTexts);
        $claimsCount = count($claimTexts[0]);
    } else {
        // fallback: count all claim-text tags in full XML
        preg_match_all('/<claim-text\b[^>]*>.*?<\/claim-text>/is', $xmlString, $claimTexts);
        $claimsCount = count($claimTexts[0]);
    }

    foreach ($claimTexts[0] as $claim) {
        $cleanText = strip_tags($claim); // remove any XML tags
        $wordsCount = str_word_count($cleanText);
        $claimsWordCount += $wordsCount;
    }

}




        // --- Estimate pages count from description ---
        

if (str_starts_with($appNumber, 'WO')) {
$descriptionUrl = "https://ops.epo.org/3.2/rest-services/published-data/application/epodoc/{$appNumber}/description";
} else {
$descriptionUrl = "https://ops.epo.org/3.2/rest-services/published-data/publication/epodoc/{$appNumber}/description";
}
$descriptionResponse = Http::withHeaders([
    'Accept' => 'application/json',
    'Authorization' => "Bearer $accessToken",
])->get($descriptionUrl);

if ($descriptionResponse->ok()) {
    try {
        $data = $descriptionResponse->json();

        // Navigate safely into description paragraphs
        $paragraphs = data_get($data, 'ops:world-patent-data.ftxt:fulltext-documents.ftxt:fulltext-document.description.p', []);

        // Normalize paragraph data (handle array or single paragraph)
        if (!is_array($paragraphs)) {
            $paragraphs = [$paragraphs];
        }

        // Concatenate all text
        $fullText = '';
        foreach ($paragraphs as $para) {
            $text = is_array($para) ? ($para['$'] ?? '') : (is_string($para) ? $para : '');
            $fullText .= ' ' . $text;
        }

        // Count characters
        $charCount = strlen($fullText);

        $wordcount = str_word_count($fullText);

        // Estimate pages (average 1800 characters per page)
        $pagesCount = max(1, ceil($charCount / 1800));

    } catch (\Exception $e) {
        \Log::error('Error parsing description for ' . $appNumber . ': ' . $e->getMessage());
        $pagesCount = null;
    }
}










// --- Get total pages and drawing pages from /images endpoint ---

if (str_starts_with($appNumber, 'WO')) {
    $imagesUrl = "https://ops.epo.org/3.2/rest-services/published-data/application/epodoc/{$appNumber}/images";
} else {
    $imagesUrl = "https://ops.epo.org/3.2/rest-services/published-data/publication/epodoc/{$appNumber}/images";
}

$imagesResponse = Http::withHeaders([
    'Accept' => 'application/json',
    'Authorization' => "Bearer $accessToken",
])->get($imagesUrl);

$totalPages = null;
$drawingsPages = null;

if ($imagesResponse->ok()) {
    try {
        $data = $imagesResponse->json();

        // Get inquiry results
        $inquiryResults = data_get($data, 'ops:world-patent-data.ops:document-inquiry.ops:inquiry-result', []);

        // Normalize single object to array
        if (isset($inquiryResults['publication-reference'])) {
            $inquiryResults = [$inquiryResults];
        }

        // --- Prefer B1 publication (granted) or fall back to A1 ---
        $preferred = collect($inquiryResults)->firstWhere(
            'publication-reference.document-id.kind.$', 'B1'
        ) ?? collect($inquiryResults)->firstWhere(
            'publication-reference.document-id.kind.$', 'A1'
        );

        if (!$preferred) {
            \Log::warning("⚠️ No valid A1/B1 publication found for {$appNumber}");
            return;
        }

        $instances = data_get($preferred, 'ops:document-instance', []);
        if (isset($instances['@system'])) {
            $instances = [$instances]; // normalize if single instance
        }

        $maxFullDocPages = 0;
        $maxDrawingPages = 0;

        foreach ($instances as $instance) {
            $desc = data_get($instance, '@desc');
            $pages = (int) data_get($instance, '@number-of-pages');

            if (strtolower($desc) === 'fulldocument') {
                $maxFullDocPages = max($maxFullDocPages, $pages);
            }

            if (strtolower($desc) === 'drawing') {
                $maxDrawingPages = max($maxDrawingPages, $pages);
            }
        }

        $totalPages = $maxFullDocPages ?: null;
        $drawingsPages = $maxDrawingPages ?: null;

        \Log::info("✅ EPO /images parsed for {$appNumber}: totalPages={$totalPages}, drawingsPages={$drawingsPages}");
    } catch (\Exception $e) {
        \Log::error('❌ Error parsing /images data for ' . $appNumber . ': ' . $e->getMessage());
    }
}



$total_wordcount = intval(($wordcount + $claimsWordCount + $abstractWordCount) * 1.0005);






        // === STEP 4: Return Combined Response ===
        return response()->json([
            'success' => true,
            'data' => [
                'application_number' => $appNumber,
                'publication_number' => $publicationNumber,
                'title' => $title,
                'applicant' => $applicant,
                'inventor' => $inventor,
                'ipc_classes' => $ipcClasses,
                'filing_date' => $filingDate,
                'priority_date' => $priorityDate,
                'priority_number' => $priorityNumber,
                'claims_count' => $claimsCount,
                'pages_count' => $totalPages,
                'drawing_pages' => $drawingsPages,
                'word_count' => $total_wordcount,
                'abstract' => $abstractWordCount,
            ]
        ]);

    } catch (\Throwable $e) {
        \Log::error('EPO Fetch Error: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}






private function normalizeEpoAppNumber($number)
{
    $number = strtoupper(trim($number));

    // Example: PCT/IB/2007/051010 → WO2007IB51010
    if (str_starts_with($number, 'PCT/')) {
        $parts = explode('/', $number);
        if (count($parts) === 4) {
            [$prefix, $country, $year, $serial] = $parts;

            // Remove any leading zeros from serial but keep digits only
            $serial = ltrim(preg_replace('/[^0-9]/', '', $serial), '0');

            return 'WO' . $year . $country . $serial;
        }
    } 
    elseif (str_starts_with($number, 'EP')) {
        return $number;
    }
    elseif (str_starts_with($number, 'WO')) {
        return $number;
    }

    elseif (preg_match('/^([A-Z]{2})(\d{4})(\d+)/', $number, $matches)) {
        $country = $matches[1];
        $year = $matches[2];
        $serial = ltrim($matches[3], '0'); // remove leading zeros
        return 'WO' . $year . $country . $serial;
    }
    elseif (preg_match('/^([A-Z]{2})\/(\d{4})\/(\d+)/', $number, $matches)) {
        $country = $matches[1];
        $year = $matches[2];
        $serial = preg_replace('/[^0-9]/', '', $matches[3]);
        return 'WO' . $year . $country . $serial;
    }

    // Leave EP or others as-is
   else{
    return $number;
   } 
   //return $number;
}




}