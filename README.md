# SocialHelp — Sistema de Gestão de Programas Sociais

SocialHelp visa digitalizar e optimizar o registo e distribuição de ajuda social: cadastro de famílias, análise socioeconómica, priorização de beneficiários (IA), relatórios e portal público.

## Requisitos
- PHP >= 8.2
- Composer
- Node.js + npm
- SQLite /MySQL / PostgreSQL (ou outro suportado)
- Extensões PHP conforme `composer.json`

## Instalação rápida
```sh
# Instalar dependências PHP
composer install

# Copiar o exemplo de .env e gerar chave
cp .env.example .env
php artisan key:generate

# Instalar dependências JS
npm install
```

## Configuração (APP URL e variáveis)
Edite o ficheiro `.env` (copiado de [`.env.example`](.env.example)) e defina a URL da aplicação:
```
APP_URL=http://localhost:8000
```
Se usar SPA/API com Sanctum, ajuste também `SANCTUM_STATEFUL_DOMAINS` em [config/sanctum.php](config/sanctum.php) para incluir o domínio/porta do frontend.

Configurar DB no `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_db
DB_USERNAME=user
DB_PASSWORD=secret
```

## Migrar e popular BD
```sh
php artisan migrate
php artisan db:seed   # opcional
```
Exemplos de migrações: [database/migrations/2026_01_08_095317_create_institutions_table.php](database/migrations/2026_01_08_095317_create_institutions_table.php), [database/migrations/2026_01_08_101759_create_family_members_table.php](database/migrations/2026_01_08_101759_create_family_members_table.php)

## Executar em desenvolvimento
```sh
# Backend
php artisan serve --host=127.0.0.1 --port=8000

# Frontend (Vite)
npm run dev
```
Para SSR/Inertia verifique [config/inertia.php](config/inertia.php) e [resources/js/ssr.ts](resources/js/ssr.ts).

## Build para produção
```sh
npm run build
php artisan migrate --force
# configurar servidor web (NGINX/Apache) apontando para /public
```

## API e documentação
A API tem rotas em [routes/api.php](routes/api.php) e web em [routes/web.php](routes/web.php). A especificação OpenAPI está em [resources/swagger/openapi.json](resources/swagger/openapi.json) e a UI em [config/swagger-ui.php](config/swagger-ui.php).

Exemplo de endpoint de registo de instituições: [`App\Http\Controllers\Api\V1\Public\InstitutionRegistrationController::store`](app/Http/Controllers/Api/V1/Public/InstitutionRegistrationController.php)

## Testes
```sh
php artisan test
```

## Notas úteis
- Serviços, controllers e modelos relevantes: [app/Services/ProjectService.php](app/Services/ProjectService.php), [app/Models/Project.php](app/Models/Project.php).
- Para seleção de instituição e contexto da API veja [routes/api.php](routes/api.php) e [bootstrap/app.php](bootstrap/app.php).

---
Licença e contribuições: veja `composer.json` e padrões do repositório.