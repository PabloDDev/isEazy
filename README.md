
# Prueba Técnica - Backend (Laravel 11 + PHP 8.3)

Este proyecto consiste en una API REST desarrollada en Laravel 11 con arquitectura limpia, orientada a un caso de gestión de tiendas y productos. El proyecto sigue una estructura modular clara, facilitando su mantenimiento y escalabilidad.

---

## Arquitectura

Se adoptó **Clean Architecture** para separar responsabilidades y facilitar pruebas, mantenimiento y escalabilidad. A continuación, se detallan las capas:

### 1. **Domain**
Contiene las interfaces, entidades de dominio y los DTOs que definen el contrato que se espera de cada módulo del sistema.

### 2. **Application**
Aquí se implementan los *Use Cases*, que contienen la lógica de negocio específica, orquestando las operaciones entre las capas de infraestructura y dominio.

### 3. **Infrastructure**
Implementa la lógica concreta para acceder a base de datos y otros servicios externos. Contiene los modelos Eloquent, repositorios concretos, y servicios como autenticación.

### 4. **Interface (Http Layer)**
Encargada de gestionar las peticiones HTTP. Contiene los controladores, requests (validaciones), y recursos (responses estructurados).

---

## Instalación

1. Clonar el repositorio y entrar al directorio:

```bash
git clone <REPO_URL>
cd store_assessment
```

2. Instalar dependencias:

- moverse al directorio store_assessment

```bash
composer install
```

3. Configurar el entorno:

```bash
cp .env.example .env
php artisan key:generate
```

4. Crear la base de datos y ejecutar las migraciones:

```bash
php artisan migrate --seed
```

5. Levantar el servidor:

```bash
php artisan serve
```

---

## Autenticación

Todos los endpoints, salvo el de login, están protegidos mediante Laravel Sanctum. Para obtener el token de acceso:

### Credenciales de usuario:

```text
Email:    iseazy@test.com
Password: test2025
```

---

## Postman Collection

**RECOMENDADO:** Se encuentra disponible una colección Postman para probar todos los endpoints de la API. La colección está dentro del repositorio en el directorio:

```
isEazy/postman_collection/
```

**NOTA:** Adicionalmente, toda la documentación detallada del uso de la api, se puede encontrar en el fichero:

```
API_DOCUMENTATION.md
```

### Instrucciones:

1. Importar la colección en Postman.
2. Ejecutar primero la petición **Login**.
3. El token automáticamente debería insertarse en las demás llamadas, en caso contrario, pegar manualmente utilizando Bearer Token.
4. Probar los endpoints de gestión de tiendas y productos.

---

## Decisiones de diseño

- Se decidió **proteger todos los endpoints** (excepto el de login), con una autenticación muy básica, considerando que la gestión de productos y tiendas es información sensible.
- En el endpoint de actualización de tiendas, **no se modifican productos**, ya que no fue especificado en los requisitos, requiere más complejidad de desarrollos y evita ambigüedad en la lógica.
- Se usaron **DTOs** entre capas para desacoplar la lógica de negocio de los modelos de base de datos.
- Se realizaron validaciones estrictas en cada request.

---

## Tests

Se incluye un **test suite automatizado** con PHPUnit que cubre los siguientes casos:

- Autenticación
- CRUD de tiendas
- Lógica de ventas de productos

### Ejecutar los tests:

```bash
php artisan test
```

O directamente:

```bash
./vendor/bin/phpunit
```

Los tests utilizan SQLite en memoria para evitar impacto en entornos locales.

---

Cualquier duda o aclaración puede ser resuelta revisando los comentarios PHPDoc incluidos en cada clase relevante del proyecto.
