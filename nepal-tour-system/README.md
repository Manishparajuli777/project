# Nepal Tourism Management System

A comprehensive web-based tourism management system for Nepal, built with PHP, MySQL, HTML, CSS, and Bootstrap.

## Project Overview

The Nepal Tourism Management System is a full-featured platform designed to manage tour packages, user bookings, enquiries, and administrative functions. It includes features for exploring Nepal's diverse tourist destinations and managing tour operations efficiently.

## Features

### Admin Panel
- **Dashboard**: Overview of users, bookings, packages, and enquiries
- **Package Management**: Create, view, edit, and delete tour packages
- **User Management**: Monitor registered users
- **Booking Management**: Confirm or cancel user bookings
- **Enquiry Management**: Handle customer enquiries
- **Issue Management**: Track and manage user issues/complaints
- **Admin Settings**: Change password and system configuration

### User Portal
- **User Registration & Login**: Create account and authenticate
- **Browse Packages**: View all available tour packages in Nepal
- **Package Details**: Get detailed information about each package
- **Booking System**: Book packages with custom dates and comments
- **Booking History**: View personal booking records
- **Profile Management**: Update personal information
- **Session Management**: Secure login/logout

## System Architecture

```
nepal-tour-system/
├── admin/
│   ├── includes/
│   │   └── config.php
│   ├── packageimages/
│   ├── css/
│   ├── js/
│   ├── index.php (Admin Login)
│   ├── dashboard.php
│   ├── create-package.php
│   ├── manage-packages.php
│   ├── manage-users.php
│   ├── manage-bookings.php
│   ├── manage-enquiries.php
│   ├── manage-issues.php
│   ├── change-password.php
│   └── logout.php
├── user/
│   ├── includes/
│   │   └── config.php
│   ├── css/
│   ├── js/
│   ├── index.php (Home Page)
│   ├── signup.php
│   ├── login.php
│   ├── logout.php
│   ├── packages.php
│   ├── package-details.php
│   ├── profile.php
│   ├── my-bookings.php
├── includes/
│   ├── config.php (Main Configuration)
│   └── database-setup.sql
└── README.md
```

## Database Tables

### admin
- UserName (Primary Key)
- Password

### tblusers
- id (Primary Key)
- FullName
- EmailId (Unique)
- MobileNumber
- Password
- Address
- RegDate
- UpdationDate

### tbltourpackages
- PackageId (Primary Key)
- PackageName
- PackageType
- PackageLocation
- PackagePrice
- PackageFetures
- PackageDetails
- PackageImage
- Creationdate
- UpdationDate

### tblbooking
- BookingId (Primary Key)
- PackageId (Foreign Key)
- UserEmail
- FromDate
- ToDate
- Comment
- RegDate
- status (0=Pending, 1=Confirmed, 2=Cancelled)
- CancelledBy
- UpdationDate
- Mode
- amts

### tblenquiry
- id (Primary Key)
- FullName
- EmailId
- MobileNumber
- Subject
- Description
- PostingDate
- Status

### tblissues
- id (Primary Key)
- UserEmail
- Issue
- Description
- PostingDate
- AdminRemark
- AdminremarkDate

### tblpages
- id (Primary Key)
- type
- detail

## Installation & Setup

### Prerequisites
- XAMPP (or any PHP-MySQL environment)
- MySQL 5.7+
- PHP 7.0+
- Web Browser

### Installation Steps

1. **Download/Clone Project**
   ```bash
   git clone [repository-url]
   cd nepal-tour-system
   ```

2. **Copy to XAMPP**
   ```bash
   Copy nepal-tour-system folder to C:\xampp\htdocs\
   ```

3. **Create Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create new database: `nepal_tourism_db`
   - Import SQL: `includes/database-setup.sql`

4. **Configure Database**
   - Edit `includes/config.php`
   - Update DB_HOST, DB_USER, DB_PASS, DB_NAME if needed

5. **Access Application**
   - User Homepage: http://localhost/nepal-tour-system/user/
   - Admin Panel: http://localhost/nepal-tour-system/admin/

### Default Credentials

**Admin Login**
- Username: `admin`
- Password: `admin123`

**Test User**
- Email: `test@example.com`
- Password: `test123` (MD5 hashed)

## Tour Packages

Tour packages are not auto-seeded during setup.

Use the admin panel to create package details, then users will see those records from `tbltourpackages`.

## Technologies Used

### Frontend
- HTML5
- CSS3
- Bootstrap 4
- JavaScript/jQuery

### Backend
- PHP 7.0+
- MySQL 5.7+
- PDO for Database Connection

### Security Features
- Password Hashing (MD5)
- SQL Injection Prevention (Prepared Statements)
- Session Management
- User Authentication

## Key Features

### Admin Features
✅ Complete package management  
✅ User and booking tracking  
✅ Enquiry and issue management  
✅ Dashboard with statistics  
✅ Secure admin panel  

### User Features
✅ Easy registration/login  
✅ Browse all packages  
✅ Book packages with dates  
✅ View booking history  
✅ User profile management  

## Future Enhancements

1. **Payment Gateway Integration** - Integrate Razorpay/Stripe
2. **Email Notifications** - Send confirmation emails
3. **Reviews & Ratings** - User review system
4. **Advanced Filtering** - Filter packages by price, location, type
5. **PDF Invoice Generation** - Generate booking invoices
6. **SMS Notifications** - SMS alerts for bookings
7. **Admin Analytics** - Advanced reporting and analytics
8. **Multi-language Support** - Support for multiple languages
9. **Mobile App** - Native mobile application
10. **API Development** - RESTful API for third-party integration

## File Structure

```
nepal-tour-system/
├── admin/                 # Admin panel files
├── user/                  # User portal files
├── includes/              # Shared configuration files
│   ├── config.php        # Database configuration
│   └── database-setup.sql # Database schema
└── README.md             # This file
```

## Security Notes

⚠️ **Important Security Recommendations**:

1. Change default admin password immediately
2. Use HTTPS in production
3. Implement advanced password hashing (bcrypt/Argon2)
4. Add CSRF protection tokens
5. Implement rate limiting
6. Use prepared statements (already implemented)
7. Validate and sanitize all user inputs
8. Keep PHP and MySQL updated

## Troubleshooting

### Database Connection Error
- Verify MySQL is running
- Check database credentials in config.php
- Ensure database `nepal_tourism_db` exists

### Admin Login Not Working
- Clear browser cookies
- Verify admin table has correct username/password
- Check DB_NAME and DB_USER in config.php

### File Upload Issues
- Check folder permissions (packageimages/)
- Allow write permissions: `chmod 755 admin/packageimages/`

### Session Issues
- Check PHP session settings
- Ensure cookies are enabled in browser
- Clear temporary files/cache

## Support & Contact

For support, please contact: support@nepaltourism.com

## License

This project is licensed under the MIT License.

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## Version History

### v1.0.0 (2026-02-10)
- Initial release
- Core features implemented
- Admin-managed packages stored in database
- Admin panel with full functionality
- User portal with booking system


