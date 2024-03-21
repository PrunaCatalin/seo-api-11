<?php

namespace App\Console\Commands\Workers;

use App\Services\Google\GoogleAnalyticsGA4Service;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Console\OutputStyle;
use Modules\Tenants\Entities\Stats\SessionDataGoogle;

class ParallelRequestsCommand extends Command
{
    protected $signature = 'parallel:requests {--website=} {--views=}';
    protected $description = 'Perform parallel requests using GuzzleClient';

    /**
     * @throws GuzzleException
     */
    public function handle()
    {
        $slug = $this->option('website');
        $views = $this->option('views');
        $this->info('Keep in mind views will be views = views * nr_keywords find in page');
        $url = "https://" . $slug;
        $code = "G-HMWQN5C82N";
        $code = "G-N9S3NQX9WC";
        $lang = "en-us";
        $metaData = $this->getMetaDataUrl($url);
        $metaData['keywords'] = [
            "piese auto",
            "accesorii auto",
            "filtre auto",
            "ulei motor",
            "anvelope",
            "baterii auto",
            "plăcuțe frână",
            "ambreiaj",
            "faruri auto",
            "suspensie auto",
            "echipamente diagnoză",
            "întreținere auto",
            "părți caroserie",
            "senzori auto",
            "sistem de evacuare",
            "radiator auto",
            "oglinzi auto",
            "țevi de eșapament",
            "pompe de apă auto",
            "curele transmisie"
        ];

        $service = new GoogleAnalyticsGA4Service();
        $output = new OutputStyle($this->input, $this->output);
        $isCustomer = false;
        for ($i = 0; $i < $views; $i++) {
            $service->addDataToCollector('empty', null, true);
            $service->addDataToCollector('g_tag', $code);
            $service->addDataToCollector('title', $metaData['title']);
            $service->addDataToCollector('language', $lang);
            $service->addDataToCollector('maxViews', $views);
            $service->addDataToCollector('keywords', $metaData['keywords']);

            $randomKeyword = $metaData['keywords'][array_rand($metaData['keywords'])];
            $agent = $service->randomWebAgent();
            $service->addDataToCollector('keywords_used', $randomKeyword);
            $service->addDataToCollector('agent', $agent['agent']);
            $service->addDataToCollector('agent_small', $agent['key']);
            $payload = $service
                ->setUa($code)
                ->setUrl($url)
                ->setUrlPage($url)
                ->setTitlePage($metaData['title'])
                ->setLanguage($lang)
                ->setCountry($lang)
                ->setKeyword($randomKeyword[0])
                ->setAgent($agent['agent'])
                ->setEvent();
            $request = [
                'payload' => $payload->buildPayload($isCustomer),
                "params" => [
                    'agent' => $agent,
                    'keyword' => $randomKeyword,
                    'event' => $service->getEvent()
                ]
            ];
            $client = new Client([
                'headers' => [
                    'User-Agent' => $request['params']['agent']
                ]
            ]);

            $maxRetries = 3; // Numărul maxim de încercări pentru fiecare cerere
            $attempt = 0; // Contorul curent de încercări
            $success = false; // Starea de succes a cererii

            while (!$success && $attempt < $maxRetries) {
                try {
                    $response = $client->request('POST', $request['payload'], [
//                        'proxy' => 'http://expressvpn2023-rotate:NgN3V9N31E8CN@p.webshare.io:80'
//                        'proxy' => 'http://91.107.180.250:80'
                    ]);

                    $service->addDataToCollector('url', $url);
                    $service->addDataToCollector('url_code', 200);
                    $success = true;
                } catch (\Exception $e) {
                    $attempt++;
                    $service->addDataToCollector('url', $url);
                    $service->addDataToCollector('url-url_code', $e->getCode());
//                    sleep(1);
//                    $success = false;
                }
                // Verifică dacă toate încercările au eșuat
                if (!$success) {
                    $service->addDataToCollector('url_failed', $url);
                } else {
                    $dataToInsert = [
                        'associated_domain_id' => 1,
                        'tenant_id' => 'seofronttest', // Presupunem că există
                        'unique_visitors' => intval($isCustomer), // take from generate CID
                        'title' => $service->getDataCollectorByKey('title'),
                        'language' => $service->getDataCollectorByKey('language'),
                        'region' => 'Region X',
                        'country' => $service->getDataCollectorByKey('language'),
                        'keyword' => $service->getDataCollectorByKey('keywords_used'),
                        'agent' => $service->getDataCollectorByKey('agent_small'),
                        'page_views' => $i,
                        'event' => $service->getDataCollectorByKey('event'),
                        'architecture' => $service->getDataCollectorByKey('architecture'),
                        'screen_resolution' => $service->getDataCollectorByKey('screen_resolution'),
                        'date' => date("Y-m-d"),
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                    SessionDataGoogle::insert($dataToInsert);
                    $output->writeln("<keyword>" . $service->getDataCollectorByKey('keywords_used') . "</keyword><br>");
//                    if ($i % 2 == 0 && $i > 0) {
//                        $isCustomer = true;
//                    } else {
//                        $isCustomer = false;
//                    }
                }
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    private function getMetaDataUrl($url): array
    {
        $metaData = ["title" => "", "keywords" => []];
        $client = new Client();
        $response = $client->get($url);
        $body = (string)$response->getBody();
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($body);
        $metaData['title'] = $dom->getElementsByTagName('title')[0]->nodeValue;
        $xpath = new DOMXPath($dom);
        $keywords = $xpath->query('//meta[@name="keywords"]/@content');

        if ($keywords->length > 0) {
            $metaData['keywords'] = explode(",", $keywords->item(0)->nodeValue);
        }
        return $metaData;
    }
}
