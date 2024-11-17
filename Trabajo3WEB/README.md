# Trabajo Especial - Tercera Entrega

## Integrantes
- [Julian Oroz]
- [Marco Ciano]

## Descripción
Este proyecto tiene como objetivo la creación de una API REST para gestionar información relacionada con vehículos. Permite a los usuarios consultar, crear, actualizar, eliminar y marcar vehículos como finalizados. La API proporciona un conjunto de endpoints para interactuar con la base de datos y modificar la información sobre los vehículos.

## URL de Ejemplo
TP3 API-REST/api/vehiculos


## Endpoints

### Vehículos

#### **GET TP3 API-REST/api/vehiculos**
Devuelve todos los vehículos disponibles en la base de datos. Permite aplicar filtrado, ordenamiento y paginación a los resultados.

**Descripción**:  
Este endpoint permite recuperar una lista de vehículos, con la opción de aplicar filtros y ordenar los resultados por varios campos.

**Parámetros de Query**:
- **vendido**: Si se especifica como `false`, se filtran los vehículos que no están marcados como vendidos.
- **orderBy**: Campo por el que se desea ordenar los resultados. Los campos válidos incluyen:
  - `marca`: Ordena los vehículos por marca.
  - `modelo`: Ordena los vehículos por modelo.
  
- **direccion**: Dirección de orden para el campo especificado en `orderBy`. Puede ser:
  - `ASC`: Orden ascendente (por defecto).
  - `DESC`: Orden descendente.

**Ejemplo de ordenamiento**:  
Para obtener todos los vehículos ordenados por marca en orden descendente:
GET TP3 API-REST/api/vehiculos?orderBy=Marca&direccion=DESC

- **filtro**: Campo por el que se desea filtrar los resultados. Los campos válidos incluyen:
  - ``: Filtra los vehículos por marca.

#### **GET TP3 API-REST/api/vehiculos/:id**
Devuelve el vehículo correspondiente al ID solicitado.

#### **POST TP3 API-REST/api/vehiculos**
Inserta un nuevo vehículo con la información proporcionada en el cuerpo de la solicitud (en formato JSON).

**Campos requeridos**:
- `Marca`: Marca del vehículo.
- `Modelo`: Modelo del vehículo.
- `Kilometros`: Kilometraje del vehículo.
- `Patente`: Número de patente del vehículo.
- `vendido`: Estado del vehículo (1 si esta vendido, 0 si no esta vendido).

**Ejemplo de JSON a insertar**:
```json
{
  "Marca": "Toyota",
  "Kilometros": 30000,
  "Patente": "ABC123",
  "Modelo": "Corolla",
  "vendido": 0
}

#### **PUT TP3 API-REST/api/vehiculos/:id**
Modifica el vehículo correspondiente al ID solicitado. La información a modificar se envía en el cuerpo de la solicitud (en formato JSON).

**Campos modificables**:
- `Marca`: Marca del vehículo.
- `Modelo`: Modelo del vehículo.
- `Kilometros`: Kilometraje del vehículo.
- `Patente`: Número de patente del vehículo.
- `vendido`: Estado del vehículo (1 si esta vendido, 0 si no esta vendido).

**Ejemplo de JSON para actualizar**:
```json
{
  "Marca": "Toyota",
  "Kilometros": 35000,
  "Patente": "DEF456",
  "Modelo": "Corolla",
  "vendido": 1
}

#### ** DELETE TP3 API-REST/api/vehiculos/:id**
Elimina el vehículo correspondiente al ID solicitado.

    
