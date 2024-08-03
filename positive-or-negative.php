<?php

use PSpell\Dictionary;
use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$test = new Embedding();

$testme =  $argv[1];

$positive = $test->calculateEmbedding( 'positive');
$negative = $test->calculateEmbedding('negative');
$neutral = $test->calculateEmbedding('neutral');

$text = $test->calculateEmbedding( $testme);

$result = [
	'Positive' => $test->distance( $text, $positive ),
	'Negative' => $test->distance( $text, $negative ),
	'Neutral' => $test->distance( $text, $neutral ),
];

asort( $result );


printf("\n\n".'"%s" is probably : %s'."\n\n",$argv[1],array_keys($result)[0]);
print_r($result);

