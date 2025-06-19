<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class TaskList extends Model
{
    /** @use HasFactory<\Database\Factories\TaskListFactory> */
    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //Un usuario puede tener muchas listas de tareas

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Una lista de tareas puede tener muchas tareas
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
