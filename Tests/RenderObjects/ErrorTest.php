<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\Tests\RenderObjects;

use Computator\FrameworkUtils\PHPTemplate\Exceptions;
use Computator\FrameworkUtils\PHPTemplate\RenderObjects\Error;
use Computator\FrameworkUtils\PHPTemplate\UserApi;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Error::class)]
final class ErrorTest extends TestCase {
	public function testExceptionPropertyValue(): void {
		$exp = new Exceptions\TemplateRenderException('asdf');
		$err = new Error(
			$this->createStub(UserApi\RenderManager::class),
			$exp,
		);
		$this->assertSame($exp, $err->exception);
		$this->assertEquals('asdf', $err->exception->getMessage());
	}

	public function testCallingMethodsReturnsSelf(): void {
		$e = new Error(
			$this->createStub(UserApi\RenderManager::class),
			$this->createStub(Exceptions\TemplateRenderException::class),
		);
		$this->assertSame($e, $e->with(1, 2, '3'));
	}

	public function testInvokeRendersError(): void {
		$r = $this->createMock(UserApi\RenderManager::class);
		$r
			->expects($this->once())
			->method('renderError')
			->with('asdf');

		(new Error(
			$r,
			new Exceptions\TemplateRenderException('asdf'),
		))();
	}
}
