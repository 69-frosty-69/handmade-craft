Handmade Crafts - Mini Product Portal
======================================

TECHNOLOGY USED
------------------
- Backend: Core PHP
- Database: MySQL (via XAMPP)
- Frontend: HTML, CSS, Bootstrap 5
- Version Control: Git
- Bonus: Dockerized project

PROJECT STRUCTURE
---------------------
/admin/
    add_product.php      -> Admin-only page to add products with images

/public/
    index.php            -> Homepage with product listings
    product.php          -> Single product detail view
    order.php            -> Order form for users
    login.php            -> Login form
    register.php         -> User registration form
    logout.php           -> Session logout

/config/
    db.php               -> Central DB connection (PDO)

/uploads/
    [Uploaded product images]

SETUP INSTRUCTIONS (Local)
------------------------------
1. Install XAMPP and start Apache + MySQL.
2. Create MySQL database: `handmade_crafts`
3. Import `database.sql` from project root.
4. Place project folder in `htdocs/`
5. Access site via: http://localhost/handmade-crafts-portal/public/

Admin Credentials (for testing)
-----------------------------------
- Username: admin
- Password: admin123

FEATURES
-----------
✅ Admin can add products  
✅ Products display on homepage  
✅ Users can register/login  
✅ Users can place orders  
✅ Image upload for each product  
✅ Secure pages using session-based role check  

DOCKERIZED SETUP
--------------------
1. Ensure Docker and Docker Compose are installed.
2. In project root, run:

   docker-compose up --build

3. Access app at: http://localhost:8080

Screenshots
--------------------

![Screenshot 1](./screenshots/screenshots/1 (1).png)
![Screenshot 2](./screenshots/screenshots/1 (2).png)
![Screenshot 3](./screenshots/screenshots/1 (3).png)
![Screenshot 4](./screenshots/screenshots/1 (4).png)
![Screenshot 5](./screenshots/screenshots/1 (5).png)
![Screenshot 5](./screenshots/screenshots/1 (6).png)

DATABASE FILES
------------------
- `database.sql` – contains schema for `users`, `products`, `orders`

