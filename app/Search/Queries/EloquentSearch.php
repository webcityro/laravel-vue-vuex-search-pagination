<?php
namespace App\Search\Queries;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

trait EloquentSearch {

    public function total(): int {
		return $this->queryWithoutLimit()->count('id');
	}

	protected function queryWithFilter(): Builder {
		if (!$this->params->search->hasFilter()) {
			return $this->query();
		}

		if (!$this->hasMultiFields()) {
			return $this->filter('search', $this->params->search->search);
		}

		$query = $this->query();

		if (!empty($this->params->search->fields)) {
			foreach ($this->params->search->fields as $field => $value) {
				$query = $this->filter($query, $field, $value);
			}
		}

		return $query;
	}

	protected function queryWithoutLimit(): Builder {
		return $this->queryWithFilter()->orderBy($this->orderBy->field, $this->orderBy->direction);
	}

	abstract protected function query(): Builder;

	abstract protected function filter(Builder $query, string $field, string $value): Builder;

	public function records(): Collection {
        return $this->limit($this->queryWithoutLimit())->get();
    }

	protected function limit(Builder $query): Builder {
		return $query->take($this->params->perPage)->skip(($this->params->page - 1) * $this->params->perPage);
	}
}
