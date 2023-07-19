<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Http\Requests\StoreLetterRequest;
use App\Http\Requests\UpdateLetterRequest;

class LetterController extends Controller
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
  public function store(StoreLetterRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Letter $letter)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Letter $letter)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateLetterRequest $request, Letter $letter)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Letter $letter)
  {
    //
  }
}
