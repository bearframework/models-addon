<?php

/*
 * Bear Framework Models
 * https://github.com/bearframework/models-addon
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

require __DIR__ . '/vendor/autoload.php';

$docsGenerator = new IvoPetkov\DocsGenerator(__DIR__, ['/classes']);
$docsGenerator->generateMarkdown(__DIR__ . '/docs/markdown');
