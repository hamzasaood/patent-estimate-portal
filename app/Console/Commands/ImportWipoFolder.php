<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WipoSample;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use SimpleXMLElement;

class ImportWipoFolder extends Command
{
    protected $signature = 'wipo:import-folder {path}';
    protected $description = 'Import WIPO biblio + searchreport XML and merge by application number';

    public function handle()
    {
        $basePath = $this->argument('path');

        if (!is_dir($basePath)) {
            $this->error("❌ Folder not found: $basePath");
            return Command::FAILURE;
        }

        $files = $this->scanFolder($basePath);
        $this->info("🔍 Found " . count($files) . " XML files...");

        $biblioData = [];
        $searchData = [];

        foreach ($files as $file) {
            if (!str_ends_with($file, '.xml')) continue;

            $xml = @simplexml_load_file($file);
            if (!$xml) {
                $this->warn("Skipping invalid XML: $file");
                continue;
            }

            // Detect file type
            // Detect file type
$root = $xml->getName();

if ($root === 'exchange-document' || $root === 'exchange-documents') {
    // 📌 Biblio
    $docs = ($root === 'exchange-documents') ? $xml->{'exchange-document'} : [$xml];
    foreach ($docs as $doc) {
        $id = (string) $doc->{'bibliographic-data'}->{'application-reference'}->{'document-id'}->{'doc-number'};
        if (!$id) continue;

        $biblioData[$id] = [
            'application_number' => $id,
            'title' => (string) $doc->{'bibliographic-data'}->{'invention-title'},
            'applicant' => (string) $doc->{'bibliographic-data'}->{'parties'}->{'applicants'}->{'applicant'}->{'applicant-name'}->{'name'},
            'filing_date' => (string) $doc->{'bibliographic-data'}->{'application-reference'}->{'document-id'}->date,
            'publication_date' => (string) $doc->{'bibliographic-data'}->{'publication-reference'}->{'document-id'}->date,
            'language' => (string) $doc['lang'],
            'region' => (string) $doc['country'],
        ];
    }
}
elseif ($root === 'search-report') {
    // 📌 Searchreport
    $id = (string) $xml->{'srep-info'}->{'application-reference'}->{'document-id'}->{'doc-number'};
    if (!$id) continue;

    // extract claims
    $claims = 0;
    $relClaimsNodes = $xml->xpath('//rel-claims');
    if ($relClaimsNodes) {
        foreach ($relClaimsNodes as $node) {
            $relText = trim((string) $node);
            if (preg_match('/(\d+)-(\d+)/', $relText, $m)) {
                $claims = max($claims, (int) $m[2]);
            } elseif (preg_match('/^\d+$/', $relText)) {
                $claims = max($claims, (int) $relText);
            }
        }
    }

    

    $searchData[$id] = [
        'application_number' => $id,
        'claims_count' => $claims ?: null,
        'pages_count' => (int) $xml->{'srep-info'}['total-page-count'],
        'priority_date' => (string) $xml->{'srep-info'}->{'date-of-earliest-priority'}->date,
    ];
}

            }
        

    

        // Merge and save
        foreach ($biblioData as $id => $biblio) {
            $merged = array_merge($biblio, $searchData[$id] ?? []);

            if (!empty($merged['application_number'])) {
                WipoSample::updateOrCreate(
                    ['application_number' => $merged['application_number']],
                    $merged
                );
                $this->info("✅ Saved {$merged['application_number']} (claims={$merged['claims_count']}, pages={$merged['pages_count']})");
            }
        }

        $this->info("🎉 Import finished.");
        return Command::SUCCESS;
    }

    private function scanFolder($path)
    {
        $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
        $files = [];
        foreach ($rii as $file) {
            if ($file->isDir()) continue;
            $files[] = $file->getPathname();
        }
        return $files;
    }
}
