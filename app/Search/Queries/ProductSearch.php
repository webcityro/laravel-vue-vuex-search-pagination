<?php

namespace App\Search\Queries;

use App\Product;
use Illuminate\Support\Collection;
use App\Search\Queries\EloquentSearch;
use Illuminate\Database\Eloquent\Builder;

class ProductSearch extends Search {

    use EloquentSearch;

    protected function query(): Builder {
        $query = Product::query();

        if ($this->params->search->hasFilter()) {
            $query->where('name', 'LIKE', '%'.$this->params->search->search.'%');
        }

        return $query;
    }
}
