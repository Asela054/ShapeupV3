<?php
namespace App\Helpers;

class NumberToWords {
    public static function convert(int $number): string {
        if ($number === 0) return 'zero';
        
        $ones = ['','one','two','three','four','five','six','seven','eight','nine',
                 'ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen',
                 'seventeen','eighteen','nineteen'];
        $tens = ['','','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety'];
        
        if ($number < 20) return $ones[$number];
        if ($number < 100) return $tens[intval($number/10)] . ($number % 10 ? ' ' . $ones[$number % 10] : '');
        if ($number < 1000) return $ones[intval($number/100)] . ' hundred' . ($number % 100 ? ' ' . self::convert($number % 100) : '');
        if ($number < 100000) return self::convert(intval($number/1000)) . ' thousand' . ($number % 1000 ? ' ' . self::convert($number % 1000) : '');
        if ($number < 10000000) return self::convert(intval($number/100000)) . ' lakh' . ($number % 100000 ? ' ' . self::convert($number % 100000) : '');
        return self::convert(intval($number/10000000)) . ' crore' . ($number % 10000000 ? ' ' . self::convert($number % 10000000) : '');
    }
}