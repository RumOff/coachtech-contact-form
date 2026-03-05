<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index(){
        $categories = Category::all();
        
        return view('index', compact('categories'));
    }

    public function confirm(Request $request){
        $category = Category::find($request->category_id);
        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'detail',
            'category_id',
        ]);

        return view('confirm', compact('category', 'contact'));
    }

    public function store(Request $request){
        if ($request->action === 'back') {
            return redirect('/contact')->withInput();
        }

        $contact = $request->only([
            'last_name',
            'first_name',
            'gender',
            'email',
            'tel1',
            'tel2',
            'tel3',
            'address',
            'building',
            'detail',
            'category_id',
        ]);
        $contact['tel'] = $request->tel1 . $request->tel2 . $request->tel3;
        Contact::create($contact);

        return view('thanks');
    }

}
