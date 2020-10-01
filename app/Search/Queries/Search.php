<?php

namespace App\Search\Queries;

use App\Search\Meta;
use App\Search\OrderBy;
use App\Search\Params;
use Illuminate\Support\Collection;

abstract class Search {

	protected $params;
	protected $orderBy;

	public function __construct(Params $params, OrderBy $orderBy) {
		$this->params = $params;
		$this->orderBy = $orderBy;
	}

	public function meta(): Meta {
		$total = $this->total();
		$lastPage = $this->lastPage($total);

		return new Meta(
			$total,
			$lastPage,
			$this->prevPage(),
			$this->nextPage($lastPage)
		);
	}

	public function params(): Params {
		return $this->params;
	}

	abstract public function total(): int;

	abstract public function records(): Collection;

	protected function lastPage(int $total): int {
		return ceil($total / $this->params->perPage) ?: 1;
	}

	protected function prevPage(): ?int {
		return $this->params->page <= 1 ? null : $this->params->page - 1;
	}

	protected function nextPage(int $lastPage): ?int {
		return $this->params->page < $lastPage ? $this->params->page + 1 : null;
	}
}
