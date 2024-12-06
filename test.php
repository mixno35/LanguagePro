<?php

use LanguagePro\LanguagePro;
use LanguagePro\Translation;

require "vendor/autoload.php";

// Initialize the Translation class using the LanguagePro factory.
// 1. Create a LanguagePro instance using the factory method.
// 2. Set the path to the directory containing the language JSON files.
// 3. Set the current language based on the HTTP_ACCEPT_LANGUAGE header.
// 4. Set the default language to English ("en").
// 5. Build the translations by loading language files.
Translation::create(LanguagePro::factory()
    ->setPathLanguages(__DIR__ . "/example") // Path to language JSON files.
    ->setCurrentLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]) // Current language detected from the browser.
    ->setDefaultLanguage("en") // Default language set to English.
    ->build()); // Build the translations by loading language files.

// Example: Fetch a translation for the key "text_sample" with fallback text and a replacement value.
var_dump("text_sample - " . Translation::tr("text_sample", "Sample text fallback %s", "(Replaced)"));

// Example: Fetch a translation for the key "text_sample_alt" with fallback text and a replacement value.
var_dump("text_sample_alt - " . Translation::tr("text_sample_alt", "Sample text fallback %s", "(Replaced)"));
