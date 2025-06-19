<?php

namespace App\Livewire;

use App\Models\TaskList;
use App\Models\Task;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\PseudoTypes\False_;

class TaskManager extends Component

{
    public bool $showCreateList = false;

    public string $newListName = '';

    public bool $isEditing = false;

    public bool $showFormTask = false;

    public TaskList $editingTasklList;

    public TaskList $selectedList;

    public Task $editingTask;


    public bool $isEditingTask = false;

    public string $taskName = "";

    public string $taskDescription = "";

    public function render()
    {
        return view(
            'livewire.task-manager',
            [
                'lists' => Auth::user()->lists, // Fetch task lists for the authenticated user



            ]
        );
    }

    public function prepareCreateList()
    {
        $this->showCreateList = true;
        $this->isEditing = false;
        $this->newListName = '';
    }
    public function CreateList()

    {

        //Validate the new list name
        $this->validate([
            'newListName' => 'required|string|max:255|regex:/^[^\d]+$/', // Allow only alphanumeric characters and spaces
        ]);

        if ($this->isEditing) {
            // If editing, update the existing task list
            $this->editingTasklList->update([
                'name' => $this->newListName,
            ]);
        } else {
            TaskList::create([
                'user_id' => Auth::user()->id,
                'name' => $this->newListName,

            ]);
        }

        // Reset the new list name and hide the create list form
        $this->newListName = '';
        $this->showCreateList = false;
        // Flash a success message

        session()->flash('success', 'List created successfully!');
    }

    public function EditList(TaskList $taskList)
    {
        $this->editingTasklList = $taskList;
        $this->showCreateList = true;
        $this->isEditing = true;

        $this->newListName = $taskList->name;
    }

    public function DeleteList(TaskList $taskList)
    {
        // Delete the task list
        $taskList->delete();

        session()->flash('success', 'List deleted successfully!');
    }

    public function selectList(TaskList $taskList)
    {
        $this->selectedList = $taskList;
    }

    public function createTask()
    {
        $this->validate([
            'taskName' => 'required|max:255',
            'taskDescription' => 'nullable|max:1000',
        ]);


        if ($this->isEditingTask) {
            $this->editingTask->update([
                'title' => $this->taskName,
                'description' => $this->taskDescription,
                'done_at' => null, // Reset done_at when editing
            ]);
        } else {
            $this->selectedList->tasks()->create([
                'title' => $this->taskName,
                'description' => $this->taskDescription,
                'done_at' => null, // Initialize done_at as null
            ]);
        }

        // Reset the task form fields
        $this->taskName = '';
        $this->taskDescription = '';
        $this->showFormTask = false;

        $this->reset(['taskName', 'taskDescription', 'showFormTask']);
        session()->flash('success', 'Task created successfully!');
    }

    public function EditTask(Task $task)
    {

        $this->editingTask = $task;
        $this->showFormTask = true;
        $this->isEditingTask = true;

        $this->taskName = $task->title;
        $this->taskDescription =    $task->description;
    }

    public function DeleteTask(Task $task)
    {
        // Delete the task
        $task->delete();

        session()->flash('success', 'Task deleted successfully!');
    }

}
