<?php


use Predis\Command\Argument\Search\CreateArguments;
use Predis\Command\Argument\Search\SchemaFields\NumericField;
use Predis\Command\Argument\Search\SchemaFields\TextField;
use Predis\Command\Argument\Search\SchemaFields\VectorField;
use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$embedding = new Embedding();

$client = new Predis\Client([
	'port'=>6378
]);

$key = 'tekom';

try {
	$client->ftdropindex( 'idx:' . $key );
} catch (Predis\Response\ServerException $e) {
	echo "Index not found\n";
}

$fields = [
	new NumericField('$.uid', "uid"),
	new TextField('$.table', "table"),
	new TextField('$.text', "text"),
	new NumericField('$.pid', "pid"),
	new TextField('$.slug', "slug"),
	new VectorField( '$.embedding', 'FLAT' ,['TYPE','FLOAT32','DIM','1536','DISTANCE_METRIC','COSINE'],'vector')
];

$arguments = new CreateArguments();
$arguments->on('JSON' )->prefix( [$key.':'])->score(1.0);

$status = $client->ftcreate( 'idx:'.$key, $fields, $arguments);

var_dump($status);
/*
 *
 * ['ON JSON PREFIX 1 text: SCORE 1.0
SCHEMA
	$.uid NUMERIC
	$.table TEXT WEIGHT 1.0 NOSTEM
	$.text TEXT WEIGHT 1.0 NOSTEM
	$.embedding AS vector VECTOR FLAT 6 TYPE FLOAT32 DIM 1536 DISTANCE_METRIC COSINE
']
 */
