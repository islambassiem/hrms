<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use App\Http\Requests\StoreVacationRequest;
use App\Http\Requests\UpdateVacationRequest;

class VacationController extends Controller
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
  public function store(StoreVacationRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Vacation $vacation)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Vacation $vacation)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateVacationRequest $request, Vacation $vacation)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Vacation $vacation)
  {
    //
  }
}
