<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

use ReflectionClass;

interface ClassSlugGeneratorInterface
{
    /**
     * @param ReflectionClass<object> $reflector
     *
     * @return string
     */
    public function __invoke(ReflectionClass $reflector): string;
}
