# traze-api
Desarrollo de API REST para la gestión de trazabilidad alimentaria, permitiendo el seguimiento completo del ciclo de vida de productos y lotes dentro de la cadena de suministro.

Implementada con Symfony 7 y API Platform 4, orientada a garantizar la integridad de los datos y cumplir con los requisitos normativos del Reglamento (CE) nº 178/2002.

El sistema permite registrar proveedores, productos y movimientos, facilitando la auditoría y control de la trazabilidad en entornos reales.
---

## Stack tecnológico

| Capa | Tecnología |
|------|-----------|
| Lenguaje | PHP 8.2 |
| Framework | Symfony 7.4 |
| API | API Platform 4.3 |
| ORM | Doctrine ORM |
| Base de datos | PostgreSQL 18 |
| Autenticación | JWT (lexik/jwt-authentication-bundle) |
| Validación | Symfony Validator |

---

## Funcionalidades

- CRUD completo para `Producto`, `Proveedor`, `Lote` y `Movimiento`
- Respuestas en formato JSON-LD / Hydra siguiendo el estándar de API Platform
- Autenticación con JWT — stateless, basada en tokens
- Grupos de serialización para controlar los campos expuestos en cada operación
- Validaciones con mensajes de error descriptivos (HTTP 422)
- Consultas personalizadas con Doctrine: búsqueda por texto, rangos de fechas, agregaciones y joins
- CORS configurado para integración con el frontend Angular
- Comando de consola para la creación de usuarios (`app:create-user`)
- Documentación interactiva automática en `/api` (Swagger UI)

---

## Modelo de datos

```
Proveedor ──┐
            ├──► Lote ──► Movimiento
Producto ───┘
```

- **Producto** — artículo alimentario con nombre, código y categoría
- **Proveedor** — empresa suministradora con datos de contacto
- **Lote** — agrupación de un producto de un proveedor, con fechas de fabricación y caducidad
- **Movimiento** — evento de trazabilidad (entrada / salida / transformacion) asociado a un lote

---

## Requisitos

- PHP 8.2+
- Composer
- PostgreSQL 18
- Symfony CLI

---

## Instalación

```bash
# Clonar el repositorio
git clone https://github.com/OAlvarezOliveira/traze-api.git
cd traze-api

# Instalar dependencias
composer install

# Configurar el entorno
cp .env .env.local
# Editar .env.local con las credenciales de la base de datos

# Generar las claves JWT
OPENSSL_CONF=/ruta/a/openssl.cnf php bin/console lexik:jwt:generate-keypair

# Crear la base de datos y ejecutar migraciones
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Crear un usuario
php bin/console app:create-user usuario@ejemplo.com contraseña

# Arrancar el servidor de desarrollo
symfony serve --no-tls
```

---

## Uso de la API

### Autenticación

```bash
# Login — obtener token JWT
POST /api/login
Content-Type: application/json

{
  "email": "usuario@ejemplo.com",
  "password": "contraseña"
}

# Respuesta
{
  "token": "eyJ0eXAiOiJKV1Qi..."
}
```

Todos los endpoints `/api/*` requieren el token en la cabecera:

```
Authorization: Bearer <token>
```

### Endpoints disponibles

#### CRUD — Generados automáticamente por API Platform

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/productos` | Listar todos los productos |
| POST | `/api/productos` | Crear un producto |
| GET | `/api/productos/{id}` | Obtener un producto |
| PATCH | `/api/productos/{id}` | Actualizar un producto |
| DELETE | `/api/productos/{id}` | Eliminar un producto |
| GET | `/api/proveedors` | Listar todos los proveedores |
| POST | `/api/proveedors` | Crear un proveedor |
| GET | `/api/proveedors/{id}` | Obtener un proveedor |
| PATCH | `/api/proveedors/{id}` | Actualizar un proveedor |
| DELETE | `/api/proveedors/{id}` | Eliminar un proveedor |
| GET | `/api/lotes` | Listar todos los lotes |
| POST | `/api/lotes` | Crear un lote |
| GET | `/api/lotes/{id}` | Obtener un lote |
| PATCH | `/api/lotes/{id}` | Actualizar un lote |
| DELETE | `/api/lotes/{id}` | Eliminar un lote |
| GET | `/api/movimientos` | Listar todos los movimientos |
| POST | `/api/movimientos` | Crear un movimiento |
| GET | `/api/movimientos/{id}` | Obtener un movimiento |
| PATCH | `/api/movimientos/{id}` | Actualizar un movimiento |
| DELETE | `/api/movimientos/{id}` | Eliminar un movimiento |

#### Consultas personalizadas

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/consultas/resumen-categoria` | Número de productos por categoría |
| GET | `/api/consultas/con-stock` | Productos con lotes disponibles |
| GET | `/api/consultas/trazabilidad/{id}` | Resumen de trazabilidad de un producto |
| GET | `/api/consultas/buscar/{texto}` | Búsqueda de productos por nombre |
| GET | `/api/consultas/categoria/{categoria}` | Productos filtrados por categoría |
| GET | `/api/consultas/por-fechas/{inicio}/{fin}` | Productos por rango de fechas |

La documentación interactiva completa está disponible en `/api`.

### Ejemplo — Crear un producto

```bash
curl -X POST http://127.0.0.1:8000/api/productos \
  -H "Authorization: Bearer <token>" \
  -H "Content-Type: application/ld+json" \
  -d '{
    "nombre": "Aceite de oliva virgen extra",
    "descripcion": "Primera presión en frío",
    "codigo": "AOVE-001",
    "categoria": "Aceites"
  }'
```

### Ejemplo — Crear un lote

```bash
curl -X POST http://127.0.0.1:8000/api/lotes \
  -H "Authorization: Bearer <token>" \
  -H "Content-Type: application/ld+json" \
  -d '{
    "numeroLote": "LOT-2026-001",
    "fechaFabricacion": "2026-01-10",
    "fechaCaducidad": "2027-01-10",
    "cantidad": 500,
    "producto": "/api/productos/1",
    "proveedor": "/api/proveedors/1"
  }'
```

---

## Estructura del proyecto

```
src/
├── Controller/       # Controllers HTTP (autenticación, endpoints personalizados)
├── Entity/           # Entidades Doctrine (Producto, Proveedor, Lote, Movimiento, User)
├── Repository/       # Consultas personalizadas Doctrine
├── Service/          # Lógica de negocio (TrazabilidadService, ProductoService)
└── Command/          # Comandos de consola (CreateUserCommand)
```

---

## Frontend

El frontend Angular 21 para esta API está disponible en:  
**[github.com/OAlvarezOliveira/traze-front](https://github.com/OAlvarezOliveira/traze-front)**

---

## Autor

**Oscar Álvarez** — Estudiante DAM  
[github.com/OAlvarezOliveira](https://github.com/OAlvarezOliveira)
