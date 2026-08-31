<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\UserApi;

use Computator\FrameworkUtils\PHPTemplate\RenderObjects;

interface TemplateClient {
	public function tpl(string $template): RenderObjects\TemplateRenderProxy|RenderObjects\Error;

	public function inherit(string $parent_template): void;

	public function define(string $block_name): void;

	public function define_end(): void;

	public function block(string $block_name): bool;

	public function primary(): void;
}
