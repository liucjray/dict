<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TranslateShellService
{
    public function send(array $req)
    {
        $cReq = collect($req);
        if ($cReq->has('q') && $cReq->get('l')) {
            return $this->callApi($cReq);
        }
        return '';
    }

    public function callApi(Collection $cReq)
    {
        $cmd = sprintf('trans :%s "%s"', $cReq->get('l'), $cReq->get('q'));
        $output = shell_exec($cmd);
        $output = preg_replace('/\\e\[(\d)*m/', '', $output);
        $output = nl2br($output);
        return $output;
    }

    public function getLanguage()
    {
        return [
            'zh-TW' => '正體中文 (Chinese)',
            'ja' => '日本語 (Japanese)',
            'ko' => '한국어 (Korean)',
            'en' => 'English',
        ];
    }

    public function getDefaultLanguageKey()
    {
        return 'zh-TW';
    }
}