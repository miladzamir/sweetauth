<?php


namespace MiladZamir\SweetAuth;


class Helper
{
    private $url;

    public static function getLastUrl()
    {
        $url = explode('/', url()->previous());
        return end($url);
    }
}
