<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve all documents with user association
        $documents = Document::with(['users', 'category'])->get();
        return response()->json($documents);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // You can return a view for the form to upload documents
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'document' => 'required|file', // Ensure a file is uploaded
            'category_id' => 'required|integer|exists:categories,id',
            'user_id' => 'required|integer|exists:users,id' // Ensure a valid user_id is provided
        ]);

        // Handle file upload and store it in the 'public/documents' directory
        if ($request->hasFile('document')) {
            $file = $request->file('document');
            $filePath = $file->store('documents', 'public'); // Store the file in the 'public/documents' folder

            // Save document data to the database
            $document = Document::create([
                'name' => $request->input('name'),
                'path' => $filePath, // Save the file path to the database
                'category_id' => $request->input('category_id')
            ]);

            // Now create the association with the user
            $document->users()->attach($request->input('user_id')); // Attach the document to the user

            return response()->json([
                'success' => true,
                'message' => 'Document uploaded and associated with user successfully!',
                'document' => $document
            ], 201);
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response()->json($document);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'string|max:255',
            'category_id' => 'integer|exists:categories,id',
            'user_id' => 'integer|exists:users,id' // Optional if you want to allow user updates
        ]);

        // Update the document attributes
        $document->update($request->only(['name', 'category_id']));

        // If a user_id is provided, update the association
        if ($request->has('user_id')) {
            $document->users()->sync($request->input('user_id')); // Sync user association
        }

        return response()->json([
            'success' => true,
            'message' => 'Document updated successfully!',
            'document' => $document
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        // Delete the file from storage
        Storage::disk('public')->delete($document->path);

        // Delete the document from the database
        $document->delete();

        return response()->json(['message' => 'Document deleted successfully']);
    }
}
