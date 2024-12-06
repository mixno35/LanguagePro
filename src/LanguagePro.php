<?php

namespace LanguagePro;

/**
 * Class LanguagePro
 *
 * Handles language settings, translations loading, and language-related operations.
 */
class LanguagePro
{

    /**
     * @var string|null Current language tag (e.g., 'en', 'fr').
     */
    protected $languageCurrentTag;

    /**
     * @var string|null Default language tag (e.g., 'en').
     */
    protected $languageDefaultTag;

    /**
     * @var string|null Path to the directory containing language JSON files.
     */
    protected $pathLanguages;

    /**
     * @var array|null Loaded translations.
     */
    protected $translations;

    /**
     * Creates a new instance of the LanguagePro class.
     *
     * @return self
     */
    public static function factory(): self
    {
        return new static();
    }

    /**
     * Sets the current language tag.
     *
     * @param string $tag Language tag (e.g., 'en', 'fr').
     * @return $this
     */
    public function setCurrentLanguage(string $tag): self
    {
        $this->languageCurrentTag = mb_strtolower(substr($tag, 0, 2), "UTF-8");
        return $this;
    }

    /**
     * Gets the current language tag.
     *
     * @return string Current language tag, or the default language if not set.
     */
    public function getCurrentLanguage(): string
    {
        return $this->languageCurrentTag ?? $this->getDefaultLanguage();
    }

    /**
     * Sets the default language tag.
     *
     * @param string $tag Language tag (e.g., 'en', 'fr').
     * @return $this
     */
    public function setDefaultLanguage(string $tag): self
    {
        $this->languageDefaultTag = mb_strtolower(substr($tag, 0, 2), "UTF-8");
        return $this;
    }

    /**
     * Gets the default language tag.
     *
     * @return string Default language tag, or 'en' if not set.
     */
    public function getDefaultLanguage(): string
    {
        return $this->languageDefaultTag ?? "en";
    }

    /**
     * Sets the path to the directory containing language JSON files.
     *
     * @param string $path Directory path.
     * @return $this
     */
    public function setPathLanguages(string $path): self
    {
        $this->pathLanguages = $path;
        return $this;
    }

    /**
     * Gets the path to the directory containing language JSON files.
     *
     * @return string Directory path.
     */
    public function getPathLanguages(): string
    {
        return $this->pathLanguages;
    }

    /**
     * Builds the translations by loading the default and current language files.
     *
     * @return $this
     */
    public function build(): self
    {
        $this->translations = $this->loadLanguage($this->getDefaultLanguage());
        if (empty($this->translations)) {
            error_log("Language default is empty: {$this->getDefaultLanguage()}");
        }

        if (strcmp($this->getCurrentLanguage(), $this->getDefaultLanguage()) !== 0) {
            $languageClientArray = $this->loadLanguage($this->getCurrentLanguage());

            if (empty($languageClientArray)) {
                error_log("Language client is empty: {$this->getCurrentLanguage()}");
            } else {
                $this->translations = array_merge($this->translations, $languageClientArray);
            }

            unset($languageClientArray);
        }

        return $this;
    }

    /**
     * Gets the loaded translations.
     *
     * @return array Translations array.
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * Loads the language file for a specific tag.
     *
     * @param string $tag Language tag (e.g., 'en', 'fr').
     * @return array Translations array from the language file.
     */
    private function loadLanguage(string $tag): array
    {
        $filePath = sprintf("%s/%s.json", $this->getPathLanguages(), $tag);

        if (!file_exists($filePath) || !is_file($filePath)) {
            error_log(sprintf("Language file not found: %s", basename($filePath)));
            return [];
        }

        $json = file_get_contents($filePath, true);
        if ($json === false) {
            error_log(sprintf("Error reading language file: %s", basename($filePath)));
            return [];
        }

        $array = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log(sprintf("JSON decode error in language file: %s", basename($filePath)));
            return [];
        }

        return $array;
    }
}