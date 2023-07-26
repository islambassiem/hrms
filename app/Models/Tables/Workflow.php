<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
  use HasFactory;
  protected $table = 'lk_workflow_status';
  protected $guarded = [];
}
