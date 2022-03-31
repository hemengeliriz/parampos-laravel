<?php

namespace Hemengeliriz\ParamposLaravel;

use Illuminate\Support\Str;

class Request
{
    public function sendRequest($baseUrl, $xml, $extraRequestMethod = null)
    {
        $baseUrl = $baseUrl . ($extraRequestMethod ? "&op=" . $extraRequestMethod : "");

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $baseUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $xml,
            CURLOPT_HTTPHEADER => [
                'Content-type: text/xml',
            ],
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        $methodName = Str::camel("parse" . $extraRequestMethod . "Response");
        if (method_exists($this, $methodName)) {
            $result = $this->$methodName($result);
        }

        return $result;
    }

    private function parseSHA2B64Response($response)
    {
        preg_match("'<SHA2B64Result>(.*?)</SHA2B64Result>'si", $response, $match);

        return $match[1];
    }

    private function parsePosOdemeResponse($response)
    {
        $res = [];
        preg_match("'<Islem_ID>(.*?)</Islem_ID>'si", $response, $match);
        $res['Islem_ID'] = $match[1];
        preg_match("'<UCD_URL>(.*?)</UCD_URL>'si", $response, $match);
        $res['UCD_URL'] = $match[1];
        preg_match("'<Sonuc>(.*?)</Sonuc>'si", $response, $match);
        $res['Sonuc'] = $match[1];
        preg_match("'<Sonuc_Str>(.*?)</Sonuc_Str>'si", $response, $match);
        $res['Sonuc_Str'] = $match[1];
        preg_match("'<Banka_Sonuc_Kod>(.*?)</Banka_Sonuc_Kod>'si", $response, $match);
        $res['Banka_Sonuc_Kod'] = $match[1];

        return $res;
    }
}
