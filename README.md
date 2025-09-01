# Waduh

```
git clone
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan serve
```

Postman : [https://lively-comet-123963.postman.co/workspace/Net~b7ddf97e-3e6c-4f8d-a27d-8118e4a74e1d/collection/29772837-cee3c45f-bc39-4e25-bf37-0636d0cb0d84?action=share&creator=21226752](https://lively-comet-123963.postman.co/workspace/Net~b7ddf97e-3e6c-4f8d-a27d-8118e4a74e1d/collection/29772837-cee3c45f-bc39-4e25-bf37-0636d0cb0d84?action=share&creator=21226752)

## Important Directories

```
.
├── app/
│   ├── Http/
│   │   └── Api
│   ├── Livewire/
│   │   ├── Cms
│   │   └── Form
│   ├── Models
│   ├── Providers
│   └── Traits
├── config
├── database
├── resources/
│   └── views/
│       ├── components
│       └── livewire
└── routes
```
## Setup 

# Run this once on your server
php artisan storage:link


## Diagnostic

List all rooms for the current hotel
curl -X GET \
  http://backend-url/api/v1/room \
  -H "X-API-KEY: <your_encrypted_token>" \
  -H "Accept: application/json"

Check your user–hotel mapping
  curl -X GET \
  http://backend-url/api/v1/hotel \
  -H "X-API-KEY: <your_encrypted_token>" \
  -H "Accept: application/json"

Verify room types (optional)
curl -X GET \
  http://backend-url/api/v1/room/type \
  -H "X-API-KEY: <your_encrypted_token>" \
  -H "Accept: application/json"