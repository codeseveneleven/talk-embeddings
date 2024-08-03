<?php

use SUDHAUS7\Embeddings\Embedding;

require "vendor/autoload.php";

$embedding = new Embedding();

$client = new Predis\Client([
	'port'=>6378
]);



$pdo = new PDO('mysql:host=127.0.0.1;dbname=tekom_relaunch', 'root', '');

$res = $pdo->query('select p.title,p.slug,tt.* from tt_content tt 
join pages p on tt.pid=p.uid 
where tt.deleted=0 and tt.hidden=0 and bodytext !="" and p.uid in (
select pages.uid  from pages 
left join pages p1 on pages.pid=p1.uid
left join pages p2 on p1.pid=p2.uid
left join pages p3 on p2.pid=p3.uid
left join pages p4 on p3.pid=p4.uid
left join pages p5 on p4.pid=p5.uid
left join pages p6 on p5.pid=p6.uid
where (pages.uid=44 or p1.uid=44 or p2.uid=44 or p3.uid=44 or p4.uid=44 or p5.uid=44 or p6.uid=44) and pages.deleted=0
)
');
$res->execute();

while($row = $res->fetch(PDO::FETCH_ASSOC)) {
	//print_r( $row);

	$text = sprintf("%s\n%s\n%s",$row['title'],$row['header'],strip_tags( $row['bodytext']));

	$key = 'tekom:'.$row['uid'];
	$set = [
		'uid'=>$row['uid'],
		'pid'=>$row['pid'],
		'slug'=>$row['slug'],
		'table'=>'tt_content',
		'text' => $text,
		'embedding'=>$embedding->calculateEmbedding( $text)
	];



	$client->jsonset( $key, '$', json_encode($set) );


	echo $key,"\n";
}

