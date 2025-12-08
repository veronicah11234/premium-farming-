<?php
namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
// Display all main categories
public function index()
{
$categories = Category::all();
return view('categories.index', compact('categories'));
}


// Show feeds inside a category
public function show($slug)
{
    $category = Category::where('slug', $slug)->firstOrFail();
    $feeds = $category->feeds;

    return view('shop.categories.show', compact('category', 'feeds'));
}



// Store a new category
public function store(Request $request)
{
$validated = $request->validate([
'name' => 'required|unique:categories,name',
'slug' => 'required|unique:categories,slug',
'description' => 'nullable|string',
'image' => 'nullable|string',
]);


Category::create($validated);
return redirect()->back()->with('success', 'Category created successfully');
}


// Update a category
public function update(Request $request, Category $category)
{
$validated = $request->validate([
'name' => 'required',
'slug' => 'required',
'description' => 'nullable|string',
'image' => 'nullable|string',
]);


$category->update($validated);
return redirect()->back()->with('success', 'Category updated successfully');
}


// Delete a category
public function destroy(Category $category)
{
$category->delete();
return redirect()->back()->with('success', 'Category deleted successfully');
}
}