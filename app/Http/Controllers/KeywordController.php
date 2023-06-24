<?php

namespace App\Http\Controllers;

use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Keyword;
use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\LaravelPhpQuery\phpQuery;
class KeywordController extends Controller
{
    public function __construct(KeywordRepositoryInterface $keyword, WebsiteRepositoryInterface $website)
    {
        $this->keyword = $keyword;
        $this->website = $website;
    }

    public function index(Keyword $keyword)
    {
        return Inertia::render('Index');
    }

    public function show()
    {
        $website = htmlspecialchars($_GET["website"]);
        $keywordArray[] = $_GET["keyword"];
        $google = $this->checkGoogleRank($website,$keywordArray);
        return response()->json($google);

        $request->validate([
            'keyword' => 'required',
            'website' => 'required'
        ]);


        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$request->website)) {
            return redirect()->back();
        }elseif (count($request->keyword)==0){
            return redirect()->back();
        }
        $responses = $this->keyword->show($request);
        foreach ($responses as $response) {
            if ($response->searches == 1) {
                $response['googleRank'] = $response->rank;
                $response['googleSearch'] = $response->searches;
            } else {
                $response['yahooRank'] = $response->rank;
                $response['yahooSearch'] = $response->searches;
            }
        }
        return response()->json($google);
        return response()->json($responses);
    }

    public function store(Request $request)
    {
        $websiteSlug = $request->website;
        $keywordSlug = $request->keyword;

        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        if ($websiteSlug == null || $keywordSlug == null) {
            return redirect()->back();
        } elseif (preg_match($pattern, $keywordSlug) || preg_match($pattern, $websiteSlug)) {
            return view('errors.404');
        }

        $website = $this->website->findByField('slug', '$websiteSlug')->first();
        $lists = $website->keyword->where('slug', '$keywordSlug');
        dd($lists);
        return response()->json($lists, 200);
    }

    public function checkGoogleRank($website, $keywordArray){
        $googleArr = [];
        foreach ($keywordArray as $keyword){
            $google = Keyword::where('slug',Str::slug($keyword))->first();
            array_push($googleArr,$google);
        }
        return $googleArr;

        $country = "en";
        $domain = "stackoverflow.com";
        $keywords = "php google keyword rank checker";
        $firstnresults = 50;

        $rank = 0;
        $urls = Array();
        $pages = ceil($firstnresults / 10);
        for($p = 0; $p < $pages; $p++){
            $start = $p * 10;
            $baseurl = "https://www.google.com/search?hl=".$country."&output=search&start=".$start."&q=".urlencode($keywords);
            $html = file_get_contents($baseurl);

            $doc = phpQuery::newDocument($html);
            dd($doc);
            foreach($doc['#ires cite'] as $node){
                $rank++;
                $url = $node->nodeValue;
                $urls[] = "[".$rank."] => ".$url;
                if(stripos($url, $domain) !== false){
                    break(2);
                }
            }
        }
          dd($urls);
        return urls;
    }

}
