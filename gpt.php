<?php

use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$test = new Embedding();

$text = $argv[1];

$result = $test->askGPT( $text);

print_r($result);
