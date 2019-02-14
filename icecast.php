<?php
/**
 * @author Tommy A. Surbakti <tommy@surbakti.net>
* */
namespace Surbakti;

class IceCast
{
    public $server = '';
    public $status = [];

    public function setUrl($url)
    {
        $this->server = $url;
    }

    private function fungsiCurl()
    {
        $data = curl_init();
        curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($data, CURLOPT_URL, $this->server.'/status-json.xsl');
        curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Fedora; Linux x86_64; rv:65.0) Gecko/20100101 Firefox/65.0");
        $hasil = curl_exec($data);
        curl_close($data);
        return $hasil;
    }

    public function cekStatus()
    {
        if (! $this->fungsiCurl()) {
            die("Server $this->server Down! ");
        }
    }

    public function getStatus()
    {
        $dataRadio = [];
        $this->cekStatus();
        $hasil = $this->fungsiCurl();
        $fileNa = json_decode($hasil, true);

        foreach ($fileNa as $key => $value) {
            if (! $value['source']) {
                die("Mount Point not found!");
            }
            foreach ($value['source'] as $key => $value) {
                $dataRadio[$key] = $value;
            }
            $this->status['bitrate'] = $dataRadio['bitrate'];
            $this->status['server_url'] = $dataRadio['server_url'];
            $this->status['title'] = $dataRadio['title'];
            $this->status['stream_start'] = $dataRadio['stream_start'];
            $this->status['server_name'] = $dataRadio['server_name'];
            $this->status['server_description'] = $dataRadio['server_description'];
            $this->status['listenurl'] = $dataRadio['listenurl'];
            $this->status['listeners'] = $dataRadio['listeners'];
            $this->status['listener_peak'] = $dataRadio['listener_peak'];
        }
        return $this->status;
    }
}
