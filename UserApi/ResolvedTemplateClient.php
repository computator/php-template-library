<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\UserApi;

/**
 * Template object reference methods available in templates.
 *
 * These methods are the ones available on objects retrieved
 * using `self::tpl()` while rendering.
 */
interface ResolvedTemplateClient {
	/**
	 * Set context to render the template with.
	 *
	 * This method is used to set the data that the template will be rendered
	 * with. Every call replaces any previous data so that the template can be
	 * rendered repeatedly with different values.
	 *
	 * # Example
	 *
	 * ```php
	 * <?php
	 * // Example user
	 * $user = ['id' => 3, 'first' => "User", 'last' => "Name"];
	 * ?>
	 *
	 * <div class="comment-list">
	 * 	<? self::tpl('comment.php')->with(
	 * 		$user,
	 * 		text: "This is a comment.",
	 * 	)() ?>
	 * </div>
	 * ```
	 *
	 * # Data Formats
	 *
	 * This method accepts data in multiple formats:
	 * - Named parameters
	 * - Parameter arrays
	 * - A mix of named parameters and arrays
	 *
	 * ## Named Parameters
	 *
	 * ```php
	 * <?php
	 * $t->with(key1: "value1", key2: "value2", key3: 3)
	 * ```
	 *
	 * ## Parameter Arrays
	 *
	 * ```php
	 * <?php
	 * $t->with(['key1' => "value1", 'key2' => "value2", 'key3' => 3])
	 * ```
	 *
	 * ```php
	 * <?php
	 * $data1 = ['key1' => "value1", 'key2' => "value2"];
	 * $data2 = ['key3' => "value3", 'key4' => 4];
	 * $t->with($data1, $data2)
	 * ```
	 *
	 * ## Mixed
	 *
	 * ```php
	 * <?php
	 * $data = ['key3' => "value3", 'key4' => 4];
	 * $t->with($data, key1: "value1", key2: "value2")
	 * ```
	 *
	 * @return self Chains to self
	 */
	public function with(mixed ...$context): self;

	/**
	 * Render the template.
	 *
	 * Invoking the template object reference by calling it as a function will
	 * render the template with the current context data.
	 *
	 * # Example
	 *
	 * ```php
	 * <? self::tpl('child.php')() ?>
	 * ```
	 */
	public function __invoke(): void;
}
