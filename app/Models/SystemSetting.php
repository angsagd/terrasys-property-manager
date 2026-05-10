<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['setting_key', 'setting_value', 'setting_type', 'description'])]
class SystemSetting extends Model
{
}
