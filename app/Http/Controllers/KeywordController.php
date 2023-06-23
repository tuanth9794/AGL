<?php

namespace App\Http\Controllers;

use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Keyword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;
use Inertia\Inertia;

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
   	 $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'description' => 'required' //optional if you want this to be required
        ]);
        
    	$response = $this->keyword->show();
        return response()->json(['message'=> 'keyword created', 
        'res' => $response]);
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


}
