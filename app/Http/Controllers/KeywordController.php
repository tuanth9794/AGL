<?php

namespace App\Http\Controllers;

use App\Interfaces\KeywordRepositoryInterface;
use App\Interfaces\WebsiteRepositoryInterface;
use App\Models\Keyword;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKeywordRequest;
use App\Http\Requests\UpdateKeywordRequest;

class KeywordController extends Controller
{
   public function __construct(KeywordRepositoryInterface $keyword, WebsiteRepositoryInterface $website)
    {
        $this->keyword = $keyword;
        $this->website = $website;
    }
    
    public function form(){
    	 return view('home');
    }
    public function index(Request $request)
    {
    $websiteSlug = $request->website;
    $keywordSlug = $request->keyword;
    
    $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/'; 
		if($websiteSlug == null || $keywordSlug == null){
			return redirect()->back();
		}elseif(preg_match($pattern, $keywordSlug) || preg_match($pattern, $websiteSlug)){
			return view('errors.404');
		}
		
        $website = $this->website->findByField('slug','$websiteSlug')->first();
        $lists = $website->keyword->where('slug','$keywordSlug');
		dd($lists);
        return response()->json($lists, 200);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $post = Post::create($data);

        return response()->json($post, 200);
    }

    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    public function update(Request $request, Post $post)
    {
        $data = $request->all();
        $post->update($data);

        return response()->json($post, 200);
    }

    public function delete(Post $post)
    {
        $post->delete();
        $posts = Post::orderBy('id', 'desc')->get();

        return response()->json($posts, 200);
    }
}
