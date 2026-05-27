<?php

if (!function_exists('custom_merge_recursive')) {
    function custom_merge_recursive(array $array1, array $array2) {
        $merged = $array1;

        foreach ($array2 as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = custom_merge_recursive($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    function sanitizeFileName($fileName)
    {
        // Remove any characters that are not alphanumeric, dashes, underscores, or dots
        return preg_replace('/[^A-Za-z0-9\-\_\.]/', '_', $fileName);
    }
}

if (!function_exists('format_currency_br')) {
    function format_currency_br($value)
    {
        if ($value){
            return 'R$ ' . number_format($value, 2, ',', '.');
        }
    }
}

if (!function_exists('formata_texto_opus')){
    function formata_texto_opus($text)
    {
        $text = preg_replace('/[\x00-\x1F\x7F-\x9F]/u', ' ', $text);
        
        // Remove acentos mantendo UTF-8
        $text = mb_ereg_replace("([àáâãäå])", 'a', $text);
        $text = mb_ereg_replace("([èéêë])", 'e', $text);
        $text = mb_ereg_replace("([ìíîï])", 'i', $text);
        $text = mb_ereg_replace("([òóôõö])", 'o', $text);
        $text = mb_ereg_replace("([ùúûü])", 'u', $text);
        $text = mb_ereg_replace("([ç])", 'c', $text);
        $text = mb_ereg_replace("([ñ])", 'n', $text);
        
        // Maiúsculas
        $text = mb_ereg_replace("([ÀÁÂÃÄÅ])", 'A', $text);
        $text = mb_ereg_replace("([ÈÉÊË])", 'E', $text);
        $text = mb_ereg_replace("([ÌÍÎÏ])", 'I', $text);
        $text = mb_ereg_replace("([ÒÓÔÕÖ])", 'O', $text);
        $text = mb_ereg_replace("([ÙÚÛÜ])", 'U', $text);
        $text = mb_ereg_replace("([Ç])", 'C', $text);
        $text = mb_ereg_replace("([Ñ])", 'N', $text);

        $text = mb_ereg_replace("([|])", '-', $text);
        
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}