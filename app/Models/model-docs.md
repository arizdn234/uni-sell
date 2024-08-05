Here's a documentation for the Laravel Eloquent models in your e-commerce platform application. This documentation outlines the relationships and properties of each model, providing a clear understanding of the data structure and how the different entities interact with each other.

---

# E-Commerce Platform Models Documentation

## 1. **User Model**

The `User` model represents a user in the system and includes information about authentication and user-related activities.

### Attributes:

- **`name`**: The name of the user.
- **`email`**: The email address of the user.
- **`password`**: The hashed password of the user.
- **`is_admin`**: A boolean indicating if the user has administrative privileges.

### Hidden Attributes:

- **`password`**: Hidden from serialization for security reasons.
- **`remember_token`**: Token for "remember me" functionality, hidden for security.

### Casts:

- **`email_verified_at`**: Cast to a `datetime` object.
- **`password`**: Automatically hashed when set.

### Relationships:

- **`orders()`**: One-to-Many relationship with `Order`. A user can have multiple orders.
- **`reviews()`**: One-to-Many relationship with `Review`. A user can write multiple reviews.
- **`cart()`**: One-to-One relationship with `Cart`. A user can have one active cart.

---

## 2. **Category Model**

The `Category` model organizes products into groups and supports hierarchical structures with parent-child relationships.

### Attributes:

- **`name`**: The name of the category.
- **`parent_id`**: References another `Category` to define a parent-child hierarchy.

### Relationships:

- **`products()`**: One-to-Many relationship with `Product`. A category can have multiple products.
- **`parent()`**: Belongs-To relationship with `Category`. Represents the parent category.
- **`children()`**: One-to-Many relationship with `Category`. Represents sub-categories.

---

## 3. **Product Model**

The `Product` model represents items available for sale.

### Attributes:

- **`name`**: The name of the product.
- **`description`**: A detailed description of the product.
- **`price`**: The price of the product in Indonesian Rupiah.
- **`stock`**: The quantity available in inventory.
- **`category_id`**: Foreign key to the `Category` model.
- **`image_url`**: URL for the product image.

### Relationships:

- **`category()`**: Belongs-To relationship with `Category`. Links a product to its category.
- **`reviews()`**: One-to-Many relationship with `Review`. A product can have multiple reviews.
- **`orderItems()`**: One-to-Many relationship with `OrderItem`. A product can be part of multiple order items.

---

## 4. **Order Model**

The `Order` model tracks customer purchases and order details.

### Attributes:

- **`user_id`**: Foreign key to the `User` model.
- **`total_amount`**: The total cost of the order.
- **`status`**: Current status of the order (e.g., pending, completed).
- **`payment_method`**: Method used to pay for the order.
- **`shipping_address`**: Address where the order will be shipped.

### Relationships:

- **`user()`**: Belongs-To relationship with `User`. Links an order to a user.
- **`items()`**: One-to-Many relationship with `OrderItem`. An order contains multiple items.
- **`payment()`**: One-to-One relationship with `Payment`. Links an order to its payment details.
- **`shipping()`**: One-to-One relationship with `Shipping`. Links an order to its shipping information.

---

## 5. **OrderItem Model**

The `OrderItem` model details the individual products in an order.

### Attributes:

- **`order_id`**: Foreign key to the `Order` model.
- **`product_id`**: Foreign key to the `Product` model.
- **`quantity`**: Quantity of the product ordered.
- **`price`**: Price of the product at the time of order.

### Relationships:

- **`order()`**: Belongs-To relationship with `Order`. Links an order item to an order.
- **`product()`**: Belongs-To relationship with `Product`. Links an order item to a product.

---

## 6. **Review Model**

The `Review` model allows users to leave feedback on products.

### Attributes:

- **`product_id`**: Foreign key to the `Product` model.
- **`user_id`**: Foreign key to the `User` model.
- **`rating`**: Numerical rating given to a product.
- **`comment`**: Textual review or feedback.

### Relationships:

- **`product()`**: Belongs-To relationship with `Product`. Links a review to a product.
- **`user()`**: Belongs-To relationship with `User`. Links a review to the user who wrote it.

---

## 7. **Cart Model**

The `Cart` model represents a user's active shopping cart.

### Attributes:

- **`user_id`**: Foreign key to the `User` model.

### Relationships:

- **`user()`**: Belongs-To relationship with `User`. Links a cart to a user.
- **`items()`**: One-to-Many relationship with `CartItem`. A cart contains multiple items.

---

## 8. **CartItem Model**

The `CartItem` model represents individual products within a cart.

### Attributes:

- **`cart_id`**: Foreign key to the `Cart` model.
- **`product_id`**: Foreign key to the `Product` model.
- **`quantity`**: Quantity of the product in the cart.

### Relationships:

- **`cart()`**: Belongs-To relationship with `Cart`. Links a cart item to a cart.
- **`product()`**: Belongs-To relationship with `Product`. Links a cart item to a product.

---

## 9. **Payment Model**

The `Payment` model contains information about the payment transaction for an order.

### Attributes:

- **`order_id`**: Foreign key to the `Order` model.
- **`amount`**: Amount paid.
- **`payment_method`**: Method used for the payment (e.g., credit card, PayPal).
- **`status`**: Current status of the payment (e.g., pending, completed).

### Relationships:

- **`order()`**: Belongs-To relationship with `Order`. Links a payment to an order.

---

## 10. **Shipping Model**

The `Shipping` model manages shipping details and tracking for orders.

### Attributes:

- **`order_id`**: Foreign key to the `Order` model.
- **`shipping_method`**: Method used to ship the order (e.g., standard, express).
- **`tracking_number`**: Tracking number provided by the shipping service.
- **`status`**: Current status of the shipment (e.g., in transit, delivered).

### Relationships:

- **`order()`**: Belongs-To relationship with `Order`. Links shipping details to an order.

---

This documentation provides a clear understanding of how each model is structured and how they interact with each other within the e-commerce application. It helps developers quickly grasp the relationships and responsibilities of each entity in the system.