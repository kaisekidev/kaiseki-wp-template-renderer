# Changelog

All notable changes to this project will be documented in this file, in reverse chronological order by release.

## 1.0.0 - 2026-06-01

First tagged release.

### Added

- `TemplateRenderer` — renders a theme template part by slug from a configurable base directory
  (config `template_renderer.template_renderer.template_directory`, default `template-parts`) and
  returns its output as a string.
- `ClassTemplateRenderer` — renders a template part located next to a given object's class file,
  deriving the slug from the class short name via a `ClassSlugGeneratorInterface`
  (config `template_renderer.class_template_renderer.template_name`, default `template`).
- `ClassTemplateSlugGenerator` (kebab-cases the class short name) and `ClassSlugGeneratorInterface`,
  aliased together in `ConfigProvider`.
- `ConfigProvider` wiring the renderer factories and the slug-generator alias.

### Changed

- PHP requirement is `^8.2` (PHP 8.4 is the primary target).
- Modernized the dev toolchain (PHPStan 2, PHPUnit 11 schema, composer-require-checker 4); now depends
  on `kaiseki/php-coding-standard: ^1.0` with the shared PHPStan config; `kaiseki/config` and
  `kaiseki/wp-hook` pinned to `^2.0`. CI now runs via the reusable workflow in `kaisekidev/.github`.
- Removed the direct `friendsofphp/php-cs-fixer` requirement — the shared coding standard owns it.
- Added the previously-missing `composer-require-checker` setup (`check-deps` script and
  `require-checker.config.json` whitelisting the WordPress runtime globals the renderers call).
