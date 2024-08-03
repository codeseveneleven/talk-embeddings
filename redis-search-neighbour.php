<?php

use Predis\Command\Argument\Search\SearchArguments;
use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";


$embedding = new Embedding();

$text = $argv[1];

$textEmbedding = $embedding->calculateEmbedding( $text);

$client = new Predis\Client([
	'port'=>6378
]);

$searchArguments = new SearchArguments();
$searchArguments
	->dialect( 2)
	->sortBy( '__vector_score')
	->addReturn( 3, '__vector_score' , 'uid','text')
	->params( ['query_vector',pack('f1536', ... $textEmbedding)])
;

$result = $client->ftsearch( 'idx:text', '(*)=>[KNN 3 @vector $query_vector]',$searchArguments);



print_r($embedding->normalizeRedisResult( $result));
// */


