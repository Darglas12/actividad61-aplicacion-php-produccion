# 🚀 TAREA 7: CI/CD CON GITHUB ACTIONS

## ✅ LO QUE YA ESTÁ HECHO AUTOMÁTICAMENTE

He creado:
- ✓ Directorio `.github/workflows/`
- ✓ Archivo `ci-cd-workflow.yml` con toda la configuración
- ✓ 4 stages implementados (BUILD, PUSH, DEPLOY, NOTIFY)

---

## 📋 PASOS QUE DEBES HACER (MANUAL)

### PASO 1️⃣: CONFIGURAR DOCKERHUB

**Objetivo:** Crear credenciales para subir imágenes a DockerHub

1. Ve a https://hub.docker.com
2. Login con tu cuenta (crear si no tienes)
3. Ve a **Account Settings → Security**
4. Click en **New Access Token**
   - Nombre: `github-actions-token`
   - Acceso: Read, Write, Delete
5. **Copiar el token completo** (aparece una sola vez)

✅ **Necesitarás:**
- Tu usuario de DockerHub (ej: `tu-usuario`)
- El token copiado

---

### PASO 2️⃣: OBTENER CERTIFICADO SSH DE AWS

**Objetivo:** Obtener las credenciales para conectarse al servidor de producción

1. Ve a tu instancia EC2 en AWS
2. Si no tienes la clave, descárgala:
   - EC2 Dashboard → Instances → tu-instancia
   - Security → Key pair → descargar `.pem`
3. Abre el archivo `.pem` con un editor
4. **Copiar TODO el contenido** (desde `-----BEGIN` hasta `-----END`)

✅ **Necesitarás:**
- IP o DNS del servidor
- Usuario SSH (ubuntu, ec2-user, etc)
- Contenido del certificado `.pem`

---

### PASO 3️⃣: CONFIGURAR SECRETS EN GITHUB

**Objetivo:** Guardar credenciales de forma segura en GitHub

1. Ve a tu repositorio GitHub
2. **Settings → Secrets and variables → Actions**
3. Click **New repository secret**

**Crear estos 3 secrets:**

#### Secret 1: `DOCKER_USERNAME`
- Valor: Tu usuario de DockerHub (ej: `darglas12`)
- Click "Add secret"

#### Secret 2: `DOCKER_PASSWORD`
- Valor: El token de DockerHub (completo)
- Click "Add secret"

#### Secret 3: `SSH_PRIVATE_KEY`
- Valor: Contenido completo del `.pem`
- **Incluye las líneas:**
  ```
  -----BEGIN RSA PRIVATE KEY-----
  [contenido del medio]
  -----END RSA PRIVATE KEY-----
  ```
- Click "Add secret"

---

### PASO 4️⃣: EDITAR VARIABLES EN EL WORKFLOW

**Archivo a editar:** `.github/workflows/ci-cd-workflow.yml`

Busca la sección `env:` y reemplaza estos valores:

```yaml
env:
  # ... otros valores ...
  AWS_HOST: "tu-ip-o-dns-aqui.com"           # ← TU IP o DNS de AWS
  AWS_USER: "ubuntu"                         # ← Tu usuario SSH
  AWS_PORT: "22"                             # ← Puerto SSH (generalmente 22)
  DOCKER_IMAGE_NAME: "tu-usuario/crud-php"  # ← tu-usuario/nombre-repo
  APP_DIRECTORY: "/home/ubuntu/app"          # ← Directorio en AWS
```

**Ejemplo completado:**
```yaml
AWS_HOST: "3.82.191.151"
AWS_USER: "ubuntu"
AWS_PORT: "22"
DOCKER_IMAGE_NAME: "darglas12/crud-php"
APP_DIRECTORY: "/home/ubuntu/crud-app"
```

---

### PASO 5️⃣: VERIFICAR QUE DOCKER COMPOSE ESTÉ EN AWS

En tu servidor AWS, crea el directorio de la app:

```bash
ssh -i tu-clave.pem ubuntu@tu-ip
mkdir -p /home/ubuntu/crud-app
cd /home/ubuntu/crud-app
# Aquí se descargará el docker-compose.yml automáticamente
```

---

## 🔄 FLUJO AUTOMÁTICO (DESPUÉS DE CONFIGURAR)

Una vez que todo esté configurado, cada vez que hagas:

```bash
git push
```

Se ejecutará **AUTOMÁTICAMENTE**:

```
1️⃣ BUILD
   └─ Construye imagen Docker
   └─ La prueba

2️⃣ PUSH  
   └─ Sube a DockerHub
   └─ Imagen: tu-usuario/crud-php:latest

3️⃣ DEPLOY
   └─ Se conecta a AWS por SSH
   └─ Descarga imagen de DockerHub
   └─ Ejecuta docker-compose up -d

4️⃣ NOTIFY
   └─ Envía resumen del despliegue
```

---

## 📊 VERIFICAR QUE FUNCIONA

### Ver el workflow en GitHub:

1. Ve a tu repositorio
2. Click en **Actions**
3. Verás los workflows ejecutándose
4. Click para ver detalles

### Ver logs:

En GitHub Actions → workflow → haz click para ver cada paso

---

## 🛠️ TROUBLESHOOTING

### ❌ Error: "Cannot connect to Docker daemon"
- El servidor AWS necesita tener Docker instalado
- Instalar: `sudo apt update && sudo apt install -y docker.io docker-compose`

### ❌ Error: "Permission denied" en SSH
- Verificar que la clave `.pem` está correcta
- Certificado SSH debe tener permisos: `chmod 600 tu-clave.pem`

### ❌ Error: "Image pull failed"
- Verificar que las credenciales de DockerHub son correctas
- En AWS: `docker login -u tu-usuario` y probar

### ❌ Workflow no inicia
- Verificar que el archivo `.yml` está en `.github/workflows/`
- Validar sintaxis YAML (no usar tabulaciones, solo espacios)

---

## 📁 ESTRUCTURA FINAL DE ARCHIVOS

```
tu-repositorio/
├── .github/
│   └── workflows/
│       └── ci-cd-workflow.yml          ← NUESTRO WORKFLOW
├── aplicacion-crud-php-desarrollo-v3/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── src/
│   └── ...
└── README.md
```

---

## ✅ CHECKLIST DE CONFIGURACIÓN

- [ ] Crear token en DockerHub
- [ ] Copiar certificado `.pem` de AWS
- [ ] Agregar 3 secrets en GitHub:
  - [ ] DOCKER_USERNAME
  - [ ] DOCKER_PASSWORD
  - [ ] SSH_PRIVATE_KEY
- [ ] Editar variables en workflow.yml:
  - [ ] AWS_HOST
  - [ ] AWS_USER
  - [ ] DOCKER_IMAGE_NAME
  - [ ] APP_DIRECTORY
- [ ] Instalar Docker en servidor AWS
- [ ] Hacer commit y push de cambios

---

## 🚀 PRIMER DEPLOYMENT

Una vez configurado todo:

```bash
# 1. Hacer cambios (si quieres)
git add .
git commit -m "Agregar CI/CD workflow"

# 2. Push (se ejecuta workflow automáticamente)
git push

# 3. Ir a GitHub → Actions para ver ejecución
# 4. Ver resultado en AWS
```

---

## 📞 REFERENCIA RÁPIDA

| Componente | Ubicación | Qué hace |
|-----------|-----------|----------|
| Workflow | `.github/workflows/ci-cd-workflow.yml` | Orquesta toda la automatización |
| Secrets | GitHub Settings → Secrets | Almacena credenciales seguras |
| Build | Stage 1 | Construye imagen Docker |
| Push | Stage 2 | Sube a DockerHub |
| Deploy | Stage 3 | Conecta SSH y despliega |
| Notify | Stage 4 | Notifica resultado |

---

## 📚 CONCEPTOS CI/CD

- **CI (Continuous Integration):** BUILD - Construir y probar automáticamente
- **CD (Continuous Delivery):** PUSH - Entregar imagen lista
- **CD (Continuous Deployment):** DEPLOY - Desplegar automáticamente a producción

---

**PRÓXIMO PASO:** Ve a tu repositorio GitHub y configura los secrets. Después, edita el archivo workflow con tus datos. ¡Luego el CI/CD funcionará automáticamente!

