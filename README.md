# LanguagePro Translation Library

`LanguagePro` is a lightweight PHP library for managing language files and translations in multilingual applications. This README explains how to use the library and its core features.

![](https://img.shields.io/badge/PHP-7.4-blue)
![](https://img.shields.io/github/v/release/mixno35/LanguagePro)
![](https://img.shields.io/packagist/dt/mixno35/language-pro)

## Installation
Use Composer to install the library:
```bash
composer require mixno35/language-pro
```
---
## Usage
### Setting Up Translations
Start by initializing the `LanguagePro` class and configuring it:
```php
use LanguagePro\LanguagePro;
use LanguagePro\Translation;

require "vendor/autoload.php";

Translation::create(LanguagePro::factory()
    ->setPathLanguages(__DIR__ . "/example") // Path to language JSON files
    ->setCurrentLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]) // Set current (client) language
    ->setDefaultLanguage("en") // Set default language
    ->build()); // Build and load translations
```

### Translation Example
To translate strings, use the `Translation::tr()` method. Provide:
- A translation key.
- An optional fallback string.
- Optional replacement values for placeholders.

Example:
```php
echo Translation::tr("greeting", "Hello, %s!", "World");
// Output: "Hello, World!" (if translation key exists)
// Otherwise: "Hello, World!" (fallback string is used)
```
---
## How It Works
### LanguagePro Class
`LanguagePro` is responsible for:
1. Managing paths and loading language JSON files.
2. Setting the default and current language.
3. Merging translations from multiple files.
### Translation Class
`Translation` provides a simple interface for:
1. Accessing translations using keys.
2. Handling fallback strings if a key is missing.
3. Dynamically replacing placeholders in translations.
---
## Directory Structure
Place your language JSON files in the configured directory. For example:
```
/example
    en.json
    fr.json
```
Sample `en.json`:
```json
{
  "greeting": "Hello, %s!",
  "farewell": "Goodbye, %s!"
}
```
---
## Example Application Code
Below is a complete example:
```php
use LanguagePro\LanguagePro;
use LanguagePro\Translation;

require "vendor/autoload.php";

// Initialize translations
Translation::create(LanguagePro::factory()
    ->setPathLanguages(__DIR__ . "/example") // Path to JSON files
    ->setCurrentLanguage($_SERVER["HTTP_ACCEPT_LANGUAGE"]) // Detect browser language
    ->setDefaultLanguage("en") // Default to English
    ->build());

// Fetch and display translations
echo Translation::tr("greeting", "Hello, %s!", "John");
echo Translation::tr("farewell", "Goodbye, %s!", "John");
```
---
## Error Handling
1. **Missing Files:** Logs an error if a language file is missing.
2. **Invalid JSON:** Logs an error for JSON decoding issues.
3. **Translation Key Errors:** Falls back to the specified fallback string.
---
## Advanced Features
### Custom Language Detection
You can customize how the current language is detected:
```php
$languageTag = "fr"; // Set your language tag dynamically
LanguagePro::factory()
    ->setPathLanguages(__DIR__ . "/example")
    ->setCurrentLanguage($languageTag)
    ->setDefaultLanguage("en")
    ->build();
```
### Handling Placeholders
Placeholders in translations can be replaced using `sprintf`:
```php
echo Translation::tr("welcome_message", "Welcome, %s!", "Alice");
// Output: "Welcome, Alice!"
```
---
## License
This project is licensed under the `MIT License`. See the [LICENSE](LICENSE) file for details.

---
Happy translating! 🎉