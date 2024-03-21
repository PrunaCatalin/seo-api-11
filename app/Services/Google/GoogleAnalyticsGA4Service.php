<?php

namespace App\Services\Google;

use App\Services\Google\Tools\GoogleAnalyticsTools;

/**
 *
 */
class GoogleAnalyticsGA4Service
{
    use GoogleAnalyticsTools;

    public string $googleLink = "https://region1.analytics.google.com/g/collect?";
    /**
     * @var array
     */
    public array $keywords = [];
    /**
     * @var array
     */
    public array $agents = ['Google Chrome', 'Firefox', 'Safari', 'Microsoft Edge'];
    /**
     * @var string
     */
    public string $language = "";
    /**
     * @var string
     */
    public string $country = "";
    /**
     * @var string
     */
    public string $ua = "";
    /**
     * @var string
     */
    public string $cid = "";
    /**
     * @var string
     */
    public string $url = "";
    /**
     * @var string
     */
    public string $urlPage = "";
    /**
     * @var string
     */
    public string $titlePage = "";
    /**
     * @var string
     */
    public string $keyword = "";

    /**
     * @var string
     */
    public string $payload = "";
    /**
     * @var string
     */
    public string $agent = "";
    /**
     * @var string
     */
    private string $version = "v=2";

    /**
     * @var bool
     */
    public bool $scroll = false;

    public string $userAgentMobile = "";

    public int $start = 0;
    /**
     * @var string
     */
    public string $event;
    private array $dataCollector = [];

    /**
     * @return string
     */
    public function getUserAgentMobile(): string
    {
        return $this->userAgentMobile;
    }

    /**
     * @param string $key
     * @param $value
     * @return GoogleAnalyticsGA4Service
     */
    public function addDataToCollector(string $key, $value, bool $reset = false): GoogleAnalyticsGA4Service
    {
        if ($reset) {
            $this->dataCollector = [];
        }
        $this->dataCollector[$key] = $value;
        return $this;
    }

    public function getDataCollectorByKey(string $key)
    {
        return $this->dataCollector[$key] ?? "";
    }

    public function getDataCollector()
    {
        return $this->dataCollector;
    }

    /**
     * @param string $userAgentMobile
     */
    public function setUserAgentMobile(string $userAgentMobile): GoogleAnalyticsGA4Service
    {
        $this->userAgentMobile = $userAgentMobile;
        return $this;
    }

    public function buildPayload(bool $existCustomer = false): string
    {
        $screenResolution = $this->getRandomScreenResolution();
        $architecture = $this->generateArhitecture();
        $this->addDataToCollector('screen_resolution', $screenResolution);
        $this->addDataToCollector('architecture', $architecture);
        $this->addDataToCollector('unique_visitors', $existCustomer);
        $payload = [
            $this->version,
            "tid=" . $this->ua,
            "gtm=" . rand(10000000, 99999999),
            "_p=" . mt_rand(0, 947483647),
            "cid=" . $this->getCid($existCustomer),
            "dh=" . $this->urlPage,
            "ul=" . $this->language,
            "sr=" . $screenResolution,
            "_s=1",
            "sid=" . rand(10000000, 99999999),
            "sct=1",
            "seg=0",
            "dl=" . $this->urlPage,
            "dr=https%3A%2F%2Fwww.google.com%2Fsearch%3Fq%3D" . $this->keyword,
            "dt=" . $this->titlePage,
            "ck=" . urlencode($this->keyword),
            "en=" . $this->getEvent(),
            "_et=" . time() + rand(5000, 9999),
            "_fv=1",
            "_ee=1",
            "_ss=1",//. $this->getStart() ,
            "_nsi=1",//. $this->getStart() ,
            'uaa=' . $architecture,
            'pscdl=noapi',
            'dma_cps=sypham',
            'dma=1',
            'tfd=496',
            'npa=0',
            '_eu=EA',

        ];
        return $this->googleLink . implode("&", $payload);
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(): GoogleAnalyticsGA4Service
    {
        $percentange = $this->getRandomPercentage();
        $event = [
            'page_view',
            'scroll&percent_scrolled=' . $percentange,
        ];
        $indexRandom = rand(0, count($event) - 1);
        $this->event = $event[$indexRandom];
        $this->addDataToCollector('event', $this->event);
        return $this;
    }

    /**
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * @param array $keywords
     */
    public function setKeywords(array $keywords): GoogleAnalyticsGA4Service
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return array
     */
    public function getAgents(): array
    {
        return $this->agents;
    }

    /**
     * @param array $agents
     */
    public function setAgents(array $agents): GoogleAnalyticsGA4Service
    {
        $this->agents = $agents;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): GoogleAnalyticsGA4Service
    {
        $this->language = $language;
        return $this;
    }

    public function setCountry(string $country): GoogleAnalyticsGA4Service
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getUa(): string
    {
        return $this->ua;
    }

    /**
     * @param string $ua
     */
    public function setUa(string $ua): GoogleAnalyticsGA4Service
    {
        $this->ua = $ua;
        return $this;
    }

    public function getCid(bool $exists = false): string
    {
        if (!$exists) {
            $this->cid = $this->generatetCid();
        }
        return $this->cid;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): GoogleAnalyticsGA4Service
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlPage(): string
    {
        return $this->urlPage;
    }

    /**
     * @param string $urlPage
     */
    public function setUrlPage(string $urlPage): GoogleAnalyticsGA4Service
    {
        $this->urlPage = $urlPage;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitlePage(): string
    {
        return $this->titlePage;
    }

    /**
     * @param string $titlePage
     */
    public function setTitlePage(string $titlePage): GoogleAnalyticsGA4Service
    {
        $this->titlePage = $titlePage;
        return $this;
    }

    /**
     * @return string
     */
    public function getKeyword(): string
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     */
    public function setKeyword(string $keyword): GoogleAnalyticsGA4Service
    {
        $this->keyword = $keyword;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): GoogleAnalyticsGA4Service
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return string
     */
    public function getAgent(): string
    {
        return $this->agent;
    }

    /**
     * @param string $agent
     */
    public function setAgent(string $agent): GoogleAnalyticsGA4Service
    {
        $this->agent = $agent;
        return $this;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version): GoogleAnalyticsGA4Service
    {
        $this->version = $version;
        return $this;
    }

    /**
     * @return bool
     */
    public function isScroll(): bool
    {
        return $this->scroll;
    }

    /**
     * @param bool $scroll
     */
    public function setScroll(bool $scroll): GoogleAnalyticsGA4Service
    {
        $this->scroll = $scroll;
        return $this;
    }

    public function setStart(int $nr): GoogleAnalyticsGA4Service
    {
        $this->start = $nr;
        return $this;
    }

    public function getStart(): int
    {
        return $this->start;
    }
}
