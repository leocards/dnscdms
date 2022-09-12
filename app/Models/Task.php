<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'area',
        'accredId',
        'programId',
        'parent',
        'role',
        'action',
        'dueDate',
        'dueTime',
        'status',
    ];

}
