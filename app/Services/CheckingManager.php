<?php

namespace App\Services;

use Mockery\Exception;
use \vipnytt\RobotsTxtParser\TxtClient;

/**
 * Class CheckingManager
 * @package App\Services
 */
class CheckingManager
{
    /**
     * @param $url
     * @return mixed
     */
    public function checkSite($url)
    {
        $url = $this->prepareUrl($url);
        $info = $this->getInfo($url);
        $checking = $this->checking($info);
        $messages = $this->getMessages($checking);
        $messages = $this->clearMessages($messages, $checking);

        return $messages;
    }

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
     * @return array
     */
    public function getInfo($url)
    {
        try {
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

            $client = new TxtClient('http://' . $url, 200, $html);

            return compact('html', 'info', 'client');
        } catch (Exception $e) {}

        return [];
    }

    /**
     * @param $info
     * @return array
     */
    public function checking($info)
    {
        $check = [
            'exist' => $this->checkExist($info),
            'host' => $this->checkHost($info),
            'host-count' => $this->countHosts($info),
            'check-size' => $this->size($info),
            'size' => $this->getSize($info),
            'sitemap' => $this->sitemap($info),
            'check-code' => $this->statusCode($info),
            'code' => $this->getStatusCode($info),
        ];

        return $check;
    }

    /**
     * @param $info
     * @return bool
     */
    public function checkExist($info)
    {
        if(isset($info['info']['http_code']) && $info['info']['http_code'] == 200) {
            return true;
        }

        return false;
    }

    /**
     * @param $info
     * @return bool
     */
    public function checkHost($info)
    {
        if(!isset($info['client'])) {
            return false;
        }

        $host = $info['client']->host()->export();

        if($host === null) {
            return false;
        }

        return true;
    }

    /**
     * @param $info
     * @return bool
     */
    public function countHosts($info)
    {
        if(!isset($info['html'])) {
            return false;
        }

        $count = substr_count($info['html'], 'Host');

        if($count == 1) {
            return true;
        }

        return false;
    }

    /**
     * @param $info
     * @return bool
     */
    public function statusCode($info)
    {
        if(isset($info['info']['http_code']) && $info['info']['http_code'] == 200) {
            return true;
        }

        return false;
    }

    /**
     * @param $info
     * @return bool
     */
    public function getStatusCode($info)
    {
        if(isset($info['info']['http_code'])) {
            return $info['info']['http_code'];
        }

        return 404;
    }

    /**
     * @param $info
     * @return bool
     */
    public function size($info)
    {
        if(isset($info['info']['size_download']) && $info['info']['size_download'] < 32768) {
            return true;
        }

        return false;
    }

    /**
     * @param $info
     * @return bool
     */
    public function getSize($info)
    {
        if(isset($info['info']['size_download'])) {
            return $info['info']['size_download'];
        }

        return 0;
    }

    /**
     * @param $info
     * @return bool
     */
    public function sitemap($info)
    {
        if(!isset($info['client'])) {
            return false;
        }

        $host = $info['client']->sitemap()->export();

        if(count($host)) {
            return true;
        }

        return false;
    }

    /**
     * @param $checking
     * @return array
     */
    public function getMessages($checking)
    {
        $all = config('messages');
        $messages = [];

        foreach ($all as $key => $fullMessage) {
            $messages[$key] = [
                'title' => $fullMessage['title'],
                'status' => $fullMessage[$checking[$key]]['status'],
                'message' => $fullMessage[$checking[$key]]['message'],
            ];

            preg_match('/\[(.*?)\]/', $messages[$key]['status'], $match);
            if (count($match)) {
                $search = $match[1];
                $messages[$key]['status'] = str_replace("[$search]", $checking[$search], $messages[$key]['status']);
            }
        }

        return $messages;
    }

    /**
     * @param $messages
     * @param $check
     * @return mixed
     */
    public function clearMessages($messages, $check)
    {
        if (!$check['exist'] || !$check['check-code']) {
            unset($messages['host']);
            unset($messages['host-count']);
            unset($messages['check-size']);
            unset($messages['sitemap']);
        }

        if (!$check['host']) {
            unset($messages['host-count']);
        }

        return $messages;
    }
}