<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TvController extends Controller
{
    public function get() {
        $key = 'tv';
        $result = Cache::get($key);

        if(empty($result)) {
            $result = $this->getFromCableNet();
            Cache::put($key, $result, 3600);
        }

        return $this->respondWithSuccess($result);
    }

    public function getFromCableNet() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://xcust.cablenet.asia/get.php?username=dammpsca&password=c1r3b0rnca&type=m3u&output=mpegts');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        // SSL important
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $output = curl_exec($ch);
        curl_close($ch);

        preg_match_all('/(?P<tag>#EXTINF:-1)|(?:(?P<prop_key>[-a-z]+)=\"(?P<prop_val>[^"]+)")|(?<something>,[^\r\n]+)|(?<url>http[^\s]+)/', $output, $match);

        $count = count($match[0]);
        $result = [];
        $index = -1;

        for ($i = 0; $i < $count; $i++) {
            $item = $match[0][$i];

            if (!empty($match['tag'][$i])) {
                //is a tag increment the result index
                ++$index;
            } elseif (!empty($match['prop_key'][$i])) {
                //is a prop - split item
                $result[$index][$match['prop_key'][$i]] = $match['prop_val'][$i];
            } elseif (!empty($match['something'][$i])) {
                //is a prop - split item
                $result[$index]['channel_name'] = str_replace(',', '', $item);
            } elseif (!empty($match['url'][$i])) {
                $result[$index]['url'] = $item;
            }
        }

        return $result;
    }
}
