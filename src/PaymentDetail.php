<?php

namespace Hemengeliriz\ParamposLaravel;

class PaymentDetail extends BaseType
{
    public function setOrderId($orderId)
    {
        $this->setProperty(Parameter::Siparis_ID, $orderId);
    }

    public function setOrderDescription($orderDescription)
    {
        $this->setProperty(Parameter::Siparis_Aciklama, $orderDescription);
    }

    public function setInstallment($installment)
    {
        $this->setProperty(Parameter::Taksit, $installment);
    }

    public function setOrderAmount(float $amount)
    {
        $this->setProperty(Parameter::Islem_Tutar, number_format($amount, 2, ',', '.'));
    }

    public function setTotalAmount(float $amount)
    {
        $this->setProperty(Parameter::Toplam_Tutar, number_format($amount, 2, ',', '.'));
    }

    public function setIpAddress($ipAddress)
    {
        $this->setProperty(Parameter::IPAdr, $ipAddress);
    }

    public function set3DMode($is3D = false)
    {
        $this->setProperty(Parameter::Islem_Guvenlik_Tip, ($is3D ? '3D' : 'NS'));
    }
}
