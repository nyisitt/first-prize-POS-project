<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
//Post Create page
public function postCreate(){
        $post = Post::orderBy('created_at','DESC')->get();
        return view('admin.Post.postCreate',compact('post'));
}
// post create
public function createPost(Request $request){
        Validator::make($request->all(),[
            'text' => 'required',
        ])->validate();
            $data = [
                'post_text' => $request->text
            ];
            $random = random_int('1','1000000000');
            // dd($request->all());
            if($request->hasFile('images')){
                $images = $request->file('images');
                foreach($images as $image){
                    $imageName = uniqid()."_".$image->getClientOriginalName();
                    $image->storeAs('public',$imageName);
                     PostImage::create([
                        'images' => $imageName,
                        'post_code' => $random
                     ]);
                }
                $data['post_images'] = $random;
            }
            Post::create($data);
            return back()->with(['message' => 'Post Create is successful']);
}
// Post delete
public function deletPost($id){
      $image =  Post::where('id',$id)->select('post_images')->first();
      if($image->post_images !== null){
        $code = $image->post_images;
        $images = PostImage::where('post_code',$code)->select('images')->get();
        foreach($images as $item){
           $image = $item->images;
           Storage::delete(['public/'.$image]);
        }
        PostImage::where('post_code',$code)->delete();
      }
      Post::where('id',$id)->delete();
        // dd($image->toArray());
        return back()->with(['message' => 'Post Delete is successful']);
}
// Post Detail
public function detailPost($id){
        $post = Post::where('id',$id)->first();
        $image_code = $post->post_images;
        $images = PostImage::where('post_code',$image_code)->get();

        // dd($images->toArray());
        return view('admin.Post.postDetail',compact('post','images'));
}
// Post Edit
public function postEdit($id){
        $post = Post::where('id',$id)->first();
        $image_code = $post->post_images;
        $images = PostImage::where('post_code',$image_code)->get();
        return view('admin.Post.postEdit',compact('post','images'));
}
// Post image delete
public function postimageDelete($name){
       PostImage::where('images',$name)->delete();
       Storage::delete('public/'.$name);
       return back();
}
// post Update
    public function postUpdate(Request $request){
        // dd($request->all());
        Validator::make($request->all(),[
            'text' => 'required',
        ])->validate();
        if($request->hasFile('images')){
            $images = $request->file('images');
            $post_code = Post::where('id',$request->id)->select('post_images')->first();
            $post_code = $post_code->post_images;
            $random = random_int('1','1000000000');
            if($post_code !== null){
                foreach($images as $item){
                    $imageName = uniqid()."_".$item->getClientOriginalName();
                    $item->storeAs( 'public', $imageName);
                    PostImage::create([
                        'post_code' => $post_code,
                        'images' => $imageName
                    ]);
                }
            }else{
                foreach($images as $item){
                    $imageName = uniqid()."_".$item->getClientOriginalName();
                    $item->storeAs( 'public', $imageName);
                    PostImage::create([
                        'post_code' => $random,
                        'images' => $imageName
                    ]);
                }
                Post::where('id',$request->id)->update([
                    'post_images' => $random
                ]);
            }

        }
        Post::where('id',$request->id)->update([
            'post_text' => $request->text
        ]);
        return back()->with(['message' => 'Post Update is successful']);
    }
// Post Customer show
public function customerpostShow(){
        $posts = Post::orderBy('created_at','DESC')->get();
        $images = PostImage::get();
        return view('user.Post.show',compact('posts','images'));
}
// Post Like
public function postLike(Request $request){
        $like = Post::where('id',$request->id)->select('reaction')->first()->reaction;
        if($request->status == 'warning'){
        $like = $like - 1;
        $status = 'warning';
        }else{
        $like = $like + 1;
        $status = 'none';
        }
         Post::where('id',$request->id)->update([
            'reaction' => $like
        ]);
        return response()->json(['like' => $like,'status'=> $status]);

}
// Post unlike
public function postunLike(Request $request){

        $unlike = Post::where('id',$request->id)->select('unlike')->first()->unlike;
        if($request->status == 'warning'){
        $unlike = $unlike - 1;
        $status = 'warning';
        }else{
        $unlike = $unlike + 1;
        $status = 'none';
        }
         Post::where('id',$request->id)->update([
            'unlike' => $unlike
        ]);
        return response()->json(['unlike' => $unlike,'status'=> $status]);
}
}
