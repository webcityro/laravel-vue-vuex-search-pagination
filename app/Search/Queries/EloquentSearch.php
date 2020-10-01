<?php
namespace App\Search\Queries;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait EloquentSearch {

    public function total(): int {
		return $this->queryWithoutLimit()->count('id');
	}

	protected function queryWithoutLimit(): Builder {
		return $this->query()->orderBy($this->orderBy->field, $this->orderBy->direction);
	}

	abstract protected function query(): Builder;

	public function records(): Collection {
        return $this->limit($this->queryWithoutLimit())->get();
    }

	protected function limit(Builder $query): Builder {
		return $query->take($this->params->perPage)->skip(($this->params->page - 1) * $this->params->perPage);
	}
}
