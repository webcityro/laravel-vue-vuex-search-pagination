<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\ProductRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider {

	public function register() {
		$this->app->bind(ProductRepositoryContract::class, ProductRepository::class);
	}
}
