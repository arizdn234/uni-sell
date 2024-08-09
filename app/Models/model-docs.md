# Database Schema Documentation

This document provides an overview of the database schema for the e-commerce application, detailing the tables and their relationships.

## Tables and Models

### 1. Users

**Table Name:** `users`

**Model:** `User`

**Attributes:**
- `id`: Primary key
- `name`: String, name of the user
- `email`: String, unique email of the user
- `password`: String, hashed password
- `is_admin`: Boolean, flag for admin users
- `email_verified_at`: Timestamp, email verification date
- `remember_token`: String, token used to remember the user

**Relationships:**
- `orders`: A user can have many orders (`hasMany`)
- `reviews`: A user can have many reviews (`hasMany`)
- `cart`: A user can have one cart (`hasOne`)

### 2. Orders

**Table Name:** `orders`

**Model:** `Order`

**Attributes:**
- `id`: Primary key
- `user_id`: Foreign key referencing `users`
- `total_amount`: Decimal, total amount of the order
- `status`: String, status of the order
- `payment_method`: String, method of payment used
- `shipping_address`: String, address for shipping

**Relationships:**
- `user`: An order belongs to a user (`belongsTo`)
- `items`: An order can have many items (`hasMany`)
- `payment`: An order has one payment (`hasOne`)
- `shipping`: An order has one shipping record (`hasOne`)

**Cascading:**
- Deleting an order will delete its associated items.

### 3. Order Items

**Table Name:** `order_items`

**Model:** `OrderItem`

**Attributes:**
- `id`: Primary key
- `order_id`: Foreign key referencing `orders`
- `product_id`: Foreign key referencing `products`
- `quantity`: Integer, quantity of the product ordered
- `price`: Decimal, price of the product at the time of order

**Relationships:**
- `order`: An order item belongs to an order (`belongsTo`)
- `product`: An order item belongs to a product (`belongsTo`)

### 4. Products

**Table Name:** `products`

**Model:** `Product`

**Attributes:**
- `id`: Primary key
- `name`: String, name of the product
- `description`: Text, description of the product
- `price`: Decimal, price of the product
- `stock`: Integer, stock quantity available
- `category_id`: Foreign key referencing `categories`
- `image_url`: String, URL of the product image

**Relationships:**
- `category`: A product belongs to a category (`belongsTo`)
- `reviews`: A product can have many reviews (`hasMany`)
- `orderItems`: A product can appear in many order items (`hasMany`)

### 5. Categories

**Table Name:** `categories`

**Model:** `Category`

**Attributes:**
- `id`: Primary key
- `name`: String, name of the category
- `parent_id`: Foreign key referencing `categories` (self-referential)

**Relationships:**
- `products`: A category can have many products (`hasMany`)
- `parent`: A category can have one parent category (`belongsTo`)
- `children`: A category can have many child categories (`hasMany`)

### 6. Reviews

**Table Name:** `reviews`

**Model:** `Review`

**Attributes:**
- `id`: Primary key
- `product_id`: Foreign key referencing `products`
- `user_id`: Foreign key referencing `users`
- `rating`: Integer, rating given by the user
- `comment`: Text, comment from the user

**Relationships:**
- `product`: A review belongs to a product (`belongsTo`)
- `user`: A review belongs to a user (`belongsTo`)

### 7. Payments

**Table Name:** `payments`

**Model:** `Payment`

**Attributes:**
- `id`: Primary key
- `order_id`: Foreign key referencing `orders`
- `amount`: Decimal, amount paid
- `payment_method`: String, method of payment used
- `status`: String, payment status

**Relationships:**
- `order`: A payment belongs to an order (`belongsTo`)

### 8. Shipping

**Table Name:** `shipping`

**Model:** `Shipping`

**Attributes:**
- `id`: Primary key
- `order_id`: Foreign key referencing `orders`
- `shipping_method`: String, method of shipping
- `tracking_number`: String, tracking number for shipment
- `status`: String, shipping status

**Relationships:**
- `order`: Shipping belongs to an order (`belongsTo`)

### 9. Carts

**Table Name:** `carts`

**Model:** `Cart`

**Attributes:**
- `id`: Primary key
- `user_id`: Foreign key referencing `users`
- `status`: String, status of the cart

**Relationships:**
- `user`: A cart belongs to a user (`belongsTo`)
- `items`: A cart can have many cart items (`hasMany`)

**Cascading:**
- Deleting a cart will delete its associated items.

### 10. Cart Items

**Table Name:** `cart_items`

**Model:** `CartItem`

**Attributes:**
- `id`: Primary key
- `cart_id`: Foreign key referencing `carts`
- `product_id`: Foreign key referencing `products`
- `quantity`: Integer, quantity of the product in the cart
- `price`: Decimal, price of the product in the cart

**Relationships:**
- `cart`: A cart item belongs to a cart (`belongsTo`)
- `product`: A cart item belongs to a product (`belongsTo`)

## Notes

- **Mass Assignment:** All models have `fillable` attributes specified for mass assignment protection.
- **Casting:** The `User` model includes casting for the `email_verified_at` attribute to a `datetime`.
- **Soft Deletion:** Some relationships include cascading deletions, such as `Order` and `Cart`, where deleting a parent record also deletes associated child records.

This schema is designed to efficiently handle typical operations in an e-commerce platform, ensuring data integrity and enabling complex queries with ease.
