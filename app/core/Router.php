<?php

namespace MeDesign\core;

class Router
{
    public static function getControls() : array 
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];    

        $url = $url[0] === '/' ? substr($url, 1) : $url;
        $url = $url[-1] === '/' ? substr($url, 0, -1) : $url;
        $url = explode('/', $url);
        $url = $url[0] !== '' ? $url : [];

        return [
            'controller' => $url[0] ?? 'main',
            'action' => $url[1] ?? 'index',
            'other' => implode('/', array_splice($url, 2)) ?? null,
        ];
    }

}
