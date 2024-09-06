<?php

use SUDHAUS7\Embeddings\Embedding;

require_once "vendor/autoload.php";

$testBias = new Embedding();

$female_profession = $testBias->calculateEmbedding( 'female profession');
$male_profession = $testBias->calculateEmbedding( 'male profession');

$jobs = [
	'Doctor',
	'Nurse',
	'Pilot',
	'Flight Attendant',
	'Teacher',
	'Professor',
	'Lawyer',
	'Paralegal',
	'Dentist',
	'Medical Examiner',
	'Programmer',
	'Software Developer',
	'Software Engineer',
	'Data Entry Operator',
	'PHP Programmer',
	'Web Developer',
	'Web Designer',
	'Assistant',
	'Secretary',
	'Assistant to the CEO',
	'CEO',
];


foreach ($jobs as $job) {
	$job_embedding = $testBias->calculateEmbedding($job);
	$d1 = $testBias->distance( $job_embedding, $female_profession );
	$d2 = $testBias->distance( $job_embedding, $male_profession );
	echo str_pad(sprintf("%s is a profession for %s.", $job, $d1 < $d2 ? 'WOMEN' : 'MEN'),40);

	printf("\tfemale: %5f", $d1);
	printf(" male: %5f\n", $d2);
}


