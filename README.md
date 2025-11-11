# Laravel Project Test

Requirement:
- [x] <a href="#get-users">Get Users</a>
- [x] <a href="#create-user">Create Users</a>

## Authentication
- [x] <a href="#login">Login</a>

## Login
endpoint: /api/login
method: POST
body:
```json
{
  "email": "administrator@mail.com",
  "password": "password"
}
```
response:
```json
{
  "token": "2|iZNwXdzFwRx7bQv9rGefFTguBdqiiZFW7GnZsOrJbf506801"
}
```

## Get Users
endpoint: /api/users
method: GET
response: 
```json
{
  "current_page": 1,
  "current_page_url": "http://localhost:8000/api/users?page=1",
  "data": [
    {
      "id": 3,
      "email": "user@mail.com",
      "name": "user",
      "role": "user",
      "created_at": "2025-11-10T16:57:02.000000Z",
      "orders_count": 0,
      "can_edit": false
    },
    {
      "id": 2,
      "email": "manager@mail.com",
      "name": "Manager",
      "role": "manager",
      "created_at": "2025-11-10T16:13:31.000000Z",
      "orders_count": 0,
      "can_edit": true
    },
    {
      "id": 1,
      "email": "administrator@mail.com",
      "name": "Administrator",
      "role": "administrator",
      "created_at": "2025-11-10T16:13:30.000000Z",
      "orders_count": 0,
      "can_edit": true
    }
  ],
  "first_page_url": "http://localhost:8000/api/users?page=1",
  "from": 1,
  "next_page_url": null,
  "path": "http://localhost:8000/api/users",
  "per_page": 10,
  "prev_page_url": null,
  "to": 3
}
```

## Create User
endpoint: /api/users
method: POST
body: 
```json
{
  "email": "user4@mail.com",
  "password": "useruser",
  "name": "user4"
}
```

response: 
```json
{
  "id": 7,
  "email": "user4@mail.com",
  "name": "user4",
  "role": "user",
  "created_at": "2025-11-11T16:22:45.000000Z",
  "orders_count": 0,
  "can_edit": false
}
```

## Note
Usually in the real project we would use:
- abstraction (interface, abstract class)
- layering (domain, application, infrastructure, presentation)
- mapping (like from domain model to dto)  

However, adding complexity for this simple project is not necessary and can lead to overcomplication/overengineering.
Always use evolutional design (start simple and add complexity only when needed).