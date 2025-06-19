# 📋 Task Manager — Aplicación de Gestión de Tareas

Task Manager es una aplicación web sencilla pero potente para la gestión de tareas personales, desarrollada con **Laravel**, **Livewire**, **Blade Components personalizados** (`flux:*`) y **Tailwind CSS**.

Permite crear múltiples listas, agregar tareas a cada una, editarlas, eliminarlas y marcarlas como completadas, todo en una interfaz moderna y reactiva.

---

## 🚀 Características

- 📑 Crear y gestionar múltiples listas de tareas
- 📝 Agregar, editar y eliminar tareas
- ✅ Marcar tareas como completadas mediante checkbox
- ⚡ Interacción dinámica sin recargar la página usando Livewire
- 🎨 Interfaz responsiva con Tailwind CSS
- 🧩 Componentes personalizados reutilizables (`flux:*`)

---

## 🛠️ Requisitos del sistema

- PHP >= 8.1
- Laravel >= 10
- Composer
- Node.js y npm
- Base de datos SQLite (por defecto) u otro motor compatible

---

## 🔧 Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/tu-usuario/task-manager.git
   cd task-manager
2. Instalar dependencias PHP:

composer install

3. Copiar archivo de entorno y generar clave:

cp .env.example .env
php artisan key:generate

4. Configurar base de datos en .env (ejemplo con SQLite):

DB_CONNECTION=sqlite
DB_DATABASE=/ruta/a/database.sqlite

5. ⚠️ Crea el archivo SQLite si no existe:

touch database/database.sqlite

6. Ejecutar migraciones:

php artisan migrate
7. Instalar y compilar assets:

npm install
npm run dev

8. ▶️ Ejecutar el proyecto
Inicia el servidor local de Laravel:


php artisan serve
Accede a la aplicación desde tu navegador:
👉 http://localhost:8000

## 📂 Estructura del Proyecto
app/Http/Livewire/TaskManager.php → Componente Livewire principal

resources/views/livewire/task-manager.blade.php → Vista principal

resources/views/components/flux/ → Componentes personalizados (flux:*)

database/migrations/ → Migraciones para task_lists y tasks

## 📌 Mejoras Planeadas
🔐 Autenticación de usuarios

🔍 Filtro de tareas por estado (completadas/pendientes)

📄 Paginación de tareas extensas

⏱️ Prioridades y fechas límite

## 🧑‍💻 Autor
Desarrollado por GERALDHINE CHICLLA ORIHUELA, Bachiller de Ingeniería de Sistemas con enfoque en desarrollo web full stack.

<img width="947" alt="image" src="https://github.com/user-attachments/assets/23e9b143-96ea-478b-8798-7e8f1760de4c" />


