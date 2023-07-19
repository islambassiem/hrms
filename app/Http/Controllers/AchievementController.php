<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Http\Requests\StoreAchievementRequest;
use App\Http\Requests\UpdateAchievementRequest;

class AchievementController extends Controller
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
  public function store(StoreAchievementRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(Achievement $achievement)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Achievement $achievement)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateAchievementRequest $request, Achievement $achievement)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Achievement $achievement)
  {
    //
  }
}
