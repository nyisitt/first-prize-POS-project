<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
//create page
public function create(){
        $category = Category::get();
        return view('admin.category.create',compact('category'));
}
// category create
public function categoryPost(Request $request){
        $this->category($request);
        Category::create([
            'category' => $request->category
        ]);
        return back()->with(['message' => 'category create is successful.Tank you!']);
}

// subcategory create
public function subcategory(Request $request){
        $this->sub($request);
        SubCategory::create([
            'category' => $request->categories,
            'subcategory'=> $request->subcategory
        ]);
        return back()->with(['message' => 'Subcategory create is successful.Tank you!']);
}
// category show
public function show(){
        $category = Category::get();
        $subcategory = SubCategory::when(request('key'),function($q){
                         $q->orWhere('category','like','%'.request('key').'%')
                         ->orWhere('subcategory','like','%'.request('key').'%');
                        })->orderBy('created_at','desc')
                        ->paginate(5);
        $subcategory->appends(request()->all());
        return view('admin.category.show',compact('category','subcategory'));
}
// category delete
public function delete($id){
        Category::where('id',$id)->delete();
        return back()->with(['message' => 'Category delete is successful.You should be change sub category']);
    }
    public function subdelete(Request $request){

        SubCategory::whereIn('id',$request->ids)->delete();
        return back()->with(['message' => 'SubCategory delete is successful.']);
}
// category update
public function edit($id){
       $data = Category::where('id',$id)->first();
        return view('admin.category.categoryUpdate',compact('data'));
    }
    public function update(Request $request){
       $this->category($request);
       Category::where('id',$request->id)->update([
        'category' => $request->category
       ]);
       return redirect()->route('category#show')->with(['message' => 'category update is successful.You should be change sub category']);
    }
    public function subedit($id){
        $category = Category::get();
        $data = SubCategory::where('id',$id)->first();
        return view('admin.category.subcategoryUpdate',compact('data','category'));
    }
    public function subupdate(Request $request){
        $this->sub($request);
        SubCategory::where('id',$request->id)->update([
            'category' => $request->categories,
            'subcategory'=> $request->subcategory
        ]);
        return redirect()->route('category#show')->with(['message' => 'Subcategory update is successful']);
}

//********************* */ private function******************
    private function category($request){
        Validator::make($request->all(),[
            'category' => 'required|unique:categories,category,'.$request->id
        ])->validate();
    }
    private function sub($request){
        Validator::make($request->all(),[
            'categories' => 'required',
            'subcategory' => 'required|unique:sub_categories,subcategory,'.$request->id
        ])->validate();
    }

}
