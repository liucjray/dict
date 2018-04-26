<?php

namespace App\Services;

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
        return Cookie::get($key);
    }

    public function getDictHistoryKey()
    {
        return 'q';
    }

    public function setDictHistory($q = '')
    {
        if ($q) {
            $qHistory = $this->get($this->getDictHistoryKey());
            $newCookie = sprintf('%s|%s', $qHistory, $q);
            $this->set($this->getDictHistoryKey(), $newCookie);
        }
    }

    public function parseDictHistory()
    {
        $qHistory = $this->get($this->getDictHistoryKey());

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