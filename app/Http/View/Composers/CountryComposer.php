<?php

namespace App\Http\View\Composers;

use App\Country;
use Illuminate\View\View;

class CountryComposer
{
    protected $country;

    public function __construct(Country $country)
    {
        $this->country = $country;
    }

    public function compose(View $view)
    {
        $view->with('countries', $this->country->getCachedCountries());
    }
}