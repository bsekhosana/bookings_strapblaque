<?php

namespace App\Helpers;

class Str
{
    /**
     * Generate a random string.
     */
    public static function random(int $length = 60, bool $include_capitals = true, bool $include_numbers = true, bool $readable_only = false): string
    {
        $characters = '';

        do {
            $characters .= \Str::random($length > 50 ? ($length * 2) : ($length * 6));

            if (! $include_numbers) {
                $characters = preg_replace('/[0-9]/', '', $characters);
            }

            if (! $include_capitals) {
                $characters = strtolower($characters);
            }

            if ($readable_only) {
                $characters = preg_replace('/[01ijlnouBINOU]/', '', $characters);
            }
        } while (strlen($characters) < $length);

        return substr($characters, 0, $length);
    }

    /**
     * Random color hex code.
     */
    public static function randomColor(bool $with_hash = false): string
    {
        $hex = '';

        do {
            $hex .= str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
        } while (strlen($hex) < 6);

        return $with_hash ? sprintf('#%s', $hex) : $hex;
    }

    /**
     * Truncate a string for excerpts/blurbs.
     *
     * @param  int  $length
     */
    public static function truncateString(?string $string, $length = 10): ?string
    {
        if (empty($string)) {
            return null;
        }

        if (strlen($string) > $length) {
            return rtrim(substr($string, 0, $length)).'...';
        }

        return $string;
    }

    /**
     * Truncate words for excerpts/blurbs.
     *
     * @param  int  $count
     */
    public static function truncateWords(?string $words, $count = 10): ?string
    {
        if (empty($words)) {
            return null;
        }

        $word_parts = explode(' ', $words);

        if (count($word_parts) < $count) {
            return $words;
        }

        return implode(' ', array_slice($word_parts, 0, $count)).'...';
    }

    /**
     * Truncate number and append string. Eg. 1.23M followers.
     */
    public static function truncateNumber(int $number, ?string $plural = null): string
    {
        if (! $plural) {
            if ($number >= 1000000) {
                return sprintf('%.1fM', $number / 1000000);
            } elseif ($number >= 1000) {
                return sprintf('%.1fK', $number / 1000);
            }

            return (string) $number;
        }

        $word = $number == 1 ? \Str::singular($plural) : $plural;

        if ($number >= 1000000) {
            return sprintf('%.1fM %s', $number / 1000000, $word);
        } elseif ($number >= 1000) {
            return sprintf('%.1fK %s', $number / 1000, $word);
        }

        return sprintf('%d %s', $number, $word);
    }

    /**
     * Convert to human-readable size.
     */
    public static function fileSize(int $bytes = 0): string
    {
        if ($bytes >= 1000000000000) {
            return sprintf('%.2f TB', ($bytes / 1000000000000));
        } elseif ($bytes >= 1000000000) {
            return sprintf('%.2f GB', ($bytes / 1000000000));
        } elseif ($bytes >= 1000000) {
            return sprintf('%.2f MB', ($bytes / 1000000));
        } elseif ($bytes >= 1000) {
            return sprintf('%d KB', ($bytes / 1000));
        } else {
            return sprintf('%d B', $bytes);
        }
    }

    /**
     * Red/green bullet icon. (FontAwesome & Bootstrap dependant).
     */
    public static function iconForBool(bool $bool, bool $marks = true): string
    {
        if ($marks) {
            return $bool ? '<i class="fas fa-fw fa-circle-check text-success"></i>' : '<i class="fas fa-fw fa-circle-xmark text-danger"></i>';
        }

        return sprintf('<i class="fas fa-fw fa-circle text-%s"></i>', $bool ? 'success' : 'danger');
    }

    /**
     * Create a blurb from given string.
     */
    public static function blurb(?string $string, int $limit = 255, ?string $suffix = '...'): ?string
    {
        if (empty($string)) {
            return null;
        }

        $string = \Str::squish($string);

        if ($suffix && strlen($string) > $limit) {
            $suffix_len = strlen($suffix);

            if (substr($string, ($suffix_len * -1), $suffix_len) === $suffix) {
                return self::clean($string, $limit, true);
            } else {
                return self::clean($string, ($limit - $suffix_len), true).$suffix;
            }
        }

        return self::clean($string, $limit, true);
    }

    public static function clean(?string $string, int $limit = -1, bool $strip_tags = false, ?string $allowed_tags = null, bool $html_decode = false): ?string
    {
        $string = \Str::squish($string);

        if (empty($string)) {
            return null;
        }

        if ($strip_tags) {
            $string = strip_tags($string, $allowed_tags);
        }

        $string = self::replaceSpecialChars($string);

        if ($html_decode) {
            $string = htmlspecialchars_decode($string);
            $string = self::replaceHtmlSpecialChars($string);
        }

        //$string = \voku\helper\ASCII::normalize_msword($string); // Doesn't seem to do anything :/
        //$string = \voku\helper\ASCII::to_ascii($string);

        $string = self::replaceSingleWithDoubleQuotes($string);

        if ($limit > 0) {
            $string = substr($string, 0, $limit);
        }

        return strlen($string) ? \Str::squish($string) : null;
    }

    /**
     * Replace HTML special characters with normal characters.
     */
    public static function replaceHtmlSpecialChars(?string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        return \Str::swap([
            '&quot;'   => '"',
            '&ldquo;'  => '"',
            '&rdquo;'  => '"',
            '&lsquo;'  => "'",
            '&rsquo;'  => "'",
            '&apos;'   => "'",
            '&ndash;'  => '-',
            '&mdash;'  => '-',
            '&hellip;' => '...',
            '&deg;'    => '°',
            '&euro;'   => '€',
            '&aacute;' => 'á',
            '&auml;'   => 'ä',
            '&eacute;' => 'é',
            '&ecirc;'  => 'ê',
            '&euml;'   => 'ë',
            '&Ecirc;'  => 'Ê',
            '&iacute;' => 'í',
            '&iuml;'   => 'ï',
            '&Icirc;'  => 'Î',
            '&oacute;' => 'ó',
            '&ouml;'   => 'ö',
            '&ocirc;'  => 'ô',
            '&ucirc;'  => 'û',
            '&uuml;'   => 'ü',
            '&Uuml;'   => 'Ü',
            '&yacute;' => 'ý',
        ], $string);
    }

    /**
     * Replace smart quotes and apostrophes etc.
     * (Microsoft characters or/and ASCII).
     */
    public static function replaceSpecialChars(?string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        return \Str::swap([
            // Windows codepage 1252
            "\xC2\x82"     => "'", // U+0082⇒U+201A [‚] single low-9 quotation mark
            "\xC2\x84"     => '"', // U+0084⇒U+201E [„] double low-9 quotation mark
            "\xC2\x91"     => "'", // U+0091⇒U+2018 [‘] left single quotation mark
            "\xC2\x92"     => "'", // U+0092⇒U+2019 [’] right single quotation mark
            "\xC2\x93"     => '"', // U+0093⇒U+201C [“] left double quotation mark
            "\xC2\x94"     => '"', // U+0094⇒U+201D [”] right double quotation mark
            "\xC2\x8B"     => '<', // U+008B⇒U+2039 [‹] single left-pointing angle quotation mark
            "\xC2\x9B"     => '>', // U+009B⇒U+203A [›] single right-pointing angle quotation mark

            // Regular Unicode
            "\xE2\x80\x98" => "'", // U+2018 [‘] left single quotation mark
            "\xE2\x80\x99" => "'", // U+2019 [’] right single quotation mark
            "\xE2\x80\x9A" => "'", // U+201A [‚] single low-9 quotation mark
            "\xE2\x80\x9B" => "'", // U+201B [‛] single high-reversed-9 quotation mark
            "\xE2\x80\x9C" => '"', // U+201C [“] left double quotation mark
            "\xE2\x80\x9D" => '"', // U+201D [”] right double quotation mark
            "\xE2\x80\x9E" => '"', // U+201E [„] double low-9 quotation mark
            "\xE2\x80\x9F" => '"', // U+201F [‟] double high-reversed-9 quotation mark
            "\xE2\x80\xB9" => '<', // U+2039 [‹] single left-pointing angle quotation mark
            "\xE2\x80\xBA" => '>', // U+203A [›] single right-pointing angle quotation mark
            "\xC2\xAB"     => '<<', // U+00AB [«] left-pointing double angle quotation mark
            "\xC2\xBB"     => '>>', // U+00BB [»] right-pointing double angle quotation mark

            // Apostrophes & quotation marks
            "\xE2\x80\xB2" => "'", // U+2032 [′] single right-pointing angle apostrophe
            "\xE2\x80\xB3" => '"', // U+2033 [″] double right-pointing angle apostrophe
            "\xE2\x80\xB4" => '"', // U+2034 [‴] triple right-pointing angle apostrophe
            "\xE2\x80\xB5" => "'", // U+2035 [‵] single left-pointing angle apostrophe
            "\xE2\x80\xB6" => '"', // U+2036 [‶] double left-pointing angle apostrophe
            "\xE2\x80\xB7" => '"', // U+2037 [‷] triple left-pointing angle apostrophe

            // Strings
            '&#x27;'       => "'",
            '&#38;'        => '&',
            '&#038;'       => '&',
            '&#039;'       => "'",
            '&#124;'       => '|',
            '&#160;'       => ' ',
            '&#234;'       => 'ê',
            '&#235;'       => 'ë',
            '&#252;'       => 'ü',
            '&#329;'       => "'n",
            '&#8203;'      => '', // Zero-width space
            '&#8209;'      => '-',
            '&#8210;'      => '-',
            '&#8211;'      => '-',
            '&#8212;'      => '-',
            '&#8213;'      => '-',
            '&#8216;'      => "'",
            '&#8217;'      => "'",
            '&#8220;'      => '"',
            '&#8221;'      => '"',
            '&#8227;'      => '-',
            '&#8228;'      => '.',
            '&#8229;'      => '..',
            '&#8230;'      => '...',
            '&#8232;'      => "\n",
            '&#'           => '',
            '’'            => "'",
            '‘'            => "'",
        ], $string);
    }

    public static function replaceSingleWithDoubleQuotes(?string $string): ?string
    {
        if (empty($string)) {
            return null;
        }

        if (\Str::contains($string, "'")) {
            // Temporarily change this to avoid 'n being mistaken for a quote
            $string = str_replace(" 'n ", ' ]}n{[ ', $string);

            if (\Str::containsAll($string, [" '", "' "])) {
                $string = str_replace([" '", "' "], [' "', '" '], $string);
            }

            if (\Str::startsWith($string, "'") && \Str::endsWith($string, "'")) {
                $string = \Str::replaceFirst("'", '"', $string);
                $string = \Str::replaceLast("'", '"', $string);
            }

            if (\Str::startsWith($string, "'") && \Str::contains($string, "' ")) {
                $string = \Str::replaceFirst("'", '"', $string);
                $string = \Str::replaceFirst("' ", '" ', $string);
            }

            if (\Str::endsWith($string, "'") && \Str::contains($string, " '")) {
                $string = \Str::replaceLast(" '", ' "', $string);
                $string = \Str::replaceLast("'", '"', $string);
            }

            if (\Str::endsWith($string, "'") && ! \Str::startsWith($string, "'")) {
                $string = \Str::replaceLast("'", '"', $string);
            }

            if (! \Str::endsWith($string, "'") && \Str::startsWith($string, "'")) {
                $string = \Str::replaceFirst("'", '"', $string);
            }

            if (\Str::startsWith($string, '"n ')) {
                $string = \Str::replaceFirst('"n ', "'n ", $string);
            }

            // Bring back the temporary named 'n
            $string = str_replace(' ]}n{[ ', " 'n ", $string);
        }

        return $string;
    }
}
