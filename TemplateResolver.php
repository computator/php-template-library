<?php declare(strict_types=1);

namespace Computator\FrameworkUtils\PHPTemplate;

use TypeError;
use ValueError;

/**
 * Resolves template names to template instances.
 */
class TemplateResolver {
	/**
	 * @param string $new_template_class A subclass of `Templates\Base` which will
	 *                                   be used to instantiate new templates.
	 * @throws TypeError
	 */
	public function __construct(
		protected string $new_template_class = Templates\File::class,
	) {
		if (!is_a($new_template_class, Templates\Base::class, true))
			throw new TypeError("'\$new_template_class' must be an instance of Templates\Base");
	}

	/**
	 * Resolve a template name to a new template instance.
	 *
	 * @throws ValueError
	 */
	final public function resolve(string $template): Templates\Base {
		if ($template == '')
			throw new ValueError("'\$template' can not be empty");
		return $this->map($template);
	}

	/**
	 * Map a template name to a new class instance.
	 *
	 * This method is intended to be overridden by descendant classes to control the
	 * mapping of template names to class instances.
	 *
	 * @return Templates\Base The new template instance
	 */
	protected function map(string $template): Templates\Base {
		return new $this->new_template_class($template);
	}
}
