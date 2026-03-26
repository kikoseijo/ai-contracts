# Política de Versionado C.O.R.E. para ai-contracts

Este documento define la estrategia de versionado y despliegue para el paquete `sunnyface-ai-contracts`. Al ser el "Santuario de los Contratos" entre el Hub y los Spokes, cualquier desincronización puede causar caídas en cascada (errores 422, fallos de hidratación).

## 1. Estrategia por Entorno (Local vs Producción)

### ❌ PROHIBIDO en Producción: `dev-main`

Nunca exijas `"sunnyface/ai-contracts": "dev-main"` en los `composer.json` de producción. Si el Hub se despliega antes que el Spoke, los contratos se desincronizan y el sistema colapsa.

### 💻 Entorno Local (Desarrollo): Symlinks

Para desarrollar con fluidez sin necesidad de hacer commits y tags constantemente, los proyectos consumidores (`sunnyface`, `SunnyGestor`) deben enlazar el paquete localmente:

```json
// En el composer.json del consumidor (solo local)
"repositories": [
    {
        "type": "path",
        "url": "../sunnyface-ai-contracts",
        "options": {
            "symlink": true
        }
    }
],
"require": {
    "sunnyface/ai-contracts": "@dev"
}
```

### 🚀 Entorno de Producción: Tags Fijos

En producción se deben exigir versiones fijas usando Semantic Versioning (SemVer):

```json
"require": {
    "sunnyface/ai-contracts": "^1.2.0"
}
```

---

## 2. Semantic Versioning Estricto para DTOs

Las reglas de SemVer cambian ligeramente cuando hablamos de **Contratos de Red**. Lo que en código normal es una "Minor", aquí puede ser un "Breaking Change" (Major).

* 🟢 **PATCH (`v1.0.1`):** Correcciones internas que no afectan la estructura de los datos.
  * Arreglar docblocks.
  * Corregir métodos helpers internos (ej. `totalTokensIn()`).

* 🟡 **MINOR (`v1.1.0`):** Cambios retrocompatibles (Seguros).
  * Añadir una nueva propiedad **opcional** (`public readonly ?string $new_field = null`).
  * Añadir un nuevo DTO completo.
  * *Por qué es seguro:* Si el Hub se actualiza primero, el Spoke antiguo no enviará ese campo. Al ser `null` por defecto, la validación de Spatie Data no fallará.

* 🔴 **MAJOR (`v2.0.0`):** Breaking Changes (Peligrosos).
  * Añadir una nueva propiedad **requerida** (sin valor por defecto).
  * Cambiar el tipo de una propiedad (ej. de `string` a `array`).
  * Renombrar o eliminar una propiedad.
  * *Por qué rompe:* Si el Hub exige un nuevo campo requerido y el Spoke aún no está actualizado, la petición fallará con un HTTP 422.

---

## 3. Flujo de Despliegue (El Baile de los Contratos)

El orden de despliegue es crítico para mantener el sistema online.

### Para cambios MINOR (Retrocompatibles)

1. Modificas `ai-contracts` y creas el Tag `v1.1.0`.
2. Actualizas el Hub a `^1.1.0` y despliegas.
3. Actualizas los Spokes a `^1.1.0` y despliegas.
*(El orden de los pasos 2 y 3 no importa).*

### Para cambios MAJOR (Breaking Changes)

Si necesitas añadir un campo requerido, debes hacerlo en dos fases para evitar caídas (Zero-Downtime Deployment):

1. **Fase 1 (Transición):**
   * En `ai-contracts`, añades el campo como **opcional** (`?string`). Lanzas `v1.5.0` (Minor).
2. **Fase 2 (Adopción):**
   * Actualizas el Hub y los Spokes para que empiecen a enviar/leer ese campo. Despliegas todos los sistemas.
3. **Fase 3 (Cierre):**
   * En `ai-contracts`, cambias el campo a **requerido** (`string`). Lanzas `v2.0.0` (Major).
4. **Fase 4 (Consolidación):**
   * Actualizas Hub y Spokes a `v2.0.0`.
