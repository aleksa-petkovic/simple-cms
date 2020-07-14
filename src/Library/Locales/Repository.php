<?php

declare(strict_types=1);

namespace Library\Locales;

use Exception;

class Repository
{
    /**
     * An array of available application locales.
     */
    protected array $availableLocales;

    /**
     * The current locale.
     */
    protected string $locale;

    /**
     * @param array  $availableLocales An array of available locales.
     * @param string $locale           The default locale.
     *
     * @throws Exception
     */
    public function __construct(array $availableLocales, string $locale)
    {
        if (!$this->validLocaleConfiguration($availableLocales, $locale)) {
            throw new Exception('Invalid locale configuration - the default locale is missing from the available locales array.');
        }

        $this->availableLocales = $availableLocales;
        $this->locale = $locale;
    }

    /**
     * Validates the locale configuration.
     *
     * Basically, the passed locale's definition must exist in the passed array
     * of available locales.
     *
     * @param array  $availableLocales The available locales.
     * @param string $locale           The default locale.
     *
     * @return bool
     */
    public function validLocaleConfiguration(array $availableLocales, string $locale): bool
    {
        foreach ($availableLocales as $availableLocale) {
            if ($availableLocale['locale'] === $locale) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the available locales.
     *
     * @return array
     */
    public function getAvailableLocales(): array
    {
        return $this->availableLocales;
    }

    /**
     * Returns an array of available languages.
     *
     * @return array
     */
    public function getAvailableLanguages(): array
    {
        return array_map(
            static function (array $locale): string {
                return $locale['language'];
            },
            $this->availableLocales,
        );
    }

    /**
     * Gets the locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * Sets the locale.
     *
     * @param string $locale The locale identifier.
     *
     * @throws Exception
     *
     * @return void
     */
    public function setLocale(string $locale): void
    {
        $properties = $this->getLocaleProperties($locale);

        if ($properties === null) {
            throw new Exception('The specified locale doesn\'t exist in the available locales: ' . $locale);
        }

        $this->locale = $locale;
    }

    /**
     * Gets the current application language (note that this is not the same as
     * the current locale, as the language might be "en" whereas the locale is
     * "en_US").
     *
     * @return string
     */
    public function getLanguage(): string
    {
        $properties = $this->getLocaleProperties($this->locale);

        return $properties['language'];
    }

    /**
     * Checks whether the current app is multilingual.
     *
     * @return bool
     */
    public function isMultilingual(): bool
    {
        return count($this->availableLocales) > 1;
    }

    /**
     * Returns the appropriate locale according to the passed language.
     *
     * Returns `null` if the specified language isn't found.
     *
     * @param string|null $language The language identifier.
     *
     * @return string|null
     */
    public function getLocaleByLanguage(?string $language): ?string
    {
        $properties = $this->getLanguageProperties($language);

        return ($properties !== null) ? $properties['locale'] : null;
    }

    /**
     * Gets the name of a language.
     *
     * Returns `null` if the language isn't found.
     *
     * @param string $language The language identifier.
     *
     * @return string|null
     */
    public function getLanguageName(string $language): ?string
    {
        $properties = $this->getLanguageProperties($language);

        return ($properties !== null) ? $properties['name'] : null;
    }

    /**
     * Checks whether the language exists.
     *
     * @param string $language The language identifier.
     *
     * @return bool
     */
    public function languageExists(string $language): bool
    {
        foreach ($this->availableLocales as $properties) {
            if ($properties['language'] === $language) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks whether the locale exists.
     *
     * @param string $locale The locale identifier.
     *
     * @return bool
     */
    public function localeExists(string $locale): bool
    {
        foreach ($this->availableLocales as $properties) {
            if ($properties['locale'] === $locale) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets the properties array for a locale.
     *
     * Assumes the current locale if no argument is passed.
     *
     * Returns `null` if the locale isn't found.
     *
     * @param string|null $locale The locale identifier.
     *
     * @return array|null
     */
    public function getLocaleProperties(?string $locale = null): ?array
    {
        $locale = $locale ?: $this->locale;

        foreach ($this->availableLocales as $properties) {
            if ($properties['locale'] === $locale) {
                return $properties;
            }
        }

        return null;
    }

    /**
     * Gets the properties array for a language.
     *
     * Assumes the current language if no argument is passed.
     *
     * Returns `null` if the language isn't found.
     *
     * @param string|null $language The language identifier.
     *
     * @return array|null
     */
    public function getLanguageProperties(?string $language = null): ?array
    {
        if ($language === null) {
            return $this->getLocaleProperties();
        }

        foreach ($this->availableLocales as $properties) {
            if ($properties['language'] === $language) {
                return $properties;
            }
        }

        return null;
    }
}
