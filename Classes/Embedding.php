<?php

namespace SUDHAUS7\Embeddings;


class Embedding extends AbstractOpenAi {

	public function __construct() {
		parent::__construct(getenv('OPENAIKEY'));
	}

}
