<?php

namespace App\Search\Payloads;

class SearchOnlyPayload extends Payload {

	public $search;

	public function __construct(string $search = null) {
		$this->search = $search;
	}

	public function toArray(): array {
		return [
			'search' => (string)$this->search
		];
	}

	public function hasFilter(): bool {
		return (bool)$this->search;
	}
}
