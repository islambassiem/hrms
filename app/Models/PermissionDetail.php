<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionDetail extends Model
{
  use HasFactory;
  protected $table = 'permission_details';
  protected $guarded = [];
}
