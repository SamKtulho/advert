<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 26/03/2017
 * Time: 16:12
 */

namespace App\Services;

class Affiliate {

    const DEFAULT_LAZADA_URI = 'http://ho.lazada.vn';
    const DEFAULT_LAZADA_CODE = 'SHNXqB';

    public static function getDefaultRedirectUrl()
    {
        return self::DEFAULT_LAZADA_URI . '/' . self::DEFAULT_LAZADA_CODE . '?url=' . urlencode('http://lazada.vn');
    }
}