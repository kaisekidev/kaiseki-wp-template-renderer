<?php

declare(strict_types=1);

namespace Kaiseki\WordPress\TemplateRenderer;

use Jawira\CaseConverter\Convert;
use ReflectionClass;

final class ClassTemplateSlugGenerator implements ClassSlugGeneratorInterface
{
    public function __invoke(ReflectionClass $reflector): string
    {
        return (new Convert($reflector->getShortName()))->toKebab();
    }
}
