<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

use ReflectionClass;
use RuntimeException;

use function dirname;
use function file_exists;
use function get_class;
use function get_template_directory;
use function get_template_part;
use function ob_get_clean;
use function ob_start;
use function realpath;
use function sprintf;
use function str_replace;
use function trailingslashit;

final class ClassTemplateRenderer
{
    public function __construct(
        private ClassSlugGeneratorInterface $slugGenerator,
        private string $defaultTemplateName = 'template'
    ) {
    }

    /**
     * @param object               $object
     * @param array<string, mixed> $args
     * @param string|null          $slug
     * @param string|null          $templateName
     */
    public function render(
        object $object,
        array $args = [],
        ?string $slug = null,
        ?string $templateName = null,
    ): string {
        $reflector = new ReflectionClass(get_class($object));
        $filename = $reflector->getFileName();

        if ($filename === false) {
            throw new RuntimeException('ReflectionClass::getFileName() returned false');
        }

        $slug = $slug === '' ? ($this->slugGenerator)($reflector) : $slug;
        $templateName ??= $this->defaultTemplateName;
        $dirname = dirname($filename);
        $path = trailingslashit(str_replace((string)realpath(get_template_directory()), '', $dirname));

        $filename = ($templateName === '' ? $slug : $slug . '-' . $templateName) . '.php';
        $absoluteFilePath = trailingslashit($dirname) . $filename;
        if (!file_exists($absoluteFilePath)) {
            throw new RuntimeException(
                sprintf(
                    'Template file %s doesn\'t exist',
                    $absoluteFilePath,
                )
            );
        }

        ob_start();
        get_template_part(
            $path . $slug,
            $templateName,
            $args
        );
        $html = ob_get_clean();

        return $html !== false ? $html : '';
    }
}
