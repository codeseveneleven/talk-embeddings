<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$test = new Embedding();

$queen = $test->calculateEmbedding( 'queen');
$woman = $test->calculateEmbedding('woman');
$monarch = $test->calculateEmbedding('monarch');
$summ = $test->vectoradd( $monarch, $woman);
$distance = $test->distance( $queen,$summ);
printf("\n\n\nDistance between Monarch + Woman and Queen %s\n\n\n",$distance);

$distance = $test->distance( $queen,$monarch);
printf("Distance between Monarch and Queen %s\n\n\n",$distance);
$distance = $test->distance( $queen,$woman);
printf("Distance between Woman and Queen %s\n\n\n",$distance);
