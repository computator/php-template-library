<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\Tests;

use Computator\FrameworkUtils\PHPTemplate\Utils;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ValueError;

#[CoversClass(Utils::class)]
final class UtilsTest extends TestCase {
	public function testTransformContextWithNamedValues(): void {
		$this->assertSame(
			[
				'asdf' => 3,
				'qwer' => [1, 2, 3],
				'zxcv' => "qwer",
			],
			Utils::transform_context([
				'asdf' => 3,
				'qwer' => [1, 2, 3],
				'zxcv' => "qwer",
			]),
		);
	}

	public function testTransformContextWithListObjects(): void {
		$this->assertSame(
			[
				'asdf' => 3,
				'qwer' => [1, 2, 3],
				'zxcv' => "qwer",
			],
			Utils::transform_context([
				[
					'asdf' => 3,
					'qwer' => [1, 2, 3],
				],
				[
					'zxcv' => "qwer",
				],
			]),
		);
	}

	public function testTransformContextWithMixedValuesAndObjects(): void {
		$this->assertSame(
			[
				'asdf' => 3,
				'qwer' => [1, 2, 3],
				'zxcv' => "qwer",
			],
			Utils::transform_context([
				'asdf' => 3,
				'qwer' => [1, 2, 3],
				[
					'zxcv' => "qwer",
				],
			]),
		);
	}

	public function testTransformContextWithNumericallyIndexedNonArrayValue(): void {
		$this->expectException(ValueError::class);
		Utils::transform_context([
			'asdf',
		]);
	}

	public function testTransformContextWithNumericallyIndexedListArrayValue(): void {
		$this->expectException(ValueError::class);
		Utils::transform_context([
			['a', 'b', 'c'],
		]);
	}
}
