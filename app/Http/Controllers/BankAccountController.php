<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Http\Requests\StoreBankAccountRequest;
use App\Http\Requests\UpdateBankAccountRequest;

class BankAccountController extends Controller
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
  public function store(StoreBankAccountRequest $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(BankAccount $bankAccount)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(BankAccount $bankAccount)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateBankAccountRequest $request, BankAccount $bankAccount)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(BankAccount $bankAccount)
  {
    //
  }
}
