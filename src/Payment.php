<?php

namespace Hemengeliriz\ParamposLaravel;

class Payment extends BaseType
{
    public const PROD_BASE_URL = 'https://posws.param.com.tr/turkpos.ws/service_turkpos_prod.asmx?wsdl';
    public const TEST_BASE_URL = 'https://test-dmz.param.com.tr:4443/turkpos.ws/service_turkpos_test.asmx?wsdl';

    protected ?Card $card;
    protected ?PaymentDetail $paymentDetail;
    protected ?string $successUrl;
    protected ?string $failureUrl;

    protected ?string $baseUrl;

    public function __construct(Card $card = null, PaymentDetail $paymentDetail = null, $successUrl = null, $failureUrl = null)
    {
        $this->card = $card;
        $this->paymentDetail = $paymentDetail;
        $this->successUrl = $successUrl;
        $this->failureUrl = $failureUrl;

        $this->baseUrl = (config('parampos-laravel.test_mode', false) ? self::TEST_BASE_URL : self::PROD_BASE_URL);

        $this->addProperties((new Auth())->getProperties());
    }

    public function pay()
    {
        $this->addProperties($this->card->getProperties());
        $this->addProperties($this->paymentDetail->getProperties());
        $this->setProperty(Parameter::Basarili_URL, $this->successUrl);
        $this->setProperty(Parameter::Hata_URL, $this->failureUrl);
        $this->setProperty(Parameter::Ref_URL, "https://param.com.tr");
        $this->setProperty(Parameter::Islem_Hash, self::hash());

        $template = XmlTemplate::generateTemplate(XmlTemplate::PAYMENT, $this->getProperties());

        return (new Request())->sendRequest($this->baseUrl, $template, 'Pos_Odeme');
    }

    public function setCard(Card $card)
    {
        $this->card = $card;
    }

    public function setPaymentDetail(PaymentDetail $paymentDetail)
    {
        $this->paymentDetail = $paymentDetail;
    }

    public function setSuccessUrl(string $successUrl)
    {
        $this->successUrl = $successUrl;
    }

    public function setFailureUrl(string $failureUrl)
    {
        $this->failureUrl = $failureUrl;
    }

    private function hash(): string
    {
        $hash = $this->getProperty(Parameter::CLIENT_CODE);
        $hash .= $this->getProperty(Parameter::GUID);
        $hash .= $this->getProperty(Parameter::Taksit);
        $hash .= $this->getProperty(Parameter::Islem_Tutar);
        $hash .= $this->getProperty(Parameter::Toplam_Tutar);
        $hash .= $this->getProperty(Parameter::Siparis_ID);
        $hash .= $this->getProperty(Parameter::Hata_URL);
        $hash .= $this->getProperty(Parameter::Basarili_URL);

        $template = XmlTemplate::generateTemplate(XmlTemplate::HASH, ['Data' => $hash]);

        return (new Request())->sendRequest($this->baseUrl, $template, 'SHA2B64');
    }
}
