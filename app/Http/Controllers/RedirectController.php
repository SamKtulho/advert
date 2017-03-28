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
        $id = $params['aff_sub1'];
        $advert = Advert::find($id);
        unset($params['aff_sub1']);

        if (!$advert) {
            return redirect(Affiliate::getDefaultRedirectUrl());
        }

        if (!empty($advert->status) && $advert->status == 1) {
            $url = $advert->url . '?' . urldecode(http_build_query(Affiliate::getRequiredParams()));

            return redirect(Affiliate::DEFAULT_LAZADA_URI . '/' . Affiliate::DEFAULT_LAZADA_CODE . '?url=' . urlencode($url) . '&aff_sub=' . $id . (!empty($params['utm_campaign']) ? '&aff_sub2=' . $params['utm_campaign'] : '') . '&' . http_build_query($params));
        }
        return Response::make('', 200);
    }
}
