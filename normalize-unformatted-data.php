<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$embedding  = new Embedding();

$normalizeMe = $argv[1];
$dictionary  = $embedding->generateDictionary([
	'rock',
	'paper',
	'scissors',
	'lizard',
	'spock',
]);

$distances = $embedding->calculateDistances(
	$embedding->calculateEmbedding( $normalizeMe ),
	$dictionary
);

print_r($distances);

printf('the Input "%s" is normalized to "%s"'."\n\n\n",$normalizeMe,array_keys($distances)[0]);
