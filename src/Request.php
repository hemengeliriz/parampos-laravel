<?php

namespace Hemengeliriz\ParamposLaravel;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class Request
{
    public function sendRequest($baseUrl, $xml, $extraRequestMethod = null)
    {
          $baseUrl = $baseUrl . ($extraRequestMethod ? "&op=" . $extraRequestMethod : "");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        $response = curl_exec($ch);
        $response = strtr($response, ['</soap:' => '</', '<soap:' => '<']);
        $response = json_decode(json_encode(simplexml_load_string($response)), true)['Body'];
        $methodName = Str::camel("parse" . $extraRequestMethod . "Response");
        if (method_exists($this, $methodName)) {
            $response = $this->$methodName($response);
        }
        return  $response;
    }

    private function parseSHA2B64Response($response)
    {
        return $response['SHA2B64Response']['SHA2B64Result'];
    }

    private function parsePosOdemeResponse($response)
    {
        return $response['Pos_OdemeResponse']['Pos_OdemeResult'];
    }

    private function parseKSKartEkleResponse($response)
    {
        return $response['KS_Kart_EkleResponse']['KS_Kart_EkleResult'];
    }

    private function parseKSTahsilatResponse($response)
    {
        return $response['KS_TahsilatResponse']['KS_TahsilatResult'];
    }
}
