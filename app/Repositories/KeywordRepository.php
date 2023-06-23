<?php

namespace App\Repositories;

use App\Interfaces\KeywordRepositoryInterface;
use App\Models\Keyword;
use App\Models\Website;

class KeywordRepository implements KeywordRepositoryInterface
{
private $keyword;
    public function __construct(Keyword $keyword, Website $website)
    {
        $this->keyword = $keyword;
        $this->website = $website;
    }

    public function show($request)
    {
        $website = $this->website->findByField('url',$request->website)->first();
        if(!isset($website)){
            $this->website->create();
        }
        $keywords = [];
        foreach ($request->keyword as $key){
            $keyword = $website->keyword->where('name',$keyword)->sortBy('rank');

        }
        return $keywords;
    }

    public function store($request)
    {
        return $this->keyword->create($request->all());
    }

}
