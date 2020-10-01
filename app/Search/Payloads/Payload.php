<?php

namespace App\Search\Payloads;

use Illuminate\Contracts\Support\Arrayable;

abstract class Payload implements Arrayable {

	abstract public function hasFilter(): bool;
}
