<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authenticate;
use App\Models\Discussion;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use App\Models\User;

class DiscussionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(Authenticate::class);
        
    }
    public function create(){
        return view('new_post');
    }
    
    public function store(Request $request){
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $discussion = new Discussion();
        $discussion->user_id = auth()->user()->id;
        $discussion->title = $validatedData['title'];
        $discussion->description = $validatedData['description'];
        
        if($discussion->save()){
            return redirect()->route('home')->with('success');
        }
        else{
            return redirect()->route('create_post')->with('failure');
        }

    }
}
