<?php

namespace SUDHAUS7\Embeddings;

use OpenAI;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use function in_array;

class AbstractOpenAi {

	public const MODELS = ['text-embedding-ada-002','text-embedding-3-small'];


	public string $model =  'text-embedding-ada-002';

	protected string $openaikey;
	protected AbstractAdapter $cache;
	public function __construct( string $openaikey ) {
		$this->openaikey = $openaikey;
		$this->cache = new FilesystemAdapter('',0,dirname(__DIR__).'/.cache');

	}

	public function getOpenaikey(): string {
		return $this->openaikey;
	}

	public function getCache(): AbstractAdapter {
		return $this->cache;
	}

	public function calculateEmbedding(string $text):array
	{
		$key = sha1($this->getModel() . $text);
		return $this->cache->get($key,function(ItemInterface $item) use ($text): array {
			$client = OpenAI::client($this->openaikey);
			$result = $client->embeddings()->create([
				"encoding_format"=> "float",
				'model'=>$this->getModel(),
				'input'=>$text,
			]);
			return $result->toArray()['data'][0]['embedding'];
		});
	}

	public function askGPT (string $prompt, string $systemprompt = 'You are a helpfull assistant', string $model='gpt-4o-mini'):string
	{

		$client = OpenAI::client($this->openaikey);
		$payload = [
			'model' => $model,
			'messages' => [
				['role' => 'system', 'content' => $systemprompt],
				['role' => 'user', 'content' => $prompt],
			],
		];

		$result = $client->chat()->create($payload);
		$answer = '';
		foreach ($result->choices as $choice) {
			$answer .= $choice->message->content;
		}
		return $answer;

	}


	function distance($a,$b):float
	{
		return 1 - ($this->dotp($a,$b) / sqrt($this->dotp($a,$a) * $this->dotp($b,$b)));
	}

	function dotp($a,$b):float
	{
		$products = array_map(function($a, $b) {
			return $a * $b;
		}, $a, $b);
		return (float)array_sum($products);
	}

	function vectorsubstract($a1,$a2):array
	{
		return array_map( function ( $x, $y ) {
			return  $x - $y;
		}, $a1, $a2 );
	}

	function vectoradd($a,$b): array
	{
		return array_map(function () {
			return array_sum(func_get_args());
		}, $a, $b);
	}


	public function generateDictionary(array $list) {
		$d = [];
		foreach ($list as $item) {
			$d[$item] = $this->calculateEmbedding( $item);
		}
		return $d;
	}

	public function calculateDistances($d1, $dictionary):array
	{
		$result = [];
		foreach ($dictionary as $item=>$d2) {
			$result[$item] = $this->distance( $d1, $d2);
		}
		asort($result);
		return $result;
	}

	public function getNearestNeighbour($d1, $dictionary)
	{
		$distances = $this->calculateDistances( $d1, $dictionary);
		$topkey = array_keys($distances)[0];
		return [$topkey, $distances[$topkey]];
	}

	public function getModel(): string
	{
		return $this->model;
	}

	public function setModel( string $model ): void
	{
		if ( in_array( $model, self::MODELS)) {
			$this->model = $model;
		}
	}

	public function normalizeRedisResult(array $result):array
	{
		$count = array_shift($result);
		$return = [];
		$key = null;
		foreach($result as $value) {
			if ($key===null) {
				$key=$value;
			} else {
				$values = [];
				for($i=0,$l=count($value);$i<$l;$i++) {
					$k = $value[$i];
					$i++;
					$v = $value[$i];
					$values[$k] = $v;
				}
				$return[ $key ] = $values;
            	$key            = null;
			}
		}

		return $return;
	}



}
