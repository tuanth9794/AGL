<?php

namespace App\Repositories;

use App\Interfaces\KeywordRepositoryInterface;
use App\Models\Keyword;

class KeywordRepository implements KeywordRepositoryInterface
{
private $keyword;
    public function __construct(Keyword $keyword)
    {
        $this->keyword = $keyword;
    }

    public function show()
    {
        return $this->keyword->all();
    }
    
    public function store($request)
    {
        return $this->keyword->create($request->all());
    }

}
