<?php

namespace Hemengeliriz\ParamposLaravel;

class Card extends BaseType
{
    /**
     * Kredi Kartı Sahibi
     * @param $cardOwner
     */
    public function setCardOwner($cardOwner)
    {
        $this->setProperty(Parameter::KK_Sahibi, $cardOwner);
    }

    /**
     * Kredi Kartı numarası
     * @param $cardNumber
     */
    public function setCardNumber($cardNumber)
    {
        $this->setProperty(Parameter::KK_No, $cardNumber);
    }

    /**
     * 2 hane Son Kullanma Ayı
     * 4 haneli Son Kullanma Yıl
     * @param null $cardExpireMonth
     * @param null $cardExpireYear
     */
    public function setCardExpireDate($cardExpireMonth = null, $cardExpireYear = null)
    {
        $this->setProperty(Parameter::KK_SK_Ay, $cardExpireMonth);
        $this->setProperty(Parameter::KK_SK_Yil, $cardExpireYear);
    }

    /**
     * CVC Kodu
     * @param $cardCvc
     */
    public function setCardCvc($cardCvc)
    {
        $this->setProperty(Parameter::KK_CVC, $cardCvc);
    }

    /**
     * Kredi Kartı Sahibi GSM No, Başında 0 olmadan (5xxxxxxxxx)
     * @param $cardOwnerPhone
     */
    public function setCardOwnerPhone($cardOwnerPhone)
    {
        $this->setProperty(Parameter::KK_Sahibi_GSM, $cardOwnerPhone);
    }

    public function saveCard($name = "")
    {
        $baseUrl = (config('parampos-laravel.test_mode', false) ? Payment::TEST_SAVE_CARD_BASE_URL : Payment::PROD_SAVE_CARD_BASE_URL);
        $this->addProperties((new Auth())->getProperties());
        $this->setProperty(Parameter::KK_Kart_Adi, $name);
        $template = XmlTemplate::generateTemplate(XmlTemplate::SAVE_CARD, $this->getProperties());

        return (new Request())->sendRequest($baseUrl, $template, 'KS_Kart_Ekle');
    }
}
