<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

use Kaiseki\Config\Config;
use Psr\Container\ContainerInterface;

final class TemplateRendererFactory
{
    public function __invoke(ContainerInterface $container): ClassTemplateRenderer
    {
        $config = Config::fromContainer($container);

        return new ClassTemplateRenderer(
            $container->get(ClassSlugGeneratorInterface::class),
            $config->string('template_renderer.template_renderer.template_directory', 'template-parts')
        );
    }
}
