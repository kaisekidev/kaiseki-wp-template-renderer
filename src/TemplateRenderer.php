<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

use RuntimeException;

use function file_exists;
use function get_template_directory;
use function get_template_part;
use function ob_get_clean;
use function ob_start;
use function sprintf;
use function trailingslashit;

final class TemplateRenderer
{
    public function __construct(
        private string $templateDirectory = 'template-parts'
    ) {
    }

    /**
     * @param string               $slug
     * @param array<string, mixed> $args
     * @param string|null          $name
     */
    public function render(
        string $slug,
        array $args = [],
        ?string $name = null,
    ): string {
        $path = trailingslashit($this->templateDirectory);
        $filename = ($name === '' ? $slug . '-' . $name : $slug) . '.php';
        $absoluteFilePath = trailingslashit(get_template_directory()) . $path . $filename;
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
            $name,
            $args
        );
        $html = ob_get_clean();

        return $html !== false ? $html : '';
    }
}
