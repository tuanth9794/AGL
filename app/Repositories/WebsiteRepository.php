<?php

namespace App\Repositories;

use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Website;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

class WebsiteRepository implements WebsiteRepositoryInterface
{
    private $website;

    public function __construct(Website $website)
    {
        $this->website = $website;
    }

    public function isset($requestArr)
    {
        $website = $this->website->where('url', $requestArr['website'])->first();
        if (!isset($website)) {
            $this->store($requestArr);
        }
        return;
    }

    public function store($request)
    {
            $request['url'] = $request['website'];
            $request['name'] = $request['website'];
            $request['slug'] = Str::slug($request['name']);
            $request['is_active'] = 1;
            $request['is_publish'] = 1;

            $this->website->create($request);
            return;
    }
}
