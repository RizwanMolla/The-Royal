# The Royal - Project Overview

## 🎯 Project Summary

**The Royal** is a complete hotel management system built from scratch using vanilla PHP, HTML, and CSS (no frameworks). This project demonstrates professional web development skills including database design, authentication, CRUD operations, and modern UI/UX design.

## ✨ Key Features

### Public Features (Guest Users)

- ✅ User registration with validation
- ✅ Secure login/logout system
- ✅ Browse luxury rooms with premium UI
- ✅ Real-time price calculation
- ✅ Room booking with date selection
- ✅ Payment processing (simulated)
- ✅ Personal booking history
- ✅ Responsive design (mobile, tablet, desktop)

### Admin Features

- ✅ Admin dashboard with statistics
- ✅ Revenue tracking
- ✅ Room management (CRUD operations)
- ✅ Booking management
- ✅ Role-based access control

## 🛠️ Technical Stack

| Component  | Technology                        |
| ---------- | --------------------------------- |
| Backend    | PHP 7.4+ (Vanilla, no frameworks) |
| Database   | MySQL with PDO                    |
| Frontend   | HTML5, CSS3 (Custom design)       |
| JavaScript | Vanilla JS (No jQuery)            |
| Server     | Apache (XAMPP)                    |

## 📊 Database Design

### Tables Structure

**users** (Authentication & Authorization)

- Stores user accounts with hashed passwords
- Role-based system (user/admin)

**rooms** (Hotel Inventory)

- Room details, pricing, availability
- Three types: Standard, Deluxe, Suite

**bookings** (Reservations)

- Links users to rooms
- Tracks dates, guests, payment status
- Foreign key relationships

## 🎨 Design Philosophy

### Premium Luxury Theme

- **Dark Mode**: Sophisticated gray color scheme
- **Accent Colors**: Blue and teal for highlights
- **Typography**: Playfair Display (headings) + Inter (body)
- **Animations**: Smooth transitions and scroll effects
- **Responsive**: Mobile-first approach

### Color Palette

```
Primary:   #111827 (Dark Gray)
Secondary: #1f2937 (Gray)
Accent 1:  #2563eb (Blue)
Accent 2:  #0d9488 (Teal)
Text:      #ffffff (White)
```

## 🔒 Security Features

1. **SQL Injection Prevention**

   - All queries use prepared statements with PDO
   - No direct string concatenation

2. **XSS Protection**

   - All output sanitized with `htmlspecialchars()`
   - User input properly escaped

3. **Password Security**

   - Bcrypt hashing with `password_hash()`
   - Secure verification with `password_verify()`

4. **Session Management**

   - Session regeneration on login
   - Role-based access control
   - Protected routes with middleware

5. **Input Validation**
   - Server-side validation for all forms
   - Client-side validation for UX
   - Type checking and sanitization

## 📁 Project Structure

```
the-royal/
│
├── 📄 index.php              # Home page with room listings
├── 📄 login.php              # User login
├── 📄 register.php           # User registration
├── 📄 logout.php             # Logout handler
├── 📄 booking.php            # Room booking form
├── 📄 payment.php            # Payment summary
├── 📄 process-payment.php    # Payment processing
├── 📄 success.php            # Booking confirmation
├── 📄 my-bookings.php        # User booking history
├── 📄 setup.sql              # Database setup script
├── 📄 README.md              # Full documentation
├── 📄 INSTALLATION.md        # Quick setup guide
│
├── 📁 admin/                 # Admin panel
│   ├── dashboard.php         # Statistics dashboard
│   ├── rooms.php             # Room list
│   ├── room-create.php       # Add new room
│   ├── room-edit.php         # Edit room
│   ├── room-delete.php       # Delete room
│   └── bookings.php          # All bookings
│
├── 📁 config/
│   └── database.php          # DB connection
│
├── 📁 includes/
│   ├── header.php            # Reusable header
│   ├── footer.php            # Reusable footer
│   └── auth.php              # Auth helpers
│
└── 📁 public/
    ├── css/
    │   └── style.css         # All styles (1000+ lines)
    └── js/
        ├── booking.js        # Price calculator
        └── animations.js     # Scroll effects
```

## 🔄 User Flow

### Guest Booking Flow

```
1. Browse Rooms (index.php)
   ↓
2. Click "Book Now"
   ↓
3. Login/Register (if not authenticated)
   ↓
4. Fill Booking Form (booking.php)
   - Select dates
   - Choose guests
   - See dynamic price
   ↓
5. Review Payment (payment.php)
   ↓
6. Process Payment (process-payment.php)
   ↓
7. Success Confirmation (success.php)
   ↓
8. View in My Bookings (my-bookings.php)
```

### Admin Flow

```
1. Login as Admin
   ↓
2. Admin Dashboard (statistics)
   ↓
3. Manage Rooms
   - Create new rooms
   - Edit existing rooms
   - Delete rooms (with validation)
   ↓
4. View All Bookings
   - See guest details
   - Check payment status
```

## 💡 Key Implementation Highlights

### 1. Dynamic Price Calculation

JavaScript automatically calculates total price based on:

- Number of nights (check-out - check-in)
- Price per night
- Updates in real-time as dates change

### 2. Authentication Middleware

```php
check_auth()  // Ensures user is logged in
check_admin() // Ensures user is admin
```

### 3. Database Relationships

- Users → Bookings (One-to-Many)
- Rooms → Bookings (One-to-Many)
- Proper foreign key constraints

### 4. Responsive Design

- Mobile: Single column layout
- Tablet: Two column layout
- Desktop: Three column grid
- Hamburger menu for mobile

### 5. Scroll Animations

Intersection Observer API for smooth fade-in effects:

```javascript
Elements fade in as they enter viewport
Smooth transitions for professional feel
```

## 📈 Statistics Tracked

Admin dashboard displays:

- **Total Revenue**: Sum of all paid bookings
- **Bookings Today**: Count of today's bookings
- **Total Rooms**: All rooms in system
- **Available Rooms**: Currently bookable rooms

## 🧪 Testing Scenarios

### Functional Testing

- ✅ User registration with validation
- ✅ Login with correct/incorrect credentials
- ✅ Booking flow from start to finish
- ✅ Admin CRUD operations
- ✅ Role-based access control
- ✅ Form validation (client & server)

### Security Testing

- ✅ SQL injection attempts blocked
- ✅ XSS attempts sanitized
- ✅ Unauthorized access prevented
- ✅ Password hashing verified

### UI/UX Testing

- ✅ Responsive on all screen sizes
- ✅ Animations smooth and performant
- ✅ Forms user-friendly
- ✅ Error messages clear

## 🚀 Performance Optimizations

1. **Database Queries**

   - Indexed columns for faster lookups
   - Efficient JOINs to avoid N+1 queries
   - Prepared statements for query caching

2. **Frontend**

   - CSS loaded once, cached by browser
   - Minimal JavaScript for fast page loads
   - Optimized images from CDN

3. **Code Organization**
   - Reusable header/footer includes
   - Modular authentication functions
   - DRY (Don't Repeat Yourself) principles

## 📚 Learning Outcomes

This project demonstrates:

- ✅ PHP fundamentals and best practices
- ✅ MySQL database design and relationships
- ✅ SQL queries with prepared statements
- ✅ Authentication and authorization
- ✅ Session management
- ✅ CRUD operations
- ✅ Form handling and validation
- ✅ Security best practices
- ✅ Responsive CSS design
- ✅ JavaScript DOM manipulation
- ✅ Modern UI/UX principles
- ✅ Code organization and structure

## 🎓 Educational Value

Perfect for:

- University semester projects
- Portfolio demonstrations
- Learning web development fundamentals
- Understanding MVC-like architecture
- Practicing database design
- Implementing security measures

## 🔮 Future Enhancement Ideas

- Email notifications (PHPMailer)
- Image upload for rooms
- Advanced search filters
- Booking cancellation
- User profile editing
- Payment gateway integration
- PDF receipt generation
- Multi-language support
- Room availability calendar
- Review and rating system

## 📞 Support & Documentation

- **README.md**: Complete documentation
- **INSTALLATION.md**: Quick setup guide
- **Code Comments**: Inline explanations
- **SQL Comments**: Database structure notes

## 🏆 Project Highlights

✨ **Professional Quality**

- Production-ready code structure
- Industry-standard security practices
- Modern UI/UX design

✨ **Educational Value**

- Well-commented code
- Clear documentation
- Best practices demonstrated

✨ **Feature Complete**

- Full booking system
- Admin management panel
- Responsive design
- Real-world functionality

---

**Built with passion for learning and excellence** 🎯

**The Royal - Where Luxury Meets Technology** 🏨
