<?php

namespace App\Services\Google\Tools;

use App\Services\Google\GoogleVersion;
use Modules\Admin\Entities\GoogleGeoId;

trait GoogleAnalyticsTools
{
    /**
     * @return string
     */
    public function generateRandomString(): string
    {
        return
            rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . "a" .
            rand(0, 9) . rand(0, 9) . "-" . rand(0, 9) . "a" . rand(0, 9) . rand(0, 9) . "-" .
            rand(0, 9) . rand(0, 9) . "d" . rand(0, 9) . "-b" . rand(0, 9) . rand(0, 9) .
            rand(0, 9) . "-" . rand(0, 9) . "b" . rand(0, 9) . rand(0, 9) . rand(0, 9) . "d" .
            rand(0, 9) . "f" . rand(0, 9) . rand(0, 9) . rand(0, 9) . "b";
    }

    /**
     * @return string
     */
    public function generateRandomProxy(): string
    {
        return rand(1, 255) . "." . rand(1, 255) . "." . rand(1, 255) . "." . rand(1, 255);
    }

    /**
     * @return array
     */
    public function randomWebAgent($is_mobile = false): array
    {
        $userAgents = parse_ini_file(storage_path("/app/resource/google/agents.ini"), true);
        $finalAgent = [];
        $finalKey = ''; // Variabilă pentru a păstra cheia

        foreach ($this->agents as $agent) {
            $keys = array_keys($userAgents[$agent]);
            $randomKey = $keys[array_rand($keys)]; // Selectează o cheie aleatorie
            $finalAgent[] = $userAgents[$agent][$randomKey];
            $finalKey = $agent; // Păstrează ultima cheie folosită
        }

        $selectedKey = array_rand($finalAgent); // Selectează un indice aleatoriu din agenții finali
        $this->agent = $finalAgent[$selectedKey];
        $agentKey = $finalKey; // Păstrează cheia corespondentă agentului selectat

        return ['agent' => $this->agent, 'key' => $agentKey];
    }

    /**
     * @return mixed
     */
    public function getCountry($country)
    {
        return GoogleGeoId::where(function ($q) use ($country) {
            $q->where("target_type", "City");
            $q->where("status", "Active");
            if (!empty($country)) {
                $q->where("country_code", strtoupper($country));
            }
        })->inRandomOrder()->first();
    }

    /**
     * @param string $version
     * @return string
     */
    public function generatetCid()
    {
        return rand(111111111, 999999999) . '.' . rand(1111111111, 9999999999);
    }

    /**
     * @return string
     */
    public function getRandomScreenResolution(): string
    {
        $resolutions = [
            '640x480',    // VGA
            '800x600',    // SVGA
            '1024x768',   // XGA
            '1280x720',   // HD
            '1280x800',   // WXGA
            '1366x768',   // Common laptop screen resolution
            '1440x900',   // WXGA+
            '1600x900',   // HD+
            '1680x1050',  // WSXGA+
            '1920x1080',  // Full HD
            '2560x1440',  // QHD
            '2560x1600',  // WQXGA
            '3840x2160'   // 4K UHD
        ];

        return $resolutions[array_rand($resolutions)];
    }

    public function generateArhitecture(): string
    {
        $list = ['x86', 'x64'];
        return $list[rand(0, sizeof($list) - 1)];
    }

    public function getRandomPercentage(): int
    {
        $numbers = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
        $indexRandom = rand(0, count($numbers) - 1);
        return $numbers[$indexRandom];
    }
}
