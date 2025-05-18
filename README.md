# Laravel API: Testülesanne

## Projekt lokaselt käima:

git clone <repo-url>
cd task-manager-api
composer install
cp .env.example .env
touch database/database.sqlite
php artisan migrate --seed
php artisan serve

## Autentimine / AUTH

POST /api/login

Body (JSON):

{
  "email": "test@example.com",
  "password": "salasona"
}

Tagastab Bearer Tokeni.

## API Endpointid

| Meetod | Endpoint                 | Kirjeldus                |
| ------ | ------------------------ | ------------------------ |
| GET    | `/api/ping`              | Kontroll, kas API töötab |
| POST   | `/api/login`             | Logi sisse               |
| GET    | `/api/tasks`             | Tagasta kõik ülesanded   |
| POST   | `/api/tasks`             | Loo uus ülesanne         |
| PUT    | `/api/tasks/{id}`        | Uuenda olemasolevat      |
| DELETE | `/api/tasks/{id}`        | Kustuta ülesanne         |
| POST   | `/api/tasks/{id}/upload` | Laadi fail üles          |

NB: Kõik ülesande endpointid vajavad Bearer Tokenit / All endpoints need the Bearer Token

Authorization: Bearer <TOKEN>

## Faili üleslaadimine / Upload file (näiteks ise kasutasin CV-d/I used CV as test)

bash
curl -X POST http://127.0.0.1:8000/api/tasks/1/upload \
  -H "Authorization: Bearer <TOKEN>" \
  -F "file=@/Users/username/cv.pdf"

## Tehtud / Done

* Autentimine Sanctumiga / AUTH using Sanctum
* Seeder testkasutajaga: [test@example.com] / Seeder w/ test user:test@example.com ; salasona (password)
* CRUD API ülesannetele / CRUD API for tasks
* Failide üleslaadimine `storage/app/public/tasks` kausta / file upload to storage/app/public/tasks 
* UUID automaatne genereerimine / Automatic UUID generation 

---
Andero Voosalu