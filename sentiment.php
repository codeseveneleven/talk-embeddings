<?php

use SUDHAUS7\Embeddings\Embedding;

require 'vendor/autoload.php';

$embedding = new Embedding();

$rateme     = $argv[1];
$dictionary = $embedding->generateDictionary( [

	'joy',
	'sadness',
	'anger',
	'fear',
	'surprise',
	'trust',
	'disgust',
	'anticipation',
	'love',
	'hate',
	'contentment',
	'excitement',
	'regret',
	'hope',
	'anxiety',
	'pride',
	'empathy',
	'gratitude',
	'relief',
	'nostalgia',
	'loneliness',
	'despair',
	'determination',
	'serenity',
	'frustration',
	'confidence',
	'compassion',
	'curiosity',
	'passion',
	'boredom',
	'amusement',
	'disbelief',
	'annoyance',
	'appreciation',
	'empathy',
	'awe',
	'inspiration',
	'comfort',
	'vulnerability',
	'skepticism',
	'satisfaction',
	'excitement',
	'indifference',
	'desire',
	'jealousy',
	'enthusiasm',
	'humility',
	'melancholy',
	'wonder',
	'wrath',
	'eagerness',
	'tenderness',
	'bitterness',
	'silliness',
	'disappointment',
	'enchantment',
	'fearlessness',
	'courage',
	'clarity',
	'sympathy',
	'restlessness',
	'tranquility',
	'ambition',
	'fascination',
	'hostility',
	'warmth',
	'disbelief',
	'resentment',
	'intrigue',
	'indifference',
	'optimism',
	'pessimism',
	'acceptance',
	'understanding',
	'determination',
	'playful',
	'unease',
	'intimacy',
	'resilience',
	'defeat',
	'connection',
	'abandonment',
	'fulfillment',
	'detachment',
	'kindness',
	'rivalry',
	'affection',
	'skepticism',
	'sentimentality',
	'indulgence',
	'boredom',
	'alertness',
	'exasperation',
	'longing',
	'detachment',
	'mindfulness',
	'indulgence',
	'determination',
	'embarrassment',
	'solace',
	'restlessness',
	'hopefulness',
	'fervor',
	'openness',
	'cynicism',
	'clarity',
	'intimacy',
	'bewilderment',
	'horror',
	'happiness',
] );

$distances = $embedding->calculateDistances(
	$embedding->calculateEmbedding( $rateme ),
	$dictionary
);
$filtered  = array_filter( $distances, function ( $val ) {
	return $val < 0.23;
} );
if (empty($filtered)) {
	$filtered  = array_filter( $distances, function ( $val ) {
		return $val < 0.25;
	} );
}

print_r( $filtered );
if ( empty( $filtered ) ) {
	print_r( $distances );
}
printf( 'the Input "%s" carries the sentiments  "%s"' . "\n", $rateme, implode( ', ', array_keys( $filtered ) ) );
