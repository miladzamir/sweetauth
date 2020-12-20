<?php


namespace MiladZamir\SweetAuth;


class Helper
{
    private $url;

    public static function getLastUrl($full = null)
    {
        if ($full != null)
            return explode('/', url()->previous());

        $url = explode('/', url()->previous());
        return end($url);
    }

    public static function getLastNowUrl($request)
    {
        $url = explode('/', $request->url());
        return end($url);
    }

    public static function getCurrentUrl()
    {
        return explode('/', url()->current());
    }

    public static function checkSession($session1, $session2)
    {
        if (session()->has($session1))
            return $session1;
        elseif (session()->has($session2))
            return $session2;
        else
            return false;

    }
}
