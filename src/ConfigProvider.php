<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

final class ConfigProvider
{
    /**
     * @return array<mixed>
     */
    public function __invoke(): array
    {
        return [
            'template_renderer' => [
                'template_renderer' => [
                    'template_directory' => 'template-parts',
                ],
                'class_template_renderer' => [
                    'template_name' => 'template',
                ],
            ],
            'hook' => [
                'provider' => [],
            ],
            'dependencies' => [
                'aliases' => [
                    ClassSlugGeneratorInterface::class => ClassTemplateSlugGenerator::class,
                ],
                'factories' => [
                    ClassTemplateRenderer::class => ClassTemplateRendererFactory::class,
                    TemplateRenderer::class => TemplateRendererFactory::class,
                ],
            ],
        ];
    }
}
