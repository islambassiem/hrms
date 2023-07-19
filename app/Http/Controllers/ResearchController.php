<?php

namespace App\Http\Controllers;

use App\Models\Research;
use App\Http\Requests\StoreResearchRequest;
use App\Http\Requests\UpdateResearchRequest;

class ResearchController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
  public function store(StoreResearchRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Research $research)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Research $research)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateResearchRequest $request, Research $research)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Research $research)
  {
    //
  }
}
