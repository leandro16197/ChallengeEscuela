# 📚 Challenge Escuela

Sistema de gestión escolar desarrollado en **Laravel**, que permite administrar cursos, usuarios y calificaciones mediante roles (Admin, Profesor y Estudiante).

---

## 🚀 Tecnologías utilizadas

- Laravel 10+
- PHP 8+
- MySQL
- Blade (Laravel)
- Tailwind CSS
- jQuery
- DataTables AJAX

---

## 👥 Roles del sistema

### 🔵 Admin
- Gestión de usuarios
- Gestión de cursos
- Asignación de profesores

### 🟣 Profesor
- Visualización de cursos asignados
- Gestión de alumnos por curso
- Carga y edición de notas

### 🟢 Estudiante
- Visualización de cursos inscriptos
- Consulta de notas

---

## 📌 Funcionalidades principales

- 🔐 Autenticación de usuarios
- 🧑‍🏫 Sistema de roles (admin / teacher / student)
- 📚 Gestión de cursos
- 👨‍🎓 Inscripción de alumnos a cursos (many-to-many)
- 📝 Sistema de calificaciones (nota 1 a 10)
- 🔄 Relación pivot `curso_user`
- 📊 Visualización de notas con DataTables AJAX
- ⚡ Interfaces dinámicas con Blade + Tailwind

---

## 🗂️ Estructura del sistema

### 📌 Tablas principales

- `users`
- `roles`
- `cursos`
- `curso_user` (pivot con campo `nota`)

---

## ⚙️ Instalación del proyecto

```bash
# Clonar repositorio
git clone https://github.com/leandro16197/ChallengeEscuela.git

cd ChallengeEscuela

# Instalar dependencias PHP
composer install

# Instalar dependencias frontend
npm install
npm run build

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Migraciones y seeders
php artisan migrate --seed

# Levantar servidor
php artisan serve
/*

USUARIOS DE PRUEBA (SEEDER)


ADMINISTRADORES
- admin1@school.com / admin
- admin2@school.com / admin

PROFESORES
- profesor1@school.com / profesor
- profesor2@school.com / profesor
- profesor3@school.com / profesor
- profesor4@school.com / profesor

ESTUDIANTES
- estudiante1@school.com / estudiante
- estudiante2@school.com / estudiante
- estudiante3@school.com / estudiante
...
- estudiante20@school.com / estudiante
