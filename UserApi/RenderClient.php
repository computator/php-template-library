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
	 * Execute the rendering process.
	 *
	 * This method will render the base template and any templates referenced by
	 * it and output the rendered content directly.
	 *
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
	 * @return string The rendered content
	 *
	 * @see RenderClient::render() Alternative method to output directly
	 */
	public function renderToString(): string;
}
