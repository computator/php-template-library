<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\RenderObjects;

interface RenderableObject {
	public function with(mixed ...$context): self;
	public function __invoke(): void;
}
