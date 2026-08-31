# Overview
This library is a templating engine for PHP that uses native PHP syntax to increase template flexibility and reduce processing overhead.

# Usage

## Method Overview
The primary engine interfaces are defined in the [`UserApi`](UserApi/) namespace.
- [`UserApi/TemplateClient`](UserApi/TemplateClient.php): Primary methods for utilizing the engine in templates.
- [`UserApi/ResolvedTemplateClient`](UserApi/ResolvedTemplateClient.php): Methods available on objects retrieved using `self::tpl()` while rendering.
- [`UserApi/RenderClient`](UserApi/RenderClient.php): User-visible methods for interacting with the [`Renderer`](Renderer.php).
- [`UserApi/RenderManager`](UserApi/RenderManager.php): Internal methods the engine uses to control the [`Renderer`](Renderer.php) during the render process.

## Templates
Templates are executed with access to the methods defined in [`UserApi/TemplateClient`](UserApi/TemplateClient.php) and are intended to be called via the `self` object as `self::method()`. Template objects retrieved using `self::tpl()` have the methods defined in [`UserApi/ResolvedTemplateClient`](UserApi/ResolvedTemplateClient.php).

Using [Short Open Tags](https://www.php.net/manual/en/language.basic-syntax.phptags.php) and [Alternative Control Structure Syntax](https://www.php.net/manual/en/control-structures.alternative-syntax.php) is encouraged to make templates more readable, as well as leaving out the final semicolon in [closing tags](https://www.php.net/manual/en/language.basic-syntax.instruction-separation.php).

### Template Types
There are several included template types:
- [`Templates/File`](Templates/File.php): Directly executes the named PHP file. (**default**)
- [`Templates/PHPString`](Templates/PHPString.php): Executes the provided literal string of PHP code.
- [`Templates/Text`](Templates/Text.php): Plain text (no execution).

### Example
This example demonstrates the primary concepts of the library with a main, base, and child template. Note that the templates can be modified to avoid referencing literal `.php` filenames by using an alternative [`TemplateResolver`](TemplateResolver.php).

#### `main.php`
```php
<? self::inherit('base.php') ?>

<? self::define('paragraph_one') ?>
	Paragraph one text.

	Paragraph one has a list:
	<ul>
		<? foreach (range(1, 5) as $n): ?>
			<li>Item <?=$n?></li>
		<? endforeach ?>
	</ul>

	More text.
<? self::define_end() ?>

<? self::define('paragraph_two') ?>
	Paragraph two text.

	Paragraph two calls another template:
	<? self::tpl('child.php')->with(
		title: "Child Title",
		items: [
			"one",
			"two",
			"three",
		],
	)() ?>

	More text.
<? self::define_end() ?>
```

#### `base.php`
```php
<h1>Base Page</h1>

<p class="one">
	<? self::block('paragraph_one') ?>
</p>

<p class="two">
	<? self::block('paragraph_two') ?>
</p>

<p class="three">
	<? if (!self::block('paragraph_three')): ?>
		Fallback text if paragraph three is not set
	<? endif ?>
</p>
```

#### `child.php`
```php
<div class="child">
	<h2><?=htmlspecialchars($title)?></h2>
	<? foreach ($items as $i): ?>
		<div class="item">
			Item content: <?=htmlspecialchars($i)?>
		</div>
	<? endforeach ?>
</div>
```

## Rendering
Rendering is controlled by creating a new instance of a [`Renderer`](Renderer.php) with a root template. The user-facing interface to the renderer instance is defined in [`UserApi/RenderClient`](UserApi/RenderClient.php).

The resolution of non-root template names to templates can be controlled by specifying an optional [`TemplateResolver`](TemplateResolver.php). The default implementation passes the template name directly to the configured template class.

### Examples

#### Default Resolver
```php
<?php

use Computator\FrameworkUtils\PHPTemplate\Renderer;
use Computator\FrameworkUtils\PHPTemplate\Templates;

// to make the example runnable
require 'vendor/autoload.php';

$renderer = Renderer::create(
	// Note that here we are instantating the root template directly.
	// Only templates referenced in `main.php` or other templates it
	// calls will use the resolver.
	new Templates\File('main.php')
);
$renderer->render();
```

#### Specifying a Resolver
```php
<?php

use Computator\FrameworkUtils\PHPTemplate\Renderer;
use Computator\FrameworkUtils\PHPTemplate\TemplateResolver;
use Computator\FrameworkUtils\PHPTemplate\Templates;

// to make the example runnable
require 'vendor/autoload.php';

$resolver = new TemplateResolver(
	// This is the class used to instantiate new templates.
	// In this case, `Templates\File` is the default so it
	// could also be left unspecified.
	Templates\File::class
);

$main_tpl = $resolver->resolve('main.php');
$renderer = Renderer::create(
	$main_tpl,
	$resolver,
);
$renderer->render();
```
