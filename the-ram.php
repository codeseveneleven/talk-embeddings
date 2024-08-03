<?php

use PSpell\Dictionary;
use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$embedding = new Embedding();
$theText = $argv[1];

[$key,$distance] = $embedding->getNearestNeighbour(
	$embedding->calculateEmbedding( $theText),
	$embedding->generateDictionary(['pickup truck','computer memory','sheep'])
);

printf("\n\n\n".'"%s" probably is : %s'."\n\n\n",$theText,$key);


