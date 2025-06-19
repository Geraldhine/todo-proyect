<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TaskList;
use App\Models\User;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'task_list_id'];

     // una tarea pertenece a una lista de tareas
    public function List()
    {
        return $this->belongsTo(TaskList::class);
    }
}
