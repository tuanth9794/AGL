<?php

namespace App\Http\Controllers;

use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Keyword;
use App\Models\Website;
use Illuminate\Database\QueryException;
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

    public function show(Request $request)
    {
        try {

            $requestArr = [];
            $requestArr['website'] = htmlspecialchars($_GET["website"]);
            $requestArr['keyword'] = explode(',',$_GET["keyword"]);

            $requestArr = $this->requestValidate($requestArr);
            $this->website->isset($requestArr);

            $yahoo = $this->checkYahooRank($requestArr);
            $google = $this->checkGoogleRank($yahoo);

            $keywords = $this->keyword->show($google);
            return response()->json($keywords);

        } catch (QueryException $e) {
            return $e;
        }
    }

    public function requestValidate($requestArr)
    {

        if ($requestArr['website'] == null || $requestArr['keyword'] == null) {
            dd('Dữ liệu thiếu hoặc không chính xác');
        }

        if (strpos($requestArr['website'], 'http://') !== true || strpos($requestArr['website'], 'https://') !== true
            || strpos($requestArr['website'], 'https://www.') !== true || strpos($requestArr['website'], 'http://www.') !== true ||
            strpos($requestArr['website'], 'www.') !== true) {
            $requestArr['website'] = 'https://' . $requestArr['website'];
        }
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $requestArr['website'])) {
            dd('Địa chỉ website không hợp lệ');
        } elseif (count($requestArr['keyword']) == 0 || count($requestArr['keyword']) > 5) {
            dd('số lượng từ khóa tìm kiếm tối đa là 5');
        }
        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        foreach($requestArr['keyword'] as $keyword){
            if ((preg_match($pattern, $keyword))){
                dd('Từ khóa không đúng định dạng');
            }
            $keyword = Str::lower($keyword);
        }

        return $requestArr;
    }

    public function checkGoogleRank($googleArr)
    {
        $googleArr['google_rank']=rand(1,50);
        $googleArr['google_searches']=rand(1000,100000);
        return $googleArr;

        $country = "en";
        $domain = "stackoverflow.com";
        $keywords = "php google keyword rank checker";
        $firstnresults = 50;

        $rank = 0;
        $urls = array();
        $pages = ceil($firstnresults / 10);
        for ($p = 0; $p < $pages; $p++) {
            $start = $p * 10;
            $baseurl = "https://www.google.com/search?hl=" . $country . "&output=search&start=" . $start . "&q=" . urlencode($keywords);
            $html = file_get_contents($baseurl);

            $doc = phpQuery::newDocument($html);
            dd($doc);
            foreach ($doc['#ires cite'] as $node) {
                $rank++;
                $url = $node->nodeValue;
                $urls[] = "[" . $rank . "] => " . $url;
                if (stripos($url, $domain) !== false) {
                    break(2);
                }
            }
        }
        dd($urls);
        return urls;
    }

    public function checkYahooRank($request){
        $request['yahoo_rank']=rand(1,50);
        $request['yahoo_searches']=rand(1000,100000);

        return $request;
    }

}
