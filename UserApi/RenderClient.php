<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\UserApi;

use Computator\FrameworkUtils\PHPTemplate\TemplateResolver;
use Computator\FrameworkUtils\PHPTemplate\Templates;

/**
 * User-visible interface to a `Renderer`.
 *
 * These are the available methods intended for public use to configure and use
 * a `Renderer`.
 *
 * Note that `Renderer` instances have additional public methods meant for
 * internal use to control the rendering process (defined by the `RenderManager`
 * interface), but these methods are not intended for use by end-users.
 *
 * @see Computator\FrameworkUtils\PHPTemplate\Renderer
 * @see RenderManager
 */
interface RenderClient {
	/**
	 * Create a new `Renderer`.
	 *
	 * This method is used to create a new `Renderer` (as a `RenderClient`) bound
	 * to the provided template.
	 *
	 * # Example
	 *
	 * ```php
	 * <?php
	 * $resolver = new TemplateResolver(
	 * 	// This is the class used to instantiate new templates.
	 * 	// In this case, `Templates\File` is the default so it
	 * 	// could also be left unspecified.
	 * 	Templates\File::class
	 * );
	 * $renderclient = Renderer::create(new Templates\File('main.php'), $resolver);
	 * ```
	 *
	 * @param Templates\Base $template The root template that the rendering process will start at.
	 *
	 * @param TemplateResolver $resolver (optional) The `TemplateResolver` that will be used to
	 *                                   resolve additional template names referenced during
	 *                                   the rendering process.
	 */
	public static function create(Templates\Base $template, TemplateResolver $resolver): RenderClient;

	/**
	 * Set context to render the root template with.
	 *
	 * This method is used to set the data that the root template will be rendered
	 * with. Every call replaces any previous data and the template is rendered
	 * with the latest specified data.
	 *
	 * # Example
	 *
	 * ```php
	 * <?php
	 * // Example user
	 * $user = ['id' => 3, 'first' => "User", 'last' => "Name"];
	 *
	 * $renderclient = Renderer::create(new Templates\File('profile.php'));
	 * $renderclient->with(
	 * 	$user,
	 * 	message: "This is a profile message.",
	 * )->render();
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
	 * $renderclient->with(key1: "value1", key2: "value2", key3: 3)
	 * ```
	 *
	 * ## Parameter Arrays
	 *
	 * ```php
	 * <?php
	 * $renderclient->with(['key1' => "value1", 'key2' => "value2", 'key3' => 3])
	 * ```
	 *
	 * ```php
	 * <?php
	 * $data1 = ['key1' => "value1", 'key2' => "value2"];
	 * $data2 = ['key3' => "value3", 'key4' => 4];
	 * $renderclient->with($data1, $data2)
	 * ```
	 *
	 * ## Mixed
	 *
	 * ```php
	 * <?php
	 * $data = ['key3' => "value3", 'key4' => 4];
	 * $renderclient->with($data, key1: "value1", key2: "value2")
	 * ```
	 *
	 * @return $this Chains to self
	 */
	public function with(mixed ...$context): self;

	/**
	 * Execute the rendering process.
	 *
	 * This method will render the base template and any templates referenced by
	 * it and output the rendered content directly.
	 *
	 * The base template will be rendered with any context data set by `with()`.
	 *
	 * @see RenderClient::with() Set the context for rendering
	 * @see RenderClient::renderToString() Alternative method to render to a string
	 */
	public function render(): void;

	/**
	 * Execute the rendering process.
	 *
	 * This method will render the base template and any templates referenced by
	 * it and return the rendered content as a string. This method does not
	 * have any output.
	 *
	 * The base template will be rendered with any context data set by `with()`.
	 *
	 * @return string The rendered content
	 *
	 * @see RenderClient::with() Set the context for rendering
	 * @see RenderClient::render() Alternative method to output directly
	 */
	public function renderToString(): string;
}
