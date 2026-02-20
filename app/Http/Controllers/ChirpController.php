<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController extends Controller
{

// The AuthorizesRequests trait provides convenient methods for authorizing actions
// based on policies, enabling you to check if the current user is allowed to perform
// a given action on a model or resource.
use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user')->latest()->take(50)->get();

        return view('home', ['chirps' => $chirps]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
        'message' => 'required|string|max:255',
    ], [
        'message.required' => 'Please write something to chirp!',
        'message.max' => 'Chirps must be 255 characters or less.',
    ]);
     
        // Create the chirp (no user for now - we'll add auth later)
        Auth()->user()->chirps()->create($validated);
     
        // Redirect back to the feed
        return redirect('/')->with('success', 'Chirp created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * url must be formated with id in the middle: /chirps/{{ $chirp->id }}/edit"
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        // We'll add authorization in lesson 11
        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     * Url format: /chirps/{{ $chirp->id }}
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        // if ($request->user()->cannot('update', $chirp)) {
        //     abort(403);
        // }

        // Validate
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);
     
        // Update
        $chirp->update($validated);
     
        return redirect('/')->with('success', 'Chirp updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();
     
        return redirect('/')->with('success', 'Chirp deleted!');
    }
}
