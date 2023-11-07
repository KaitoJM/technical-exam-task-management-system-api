<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const OPEN = 'open';
    const INPROGRESS = 'in progress';
    const COMPLETED = 'completed';

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'created_by',
        'assignee_id',
        'status',
    ];
}
