<?php

namespace App\Helpers;

class GreetingHelper
{
    public static function getGreeting()
    {
        $hour = now()->hour;
        $greeting = '';

        if ($hour >= 4 && $hour < 11) {
            $greeting = 'Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $greeting = 'Siang';
        } elseif ($hour >= 15 && $hour < 19) {
            $greeting = 'Sore';
        } else {
            $greeting = 'Malam';
        }

        return "Selamat $greeting";
    }
}
