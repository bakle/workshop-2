<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Country extends Model
{
    public function getCachedCountries(): Collection
    {
        return Cache::remember('countries', now()->addDay(), function() {
            return $this->all();
        });
    }
}
