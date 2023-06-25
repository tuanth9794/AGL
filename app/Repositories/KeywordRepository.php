<?php

namespace App\Repositories;

use App\Interfaces\KeywordRepositoryInterface;

use App\Models\Keyword;
use App\Models\Website;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $website = $this->website->where('url', $request['website'])->first();
            $obj = $this->keyword->where('name', $request['keyword'])->where('website_id', $website->id)->first();
            if (!isset($obj)) {
                $obj = $this->store($request, $request['keyword'], $website);
            } else {
                $obj = $this->update($request, $obj, $website);
            }

        return $obj;
    }

    public function store($request, $keyword, $website)
    {
        return $website->keyword()->create(['name' => $keyword, 'slug' => Str::slug($keyword . '-' . time()),
            'is_active' => 1, 'is_publish' => 1, 'google_rank' => $request['google_rank'], 'google_searches' => $request['google_searches'],
            'yahoo_rank' => $request['yahoo_rank'], 'yahoo_searches' => $request['yahoo_searches']]);
    }

    public function update($request, $obj, $website)
    {
        $request['name'] = $obj->name;
        $request['slug'] = Str::slug($obj->name);
        $requestKeyword = new Keyword($request);
        DB::table('keywords')
            ->where('id', $obj->id)
            ->update($requestKeyword->attributesToArray());
        return $this->keyword->find($obj->id);

    }

}
