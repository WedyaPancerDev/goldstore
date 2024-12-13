<?php

namespace App\Helpers;

use DateTime;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class Text
{
    public static function removeSpecialChars($string)
    {
        $string = str_replace(' ', '_', $string);
        return preg_replace('/[^A-Za-z0-9_.]/', '', $string);
    }

    public static function formatPhoneNumber($phoneNumber)
    {
        if (Str::startsWith($phoneNumber, '08')) {
            return '628' . substr($phoneNumber, 2);
        }

        return $phoneNumber;
    }

    public static function encryptString($string)
    {
        return Crypt::encrypt($string);
    }

    public static function generateCode($model, $prefix, $length, $field)
    {
        $lastData = $model::orderBy('id', 'desc')->first();
        if (!$lastData) {
            return $prefix . str_pad(1, $length, '0', STR_PAD_LEFT);
        }

        $lastCode = $lastData->$field;
        $lastNumber = substr($lastCode, strlen($prefix));
        $nextNumber = $lastNumber + 1;

        return $prefix . str_pad($nextNumber, $length, '0', STR_PAD_LEFT);
    }

    public static function decryptString($string)
    {
        return Crypt::decrypt($string);
    }

    public static function formatToRupiah($number)
    {
        return 'Rp. ' . number_format($number, 0, ',', '.');
    }

    public static function formatToRupiahClean($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
