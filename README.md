<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Blog API

This project is a **Blog API** built with Laravel 12. It provides RESTful endpoints for managing posts, categories, and comments using repositories, services, interfaces, requests, and resources to follow clean architecture principles.

## Features

* User authentication via Laravel Sanctum.
* CRUD operations for:

  * Posts
  * Categories
  * Comments
* Role-based authorization using policies.
* Standardized API response structure (success & error).
* Pagination support for listings.
* Rate limiting protection.
* Centralized exception handling.
* Feature tests included.

## Installation

1. **Clone the repository:**

```bash
git clone https://github.com/ibrahimsendev/blog-api.git
cd blog-api
```

2. **Install dependencies:**

```bash
composer install
```

3. **Set up environment file:**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure your database in the `.env` file and run migrations:**

```bash
php artisan migrate
```

5. **Run the application:**

```bash
php artisan serve
```

## API Endpoints

| Method | Endpoint             | Description                |
| ------ | -------------------- | -------------------------- |
| POST   | `/api/auth/register`   | Register a new user        |
| POST   | `/api/auth/login`      | Login and get API token    |
| POST   | `/api/auth/logout`     | Logout authenticated user  |
| GET    | `/api/posts`           | List all posts (paginated) |
| GET    | `/api/posts/{id}`      | Show single post           |
| POST   | `/api/posts`           | Create new post            |
| PUT    | `/api/posts/{id}`      | Update existing post       |
| DELETE | `/api/posts/{id}`      | Delete post                |
| GET    | `/api/categories`      | List all categories        |
| GET    | `/api/categories/{id}` | Show category details      |
| POST   | `/api/categories`      | Create new category        |
| PUT    | `/api/categories/{id}` | Update category            |
| DELETE | `/api/categories/{id}` | Delete category            |
| GET    | `/api/comments`        | List all comments          |
| POST   | `/api/comments`        | Create comment             |
| PUT    | `/api/comments/{id}`   | Update comment             |
| DELETE | `/api/comments/{id}`   | Delete comment             |

**🔗 [Blog API - Postman Collection](https://www.postman.com/technical-specialist-83839034/blog-api/collection/vzvtwgm/blog-api-laravel-12?action=share&creator=40401228)**

## Request Validation Rules

* **Posts:**

  * `title`: Required, string, max 255 characters.
  * `content`: Required.
  * `category_id`: Must exist in categories.

* **Categories:**

  * `name`: Required, string, max 255 characters.

* **Comments:**

  * `content`: Required.
  * `post_id`: Must exist in posts.

* **Authentication:**

  * `email`: Required, valid email, unique.
  * `password`: Required, min 8 characters.

## Technologies Used

* Laravel 12 (Framework)
* Laravel Sanctum (API Authentication)
* PHP 8.2+ (Programming Language)
* MySQL (Database)
* PHPUnit (Testing)
* Postman (API Testing)

## Additional Notes

* Follows clean architecture: Services, Repositories, Interfaces, Resources, Requests.
* Global error handling and response standardization using custom ApiResponse trait.
* Rate limiting applied via middleware.
* Feature tests ensure stability.

---

## License

This project is open-source and available under the [MIT license](https://opensource.org/licenses/MIT).
