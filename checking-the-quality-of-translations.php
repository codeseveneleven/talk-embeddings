<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$embedding = new Embedding();

$text1 = $argv[1];
$text2 = $argv[2];

$d1 = $embedding->calculateEmbedding($text1);
$d2 = $embedding->calculateEmbedding($text2);


$distance = $embedding->distance($d1, $d2);

$rating = $distance > 0.125 ? 'BAD' : 'GOOD';

printf("\n\n%s\n\n%s\n\nDistance: %s\n\nRating: %s\n\n", $text1, $text2, $distance, $rating);




