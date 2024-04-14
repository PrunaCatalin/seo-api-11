<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\DomCrawler\Crawler;

class RablauCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    private CookieJar $cookieJar;
    private Client $client;
    protected $signature = 'app:piesa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     * @throws GuzzleException
     */
    public function handle()
    {
        $this->cookieJar = new CookieJar();
        $this->client = new Client([
            'cookies' => $this->cookieJar,
//            'allow_redirects' => true,
        ]);
        $source = $this->login();
        $filename = storage_path('app/public/pag.html');
        file_put_contents($filename, $this->searchDetails('146.770EL', $source));
    }

    private function login()
    {
        $getUrl = 'https://web4.carparts-cat.com/CatConnect.aspx?Data=BA3971A4E3483317A6A42766679254F0369533AF55EC913F009BD06C302DB6E00E16A3D8D6D28484306CD45C3BD9FA2B402C3B2A52766A3409DF88B9CAF278968D86C1DFE8E562D07FE237D25B6A0EDF70B016EF366BE5F9939F5210BB6420170A6DF3DD8615B0450C003ED13B386F25D13A2A9DC00627E61383D3283409E961';
        return $this->makeGetRequest($getUrl);
    }

    /**
     * @throws GuzzleException
     */
    private function searchDetails($idArticol, $source)
    {
        $crawler = new Crawler($source);

        $url = $crawler->filter('#Main')->each(function (Crawler $node) {
            return 'https://web4.carparts-cat.com/' . str_replace('./', '', $node->attr('action'));
        });
        $urlParts = [];
        parse_str($url[0], $urlParts);

        $this->makePostRequestWithJson(
            'https://web4.carparts-cat.com/wsvc/Global/DBUserItem.asmx/SetHomeSearchHistory',
            [
                'sessionID' => $urlParts['10'],
                'typeRefKombi' => '100+-1',
                'suchtext' => $idArticol
            ]
        );

        //$url = 'https://web4.carparts-cat.com/Default.aspx?10=1DFC95B106024D5B85A64B4B6540E6E8117004&12=130&14=4&122=1&230=8&1271=86&1272=d36bea7b-96d2-4bea-8ef5-544588de55a5';
        $data = [
            '__EVENTTARGET' => 'tp_articlesearch_imgBtn',
            '__EVENTARGUMENT' => '',
            '__VIEWSTATE' => '',
            '__PREVIOUSPAGE' => 'zziS_Pir3r6aVy2rhcqYd7H1KZLp8z4h4TIIqqcLnsQGMOH4gtIMCFuTQDTmhPgMope3191g4ddjGdA3KfSsf5ZaZmE1',
            'chatData' => '',
            'tp_articlesearch$chkbox_artikelsuche_input_manufacturer' => 'on',
            'tp_articlesearch$chkbox_artikelsuche_input_trader' => 'on',
            'tp_articlesearch$chkbox_artikelsuche_input_oenr' => 'on',
            'tp_articlesearch$ddl_artikelsuche_oenr' => '0',
            'tp_articlesearch$txt_art_direkt' => $idArticol,
            'tp_articlesearch$txt_universalArticleSearch' => '',
            'tp_articlesearch$auswahl_etypart' => 'tabcontrol_pkw_auswahl_etypart_rb_pkw',
            'tp_articlesearch$txt_nkwrefid' => '',
            'tp_articlesearch$auswahl_tecdoc_motorcode_combo_NKW' => 'widgetauswahl_etypart_rb_motorcode_NKW',
            'tp_articlesearch$txt_tecdoc_motorcode_combo_NKW' => '',
            'tp_articlesearch$txt_regnr_24' => '',
            'tp_articlesearch$txt_motorcode' => '',
            'hf_contractId' => '',
            'hf_cid' => '',
            'hf_username' => '',
            'hf_pw' => '',
            'hf_reqUrl' => '',
            'hf_DvseSid' => '',
            'hf_signature' => '',
            'hf_erstzulassung' => '',
            'hf_kennzeichen' => '',
            'hf_VIN' => '',
            'hf_kunde' => '',
            'hf_KBA' => '',
            'hf_vorgangsbez' => '',
        ];


        return $this->makePostRequest($url[0], $data);
    }

    private function getDetails()
    {
    }

    protected function makeGetRequest($url): StreamInterface
    {
        $response = $this->client->get($url);
        return $response->getBody();
    }

    /**
     * @throws GuzzleException
     */
    protected function makePostRequest(string $url, $formData): StreamInterface
    {
        $response = $this->client->request('POST', $url, [
            'form_params' => $formData
        ]);
        return $response->getBody();
    }

    protected function makePostRequestWithJson($url, $jsonData)
    {
        try {
            $response = $this->client->post($url, [
                'json' => $jsonData,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            return $response->getBody();
        } catch (GuzzleException $e) {
            echo 'Request failed: ' . $e->getMessage() . "\n";
        }
    }

}
