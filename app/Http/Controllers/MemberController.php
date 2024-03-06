<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
//Userlists Page
public function userlistsPage(){
        $userlists = User::when(request('key'),function($q){
                    $q->where('name','like','%'.request('key').'%');
        })
                    ->where('role','user')->paginate(5);
        // dd($userlists->toArray());
        return view('admin.member.userlists',compact('userlists'));
}
// To change userlist role
public function userlistChange(Request $request){
        User::where('id',$request->id)->update([
            'role' => $request->status
        ]);
        return response()->json();
}
// To show admin list
public function adminlistsPage(){
        $adminlists = User::when(request('key'),function($q){
            $q->where('name','like','%'.request('key').'%');
            })
                         ->where('role','admin')->get();
        return view('admin.member.adminlists',compact('adminlists'));
}
// To show Deli list
public function delilistsPage(){
        $deli = User::when(request('key'),function($q){
            $q->where('name','like','%'.request('key').'%');
            })
                         ->where('role','deli')->get();
            return view('admin.member.delilists',compact('deli'));
}
}
