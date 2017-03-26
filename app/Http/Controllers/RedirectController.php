<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Affiliate;
use App\Advert;
use Illuminate\Support\Facades\Response;

class RedirectController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();

        if (empty($params['aff_sub1'])) {
            return redirect(Affiliate::getDefaultRedirectUrl());
        }

        $advert = Advert::find($params['aff_sub1']);
       // unset($params['aff_sub1']);

        if (!$advert) {
            return redirect(Affiliate::getDefaultRedirectUrl());
        }

        if (!empty($advert->status) && $advert->status == 1) {
            $url = $advert->url . '?' . http_build_query($params);

            return redirect(Affiliate::DEFAULT_LAZADA_URI . '/' . Affiliate::DEFAULT_LAZADA_CODE . '?url=' . urlencode($url));
        }
        return Response::make('', 200);
    }
}
