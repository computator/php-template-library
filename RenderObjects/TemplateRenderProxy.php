<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\RenderObjects;

use Computator\FrameworkUtils\PHPTemplate\Exceptions;
use Computator\FrameworkUtils\PHPTemplate\Templates;
use Computator\FrameworkUtils\PHPTemplate\UserApi;
use Computator\FrameworkUtils\PHPTemplate\Utils;
use ValueError;

class TemplateRenderProxy implements UserApi\ResolvedTemplateClient {
	protected static int $next_id = 1;
	public readonly int $id;

	/** @var array<string,mixed> $context */
	protected array $context = [];

	public function __construct(
		protected readonly UserApi\RenderManager $renderer,
		protected readonly Templates\Base $tpl,
	) {
		$this->id = self::$next_id++;
	}

	public function with(mixed ...$context): self {
		try {
			$this->context = Utils::transform_context($context);
		} catch (ValueError $e) {
			throw new Exceptions\TemplateLogicException("'".__FUNCTION__."' called using invalid data format: $e", previous: $e);
		}
		return $this;
	}

	public function __invoke(): void {
		$this->renderer->renderProxiedTemplate($this, $this->context);
	}
}
