<?php

namespace App\Repositories;

use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Website;

class WebsiteRepository implements WebsiteRepositoryInterface
{
private $website;
    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function store()
    {
        return $this->website->all();
    }

}
