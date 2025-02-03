<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchTrait
{
    public function insensitiveUnaccentedSearch(Builder $query, string $column, string $search)
    {
        $search = $this->prepareStringToBeSearched($search);
        return $query->whereRaw('LOWER(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE('.$column.', "ã", "a"), "á", "a"), "à", "a"), "â", "a"), "ä", "a"), "é", "e"), "è", "e"), "ê", "e"), "ë", "e"), "í", "i"), "ì", "i"), "î", "i"), "ï", "i"), "ó", "o"), "ò", "o"), "ô", "o"), "ö", "o"), "õ", "o"), "ú", "u"), "ù", "u"), "û", "u"), "ü", "u"), "ç", "c")) LIKE ?', ["%$search%"]);
    }

    public function prepareStringToBeSearched(string $search)
    {
        $acentos = array(
            'A' => '/&Agrave;|&Aacute;|&Acirc;|&Atilde;|&Auml;|&Aring;/',
            'a' => '/&agrave;|&aacute;|&acirc;|&atilde;|&auml;|&aring;/',
            'C' => '/&Ccedil;/',
            'c' => '/&ccedil;/',
            'E' => '/&Egrave;|&Eacute;|&Ecirc;|&Euml;/',
            'e' => '/&egrave;|&eacute;|&ecirc;|&euml;/',
            'I' => '/&Igrave;|&Iacute;|&Icirc;|&Iuml;/',
            'i' => '/&igrave;|&iacute;|&icirc;|&iuml;/',
            'N' => '/&Ntilde;/',
            'n' => '/&ntilde;/',
            'O' => '/&Ograve;|&Oacute;|&Ocirc;|&Otilde;|&Ouml;/',
            'o' => '/&ograve;|&oacute;|&ocirc;|&otilde;|&ouml;/',
            'U' => '/&Ugrave;|&Uacute;|&Ucirc;|&Uuml;/',
            'u' => '/&ugrave;|&uacute;|&ucirc;|&uuml;/',
            'Y' => '/&Yacute;/',
            'y' => '/&yacute;|&yuml;/',
            'a.' => '/&ordf;/',
            'o.' => '/&ordm;/');

        $replaceToNonAccentsChars = preg_replace($acentos, array_keys($acentos), htmlentities($search, ENT_NOQUOTES, 'UTF-8'));
        $toLowerChars = mb_strtolower($replaceToNonAccentsChars, 'utf-8');
        return $toLowerChars;
    }
}
