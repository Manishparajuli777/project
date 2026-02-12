# Quick Start Guide - Nepal Tourism Management System

## ⚡ Get Started in 5 Minutes

### Step 1: Start XAMPP Services
```
1. Open XAMPP Control Panel
2. Click "Start" for Apache
3. Click "Start" for MySQL
```

### Step 2: Create Database
```
1. Open browser → http://localhost/phpmyadmin
2. Click "New" database
3. Database name: nepal_tourism_db
4. Collation: utf8_general_ci
5. Click "Create"
6. Go to "Import" tab
7. Select: includes/database-setup.sql
8. Click "Import"
```

If you prefer an automated method or you see "Unknown database 'nepal_tourism_db'" in the browser, open `install.php` in your project root to create the database and import the schema automatically:

```
http://localhost/project/nepal-tour-system/install.php
```

### Step 3: Access Application

**Admin Panel:**
- URL: http://localhost/project/nepal-tour-system/admin/
- Username: `admin`
- Password: `admin123`

**User Portal:**
- URL: http://localhost/project/nepal-tour-system/user/
- New users can register or use existing accounts

### Step 4: First Actions

**As Admin:**
1. Login to admin panel
2. View Dashboard - check statistics
3. Create a new package
4. Manage existing packages
5. Change admin password

**As User:**
1. Go to homepage
2. Click "Sign Up" (or Login if you have account)
3. Browse "View All Packages"
4. Click on a package
5. Fill booking form with dates
6. Submit booking
7. View booking in "My Bookings"

## 🎯 Test Credentials

| Role | Email/Username | Password |
|------|---|---|
| Admin | admin | admin123 |
| Test User | test@example.com | test123 |

## 📁 Important Files

| File | Purpose |
|------|---------|
| `includes/database-setup.sql` | Database schema (no sample packages) |
| `includes/config.php` | Database configuration |
| `admin/index.php` | Admin login |
| `user/index.php` | User homepage |

## 🔧 If Something Goes Wrong

### "Database connection error"
1. Check MySQL is running
2. Verify credentials in `includes/config.php`
3. Verify database `nepal_tourism_db` exists

### Admin login not working
1. Verify username is: `admin`
2. Verify password is: `admin123` (case-sensitive)
3. Clear browser cache

### Pages not loading
1. Restart Apache
2. Verify file permissions
3. Check error logs in XAMPP

## 📊 What's Included

✅ Admin Dashboard with statistics  
✅ Package management (add, edit, delete)  
✅ User registration & login  
✅ Package browsing & details  
✅ Booking system  
✅ Booking history  
- Admin-managed package data from database
- Enquiry management
✅ Issue tracking  

## 🚀 Next Steps

1. Customize package images
2. Update contact information
3. Add payment gateway
4. Configure email notifications
5. Customize styling and branding
6. Deploy to web server

## 📚 Full Documentation

See README.md for complete documentation

---

**Questions?** Check the troubleshooting section in README.md




