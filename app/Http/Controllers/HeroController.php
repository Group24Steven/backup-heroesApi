<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Hero::query()->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $hero = Hero::create($request->all());
        return response()->json($hero, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        return response()->json($hero);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        if (!$hero) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $hero->update($request->all());
        return $this->show($hero);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        if (!$hero) {
            return response()->json(['error' => 'Resource not found'], 404);
        }

        $hero->delete();
        return response()->json(null, 204);
    }
}
