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
use function Monolog\toArray;

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
            $keywords = [];
            $requestArr['website'] = htmlspecialchars($_GET["website"]);
            $requestArr['keyword'] = explode(',', $_GET["keyword"]);

            $requestArr = $this->requestValidate($requestArr);
            $this->website->isset($requestArr);

            foreach ($requestArr['keyword'] as $keyword){
                $requestArr['keyword'] = $keyword;
                $yahoo = $this->checkYahooRank($requestArr,$keyword);
                $google = $this->checkGoogleRank($yahoo,$keyword);
                $keyword = $this->keyword->show($google);
                $keyword['google_searches'] = number_format($keyword['google_searches'],0);
                $keyword['yahoo_searches'] = number_format($keyword['yahoo_searches'],0);
                array_push($keywords,$keyword);
            }

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
        foreach (['http://','https://','www.','http://www.','https://www.'] as $http){
            if(strpos($requestArr['website'],$http) !== false){
                $exp = explode($http,$requestArr['website']);
                $requestArr['website'] = $exp[1];
            }
        }
        if (strpos($requestArr['website'], 'http://') !== true || strpos($requestArr['website'], 'https://') !== true
            || strpos($requestArr['website'], 'https://www.') !== true || strpos($requestArr['website'], 'http://www.') !== true ||
            strpos($requestArr['website'], 'www.') !== true) {
            $requestArr['website'] = $requestArr['website'];
        }
        if (!preg_match("/\b[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $requestArr['website'])) {
            dd('Địa chỉ website không hợp lệ');
        } elseif (count($requestArr['keyword']) == 0 || count($requestArr['keyword']) > 5) {
            dd('số lượng từ khóa tìm kiếm tối đa là 5');
        }
        $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
        foreach ($requestArr['keyword'] as $keyword) {
            if ((preg_match($pattern, $keyword))) {
                dd('Từ khóa không đúng định dạng');
            }
            $keyword = Str::lower($keyword);
        }

        return $requestArr;
    }

    public function checkGoogleRank($request,$keyword)
    {

        $GOOGLE_API_KEY = 'AIzaSyAs-QohEtDl-dlbX6dyB-CUd5gfFFQViJ0';
        $GOOGLE_CSE_CX = '90a7f885c6c6247f2';
        $query = urlencode($keyword);
        $domain = $request['website'];
        $pages = 5;
        $gl = "vi";
        $hl = "vi";

        $found = false;
        for ($page = 1; $page <= $pages && $found == false; $page++) {
            $apiurl = sprintf('https://www.googleapis.com/customsearch/v1?q=%s&cx=%s&key=%s&hl=%s&gl=%s&start=%d', $query, $GOOGLE_CSE_CX, $GOOGLE_API_KEY, $hl, $gl, ($page - 1) * 10 + 1);
            $json = file_get_contents($apiurl);
            $obj = json_decode($json);

            $i = 0;
            foreach ($obj->items as $idx => $item) {
                $i+= 1;
                if (strpos($item->link, $domain)!== false) {
                    $found = true;
                    $request['google_rank'] = $i;
                    $request['google_searches'] = $obj->queries->request[0]->totalResults;
                    return $request;
                }
            }
        }
        if ($found !== true) {
            $request['google_rank'] = 0;
            $request['google_searches'] = '0';
            return $request;
        }
    }

    public function checkYahooRank($request,$keyword)
    {
        $request['yahoo_rank'] = rand(1, 50);
        $request['yahoo_searches'] = rand(1000, 100000);

        return $request;
    }

}
