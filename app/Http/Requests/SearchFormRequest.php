<?php
namespace App\Http\Requests;

use App\Search\Params;
use App\Search\OrderBy;

interface SearchFormRequest {

    public function requestParams(): Params;

    public function requestOrder(): OrderBy;
}
