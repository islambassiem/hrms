<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenericRequest extends Model
{
  use HasFactory;
  protected $table = 'generic_requests';
  protected $guarded = [];
}
