# 🔐 CONFIGURACIÓN DETALLADA: CI/CD GITHUB ACTIONS

## 1️⃣ PASO A PASO: CREAR TOKEN DOCKERHUB

### Opción A: Desde la web

**Ubicación:** https://hub.docker.com/settings/security

1. Click en **"New Access Token"**
   ```
   Name: github-actions-token
   Access: Read, Write, Delete ✓
   ```

2. Copiar el token que aparece:
   ```
   dckr_pat_xxxxxxxxxxxxxxxxxxxx  ← COPIAR ESTO
   ```

---

## 2️⃣ PASO A PASO: OBTENER CLAVE SSH DE AWS

### Si ya tienes la instancia EC2

1. En AWS Console → EC2 → Instances
2. Selecciona tu instancia
3. **Security → Key pair**
4. Si no tienes descargada:
   - Crea nueva: **Actions → Security Groups → ...**
   - O descarga la existente

### Convertir certificado si es necesario

```bash
# Si tienes .pem
chmod 600 tu-archivo.pem

# Si tienes .ppk (PuTTY), convertir:
# (usar PuTTYgen o openssl)
```

### Copiar contenido

```bash
cat tu-archivo.pem
```

Debería verse así:
```
-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEA2vbTnz...
... muchas líneas ...
-----END RSA PRIVATE KEY-----
```

**COPIAR TODO** (incluyendo BEGIN y END)

---

## 3️⃣ PASO A PASO: GITHUB SECRETS

### Ir a GitHub

1. Tu repositorio → **Settings**
2. Left panel → **Secrets and variables → Actions**
3. Click **"New repository secret"**

### Agregar Secret #1: DOCKER_USERNAME

```
Name: DOCKER_USERNAME
Value: tu-usuario-dockerhub
       (ej: darglas12)

[Add secret]
```

### Agregar Secret #2: DOCKER_PASSWORD

```
Name: DOCKER_PASSWORD
Value: dckr_pat_xxxxxxxxxxxx  (tu token)

[Add secret]
```

### Agregar Secret #3: SSH_PRIVATE_KEY

```
Name: SSH_PRIVATE_KEY
Value: -----BEGIN RSA PRIVATE KEY-----
       MIIEpAIBAAKCAQEA...
       ... todo el contenido ...
       -----END RSA PRIVATE KEY-----

[Add secret]
```

**⚠️ IMPORTANTE:** No agregar espacios extra, copiar exactamente

---

## 4️⃣ EDITAR ARCHIVO WORKFLOW

### Archivo: `.github/workflows/ci-cd-workflow.yml`

Busca la sección `env:` (alrededor de línea 15):

```yaml
env:
  DOCKER_USERNAME: ${{ secrets.DOCKER_USERNAME }}
  DOCKER_PASSWORD: ${{ secrets.DOCKER_PASSWORD }}
  SSH_PRIVATE_KEY: ${{ secrets.SSH_PRIVATE_KEY }}
  # ↓↓↓ EDITAR ESTOS (líneas 23-26) ↓↓↓
  AWS_HOST: "tu-ip-o-dns-aqui.com"           # ← CAMBIAR ESTO
  AWS_USER: "ubuntu"                         # ← CAMBIAR ESTO
  AWS_PORT: "22"                             # ← CAMBIAR ESTO SI ES DIFERENTE
  DOCKER_IMAGE_NAME: "tu-usuario/crud-php"  # ← CAMBIAR ESTO
  APP_DIRECTORY: "/home/ubuntu/app"          # ← CAMBIAR ESTO SI DESEAS
```

### Ejemplo de ANTES:

```yaml
AWS_HOST: "tu-ip-o-dns-aqui.com"
AWS_USER: "ubuntu"
DOCKER_IMAGE_NAME: "tu-usuario/crud-php"
```

### Ejemplo de DESPUÉS (completado):

```yaml
AWS_HOST: "3.82.191.151"
AWS_USER: "ubuntu"
DOCKER_IMAGE_NAME: "darglas12/crud-php"
```

---

## 5️⃣ VERIFICAR DOCKER EN AWS

### Conectar a tu servidor

```bash
ssh -i tu-clave.pem ubuntu@3.82.191.151
# Reemplazar 3.82.191.151 con tu IP/DNS
```

### Instalar Docker si no está

```bash
# Actualizar
sudo apt update

# Instalar Docker
sudo apt install -y docker.io docker-compose ubuntu-docker-plugin

# O usar instalador oficial
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Agregar tu usuario a grupo docker
sudo usermod -aG docker ubuntu

# Log out y log in para aplicar cambios
exit
ssh -i tu-clave.pem ubuntu@3.82.191.151
```

### Verificar que funciona

```bash
docker run hello-world
```

---

## 6️⃣ SUBIR CAMBIOS A GIT

```bash
# Desde tu máquina local
cd /home/ubuntu/actividad61-aplicacion-php-produccion

git add .github/workflows/ci-cd-workflow.yml
git add TAREA7_CI_CD_SETUP.md
git commit -m "Agregar flujo CI/CD con GitHub Actions"
git push origin main
```

### Verificar en GitHub

1. Ve a tu repositorio
2. Verifica que ves:
   - `.github/workflows/ci-cd-workflow.yml` en el árbol de archivos
   - `TAREA7_CI_CD_SETUP.md` en la raíz

---

## 🧪 PRUEBA INICIAL

### Primera ejecución (manual)

Después de subir el workflow, GitHub lo detectará automáticamente.

1. Ve a **Actions** en GitHub
2. Verás "CI/CD Pipeline - CRUD PHP Application"
3. Para iniciar: haz cualquier cambio y push
   ```bash
   # o simplemente
   echo "# Test" >> README.md
   git add README.md
   git commit -m "Test CI/CD"
   git push
   ```

### Ver ejecución

1. GitHub → **Actions**
2. Click en el workflow
3. Ver el progreso de cada stage:
   - 🔨 Build (verde = OK)
   - 📦 Push (verde = OK)
   - 🚀 Deploy (verde = OK)
   - 📢 Notify (verde = OK)

---

## 🔍 VERIFICAR EN AWS

Mientras se ejecuta el workflow, conecta a tu servidor:

```bash
# En otra terminal
ssh -i tu-clave.pem ubuntu@tu-ip

# Ver contenedores en tiempo real
watch -n 2 docker-compose ps
# O una sola vez
docker-compose ps

# Ver logs
docker-compose logs -f
```

---

## ✅ VALIDACIÓN FINAL

Después de completar la configuración:

### En GitHub
- [ ] Secrets creados y visibles en Settings
- [ ] Archivo workflow en `.github/workflows/ci-cd-workflow.yml`
- [ ] Variables editadas con tus valores

### En AWS
- [ ] Docker instalado
- [ ] Servidor SSH accesible
- [ ] Puertos 80, 443 abiertos

### Primer despliegue
- [ ] Hacer push
- [ ] Ver Actions en ejecución
- [ ] Comprobar logs
- [ ] Verificar contenedores en AWS

---

## 🐛 SOLUCIÓN DE PROBLEMAS

### Workflow no aparece en GitHub Actions
- Verificar que archivo está en `.github/workflows/ci-cd-workflow.yml`
- Activar Actions si está deshabilitado: Settings → Actions → Enable

### BUILD falla
- Verificar que Dockerfile existe en `aplicacion-crud-php-desarrollo-v3/`
- Comprobar sintaxis del Dockerfile

### PUSH falla (error de autenticación)
- Verificar que DOCKER_USERNAME y DOCKER_PASSWORD están correctos
- Probar manualmente:
  ```bash
  docker login -u tu-usuario -p tu-token
  ```

### DEPLOY falla (error de SSH)
- Verificar que SSH_PRIVATE_KEY es exacto (sin espacios extra)
- Probar SSH manualmente:
  ```bash
  ssh -i tu-clave.pem ubuntu@tu-ip
  ```
- Comprobar que puerto 22 está abierto en Security Group

### En AWS: "Docker not found"
- Instalar Docker en el servidor AWS

---

## 📊 FLUJO DETALLADO

```
┌─────────────────────────────────────────────────────────┐
│ git push                                                │
└────────────────┬────────────────────────────────────────┘
                 │
                 ▼
        ┌────────────────┐
        │ GitHub Webhook │
        └────────┬───────┘
                 │
        ┌────────▼──────────────┐
        │ GitHub Actions Starts │
        └────────┬──────────────┘
                 │
    ┌────────────┼────────────┐
    │            │            │
    ▼            ▼            ▼
 BUILD       needs: -     needs: -
 ├─ Checkout  build      build, push
 ├─ Build     
 └─ Test       PUSH        DEPLOY
                ├─ Login    ├─ SSH Key
                ├─ Build    ├─ SSH Connect
                └─ Push     ├─ Docker Pull
                            └─ Docker Up
                 │            │
                 └────────┬────┘
                          │
                    ┌─────▼─────┐
                    │   NOTIFY   │
                    │ Send Result│
                    └────────────┘
```

---

## 🎯 SUMMARY

**Lo que hace el workflow cada vez que haces `git push`:**

1. **BUILD** - Construye imagen Docker desde tu código
2. **PUSH** - Sube imagen a DockerHub
3. **DEPLOY** - Se conecta a AWS por SSH
4. **RUN** - Descarga imagen y ejecuta contenedores
5. **NOTIFY** - Envia resultado del deployment

**Sin que tengas que hacer nada = ¡Automatización total!**

---
