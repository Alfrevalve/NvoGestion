# Esquema Detallado del Proyecto

## 1. Módulos
El sistema se divide en tres módulos principales, cada uno encargado de una parte del proceso completo:

### Cirugías
- **Funcionalidad principal**: Gestión integral de las cirugías programadas. Permite programar nuevas cirugías, asignar recursos e instrumentistas, y hacer seguimiento del estado de cada cirugía (programada, en proceso, realizada, cancelada). Este módulo se ha actualizado para incluir nuevas características de seguimiento en tiempo real.

- **Características**: Incluye formularios para registrar datos de la cirugía (fecha, hora, tipo de procedimiento, hospital/clínica, paciente si corresponde, equipo médico involucrado) y las necesidades de instrumental o insumos quirúrgicos. Este módulo se integra con Almacén para reservar el instrumental necesario y con Despacho para coordinar la entrega de insumos a la ubicación de la cirugía.
- **Interacciones**: Genera solicitudes al almacén para preparar kits quirúrgicos, y notifica al módulo de despacho cuando un kit está listo para ser enviado. También permite registrar la finalización de la cirugía y confirmar el consumo o devolución de insumos e instrumentos.

### Almacén
- **Funcionalidad principal**: Administración del inventario de insumos e instrumentos. Controla las existencias en tiempo real, el ingreso de nuevos productos, la reserva y salida de artículos para cirugías, y la devolución o reposición de stock. Se han implementado alertas de stock bajo para mejorar la gestión de inventario.

- **Características**: Proporciona pantallas para registrar entradas de stock (recepción de compras o devoluciones post-cirugía) y salidas de stock (prestación de instrumental para cirugía, consumibles utilizados). Maneja ubicaciones físicas dentro del almacén para cada artículo, niveles mínimos y máximos de inventario, y alertas de stock bajo. Incluye un registro histórico de movimientos de inventario (kardex), y la generación de pedidos de reposición cuando sea necesario.
- **Interacciones**: Recibe solicitudes desde Cirugías con la lista de instrumentos/insumos requeridos para cada cirugía, descontando temporalmente esos artículos del inventario (reservándolos). Una vez terminada la cirugía, ajusta las existencias según consumos reales o devoluciones. Además, interactúa con Despacho proporcionando los productos que deben ser enviados y actualizando el estado cuando el despacho retira o entrega mercadería.

### Despacho
- **Funcionalidad principal**: Manejo de la distribución y entrega de materiales. Coordina la preparación de envíos, la asignación de despachadores y vehículos, y el seguimiento de entregas de instrumental e insumos desde el almacén hasta el lugar de cirugía (u otro destino requerido). Se han mejorado los tiempos de entrega mediante la optimización de rutas.

- **Características**: Permite crear órdenes de despacho ligadas a cirugías o ventas, con detalles como dirección de entrega, fecha/hora límite de entrega, contenido del paquete (lista de ítems desde el almacén) y responsable del envío. Incluye la gestión del estado del despacho (pendiente, en tránsito, entregado) y la opción de registrar devoluciones (por ejemplo, recolección de instrumentos usados post-cirugía para retornarlos al almacén).
- **Interacciones**: Toma insumos del módulo Almacén cuando una orden de envío es generada. Notifica a los involucrados (ej. Jefe de Despacho, Despachador asignado, Instrumentista receptor) sobre el envío. Al confirmar la entrega, informa al módulo Cirugías que el material ha llegado a destino y al Almacén si hay que actualizar el inventario (por ejemplo, marcando instrumentos como "en uso" o registrando devoluciones tras la cirugía).

## 2. Roles de Usuarios
El sistema contempla distintos perfiles de usuario, cada uno con permisos y vistas acordes a sus responsabilidades. Se han añadido nuevos roles para mejorar la gestión de usuarios.

- **Administrador General**: Control total del sistema.
- **Gerente**: Acceso a informes globales y dashboards de alto nivel.
- **Jefe de Línea**: Responsable de una línea de producto o cirugía.
- **Instrumentista**: Encargado del instrumental quirúrgico.
- **Jefe de Almacén**: Encargado de las operaciones de almacén.
- **Almacenista**: Personal operativo del almacén.
- **Jefe de Despacho**: Responsable de la logística de envíos.
- **Despachador**: Personal de logística que realiza físicamente el despacho.
- **Vendedor**: Ejecutivo comercial que genera solicitudes de servicio.

## 3. Métricas Clave y Dashboards
- **Cirugías**: Número de cirugías programadas vs. realizadas, tasa de cancelación, tiempo de preparación, duración promedio, consumo de recursos. Se han añadido nuevas métricas para un análisis más detallado.

- **Almacén**: Nivel de stock actual, ítems bajo mínimos, rotación de inventario, entradas y salidas mensuales, exactitud de inventario.
- **Despacho**: Órdenes de despacho realizadas vs. pendientes, tiempos de entrega promedio, porcentaje de entregas a tiempo.

## 4. Notificaciones
El sistema incorpora un mecanismo de notificaciones para mantener informados a los usuarios adecuados en cada paso del proceso.

## 5. Interfaz Visual
La aplicación tendrá una interfaz web responsiva e intuitiva, construida con el framework Bootstrap.

## 6. Flujo General del Sistema
Se describe el flujo de procesos principales del sistema, integrando los módulos mencionados.
