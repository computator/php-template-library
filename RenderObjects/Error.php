<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\RenderObjects;

use Computator\FrameworkUtils\PHPTemplate\Exceptions;
use Computator\FrameworkUtils\PHPTemplate\UserApi;

class Error implements UserApi\ResolvedTemplateClient {
	public function __construct(
		protected readonly UserApi\RenderManager $renderer,
		public readonly Exceptions\TemplateRenderException $exception,
	) {}

	public function with(mixed ...$_): self {
		return $this;
	}

	public function __invoke(): void {
		$this->renderer->renderError($this->exception->getMessage());
	}
}
