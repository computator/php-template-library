<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate;

use ValueError;

use function array_is_list, is_array, is_int;

class Utils {
	/** @return array<string,mixed> */
	public static function transform_context(array $context): array {
		$out = [];
		foreach ($context as $k => $v) {
			if (is_int($k)) {
				if (!is_array($v))
					throw new ValueError("non-array values require a non-numeric key");
				if (array_is_list($v))
					throw new ValueError("list array values require a non-numeric key");
				$out = [...$out, ...$v];
			}
			else
				$out[$k] = $v;
		}
		return $out;
	}
}
