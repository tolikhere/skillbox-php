<?php

namespace App\Http\Controllers;

use App\Models\TelegraphText;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TextController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('telegraph.index', [
            'messages' => TelegraphText::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'title' => 'required|string',
            'author' => 'required|string'
        ]);

        TelegraphText::create($validated);

        return redirect(route('index'));
    }

        /**
     * Show the form for editing the specified resource.
     */
    public function edit(TelegraphText $telegraph): View
    {

        return view('telegraph.edit', [
            'telegraph' => $telegraph,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TelegraphText $telegraph): RedirectResponse
    {
        $validated = $request->validate([
            'text' => 'required|string',
            'title' => 'required|string',
            'author' => 'required|string',
        ]);

        $telegraph->update($validated);
        return redirect(route('index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(?int $id): RedirectResponse
    {
        $telegraph = TelegraphText::findOrFail($id);

        $telegraph->delete();

        return redirect(route('index'));
    }
}
