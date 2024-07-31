<?php

use \Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(ComponentRegistrar::THEME,
    'frontend/RenanDomingues/centralgospel'
    , __DIR__
);

if( ! function_exists('limit_text')) {
    function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos   = array_keys($words);
            $text  = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

if(! function_exists('fix_html')) {
    function fix_html($html) {
        $doc = new DOMDocument();
        $doc->substituteEntities = false;
        $content = mb_convert_encoding($html, 'html-entities', 'utf-8');
        @$doc->loadHTML($content);
        return $doc->saveHTML();
    }
}