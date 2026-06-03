# kaiseki/wp-template-renderer

Render WordPress template parts by slug or from a class, with a configurable class-to-slug generator.

Two renderers, both wired through `ConfigProvider`:

- **`TemplateRenderer`** — renders a template part by slug from a configurable base directory under the
  active theme (default `template-parts`), capturing its output as a string.
- **`ClassTemplateRenderer`** — renders a template part that lives next to a given object's class file,
  deriving the slug from the class short name (kebab-cased by default) via a
  `ClassSlugGeneratorInterface`.

## Installation

```bash
composer require kaiseki/wp-template-renderer
```

Requires PHP 8.2 or newer.

## Usage

Register `ConfigProvider` with your laminas-style config aggregator. It declares the renderer factories
and aliases `ClassSlugGeneratorInterface` to the kebab-case `ClassTemplateSlugGenerator`, and exposes a
`template_renderer` config key for the defaults:

```php
use Kaiseki\WordPress\TemplateRenderer\ConfigProvider;

return (new ConfigProvider())();
// [
//     'template_renderer' => [
//         'template_renderer'       => ['template_directory' => 'template-parts'],
//         'class_template_renderer' => ['template_name' => 'template'],
//     ],
//     'dependencies' => [ /* aliases + factories */ ],
//     'hook'         => ['provider' => []],
// ]
```

### Rendering a template part by slug

```php
use Kaiseki\WordPress\TemplateRenderer\TemplateRenderer;

/** @var TemplateRenderer $renderer */
$renderer = $container->get(TemplateRenderer::class);

// Renders <stylesheet>/template-parts/card.php and returns its output.
$html = $renderer->render('card', ['title' => 'Hello']);

// With a name variant: <stylesheet>/template-parts/card-featured.php
$html = $renderer->render('card', ['title' => 'Hello'], 'featured');
```

The base directory is configurable via `template_renderer.template_renderer.template_directory`.

### Rendering a template part from a class

```php
use Kaiseki\WordPress\TemplateRenderer\ClassTemplateRenderer;

/** @var ClassTemplateRenderer $renderer */
$renderer = $container->get(ClassTemplateRenderer::class);

// For an instance of App\Blocks\HeroBlock, looks for hero-block-template.php
// next to HeroBlock's class file and returns its output.
$html = $renderer->render($block, ['heading' => 'Welcome']);

// Override the derived slug and/or the template name suffix:
$html = $renderer->render($block, ['heading' => 'Welcome'], slug: 'hero', templateName: '');
```

The slug is produced by the `ClassSlugGeneratorInterface` binding (kebab-cased class short name by
default); the template-name suffix defaults to
`template_renderer.class_template_renderer.template_name`.

Both renderers throw a `RuntimeException` when the resolved template file does not exist.

## Development

```bash
composer install
composer check   # check-deps, cs-check, phpstan
```

## License

MIT — see [LICENSE](LICENSE.md).
