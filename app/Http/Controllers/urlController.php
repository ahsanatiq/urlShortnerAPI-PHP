<?php

namespace App\Http\Controllers;

use App\Transformers\UrlTransformer;
use App\Url;
use DB;
use Detection\MobileDetect;
use Hashids\Hashids;
use Illuminate\Http\Request;

class urlController extends Controller
{

    public function index()
    {
        $urls = Url::all();
        if (count($urls)) {
            return fractal($urls, new UrlTransformer())->toArray();
        }
        return ['message' => 'no urls found'];
    }

    public function redirectToTarget($hashId, Hashids $hashids, MobileDetect $mobileDetect, Request $request)
    {
        $id = $hashids->decode($hashId);
        if ($id) {
            $url = Url::findOrFail($id[0]);
            $mobileDetect->setUserAgent($request->header('user-agent'));
            if ($mobileDetect->isMobile() && !$mobileDetect->isTablet() && $url->mobile_url) {
                $url->increment('mobile_counter');
                return redirect($url->mobile_url);
            }
            if ($mobileDetect->isTablet() && $url->tablet_url) {
                $url->increment('tablet_counter');
                return redirect($url->tablet_url);
            }
            $url->increment('desktop_counter');
            return redirect($url->desktop_url);
        }
        return response()->json(['message' => 'invalid short url'], 400);
    }

    public function create(Request $request, Hashids $hashIds)
    {
        $this->validate($request, Url::rules());
        $newUrl = Url::create($request->all());
        return ['short_url' => url(env('APP_URL','localhost').'/'.$hashIds->encode($newUrl->id))];
    }

    public function update($hashId, Request $request, Hashids $hashids)
    {
        $this->validate($request, Url::rules('update'));
        $id = $hashids->decode($hashId);
        if ($id) {
            $url = Url::findOrFail($id[0]);
            $url->update($request->all());
            return fractal($url, new UrlTransformer())->toArray();
        }

        return response()->json(['message' => 'invalid short url'], 400);
    }

}
