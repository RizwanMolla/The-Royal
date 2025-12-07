# Quick Installation Guide for XAMPP

## Step-by-Step Installation

### 1. Install XAMPP

- Download from: https://www.apachefriends.org/
- Install and launch XAMPP Control Panel
- Start **Apache** and **MySQL** services

### 2. Copy Project Files

- Copy the entire `the-royal` folder
- Paste it into: `C:\xampp\htdocs\`
- Final path: `C:\xampp\htdocs\the-royal\`

### 3. Setup Database

**Option A: Using phpMyAdmin (Recommended)**

1. Open browser and go to: `http://localhost/phpmyadmin`
2. Click on **"Import"** tab
3. Click **"Choose File"** and select `setup.sql` from the project folder
4. Click **"Go"** button at the bottom
5. Wait for success message

**Option B: Manual SQL Execution**

1. Open: `http://localhost/phpmyadmin`
2. Click **"SQL"** tab
3. Open `setup.sql` file in a text editor
4. Copy all the SQL code
5. Paste into the SQL query box
6. Click **"Go"**

### 4. Verify Database

- In phpMyAdmin, you should see a database named `the_royal`
- It should contain 3 tables: `users`, `rooms`, `bookings`
- Check that sample data is loaded

### 5. Access the Application

Open your browser and navigate to:

```
http://localhost
```

### 6. Login

**Admin Account:**

- Email: `admin@theroyal.com`
- Password: `password`

**Guest Account:**

- Email: `guest@example.com`
- Password: `password`

## Troubleshooting

### Problem: "Database connection failed"

**Solution:**

- Make sure MySQL is running in XAMPP Control Panel (green indicator)
- Check if database `the_royal` exists in phpMyAdmin
- Verify `config/database.php` has correct credentials

### Problem: "Page not found" or 404 error

**Solution:**

- Verify Apache is running in XAMPP (green indicator)
- Check project is in correct location: `C:\xampp\htdocs\the-royal\`
- Access via: `http://localhost` (include the trailing slash)

### Problem: Images not loading

**Solution:**

- Check your internet connection (images load from Unsplash CDN)
- If offline, you can replace image URLs in the database with local images

### Problem: "Access denied" when logging in

**Solution:**

- Make sure you imported the `setup.sql` file correctly
- Try re-importing the database
- Check that users table has data

### Problem: CSS not loading (page looks unstyled)

**Solution:**

- Clear browser cache (Ctrl + Shift + Delete)
- Check that `public/css/style.css` file exists
- Verify Apache is serving static files correctly

## Testing the Application

### As a Guest User:

1. Register a new account
2. Browse available rooms on home page
3. Click "Book Now" on any room
4. Fill in booking details (dates, guests)
5. Watch the price calculate automatically
6. Submit booking
7. Process payment
8. View booking in "My Bookings"

### As an Admin:

1. Login with admin credentials
2. Go to Admin Dashboard
3. View statistics (revenue, bookings, rooms)
4. Click "Manage Rooms"
5. Try creating a new room
6. Edit an existing room
7. View all bookings
8. Check booking details and status

## Default Database Configuration

The project is pre-configured for XAMPP defaults:

```
Host: localhost
Username: root
Password: (empty)
Database: the_royal
```

If your XAMPP has different MySQL credentials, edit `config/database.php`:

```php
define("DB_HOST", "localhost");
define("DB_USER", "root");        // Change if different
define("DB_PASS", "");            // Add password if set
define("DB_NAME", "the_royal");
```

## Next Steps

After successful installation:

1. Explore all features as both guest and admin
2. Try creating new rooms with different types
3. Make test bookings
4. Check the responsive design on mobile (resize browser)
5. Review the code to understand the implementation

## Need Help?

- Check the main `README.md` for detailed documentation
- Review code comments for explanations
- Verify all XAMPP services are running
- Check Apache and MySQL error logs in XAMPP

---

**Enjoy using The Royal Hotel Management System!** 🏨
