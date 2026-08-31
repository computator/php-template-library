<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate\UserApi;

/**
 * Template engine methods available in templates.
 */
interface TemplateClient {
	/**
	 * Output a block defined in a child template.
	 *
	 * This method is used to output a block that a child template has previously
	 * defined using `self::block()`. The return value of this method can be
	 * used to decide whether to render any fallback content.
	 *
	 * This method is only valid in a template that has been set as a parent
	 * from a child via `self::inherit()`.
	 *
	 * # Examples
	 *
	 * ## Normal
	 * ```php
	 * <? self::block('block_name'): ?>
	 * ```
	 *
	 * ## Fallback
	 * ```php
	 * <? if(!self::block('block_name')): ?>
	 * 	Fallback content
	 * <? endif ?>
	 * ```
	 *
	 * @return bool whether or not the block was found and output
	 */
	public function block(string $block_name): bool;

	/**
	 * Start defining a template block.
	 *
	 * Blocks defined with this method can be output in the parent template
	 * using `self::block()`.
	 *
	 * This method is only valid in a child template that has set a
	 * parent with `self::inherit()`.
	 *
	 * # Example
	 * ```php
	 * <? self::define('block_name') ?>
	 * 	Block content
	 * <? self::define_end() ?>
	 * ```
	 */
	public function define(string $block_name): void;

	/**
	 * End the current template block being defined.
	 *
	 * This method is used to mark the end of a block started with `self::define()`.
	 *
	 * This method is only valid in a child template that has set a
	 * parent with `self::inherit()`.
	 *
	 * # Example
	 * ```php
	 * <? self::define('block_name') ?>
	 * 	Block content
	 * <? self::define_end() ?>
	 * ```
	 */
	public function define_end(): void;

	/**
	 * Set a parent template to render this template with.
	 *
	 * This method can not be called more than once per template.
	 *
	 * # Example
	 *
	 * ## `child.php`
	 * ```php
	 * <? self::inherit('parent.php') ?>
	 *
	 * <? self::define('block_one') ?>
	 * 	Block content
	 * <? self::define_end() ?>
	 * ```
	 *
	 * ## `parent.php`
	 * ```php
	 * <div class="content">
	 * 	<? self::block('block_one') ?>
	 * </div>
	 * ```
	 */
	public function inherit(string $parent_template): void;

	/**
	 * Output non-block content from a child template.
	 *
	 * This method is used to output all content displayed in a child
	 * template outside of defined blocks.
	 *
	 * This method is only valid in a template that has been set as a parent
	 * from a child via `self::inherit()`.
	 *
	 * # Example
	 *
	 * ## `child.php`
	 * ```php
	 * <? self::inherit('parent.php') ?>
	 *
	 * <p>Content outside block</p>
	 * ```
	 *
	 * ## `parent.php`
	 * ```php
	 * <div class="content">
	 * 	<? self::primary() ?>
	 * </div>
	 * ```
	 */
	public function primary(): void;

	/**
	 * Retrieve a reference to another template.
	 *
	 * This method is used to load another template to render. This returns a
	 * reference to the template rather than immediately rendering it, so the
	 * template can be used immediately or saved in a variable for later use.
	 *
	 * This method returns a reference to the template as an object that
	 * implements [UserApi\ResolvedTemplateClient](ResolvedTemplateClient.php).
	 *
	 * # Example
	 *
	 * ## `main.php`
	 * ```php
	 * <? self::tpl('child.php')() ?>
	 * ```
	 *
	 * ## `child.php`
	 * ```php
	 * <p>Child content</p>
	 * ```
	 */
	public function tpl(string $template): ResolvedTemplateClient;
}
