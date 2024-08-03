<?php

use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$test = new Embedding();

$text = $argv[1];

$disambiguated_text = $test->askGPT( $text,'you are an assistant tasked with disambiguate the users input. If available replace the keywords with more common words');

var_dump($disambiguated_text);
