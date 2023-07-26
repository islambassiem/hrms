<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttachmentType extends Model
{
  use HasFactory;
  protected $table = 'lk_attachment_types';
  protected $guarded = [];
}
