<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BulkImport extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['batches' => 'json'];
}
