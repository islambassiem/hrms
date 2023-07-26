<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceType extends Model
{
  use HasFactory;
  protected $table = "lk_maintenance_types";
  protected $guarded = [];
}
