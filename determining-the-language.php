<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';


$testme = $argv[1];
$test = new Embedding();
//$test->setModel( Embedding::MODELS[1]);
$english = $test->calculateEmbedding( 'english');
$german = $test->calculateEmbedding('german');
$french = $test->calculateEmbedding('french');
$text = $test->calculateEmbedding( $testme);
$result = [
	'english' => $test->distance( $text, $english ),
	'german' => $test->distance( $text, $german ),
	'french' => $test->distance( $text, $french )
];
asort( $result );

printf("\n\n\n".'"%s" probably is in : %s'."\n\n\n",$testme,array_keys($result)[0]);
print_r($result);


