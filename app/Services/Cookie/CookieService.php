<?php

namespace App\Services\Cookie;

use Illuminate\Support\Facades\Cookie;

class CookieService
{
    public $history = [];

    public function set($key = '', $value = '', $minutes = 30)
    {
        Cookie::queue($key, $value, $minutes);
    }

    public function get($key = '')
    {
        $c = Cookie::get($key);

        // 判斷若有使用 Cookie::queue 方法新增資料，即時更新以利註冊至前台頁面進行顯示
        if (array_key_exists($key, Cookie::getQueuedCookies())) {
            $c = Cookie::getQueuedCookies()[$key];
            $d = explode(' ', $c)[0];
            list($key2, $c) = explode('=', $d);
            $c = str_replace(';', '', urldecode($c));
        }

        return $c;
    }

    public function setDictHistory($q = '')
    {
        if ($q) {
            $oldCookie = Cookie::get($this->getKey());
            $newCookie = sprintf('%s|%s', $oldCookie, $q);
            Cookie::queue($this->getKey(), $newCookie, 30);
        }
    }

    public function parseDictHistory()
    {
        $qHistory = $this->get($this->getKey());

        $qHistory = collect(explode('|', $qHistory));

        $rtn = [];
        foreach ($qHistory as $item) {
            if (!$item) {
                continue;
            }
            if (array_key_exists($item, $rtn)) {
                $rtn[$item] += 1;
            } else {
                $rtn[$item] = 1;
            }
        }

        arsort($rtn); //sort by value high to low
        return $rtn;
    }
}