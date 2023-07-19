<?php

namespace App\Http\Controllers;

use App\Models\Dependent;
use App\Http\Requests\StoreDependentRequest;
use App\Http\Requests\UpdateDependentRequest;

class DependentController extends Controller
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
  public function store(StoreDependentRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Dependent $dependent)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Dependent $dependent)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateDependentRequest $request, Dependent $dependent)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Dependent $dependent)
  {
    //
  }
}
