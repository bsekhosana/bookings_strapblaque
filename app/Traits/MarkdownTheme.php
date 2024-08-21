<?php

namespace App\Traits;

trait MarkdownTheme
{
    /**
     * Theme name, logo, URL and styles.
     */
    public array $md_theme = [
        'name' => null, // Fallback: config('app.name')
        'logo' => null, // Fallback: 'images/logo.png'
        'url'  => null, // Fallback: config('app.url')
        'css'  => null, // Fallback: {theme_name}.css ?? default.css
    ];

    public function theme(string $theme): self
    {
        /** @var array<string, array> $themes */
        $themes = config('mail.markdown.themes');

        if (isset($themes[$theme])) {
            $this->md_theme = $themes[$theme];

            $css = $this->md_theme['css'] ?? $theme;
            $css = \Str::endsWith($css, '.css') ? substr($css, 0, strlen($css - 4)) : $css;

            if (! file_exists(base_path(sprintf('resources/views/vendor/mail/html/themes/%s.css', $css)))) {
                throw new \Exception(sprintf('Mail theme CSS [%s.css] does not exist.', $css));
            }
        } else {
            throw new \Exception(sprintf('Mail theme [%s] does not exist.', $theme));
        }

        $this->md_theme['name'] ??= config('app.name');
        $this->md_theme['logo'] ??= '/images/logo.png';
        $this->md_theme['url'] ??= config('app.url');
        $this->md_theme['css'] = $this->theme = $css ?? 'default';

        return $this;
    }
}
