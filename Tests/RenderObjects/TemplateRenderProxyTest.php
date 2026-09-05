<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\Tests\RenderObjects;

use Computator\FrameworkUtils\PHPTemplate\Exceptions;
use Computator\FrameworkUtils\PHPTemplate\RenderObjects\TemplateRenderProxy;
use Computator\FrameworkUtils\PHPTemplate\Templates;
use Computator\FrameworkUtils\PHPTemplate\UserApi;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TemplateRenderProxy::class)]
final class TemplateRenderProxyTest extends TestCase {
	public function testInstanceIdsAreUnique(): void {
		$r = $this->createStub(UserApi\RenderManager::class);
		$t = $this->createStub(Templates\Base::class);

		$p1 = new TemplateRenderProxy($r, $t);
		$p2 = new TemplateRenderProxy($r, $t);
		$p3 = new TemplateRenderProxy($r, $t);

		$this->assertCount(3, array_unique([
			$p1->id,
			$p2->id,
			$p3->id,
		], SORT_REGULAR));
	}

	public function testWithSetsContext(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$proxy = new TemplateRenderProxy($r, $this->createStub(Templates\Base::class));

		$r
			->expects($this->once())
			->method('renderProxiedTemplate')
			->with($proxy, [
				'a' => 'a',
				'b' => 2,
			]);

		$proxy->with(
			a: 'a',
			b: 2,
		)();
	}

	public function testWithTwiceReplacesContext(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$proxy = new TemplateRenderProxy($r, $this->createStub(Templates\Base::class));

		$r
			->expects($this->once())
			->method('renderProxiedTemplate')
			->with($proxy, [
				'a' => 'a',
				'b' => 2,
			]);

		$proxy->with(
			a: 'old',
			b: 1,
		)->with(
			a: 'a',
			b: 2,
		)();
	}

	public function testWithUsingArrays(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$proxy = new TemplateRenderProxy($r, $this->createStub(Templates\Base::class));

		$r
			->expects($this->once())
			->method('renderProxiedTemplate')
			->with($proxy, [
				'a' => 'a',
				'b' => 2,
			]);

		$proxy->with(
			[
				'a' => 'a',
				'b' => 2,
			]
		)();
	}

	public function testWithUsingInvalidFormat(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$proxy = new TemplateRenderProxy($r, $this->createStub(Templates\Base::class));

		$r
			->expects($this->never())
			->method('renderProxiedTemplate');

		$this->expectException(Exceptions\TemplateLogicException::class);
		$proxy->with(
			[
				'a',
				'b',
			]
		);
	}

	public function testInvokeRendersSelf(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$proxy = new TemplateRenderProxy($r, $this->createStub(Templates\Base::class));

		$r
			->expects($this->once())
			->method('renderProxiedTemplate')
			->with($proxy, []);

		$proxy();
	}
}
