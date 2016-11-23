<?php
/**
 * Created by PhpStorm.
 * User: Nhut Tran
 * Date: 10/22/2015 1:07 PM
 */

namespace App\Helpers;


use App;
use Cache;
use Storage;

class Meta
{
    public static $params = [
        'name' => ['keywords', 'description'],
        'property' => ['og:site_name', 'og:type', 'og:title', 'og:image', 'og:description', 'og:url'],
    ];
    public function addMeta($aliasUrl)
    {
        if (!empty($aliasUrl)) {
            $metaHtml = $this->defaultMeta();
            $data = trans("meta.$aliasUrl");
            if(!empty($data) && is_array($data)) {
                $metaParse = Cache::remember('meta_'.$aliasUrl, 30, function() use ($data) {
                    return $this->parseMeta($data);
                });
                $metaHtml .= $metaParse;
            }else{
                $data = trans("meta.*");
                $metaParse = Cache::remember('meta_'.$aliasUrl, 30, function() use ($data) {
                    return $this->parseMeta($data);
                });
                $metaHtml .= $metaParse;
            }
            return $metaHtml;
        }
        return null;
    }

    private function defaultMeta(){
        $metaHtml = '<meta name="robots" content="index,follow" />'. PHP_EOL;
        $metaHtml .= '<meta name="copyright" content="©2016 MetVuong.com" />'. PHP_EOL;
        return $metaHtml;
    }

    private function parseMeta($data)
    {
        $metaHtml = '';
        if(!empty($data) && is_array($data)) {
            foreach ($data as $key => $item) {
                if (!empty($item)) {
                    $name = 'property';
                    if (in_array($key, Meta::$params['name'])) {
                        $name = 'name';
                    }
                    $metaHtml .= '<meta ' . $name . '="' . $key . '" content="' . $item . '" />' . PHP_EOL;
                }
            }
        }
        return $metaHtml;
    }

}