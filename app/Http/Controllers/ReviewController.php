<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('approved', true)->orderBy('created_at','desc')->paginate(10);
        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'rating'=>'required|integer|min:1|max:5',
            'comment'=>'required|string|max:2000',
        ]);

        Review::create(array_merge($data, ['approved' => false])); // admin must approve
        return back()->with('success', 'Thanks for your review! It will appear after approval.');
    }
}
