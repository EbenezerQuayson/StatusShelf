# StatusShelf 🛍️

**StatusShelf** is a multi-vendor e-commerce platform that connects buyers and sellers through a centralized marketplace while facilitating transactions via WhatsApp. It is designed to be a lightweight, "WhatsApp-first" e-commerce solution for small businesses.

## 🚀 Features

### 🏪 For Sellers
- **Store Creation:** Register a business and get a unique store link (e.g., `shop.php?u=username`).
- **Dashboard:** A private area to manage products and view inventory status.
- **Product Management:** Upload products with images, prices, and categories.
- **Direct Sales:** Receive orders directly on WhatsApp with pre-filled message details.

### 🛒 For Customers
- **Marketplace:** Browse products from all sellers in one place.
- **Smart Search:** Real-time (AJAX) search to find products instantly.
- **Filtering:** Filter products by categories (Fashion, Electronics, Food, etc.).
- **Wishlist:** Create an account to "Heart" and save items for later.
- **Seller Discovery:** Visit specific seller profiles to see only their stock.

### 🔐 Security & Tech
- **Authentication:** Secure login/signup for both Sellers and Customers.
- **Data Protection:** Passwords are hashed using `password_hash()` (Bcrypt).
- **Session Management:** Role-based access control (Sellers cannot access Customer pages and vice versa).

## 🛠️ Tech Stack

- **Frontend:** HTML5, Tailwind CSS (via CDN), JavaScript (Vanilla).
- **Backend:** PHP (Native/Vanilla).
- **Database:** MySQL.
- **Architecture:** Procedural PHP with a component-based structure (Includes/Config).

## ⚙️ Installation & Setup

Follow these steps to run StatusShelf on your local machine.

### Prerequisites
- A local server environment (XAMPP, WAMP, MAMP, or Laragon).
- PHP 7.4 or higher.
- MySQL 5.7 or higher.

### Steps
1.  **Clone the Repository**
    ```bash
    git clone [https://github.com/yourusername/statusshelf.git](https://github.com/yourusername/statusshelf.git)
    ```

2.  **Move to Server Directory**
    - Move the project folder into your server's root directory (e.g., `htdocs` for XAMPP or `www` for WAMP).

3.  **Setup the Database**
    - Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
    - Create a new database named `statusshelf_db`.
    - Import the `database/schema.sql` file (or copy the SQL from the project documentation) to create the tables.

4.  **Configure Database Connection**
    - Open `config/db.php`.
    - Ensure the credentials match your local setup:
      ```php
      $host = "localhost";
      $user = "root";       // Default XAMPP user
      $pass = "";           // Default XAMPP password is empty
      $dbname = "statusshelf_db";
      ```

5.  **Run the Project**
    - Open your browser and go to:
      `http://localhost/statusshelf/index.php`

## 📂 Project Structure

```text
statusshelf/
├── assets/             # Images and Uploads
├── config/             # Database connection file
├── includes/           # Reusable logic (AJAX search, Save Item)
├── seller/             # Seller-specific pages (Dashboard, Login, Register)
├── customer/           # Customer-specific pages (Profile, Login, Register)
├── index.php           # Landing Page
├── marketplace.php     # Main product feed
├── shop.php            # Individual Seller Storefront
└── explore.php         # Category discovery page
