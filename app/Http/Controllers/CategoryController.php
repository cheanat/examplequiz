<?php

namespace App\Http\Controllers;

use App\Models\Api\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // $categorys = Category::take(2)->get();
        $categorys = Category::get();
        return view('category.index',compact('categorys'));
    }
    public function create()
    {
        return view('category.create');

    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imageName = time().'.'.$request->image_url->extension();
        $request->image_url->move(public_path('images'), $imageName);

        // Save room details to database
        $room = new Category([
            'name' => $request->get('name'),
            'image_url' => 'images/'.$imageName,
        ]);
        $room->save();
        return redirect()->route('category.index')->with('success', 'Room created successfully.');
    }
    public function edit(Category $category){
        return view('category.edit',compact('category'));

    }
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Image is optional
        ]);

        // Check if a new image is uploaded
        if ($request->hasFile('image_url')) {
            // Handle file upload
            $imageName = time().'.'.$request->image_url->extension();
            $request->image_url->move(public_path('images'), $imageName);

            // Update the room details with the new image
            $category->image_url = 'images/'.$imageName; // Save relative path to image
        }

        // Update room details
        $category->name = $request->get('name');
        $category->save();

        return redirect()->route('category.index')->with('success', 'Room updated successfully.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Room deleted successfully.');
    }
}
