<?php

if (!function_exists('config')) {
    function config($key, $fallback = null)
    {
        static $config;

        if (is_null($config)) $config = include 'configs.php';

        return array_key_exists($key, $config) ? $config[$key] : $fallback;
    }
}
