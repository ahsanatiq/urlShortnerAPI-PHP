<?php
namespace App\Transformers;

use App\Url;
use League\Fractal\TransformerAbstract;

class UrlTransformer extends TransformerAbstract
{
    public function transform(Url $url)
    {
        return [
            'desktop_url' => $url->desktop_url,
            'desktop_counter' => $url->desktop_counter,
            'mobile_url' => $url->mobile_url,
            'mobile_counter' => $url->mobile_counter,
            'tablet_url' => $url->tablet_url,
            'tablet_counter' => $url->tablet_counter,
            'created' => $url->created_at->diffForHumans(),
        ];
    }
}