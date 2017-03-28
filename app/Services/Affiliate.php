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
    const DEFAULT_LAZADA_CODE = 'SHNXhl';

    private static $requiredParams = [
        'offer_id' => '{offer_id}',
        'affiliate_id' => '{affiliate_id}',
        'offer_name' => '{offer_name}_{offer_file_id}',
        'affiliate_name' => '{affiliate_name}',
        'transaction_id' => '{transaction_id}',
        'aff_source' => '{source}'
    ];

    /**
     * @return array
     */
    public static function getRequiredParams()
    {
        return self::$requiredParams;
    }

    public static function getDefaultRedirectUrl()
    {
        return self::DEFAULT_LAZADA_URI . '/' . self::DEFAULT_LAZADA_CODE . '?url=' . urlencode('http://lazada.vn?' . http_build_query(self::$requiredParams));
    }
}