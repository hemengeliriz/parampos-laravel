<?php

namespace Hemengeliriz\ParamposLaravel;

class XmlTemplate
{
    public const PAYMENT = 'payment';
    public const KS_PAYMENT = 'ks_payment';
    public const HASH = 'hash';
    public const SAVE_CARD = 'save_card';

    public static function generateTemplate($template, $properties = [])
    {
        $template = file_get_contents(__DIR__ . "/../resources/templates/$template.xml");
        foreach ($properties as $property => $value) {
            $template = str_replace("<$property></$property>", "<$property>$value</$property>", $template);
        }

        return $template;
    }
}
