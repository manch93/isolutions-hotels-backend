<?php

namespace Database\Seeders;

use App\Models\M3uSource;
use App\Models\M3uChannel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class M3USeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $source = M3uSource::create([
            'name' => 'Cable Net',
            'url' => 'http://xcust.cablenet.asia/get.php?username=dammpsca&password=c1r3b0rnca&type=m3u&output=mpegts',
            'type' => 'GET',
            'active' => 1,
        ]);

        // Call Api
        $ch = curl_init();
        $url = $source->url;
        $type = $source->type;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);

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
                $result[$index]['name'] = str_replace(',', '', $item);
            } elseif (!empty($match['url'][$i])) {
                $result[$index]['url'] = $item;
            }
        }

        // Save to database
        foreach ($result as $item) {
            M3uChannel::updateOrCreate([
                'm3u_source_id' => $source->id,
                'name' => $item['name'],
            ], [
                'url' => $item['url'],
                'active' => 1,
            ]);
        }
    }
}
