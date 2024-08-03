<?php

use SUDHAUS7\Embeddings\Embedding;
use PDO;

require "vendor/autoload.php";

$embedding = new Embedding();

$client = new Predis\Client([
	'port'=>6378
]);
$client->set('foo', 'bar');


$pdo = new PDO('mysql:host=127.0.0.1;dbname=ekd-devel', 'root', '');

$res = $pdo->query('select uid,losungstext,lehrtext from tx_ekdpluginkalenderblatt_domain_model_losung where deleted=0 and hidden=0 and sys_language_uid=0');
$res->execute();

while($row = $res->fetch(PDO::FETCH_ASSOC)) {
	//print_r( $row);

	$key1 = 'text:'.$row['uid'].':1';
	$set1 = [
		'uid'=>$row['uid'],
		'table'=>'tx_ekdpluginkalenderblatt_domain_model_losung',
		'text' => $row['losungstext'],
		'embedding'=>$embedding->calculateEmbedding( $row['losungstext'])
	];

	$key2 = 'text:'.$row['uid'].':2';
	$set2 = [
		'uid'=>$row['uid'],
		'table'=>'tx_ekdpluginkalenderblatt_domain_model_losung',
		'text' => $row['lehrtext'],
		'embedding'=>$embedding->calculateEmbedding( $row['lehrtext'])
	];

	$client->jsonset( $key1, '$', json_encode($set1) );
	$client->jsonset( $key2, '$', json_encode($set2) );

	echo $key1,' ',$key2,"\n";
}

