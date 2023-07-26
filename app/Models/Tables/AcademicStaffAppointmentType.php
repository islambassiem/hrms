<?php

namespace App\Models\Tables;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicStaffAppointmentType extends Model
{
  use HasFactory;
  protected $table = 'lk_academic_staff_appointment_types';
  protected $guarded = [];
}
