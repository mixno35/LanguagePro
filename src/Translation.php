<?php

namespace LanguagePro;

use Exception;

/**
 * Class Translation
 *
 * Provides translation functionality using the LanguagePro class.
 */
class Translation
{
    /**
     * @var LanguagePro Instance of LanguagePro for managing language settings and translations.
     */
    private static LanguagePro $languagePro;

    /**
     * @var array Translations array loaded from the language files.
     */
    private static array $translations;

    /**
     * Initializes the Translation class with a LanguagePro instance.
     *
     * @param LanguagePro $model An instance of the LanguagePro class.
     * @return void
     */
    public static function create(LanguagePro $model): void
    {
        self::$languagePro = $model;
        self::$translations = $model->getTranslations();
    }

    /**
     * Retrieves a translated string by key, optionally applying replacements.
     *
     * @param string $key The key for the translation string.
     * @param string|null $fallback Fallback string if the translation key is not found.
     * @param mixed ...$replace Values to replace placeholders in the translation string.
     * @return string The translated string, with replacements applied.
     */
    public static function tr(string $key, string $fallback = null, ...$replace): string
    {
        $textFallback = !empty($fallback) ? $fallback : $key;
        $text = array_key_exists($key, self::$translations) ? self::$translations[$key] : $textFallback;

        try {
            return trim(!empty($replace) ? sprintf($text, ...$replace) : $text);
        } catch (Exception $e) {
            error_log(sprintf("Language script error: %s", $e->getMessage()));
        }

        return $textFallback;
    }

    /**
     * Gets the LanguagePro instance used by the Translation class.
     *
     * @return LanguagePro The LanguagePro instance.
     */
    public static function languagePro(): LanguagePro
    {
        return self::$languagePro;
    }
}