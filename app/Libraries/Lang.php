<?php
namespace App\Libraries;

use App\Models\Language;

class Lang {
    /**
     * Get list language in database
     * 
     * @return \Collection
     */
    public function list_lang() {
        return Language::get();
    }

    /**
     * Check if language is exists in database
     * 
     * @param string $locale
     * @return bool
     */
    public function check_exists($locale) {
        $list = Language::get();
        foreach($list as $key=>$lang) {
            if ($lang->short_name == $locale)
                return 1;
        }
        return 0;
    }

    /**
     * Get list language short name
     * 
     * @return \String
     */
    public function get_locale() {
        $list = Language::get();
        $locale = '';
        foreach($list as $key=>$lang) {
            $locale .= $lang->short_name.'|';
        }
        return $locale;
    }
}
