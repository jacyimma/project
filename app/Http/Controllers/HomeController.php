<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\UserPosts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\PostCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $users = User::where('id','!=',Auth::id())->get();

        $categories = $request->get('categories');
        $parsed = [];

        $distrubute_post = [];
        if(!empty($request->get('categories'))){
            $parsed = explode("&",$request->get('categories'));

            $distrubute_post = UserPosts::whereHas('post_categories', function($q) use($parsed) {
                $q->whereIn('category_id', $parsed);
            })->get();
        }
        
        $posts = empty($request->get('categories')) ? UserPosts::all() : $distrubute_post;

        $new_ar = array();
        $query_str = "";

        for($x = count($posts)-1;$x >= 0;$x--){
            array_push($new_ar,$posts[$x]);
        }

        for($x = 0;$x < count($parsed);$x++){
            $query_str .= $parsed[$x];
        }

        $this->data['users'] = $users;
        $this->data["posts"] = $new_ar;
        $this->data['parsed'] = $parsed;
        $this->data['prev'] = $query_str;
        return view('home',$this->data);
    }
    public function savePostCategory(Request $request){

    }
    public function editProfile(Request $request){
        $phone = $request->get('phone');
        $about = $request->get('about');
        
        $object = Profile::where("user_id",Auth::id())->first();
        $object["phone"] = $phone;
        $object["about-me"] = $about;

        $object->save();

        return back();
    }
    public function addPost(Request $request){
        
        $request->validate([
            'content' => 'required',
            'categories' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Only allow .jpg, .bmp and .png file types.
        ]);
        $categories = explode("&",$request->get('categories'));
        $new_category = array();

        for($x = 0;$x < count($categories);$x++){
            array_push($new_category, PostCategory::where('id',(int)$categories[$x])->get()[0]->id);
        }

        $file = $request->file('image') ;
        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);

        $post = new UserPosts([
            "content" => $request->get('content'),
            "slug" => $fileName.$request->get('content'),
            "image" => $fileName,
            "user_id" => Auth::id()
        ]);

        $post->save(); 

        $category = PostCategory::find($new_category);
        $post->post_categories()->attach($category);

        return back();
    }
}
