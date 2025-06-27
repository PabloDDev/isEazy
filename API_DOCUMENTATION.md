
# Documentación de la API - Gestión de Tiendas y Productos

Esta API permite la gestión de tiendas y productos, incluyendo creación, visualización, actualización, eliminación y ventas. Todos los endpoints (excepto login) están protegidos mediante autenticación por token (Laravel Sanctum).

---

## Autenticación

### `POST /api/v1/login`

Autentica un usuario y devuelve un token de acceso.

#### Parámetros:
```json
{
  "email": "iseazy@test.com",
  "password": "test"
}
```

#### Respuesta:
```json
{
  "token": "TOKEN_DE_ACCESO"
}
```

> Usa este token como "Bearer Token" en las siguientes llamadas.

---

## Tiendas

### `GET /api/v1/stores`

Obtiene todas las tiendas junto con el número de productos asociados.

#### Respuesta:
```json
[
  {
    "id": 1,
    "name": "Nombre Tienda",
    "description": "Descripción opcional",
    "product_count": 10
  }
]
```

---

### `POST /api/v1/stores/show`

Obtiene el detalle de una tienda y sus productos.

#### Parámetros:
```json
{
  "store_id": 1
}
```

#### Respuesta:
```json
{
  "id": 1,
  "name": "Tienda 1",
  "description": "Texto opcional",
  "products": [
    {
      "id": 3,
      "name": "Producto A",
      "stock": 10
    }
  ]
}
```

---

### `POST /api/v1/stores/create`

Crea una tienda con productos asociados.

#### Parámetros:
```json
{
  "name": "Tienda nueva",
  "description": "Descripción",
  "products": [
    {
      "name": "Producto 1",
      "stock": 10
    },
    {
      "name": "Producto 2",
      "stock": 20
    }
  ]
}
```

#### Respuesta:
```json
{
  "id": 2,
  "name": "Tienda nueva",
  "description": "Descripción",
  "products": [...]
}
```

---

### `POST /api/v1/stores/update`

Actualiza el nombre o descripción de una tienda.

#### Parámetros:
```json
{
  "store_id": 2,
  "name": "Tienda actualizada",
  "description": "Texto actualizado"
}
```

#### Respuesta:
```json
{
  "message": "Store updated successfully"
}
```

---

### `DELETE /api/v1/stores/delete`

Elimina una tienda por ID.

#### Parámetros:
```json
{
  "store_id": 2
}
```

#### Respuesta:
```json
{
  "message": "Store deleted successfully"
}
```

---

## Productos

### `POST /api/v1/products/sell`

Vende un producto desde una tienda, actualizando su stock.

#### Parámetros:
```json
{
  "store_id": 1,
  "product_id": 3,
  "quantity": 1
}
```

#### Respuesta Exitosa:
```json
{
  "message": "Sale completed successfully.",
  "remaining_stock": 9
}
```

#### Respuesta con stock insuficiente:
```json
{
  "message": "Insufficient stock."
}
```

#### Respuesta si el producto no pertenece a la tienda:
```json
{
  "message": "Product not found in this store."
}
```

---

## Uso con Postman

1. Importar `store_api_collection.json` desde la raíz del proyecto.
2. Ejecutar primero la llamada de `login` para obtener el token.
3. Usar ese token como **Bearer Token** en el resto de peticiones.
