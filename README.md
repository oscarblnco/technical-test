# Proyecto Biblioteca - Laravel 12 + Livewire + Tailwind + Flux

Este proyecto es una aplicación de biblioteca desarrollada con **Laravel 12**, que utiliza **Livewire** para componentes interactivos, **TailwindCSS** para estilos modernos y **Flux** como kit de inicio para una base frontend estructurada y escalable.

## ✨ Características

- Laravel 12 como framework principal.
- Livewire para componentes reactivas sin necesidad de escribir JavaScript.
- TailwindCSS para una interfaz moderna y personalizable.
- Flux Starter Kit para una estructura frontend robusta y productiva.
- Módulo de **Categorías** y módulo de **Libros** completamente funcionales.
- Dark/Light mode

---

## ✅ Requisitos del sistema

- **PHP** >= 8.1
- **Composer**
- **Node.js** >= 16.x
- **NPM**
- Base de datos compatible (MySQL, PostgreSQL, SQLite, etc.)
- Extensiones PHP necesarias:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON

---

## ⚙️ Instalación del proyecto

### 1. Clona el repositorio

```bash
git clone https://github.com/oscarblnco/technical-test.git
cd technical-test
```

### 2. Instala las dependencias de PHP

```bash
composer install
```

### 3. Instala las dependencias de Node.js

```bash
npm install
```

### 4. Copia el archivo de entorno

```bash
cp .env.example .env
```

### 5. Genera la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Ejecuta las migraciones

- Primero crea la base de datos
- Cambia las variables de entorno de la BBDD

```plain
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```

```bash
php artisan migrate --seed
```

### 7. Compila los assets

```bash
npm run dev
```

### 8. Ejecutar el servidor

```bash
php artisan serve
```

## Datos de usuario de prueba

Para acceder a la aplicación durante el desarrollo o para fines de demostración, utiliza las siguientes credenciales:

- **Correo:** test@example.com
- **Contraseña:** 12345678

---

## Módulos del sistema

### 📁 Categorías
- Gestión de categorías de libros: crear, editar y eliminar.
- Validaciones en tiempo real a través de Livewire para una experiencia de usuario óptima.

### 📚 Libros
- Gestión completa de libros: crear, editar y eliminar.
- Validaciones en tiempo real a través de Livewire para una experiencia de usuario óptima.
- Relación de libros con categorías.
- Uso de componentes Livewire para interfaces dinámicas y reactivas.
- Filtros de libros.

---

## 🚀 Tecnologías utilizadas

- **Laravel 12**
- **Livewire**
- **TailwindCSS**
- **Alpine.js**
- **Flux Starter Kit** (estructura frontend robusta)