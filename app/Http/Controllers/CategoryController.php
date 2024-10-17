<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::all();
        return response()->json($categories); // Return categories as JSON
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Create a new category
        $category = Category::create($request->all());

        // Return the created category
        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        // Return the specific category
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Update the category with new data
        $category->update($request->all());

        // Return updated category
        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // Delete the category
        $category->delete();

        // Return a success message
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
