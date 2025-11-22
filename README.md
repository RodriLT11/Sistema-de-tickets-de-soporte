# Sistema-de-tickets-de-soporte
Sistema de tickets de soporte (PHP + MySQL + JS + Bootstrap) — gestión de usuarios, tickets, SLA, dashboards y reportes.

================================================================================
1. MÓDULO DE USUARIOS Y AUTENTICACIÓN
================================================================================

ROLES DE USUARIO:
- Cliente: Puede crear y ver sus propios tickets
- Agente de Soporte: Puede ver, responder y gestionar tickets asignados
- Administrador: Control total del sistema

FUNCIONALIDADES DE AUTENTICACIÓN:
- Registro de usuarios con validación de email
- Login/Logout con sesiones seguras
- Recuperación de contraseña por email
- Perfil de usuario editable (avatar, información de contacto)
- Cambio de contraseña desde el perfil
- Verificación de email (opcional pero recomendado)

================================================================================
2. MÓDULO DE TICKETS
================================================================================

CREACIÓN DE TICKETS:
- Formulario con campos:
  * Asunto (obligatorio)
  * Categoría (Técnico, Ventas, Facturación, Otro)
  * Prioridad (Baja, Media, Alta, Urgente)
  * Descripción detallada (editor de texto enriquecido)
  * Adjuntar archivos (imágenes, PDFs, max 5MB)
- Generación automática de número de ticket único
- Asignación automática de estado "Nuevo"
- Timestamp de creación

GESTIÓN DE TICKETS - ESTADOS POSIBLES:
- Nuevo
- Abierto/En Progreso
- En Espera (esperando respuesta del cliente)
- Resuelto
- Cerrado
- Reabierto

VISUALIZACIÓN DE TICKETS:
- Lista de tickets con tabla responsive
- Filtros por:
  * Estado
  * Prioridad
  * Categoría
  * Fecha de creación
  * Agente asignado
- Búsqueda por número de ticket o palabra clave
- Paginación (10-20 tickets por página)
- Ordenamiento por fecha, prioridad, estado

DETALLES DEL TICKET:
- Vista completa del ticket con toda la información
- Historial de cambios de estado
- Timeline de todas las interacciones
- Información del cliente
- Agente asignado actual
- Tiempo transcurrido desde la creación
- Tiempo de primera respuesta
- Tiempo de resolución

================================================================================
3. MÓDULO DE RESPUESTAS Y COMENTARIOS
================================================================================

SISTEMA DE MENSAJES:
- Los clientes pueden responder a sus tickets
- Los agentes pueden responder y agregar notas internas
- Notas internas: Solo visibles para agentes/admins
- Respuestas públicas: Visibles para el cliente
- Editor de texto con formato básico
- Adjuntar archivos en respuestas
- Timestamp en cada mensaje
- Indicador de quién escribió el mensaje

NOTIFICACIONES:
Email automático cuando:
- Se crea un nuevo ticket
- Un agente responde
- El cliente responde
- Cambia el estado del ticket
- Se asigna o reasigna un ticket
- Notificaciones en el sistema (badge con contador)

================================================================================
4. MÓDULO DE ASIGNACIÓN
================================================================================

ASIGNACIÓN DE TICKETS:
- Asignación manual por administradores
- Auto-asignación por agentes disponibles
- Reasignación de tickets
- Transferencia entre departamentos/categorías
- Historial de asignaciones

GESTIÓN DE CARGA DE TRABAJO:
- Ver tickets asignados por agente
- Límite configurable de tickets activos por agente
- Balance automático de carga (opcional)

================================================================================
5. DASHBOARD Y REPORTES
================================================================================

DASHBOARD PARA CLIENTES:
- Total de tickets creados
- Tickets abiertos actuales
- Tickets resueltos
- Tiempo promedio de resolución
- Últimos tickets creados

DASHBOARD PARA AGENTES:
- Tickets asignados pendientes
- Tickets nuevos sin asignar
- Tickets urgentes
- Tickets en espera de respuesta
- Métricas personales (tiempo respuesta, resolución)

DASHBOARD PARA ADMINISTRADORES:

Métricas generales:
- Total de tickets por estado
- Tickets por categoría
- Tickets por prioridad
- Gráficos de tendencias (últimos 7, 30 días)

Métricas de rendimiento:
- Tiempo promedio de primera respuesta
- Tiempo promedio de resolución
- Tasa de satisfacción del cliente
- Tickets resueltos vs nuevos

Rendimiento por agente:
- Tickets resueltos por agente
- Tiempo promedio de respuesta
- Tickets activos por agente
- Calificación promedio

REPORTES EXPORTABLES:
- Generar reportes en PDF
- Filtrar por rango de fechas
- Reportes por categoría, agente, estado
- Exportar listado de tickets a Excel/CSV

================================================================================
6. MÓDULO DE ADMINISTRACIÓN
================================================================================

GESTIÓN DE USUARIOS:
- Listar todos los usuarios
- Crear/editar/desactivar usuarios
- Asignar y cambiar roles
- Ver actividad de usuarios
- Resetear contraseñas

CONFIGURACIÓN DEL SISTEMA:
- Categorías de tickets (CRUD)
- Plantillas de respuestas predefinidas
- Configuración de emails (remitente, plantillas)
- Ajustes de notificaciones
- Reglas de auto-asignación
- Horario de atención

BASE DE CONOCIMIENTO (Opcional pero recomendado):
- Artículos de ayuda/FAQs
- Categorización de artículos
- Búsqueda en la base de conocimiento
- Sugerir artículos relacionados al crear ticket

================================================================================
7. FUNCIONALIDADES ADICIONALES
================================================================================

SISTEMA DE SATISFACCIÓN:
- Calificación del servicio (1-5 estrellas)
- Comentario opcional del cliente
- Solicitar calificación al cerrar ticket
- Ver calificaciones en el dashboard

SISTEMA DE ETIQUETAS/TAGS:
- Agregar etiquetas personalizadas a tickets
- Filtrar por etiquetas
- Etiquetas predefinidas y personalizadas

BÚSQUEDA AVANZADA:
- Búsqueda por múltiples criterios
- Búsqueda en contenido de mensajes
- Guardar búsquedas frecuentes

SISTEMA DE SLA (Service Level Agreement):
- Definir tiempos máximos por prioridad
- Alertas cuando se acerca el límite
- Marcadores visuales de tickets vencidos
- Métricas de cumplimiento de SLA

HISTORIAL Y AUDITORÍA:
- Log completo de todas las acciones
- Quién hizo qué y cuándo
- Cambios en tickets
- Acciones administrativas

================================================================================
8. CARACTERÍSTICAS TÉCNICAS
================================================================================

SEGURIDAD:
- Contraseñas hasheadas (password_hash)
- Protección contra SQL Injection (prepared statements)
- Protección contra XSS
- Validación de archivos subidos
- CSRF tokens en formularios
- Control de acceso por roles

PERFORMANCE:
- Índices en base de datos
- Paginación eficiente
- Caché de consultas frecuentes (opcional)
- Optimización de imágenes subidas

RESPONSIVIDAD:
- Diseño 100% responsive con Bootstrap
- Mobile-first approach
- Compatible con tablets y smartphones

USABILIDAD:
- Interfaz intuitiva y limpia
- Feedback visual de acciones (toasts/alerts)
- Loading spinners en operaciones AJAX
- Confirmaciones para acciones críticas
- Breadcrumbs de navegación
- Tooltips explicativos

================================================================================
9. ESTRUCTURA DE BASE DE DATOS
================================================================================

TABLAS PRINCIPALES:

1. users
   - id, username, email, password, role, avatar, created_at, status

2. tickets
   - id, ticket_number, user_id, agent_id, category_id, priority, subject, 
     status, created_at, updated_at, closed_at

3. ticket_messages
   - id, ticket_id, user_id, message, is_internal, created_at, attachments

4. categories
   - id, name, description

5. attachments
   - id, ticket_id, message_id, filename, filepath, filesize, uploaded_by, 
     created_at

6. ticket_history
   - id, ticket_id, user_id, action, old_value, new_value, created_at

7. ratings
   - id, ticket_id, user_id, rating, comment, created_at

8. notifications
   - id, user_id, ticket_id, message, is_read, created_at

9. knowledge_base
   - id, title, content, category_id, views, created_at

10. tags
    - id, name

11. ticket_tags
    - ticket_id, tag_id

================================================================================
10. FUNCIONALIDADES AJAX
================================================================================

- Actualización de estado de ticket sin recargar
- Envío de respuestas en tiempo real
- Marcar notificaciones como leídas
- Auto-guardado de borradores
- Búsqueda predictiva
- Cargar más tickets (infinite scroll opcional)

================================================================================
================================================================================

Stack tecnológico:
- Backend: PHP
- Frontend: HTML, CSS, JavaScript, Bootstrap
- Base de datos: MySQL

El proyecto incluye todos los aspectos de un sistema de soporte profesional
incluyendo autenticación, autorización, CRUD completo, dashboards, reportes,
notificaciones y características avanzadas como SLA y base de conocimiento.
