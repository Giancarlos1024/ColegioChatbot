# Plan: Sistema de Login y Registro para Alumnas

## Pasos a Implementar:

### 1. **Rutas Separadas** ✅
- [x] `/student/login` → Login de estudiantes
- [x] `/student/register` → Registro de estudiantes
- [x] `/student/dashboard` → Dashboard de estudiantes
- [x] `/student/inscripciones` → Ver inscripciones
- [x] `/student/inscribirse/{taller}` → Inscribirse a taller
- [x] `/student/desinscribirse/{taller}` → Desinscribirse de taller

### 2. **Controladores** ✅
- [x] `StudentAuthController` → Para login/registro de estudiantes
- [x] `StudentController` → Dashboard de estudiantes

### 3. **Vistas**
- [ ] Login de estudiantes (`resources/js/pages/student/Login.vue`)
- [ ] Registro de estudiantes (`resources/js/pages/student/Register.vue`)
- [ ] Dashboard de estudiantes (`resources/js/pages/student/Dashboard.vue`)

### 4. **Actualizaciones** ✅
- [x] Actualizar botones en Inicio.vue → `/student/login` y `/student/register`

### 5. **Funcionalidades Específicas**
- [ ] Inscripción a talleres para estudiantes
- [ ] Ver sus inscripciones activas
- [ ] Perfil de estudiante

### 6. **Limpieza**
- [ ] Eliminar modelo Inscripcion temporal (ya no necesario)
- [ ] Crear layout para estudiantes
- [ ] Configurar modelo User para relación con talleres
