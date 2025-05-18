# Laravel API: Testülesanne / Test task

## Projekt lokaselt käima / Run locally (first time setup/ ühekordne):

```
git clone <repo-url>| 
cd task-manager-api|
composer install|
cp .env.example .env|
touch database/database.sqlite|
php artisan migrate --seed|
php artisan serve

## Autentimine / AUTH

POST /api/login

Body (JSON):

{
  "email": "admin@example.com",
  "password": "password123"
}

Tagastab Bearer Tokeni.

## API Endpointid

| Meetod | Endpoint                 | 
| ------ | ------------------------ | 
| GET    | `/api/ping`              | 
| POST   | `/api/login`             | 
| GET    | `/api/tasks`             | 
| POST   | `/api/tasks`             | 
| PUT    | `/api/tasks/{id}`        | 
| DELETE | `/api/tasks/{id}`        | 
| POST   | `/api/tasks/{id}/upload` | 

NB: Kõik ülesande endpointid vajavad Bearer Tokenit / All endpoints need the Bearer Token

Authorization: Bearer <TOKEN>

## Faili üleslaadimine / Upload file (näiteks ise kasutasin CV-d/I used CV as test)

bash
curl -X POST http://127.0.0.1:8000/api/tasks/1/upload \
  -H "Authorization: Bearer <TOKEN>" \
  -F "file=@/Users/username/cv.pdf"

---
Andero Voosalu