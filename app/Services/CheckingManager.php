<?php

namespace App\Services;


use App\Services\Robots\RobotsTxtParser;

class CheckingManager
{
    /**
     * @param $url
     * @return mixed
     */
    public function prepareUrl($url)
    {
        $url = preg_replace("(^https?://)", "", htmlspecialchars(trim($url)));
        $url = str_replace('/robots.txt', '', $url);
        $url .= '/robots.txt';

        return $url;
    }

    /**
     * @param $url
     * @return mixed
     */
    public function checkSite($url)
    {
        $info = $this->getInfo($url);

        return $info;
    }

    /**
     * @param $url
     * @return array
     */
    public function getInfo($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        curl_setopt( $ch , CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 200);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:45.0) Gecko/20100101 Firefox/45.0');

        $html = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        $parser = new RobotsTxtParser($html);

        return compact('html', 'info', 'parser');
    }
}