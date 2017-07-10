<?php

namespace BoardGameTracker\Http\Controllers;

use BoardGameTracker\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \BoardGameTracker\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \BoardGameTracker\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \BoardGameTracker\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bggUsername = $request->get('name');

        Collection::StoreUserCollection($bggUsername, $id);

        return redirect(route('user.show',['id' => $bggUsername]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \BoardGameTracker\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {

    }
}
