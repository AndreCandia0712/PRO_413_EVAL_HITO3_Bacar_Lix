# Sistema de Gestión Escolar — BacarLix

**PRO-413 | Programación III | Hito 3 | Gestión Escolar**

Aplicación web desarrollada con **Laravel 13, PHP 8.4, MySQL 8 y Docker**, orientada a la administración de estudiantes, docentes, asignaturas, inscripciones y calificaciones.

El proyecto utiliza **dos servidores MySQL independientes**, ubicados en equipos diferentes, con tablas distribuidas y consultas integradas mediante Laravel.

## 1. Integrantes y responsabilidades

| Integrante | Rama Git | Responsabilidad |
|---|---|---|
| André Candia | `backend` | Laravel, modelos, controladores, rutas, integración y pruebas |
| Pablo Medina | `docker` | Contenedor MySQL, configuración Docker y base escolar |
| Ricardo | `database` | SQL institucional, datos de prueba y CRUD de docentes |
| Arturo | `frontend` | Interfaz Blade, dashboard, tablas y formularios |

Cada integrante desarrolla sus funcionalidades en una rama independiente y registra sus avances mediante commits.

## 2. Tecnologías utilizadas

- PHP 8.4
- Laravel 13
- MySQL 8
- Docker y Docker Compose
- Blade
- Bootstrap 5
- Git y GitHub
- Composer

## 3. Arquitectura del sistema

El sistema está distribuido entre tres servicios:

**Equipo de André — Windows 11**

- Contenedor Docker con Laravel y PHP.
- Puerto de acceso web: `8000`.
- Procesamiento de peticiones HTTP.
- Modelos, controladores, validaciones y vistas Blade.
- Conexión a los dos servidores MySQL.

**Equipo de Pablo — Linux**

- Contenedor Docker con MySQL 8.
- Puerto publicado: `3307`.
- Base de datos: `gestion_escolar`.
- Almacena la información escolar.

**Servidor institucional**

- MySQL administrado por la institución.
- Puerto: `3306`.
- Base de datos asignada: `pro413_bacarlix`.
- Almacena información de docentes y organización académica.

### Diagrama de arquitectura

```text
                   NAVEGADOR WEB
                         |
                         | HTTP :8000
                         v
              +-----------------------+
              | EQUIPO DE ANDRÉ       |
              | Windows + Docker      |
              | Laravel / PHP 8.4     |
              | Blade / Bootstrap     |
              +-----------------------+
                    |             |
             MySQL :3307     MySQL :3306
                    |             |
                    v             v
         +----------------+  +-------------------+
         | EQUIPO PABLO   |  | SERVIDOR          |
         | Linux + Docker |  | INSTITUCIONAL     |
         | MySQL 8        |  | MySQL             |
         | gestion_escolar|  | pro413_bacarlix   |
         +----------------+  +-------------------+
```

Las conexiones se realizan mediante PDO MySQL desde Laravel.

**No se duplican las tablas entre servidores.**

## 4. Distribución de las tablas

### MySQL del grupo — equipo de Pablo

Base de datos: `gestion_escolar`

| Tabla | Descripción |
|---|---|
| `estudiantes` | Datos personales de los estudiantes |
| `asignaturas` | Materias disponibles |
| `inscripciones` | Relación entre estudiantes y asignaturas |
| `calificaciones` | Notas correspondientes a inscripciones |

### MySQL institucional

Base de datos: `pro413_bacarlix`

| Tabla | Descripción |
|---|---|
| `docentes` | Datos de docentes |
| `gestiones_academicas` | Períodos académicos |
| `aulas` | Aulas disponibles |
| `asignaciones_docentes` | Asignación de docentes a asignaturas, aulas y gestiones |

### Relación entre servidores

La tabla institucional `asignaciones_docentes` incluye `asignatura_id`, cuyo valor corresponde a `asignaturas.id` en el servidor de Pablo.

Esta relación se resuelve en Laravel mediante consultas independientes y procesamiento PHP. No se utiliza una clave foránea SQL entre servidores.

**Nota sobre permisos:** la cuenta institucional utilizada inicialmente no disponía del privilegio `REFERENCES`. Por ello, las relaciones de `asignaciones_docentes` se definieron mediante columnas e índices, y su consistencia debe validarse en la aplicación. Los índices no sustituyen las restricciones de clave foránea.

## 5. Requisitos previos

Para ejecutar el sistema se necesita:

- Docker y Docker Compose.
- Git.
- Acceso de red entre las computadoras.
- Credenciales válidas para ambos servidores MySQL.
- Puertos necesarios habilitados en la red local.

Para desarrollo local sin Docker también se requieren PHP 8.4, Composer y las extensiones PHP correspondientes.

## 6. Clonar el repositorio

```bash
git clone URL_DEL_REPOSITORIO
cd NOMBRE_DEL_REPOSITORIO
```

Reemplazar los valores por la URL y el nombre real del repositorio del equipo.

Para trabajar en una rama:

```bash
git fetch origin
git switch backend
```

Cada integrante debe utilizar su rama correspondiente: `backend`, `docker`, `database` o `frontend`.

## 7. Configuración de MySQL en el equipo de Pablo

En Linux, Pablo debe iniciar el servicio MySQL definido en su Docker Compose.

Primero verificar los servicios:

```bash
docker compose config --services
```

Si el servicio MySQL se llama `db`, iniciar únicamente ese servicio:

```bash
docker compose up -d db
```

Comprobar el estado:

```bash
docker compose ps
```

El contenedor MySQL debe publicar el puerto `3307` del equipo de Pablo hacia el puerto interno `3306` del contenedor.

Ejemplo de publicación:

```yaml
ports:
  - "3307:3306"
```

El servicio debe utilizar un volumen persistente para conservar los datos.

**Importante:** las credenciales de MySQL deben configurarse mediante variables de entorno y no incluirse en el repositorio público.

### Cargar el esquema escolar

Desde la raíz del proyecto:

```bash
docker compose cp sql/grupo.sql db:/tmp/grupo.sql
```

Entrar al cliente MySQL:

```bash
docker compose exec db mysql -u root -p
```

Dentro de MySQL:

```sql
SOURCE /tmp/grupo.sql;
```

El archivo `sql/grupo.sql` crea las cuatro tablas escolares e inserta registros de prueba.

### Verificar la base

```sql
USE gestion_escolar;

SHOW TABLES;

SELECT COUNT(*) FROM estudiantes;
SELECT COUNT(*) FROM asignaturas;
SELECT COUNT(*) FROM inscripciones;
SELECT COUNT(*) FROM calificaciones;
```

Con el conjunto inicial de prueba, los conteos esperados son:

| Tabla | Registros |
|---|---:|
| estudiantes | 5 |
| asignaturas | 5 |
| inscripciones | 6 |
| calificaciones | 6 |

Los conteos pueden variar después de utilizar el sistema.

## 8. Configuración del servidor institucional

La base de datos institucional se encuentra en un servidor MySQL administrado por la institución.

La base asignada al equipo es:

```text
pro413_bacarlix
```

El esquema está documentado en:

```text
sql/institucional.sql
```

Las tablas institucionales deben crearse únicamente en la base asignada al grupo.

Si se utiliza el cliente MySQL:

```bash
mysql -h HOST_INSTITUCIONAL -P 3306 -u USUARIO_INSTITUCIONAL -p pro413_bacarlix
```

Una vez dentro:

```sql
SOURCE ruta/al/archivo/sql/institucional.sql;
```

**Precaución:** verificar el contenido del script antes de ejecutarlo. No utilizar `DROP DATABASE`, `migrate:fresh` ni eliminar tablas ajenas al proyecto.

## 9. Configurar Laravel en el equipo de André

En Windows, clonar el repositorio y abrirlo desde Git Bash o VS Code.

Crear el archivo de entorno:

```bash
cp .env.example .env
```

Configurar las variables de las dos conexiones MySQL:

```dotenv
APP_NAME=BacarLix
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=HOST_LAN_PABLO
DB_PORT=3307
DB_DATABASE=gestion_escolar
DB_USERNAME=USUARIO_MYSQL_GRUPO
DB_PASSWORD=CONTRASENA_MYSQL_GRUPO

DB_DOCENTE_HOST=HOST_INSTITUCIONAL
DB_DOCENTE_PORT=3306
DB_DOCENTE_DATABASE=pro413_bacarlix
DB_DOCENTE_USERNAME=USUARIO_INSTITUCIONAL
DB_DOCENTE_PASSWORD=CONTRASENA_INSTITUCIONAL

SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

Sustituir todos los valores de ejemplo por las credenciales y direcciones autorizadas de la red.

El archivo `.env` contiene información sensible y **no debe subirse a GitHub**.

La conexión `mysql` apunta al servidor de Pablo y la conexión `mysql_docente` apunta al servidor institucional.

### Configuración de conexiones

En `config/database.php` deben existir ambas conexiones.

La conexión principal `mysql` utiliza las variables `DB_*`.

La conexión institucional se configura con el nombre `mysql_docente` y utiliza las variables `DB_DOCENTE_*`.

Los modelos seleccionan su servidor mediante:

```php
protected $connection = 'mysql';
```

o:

```php
protected $connection = 'mysql_docente';
```

## 10. Construir y levantar Laravel con Docker

Desde la raíz del proyecto en el equipo de André:

```bash
docker compose build
docker compose up -d
```

Verificar:

```bash
docker compose ps
```

El servicio Laravel debe publicar el puerto `8000` y escuchar en todas las interfaces del contenedor:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Instalar dependencias si falta `vendor`

La configuración Docker puede montar la carpeta del proyecto sobre `/var/www`, ocultando las dependencias instaladas durante la construcción de la imagen.

Si aparece el error:

```text
Failed opening required vendor/autoload.php
```

Instalar las dependencias en el volumen del proyecto:

```bash
docker compose run --rm --no-deps app composer install
```

Después iniciar o reiniciar el servicio:

```bash
docker compose up -d
```

### Generar la clave de Laravel

Si el archivo `.env` no contiene `APP_KEY`:

```bash
docker compose exec app php artisan key:generate
```

Limpiar la configuración:

```bash
docker compose exec app php artisan optimize:clear
```

Compilar las vistas:

```bash
docker compose exec app php artisan view:cache
```

Consultar las rutas:

```bash
docker compose exec app php artisan route:list
```

## 11. Acceso a la aplicación

Desde el equipo de André:

```text
http://localhost:8000
```

Desde otra computadora de la misma red:

```text
http://IP_LAN_DE_ANDRE:8000
```

Para obtener la IP LAN en Windows:

```powershell
ipconfig
```

Se debe utilizar la dirección IPv4 del adaptador de red correspondiente.

Si el navegador de otra computadora no puede acceder:

1. Verificar que el contenedor Laravel esté encendido.
2. Confirmar que Docker publique `0.0.0.0:8000:8000`.
3. Revisar el firewall de Windows.
4. Comprobar que ambos equipos estén en una red con conectividad.
5. Verificar que la aplicación escuche en `0.0.0.0`.

## 12. Funcionalidades del sistema

El proyecto contempla:

- Dashboard con resumen de registros.
- Listado y administración de estudiantes.
- Listado y administración de docentes.
- Consulta de asignaturas.
- Consulta y administración de inscripciones.
- Registro y consulta de calificaciones.
- Asignación de docentes a asignaturas y aulas.
- Validaciones de formularios.
- Manejo de excepciones.
- Acceso a dos servidores MySQL independientes.

Las funcionalidades se habilitan conforme se integran sus respectivos controladores, modelos y vistas.

## 13. Verificar las dos conexiones MySQL

Desde el equipo de André:

```bash
docker compose exec app php artisan tinker
```

Probar el servidor de Pablo:

```php
DB::connection('mysql')->select('SELECT 1 AS prueba');
```

Probar el servidor institucional:

```php
DB::connection('mysql_docente')->select('SELECT 1 AS prueba');
```

Ambas consultas deben devolver `prueba = 1`.

### Verificar las tablas

Servidor de Pablo:

```php
DB::connection('mysql')->select('SHOW TABLES');
```

Servidor institucional:

```php
DB::connection('mysql_docente')->select('SHOW TABLES');
```

### Verificar registros mediante modelos

```php
App\Models\Estudiante::count();
App\Models\Asignatura::count();
App\Models\Inscripcion::count();
App\Models\Calificacion::count();

App\Models\Docente::count();
App\Models\GestionAcademica::count();
App\Models\Aula::count();
App\Models\AsignacionDocente::count();
```

Estas pruebas requieren que los modelos y tablas correspondientes estén creados.

Para salir de Tinker:

```php
exit
```

## 14. Rutas de la aplicación

Las rutas principales previstas son:

| Método | Ruta | Función |
|---|---|---|
| GET | `/` | Dashboard |
| GET | `/estudiantes` | Listar estudiantes |
| GET | `/estudiantes/crear` | Crear estudiante |
| POST | `/estudiantes` | Guardar estudiante |
| GET | `/estudiantes/{id}/editar` | Editar estudiante |
| PUT | `/estudiantes/{id}` | Actualizar estudiante |
| DELETE | `/estudiantes/{id}` | Eliminar estudiante |
| GET | `/docentes` | Listar docentes |
| GET | `/docentes/crear` | Crear docente |
| POST | `/docentes` | Guardar docente |
| GET | `/docentes/{id}/editar` | Editar docente |
| PUT | `/docentes/{id}` | Actualizar docente |
| DELETE | `/docentes/{id}` | Eliminar docente |
| GET | `/asignaturas` | Listar asignaturas |
| GET | `/inscripciones` | Listar inscripciones |
| GET | `/estado-sistema` | Verificación de conexiones, si está habilitada |

Consultar las rutas realmente implementadas con:

```bash
docker compose exec app php artisan route:list
```

## 15. Programación orientada a objetos

El sistema utiliza principios de programación orientada a objetos:

**Encapsulamiento:** los modelos y controladores organizan la lógica y los datos del sistema.

**Herencia:** los modelos Eloquent heredan de `Illuminate\Database\Eloquent\Model`, mientras que los controladores extienden la clase base `Controller`.

**Polimorfismo:** los diferentes modelos Eloquent comparten una interfaz de operaciones como `create`, `find`, `update` y `delete`, con comportamientos específicos según su entidad y conexión.

También se emplean:

- Declaraciones de tipos estrictos en clases PHP desarrolladas.
- Validación de datos con Laravel.
- Manejo de excepciones con `try/catch`.
- Arreglos y colecciones PHP para procesar información.
- Separación entre lógica de aplicación y presentación Blade.

## 16. Estructura del proyecto

```text
app/
├── Http/
│   └── Controllers/
├── Models/
│   ├── Docente.php
│   ├── GestionAcademica.php
│   ├── Aula.php
│   ├── AsignacionDocente.php
│   ├── Estudiante.php
│   ├── Asignatura.php
│   ├── Inscripcion.php
│   └── Calificacion.php

config/
└── database.php

resources/
└── views/
    ├── layouts/
    │   └── app.blade.php
    ├── dashboard.blade.php
    ├── estudiantes/
    ├── docentes/
    ├── asignaturas/
    └── inscripciones/

routes/
└── web.php

sql/
├── grupo.sql
└── institucional.sql

Dockerfile
compose.yaml
composer.json
composer.lock
README.md
```

La estructura final puede variar según los módulos efectivamente implementados.

## 17. Trabajo colaborativo con Git

Se utilizan cuatro ramas:

```text
backend
docker
database
frontend
```

Cada integrante trabaja en su propia rama.

### Guardar avances

```bash
git status
git add RUTA_DEL_ARCHIVO
git commit -m "feat: descripcion del cambio"
git push origin NOMBRE_DE_RAMA
```

Los commits deben corresponder a avances reales.

### Integración de ramas

La integración la realiza el responsable de backend:

```bash
git switch backend
git fetch origin
git merge origin/frontend
git merge origin/database
git merge origin/docker
```

Si se producen conflictos, deben resolverse antes de continuar con el siguiente merge.

Una vez integrada y verificada la aplicación:

```bash
git push origin backend
```

### Verificar historial

```bash
git log --oneline --all --graph --decorate
```

Cada integrante debe conservar evidencia de sus contribuciones y cumplir la cantidad de commits exigida por la evaluación.

## 18. Solución de errores frecuentes

### Error: `vendor/autoload.php` no existe

Faltan dependencias de Composer.

```bash
docker compose run --rm --no-deps app composer install
```

### Error: conexión MySQL rechazada

Verificar:

- Que el servidor esté encendido.
- La IP del equipo.
- El puerto publicado.
- El usuario y contraseña.
- Los permisos de acceso remoto.
- El firewall y la conectividad de red.

### Error: `Unknown database`

Comprobar el nombre exacto de la base, incluyendo mayúsculas y minúsculas.

### Error: `REFERENCES command denied`

El usuario no dispone del permiso `REFERENCES` para crear claves foráneas. Solicitarlo al administrador autorizado o utilizar el esquema alternativo documentado, con validación de relaciones desde Laravel.

### Error: `No such container`

Consultar los nombres reales:

```bash
docker ps -a
```

También se pueden identificar los servicios con:

```bash
docker compose ps
```

### Error: `View not found`

Comprobar que el archivo Blade exista en `resources/views` y que el controlador use el nombre correcto.

Limpiar vistas:

```bash
docker compose exec app php artisan view:clear
```

### Error: página no encontrada (404)

Verificar que la ruta esté registrada:

```bash
docker compose exec app php artisan route:list
```

## 19. Seguridad y buenas prácticas

- No subir archivos `.env`.
- No publicar contraseñas ni claves privadas.
- No subir la carpeta `vendor`.
- Mantener los SQL de cada servidor separados.
- No crear tablas duplicadas en ambas bases.
- Utilizar validaciones antes de escribir registros.
- Gestionar excepciones y registrar errores.
- Evitar operaciones destructivas sobre bases institucionales.
- Usar `APP_DEBUG=false` en despliegues expuestos fuera del entorno de desarrollo.
- Mantener el repositorio público sin credenciales.

## 20. Evidencias de funcionamiento

Para la presentación y evaluación se recomienda mostrar:

1. Los contenedores Docker correspondientes.
2. El acceso a Laravel desde otra computadora.
3. La conexión satisfactoria con ambas bases.
4. Las tablas de cada servidor.
5. Una consulta real de lectura desde cada MySQL.
6. Una operación de escritura en cada MySQL.
7. Las pantallas Blade y los formularios.
8. El historial de commits de los cuatro integrantes.
9. Los archivos SQL y la documentación del repositorio.

---

**Proyecto académico — PRO-413, Programación III, Hito 3.**

**Equipo BacarLix.**