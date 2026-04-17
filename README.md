# traze-api

REST API for food traceability management, built with **Symfony 7** and **API Platform 4**. Tracks products, batches, suppliers and movements across the supply chain, complying with EU Regulation CE 178/2002 on food traceability.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Language | PHP 8.2 |
| Framework | Symfony 7.4 |
| API | API Platform 4.3 |
| ORM | Doctrine ORM |
| Database | PostgreSQL 18 |
| Auth | JWT (lexik/jwt-authentication-bundle) |
| Validation | Symfony Validator |

---

## Features

- Full CRUD REST API for `Producto`, `Proveedor`, `Lote` and `Movimiento`
- JSON-LD / Hydra responses following API Platform standards
- JWT authentication — stateless, token-based
- Serialization groups — fine-grained control over exposed fields
- Constraint validation with meaningful error messages (422)
- Custom Doctrine queries — search, date ranges, aggregations, joins
- CORS configured for Angular frontend integration
- Console command for user management (`app:create-user`)

---

## Data Model

```
Proveedor ──┐
            ├──► Lote ──► Movimiento
Producto ───┘
```

- **Producto** — food item with name, code and category
- **Proveedor** — supplier with contact details
- **Lote** — batch linking a product and supplier, with manufacturing and expiry dates
- **Movimiento** — traceability event (entrada / salida / transformacion) linked to a batch

---

## Requirements

- PHP 8.2+
- Composer
- PostgreSQL 18
- Symfony CLI

---

## Installation

```bash
# Clone the repository
git clone https://github.com/OAlvarezOliveira/traze-api.git
cd traze-api

# Install dependencies
composer install

# Configure environment
cp .env .env.local
# Edit .env.local with your database credentials and JWT passphrase

# Generate JWT keys
OPENSSL_CONF=/path/to/openssl.cnf php bin/console lexik:jwt:generate-keypair

# Create database and run migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Create a user
php bin/console app:create-user user@example.com yourpassword

# Start the development server
symfony serve --no-tls
```

---

## API Usage

### Authentication

```bash
# Login — get JWT token
POST /api/login
Content-Type: application/json

{
  "email": "user@example.com",
  "password": "yourpassword"
}

# Response
{
  "token": "eyJ0eXAiOiJKV1Qi..."
}
```

All `/api/*` endpoints require the token in the Authorization header:

```
Authorization: Bearer <token>
```

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/productos` | List all products |
| POST | `/api/productos` | Create a product |
| GET | `/api/productos/{id}` | Get a product |
| PATCH | `/api/productos/{id}` | Update a product |
| DELETE | `/api/productos/{id}` | Delete a product |
| GET | `/api/proveedors` | List all suppliers |
| POST | `/api/proveedors` | Create a supplier |
| GET | `/api/lotes` | List all batches |
| POST | `/api/lotes` | Create a batch |
| GET | `/api/movimientos` | List all movements |
| POST | `/api/movimientos` | Create a movement |

Full interactive documentation available at `/api` (Swagger UI).

### Example — Create a product

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

### Example — Create a batch

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

## Project Structure

```
src/
├── Controller/       # HTTP controllers (auth, custom endpoints)
├── Entity/           # Doctrine entities (Producto, Proveedor, Lote, Movimiento, User)
├── Repository/       # Custom Doctrine queries
├── Service/          # Business logic (TrazabilidadService, ProductoService)
└── Command/          # Console commands (CreateUserCommand)
```

---

## Frontend

The Angular 21 frontend for this API is available at:  
**[github.com/OAlvarezOliveira/traze-front](https://github.com/OAlvarezOliveira/traze-front)**

---

## Author

**Oscar Álvarez** — DAM Student  
[github.com/OAlvarezOliveira](https://github.com/OAlvarezOliveira)
