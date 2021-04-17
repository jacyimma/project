<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPosts;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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
    public function index()
    {
        $users = User::where('id','!=',Auth::id())->get();

        $posts = UserPosts::all();

        $new_ar = array();

        for($x = count($posts)-1;$x >= 0;$x--){
            array_push($new_ar,$posts[$x]);
        }

        $this->data['users'] = $users;
        $this->data["posts"] = $new_ar;
        return view('home',$this->data);
    }
    public function addPost(Request $request){
        $request->validate([
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048' // Only allow .jpg, .bmp and .png file types.
        ]);

        $file = $request->file('image') ;
        $fileName = $file->getClientOriginalName() ;
        $destinationPath = public_path().'/images/' ;
        $file->move($destinationPath,$fileName);

        $post = new UserPosts([
            "content" => $request->get('content'),
            "slug" => $fileName,
            "image" => $fileName,
            "user_id" => Auth::id()
        ]);
        $post->save(); 
        return redirect('/home');
    }
}
