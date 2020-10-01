<?php

namespace App\Repositories\Contracts;

use App\Search\Queries\Search;
use App\Http\Requests\SearchFormRequest;

interface ProductRepositoryContract {

	public function search(SearchFormRequest $request): Search;
}
