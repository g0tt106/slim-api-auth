# slim-api-auth

# REST API Documentation

## Overview
This REST API allows users to manage products. Authentication is required via an API key, which can be obtained after registration.

## Installation and Setup

1. Clone the repository:
   ```sh
   git clone https://github.com/yourusername/your-repo.git
   cd your-repo
   ```
2. Start the API using Docker:
   ```sh
   docker compose up -d --build
   docker exec -it app-crud bash
   composer install
   ```
3. Generate an encryption key and set it in the `.env` file:
   ```sh
   vendor/bin/generate-defuse-key
   ```
   Add the key to `.env`:
   ```sh
   ENCRYPTION_KEY=your_generated_key
   ```
4. After registering, you will receive your `HASH_SECRET_KEY`. Add it to `.env`:
   ```sh
   HASH_SECRET_KEY=your_secret_key
   ```

## Authentication

1. Open `http://localhost:8000/` to access the authentication interface.
2. Register or log in.
3. In your profile, obtain your API key.
4. Use the API key in headers for authentication:
   ```sh
   X-API-Key: your_api_key
   ```
5. Now you can access the API at `http://localhost:8000/api/products`.

## API Endpoints

| Method  | Endpoint               | Description            |
|---------|------------------------|------------------------|
| GET     | `/api/products`        | Get all products      |
| GET     | `/api/products/{id}`   | Get a product by ID   |
| POST    | `/api/products`        | Create a new product  |
| PUT     | `/api/products/{id}`   | Update a product      |
| DELETE  | `/api/products/{id}`   | Delete a product      |

## Notes
- The API does not have a frontend UI; use Postman or another API testing tool.
- Ensure you pass the correct API key in the headers to authenticate requests.
- The API is running on `http://localhost:8000/`. If using another port, update requests accordingly.
