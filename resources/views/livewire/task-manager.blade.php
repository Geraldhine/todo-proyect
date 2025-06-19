{{-- 
    Vista Blade: task-manager.blade.php

    Descripción:
    Esta vista corresponde a la interfaz principal de la aplicación de gestión de tareas. Permite a los usuarios crear y visualizar listas de tareas, así como agregar, editar y eliminar tareas dentro de cada lista. Utiliza componentes personalizados (flux:button, flux:field, etc.) y está diseñada para integrarse con Livewire para la gestión reactiva de estados.

    Secciones principales:
    - Encabezado: Título y descripción de la aplicación.
    - Panel de Listas:
        - Muestra todas las listas existentes.
        - Permite crear una nueva lista mediante un formulario desplegable.
        - Botón para agregar nuevas listas.
        - Muestra el número de tareas por lista.
        - Mensaje cuando no hay listas disponibles.
    - Panel de Tareas:
        - Muestra las tareas de la lista seleccionada.
        - Permite crear una nueva tarea mediante un formulario.
        - Botones para editar y eliminar tareas.
        - Checkbox para seleccionar tareas.

    Notas:
    - Utiliza directivas de Livewire para la interacción dinámica (ej: wire:click, wire:model).
    - Los componentes flux:* son personalizados y deben estar definidos en el proyecto.
    - El diseño utiliza Tailwind CSS para estilos responsivos y modernos.
--}}

<div>
    {{-- Encabezado --}}
    <div class="max-w-5xl mx-auto px-4">
        <h1 class="text-xl font-bold mb-2">Aplicación de Tareas</h1>
        <p class="mb-4 text-sm text-gray-600">
            Organiza tus tareas de manera eficiente. Crea listas, agrega tareas y mantén un seguimiento de tu progreso.
        </p>
    </div>

    {{-- Contenedor principal --}}
    <div class="max-w-5xl mx-auto p-4 flex flex-col md:flex-row gap-4 text-sm">

        {{-- Panel de Listas --}}
        <div class="w-full md:w-1/2">
            <div class="bg-white text-black shadow-md rounded-lg p-4">

                {{-- Encabezado y botón --}}
                <div class="mb-3 flex gap-3 items-center">
                    <h2 class="text-lg font-semibold">Mis Listas</h2>
                    <flux:button wire:click="prepareCreateList">+ Nueva Lista</flux:button>
                </div>

                {{-- Formulario de lista --}}
                @if ($showCreateList)
                    <div class="flex flex-col bg-gray-100 rounded-lg mb-4 p-4 gap-3">
                        <h3 class="text-base font-semibold">{{ $isEditing ? 'Editar' : 'Nueva' }} Lista</h3>

                        <flux:field>
                            <flux:label>Nombre de la Lista</flux:label>
                            <flux:input wire:model="newListName" name="listName"
                                class="w-full bg-amber-50 text-black text-sm rounded-lg py-1 px-2"
                                placeholder="Nombre de la lista" />
                            <span class="text-red-500 text-xs">{{ $errors->first('newListName') }}</span>
                        </flux:field>

                        <div class="flex gap-2 mt-2">
                            <flux:button wire:click="CreateList" class="w-full">
                                {{ $isEditing ? 'Actualizar' : 'Guardar' }} Lista
                            </flux:button>
                            <flux:button wire:click="$set('showCreateList', false)" class="w-full">
                                Cancelar
                            </flux:button>
                        </div>
                    </div>
                @endif

                {{-- Listado de Listas --}}
                @if (!empty($lists) && $lists->isNotEmpty())
                    @foreach ($lists as $list)
                        <div @class([
                            'flex justify-between items-center border rounded-lg p-3 mb-2 cursor-pointer hover:bg-gray-50',
                            'bg-blue-100' => $selectedList && $selectedList->id === $list->id,
                        ])>
                            <div wire:click="selectList({{ $list->id }})" class="flex-1">
                                <span class="font-medium">{{ $list->name }}</span>
                                <p class="text-xs text-gray-500">{{ $list->tasks->count() }} Tareas</p>
                            </div>
                            <div class="flex gap-2">
                                <flux:button wire:click.prevent="EditList({{ $list->id }})">✏️</flux:button>
                                <flux:button wire:click.prevent="DeleteList({{ $list->id }})">🗑️</flux:button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-xs text-gray-500">No hay listas disponibles.</p>
                @endif
            </div>
        </div>

        {{-- Panel de Tareas --}}
        <div class="w-full md:w-1/2">
            @if ($selectedList)
                <div class="bg-white text-black shadow-md rounded-lg p-4">
                    <div class="mb-3 flex justify-between items-center">
                        <h2 class="text-lg font-semibold">Tareas de "{{ $selectedList->name }}"</h2>
                        <flux:button wire:click="$set('showFormTask', true)">+ Nueva Tarea</flux:button>
                    </div>

                    {{-- Formulario Nueva Tarea --}}
                    @if ($showFormTask)
                        <div class="bg-gray-100 rounded-lg mb-3 p-4 flex flex-col gap-3">
                            <h3 class="text-base font-semibold">{{ $isEditingTask ? 'Editar' : 'Nueva' }} Tarea</h3>
                            <flux:field>
                                <flux:label>Nombre de Tarea</flux:label>
                                <flux:input wire:model="taskName"
                                    class="bg-amber-50 text-sm py-1 px-2 rounded w-full"
                                    placeholder="Nombre de tarea" />
                                <span class="text-red-500 text-xs">{{ $errors->first('taskName') }}</span>
                            </flux:field>
                            <flux:field>
                                <flux:label>Descripción</flux:label>
                                <flux:input wire:model="taskDescription"
                                    class="bg-amber-50 text-sm py-1 px-2 rounded w-full"
                                    placeholder="Descripción" />
                                <span class="text-red-500 text-xs">{{ $errors->first('taskDescription') }}</span>
                            </flux:field>
                            <div class="flex gap-2">
                                <flux:button wire:click="createTask" class="w-full">
                                    {{ $isEditingTask ? 'Editar' : 'Crear' }} Tarea
                                </flux:button>
                                <flux:button wire:click="$set('showFormTask', false)" class="w-full">Cancelar</flux:button>
                            </div>
                        </div>
                    @endif

                    {{-- Lista de Tareas --}}
                    @if ($selectedList->tasks->isEmpty())
                        <p class="text-center text-gray-500 text-sm">No hay tareas en esta lista.</p>
                    @else
                        @foreach ($selectedList->tasks as $task)
                            <div class="flex justify-between items-center border rounded-lg p-3 mb-2 text-sm">
                                <flux:checkbox wire:click="toggleTaskCompletion({{ $task->id }})"
                                    {{ $task->done_at ? 'checked' : '' }} class="mr-3" />

                                <div class="flex-1">
                                    <p @class([
                                        'font-semibold',
                                        'line-through' => $task->done_at,
                                        'text-gray-500' => $task->done_at,
                                        'text-green-700' => !$task->done_at,
                                    ])>{{ $task->title }}</p>
                                    <p @class(['text-xs', 'line-through' => $task->done_at])>{{ $task->description }}</p>
                                </div>

                                <div class="flex gap-1">
                                    <flux:button wire:click="EditTask({{ $task->id }})">✏️</flux:button>
                                    <flux:button wire:click="DeleteTask({{ $task->id }})">🗑️</flux:button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            @else
                <div class="bg-white text-black shadow-md rounded-lg p-4 text-center text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto mb-2 text-gray-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <p class="text-gray-500">Selecciona una lista para ver sus tareas.</p>
                </div>
            @endif
        </div>

    </div>
</div>
