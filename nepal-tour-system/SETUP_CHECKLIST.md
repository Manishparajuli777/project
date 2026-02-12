# Nepal Tourism Management System - Setup Checklist

## Pre-Installation Checklist

- [ ] XAMPP installed and working
- [ ] MySQL service running
- [ ] Apache service running
- [ ] PHP version 7.0+ (check with `php -v`)
- [ ] Project folder copied to `C:\xampp\htdocs\project\nepal-tour-system\`
- [ ] Read permissions on project folder
- [ ] Write permissions on `admin/packageimages/` folder

## Installation Checklist

- [ ] Database `nepal_tourism_db` created in MySQL
- [ ] `database-setup.sql` imported successfully
- [ ] 7 tables created:
  - [ ] admin
  - [ ] tblusers
  - [ ] tbltourpackages (empty until admin adds packages)
  - [ ] tblbooking
  - [ ] tblenquiry
  - [ ] tblissues
  - [ ] tblpages
- [ ] `includes/config.php` database credentials verified
- [ ] All PHP files present and readable

## Access Verification Checklist

- [ ] Admin login page loads: http://localhost/project/nepal-tour-system/admin/
- [ ] Admin login successful with credentials: admin / admin123
- [ ] Admin dashboard shows statistics
- [ ] User homepage loads: http://localhost/project/nepal-tour-system/user/
- [ ] Packages display on user homepage
- [ ] Can navigate to all pages without 404 errors

## Functionality Testing Checklist

### Admin Panel
- [ ] Dashboard displays correct statistics
- [ ] Can create new package
- [ ] Can edit existing package
- [ ] Can delete package
- [ ] Can view all users
- [ ] Can view all bookings
- [ ] Can confirm booking
- [ ] Can cancel booking
- [ ] Can view enquiries
- [ ] Can mark enquiry as read
- [ ] Can view issues
- [ ] Can change admin password (and login with new password)

### User Portal
- [ ] Can register new user
- [ ] Can login with registered account
- [ ] Can view all packages
- [ ] Can view package details
- [ ] Can submit booking with dates
- [ ] Can view profile
- [ ] Can view booking history
- [ ] Can logout successfully

## Security Checklist

- [ ] Default admin password changed
- [ ] Database backups created
- [ ] Error reporting disabled in production
- [ ] File permissions set correctly (644 for files, 755 for directories)
- [ ] `config.php` credentials are secure
- [ ] No sensitive data exposed in HTML comments

## Performance Checklist

- [ ] Pages load in under 2 seconds
- [ ] No database connection errors
- [ ] No PHP warnings or errors in console
- [ ] Images display correctly
- [ ] Responsive design works on mobile

## Documentation Checklist

- [ ] README.md reviewed
- [ ] QUICKSTART.md reviewed
- [ ] Database schema understood
- [ ] Default credentials documented
- [ ] Test users created for QA

## Deployment Preparation Checklist

- [ ] All required dependencies installed
- [ ] Database backed up
- [ ] Configuration files updated for production
- [ ] HTTPS configured (if deploying online)
- [ ] Email configuration complete (if notifications enabled)
- [ ] Payment gateway configured (if payment enabled)
- [ ] Admin contact information updated
- [ ] Terms and Privacy policy pages customized

## Troubleshooting Checklist

If something doesn't work:
- [ ] Check MySQL is running: `services.msc` → MySQL
- [ ] Check Apache is running: XAMPP Control Panel
- [ ] Check PHP error logs: `C:\xampp\apache\logs\error.log`
- [ ] Check database connection: verify credentials in config.php
- [ ] Check file permissions: right-click folder → properties
- [ ] Test database connection: Create test.php with PDO connection
- [ ] Clear browser cache and cookies
- [ ] Restart Apache and MySQL

## System Requirements

| Component | Requirement | Current |
|-----------|-------------|---------|
| PHP | 7.0+ | _____ |
| MySQL | 5.7+ | _____ |
| Apache | 2.4+ | _____ |
| Browser | Modern | _____ |
| Disk Space | 50MB+ | _____ |
| RAM | 512MB+ | _____ |

## Additional Notes

```
Date Installed: ________________
Installed By: ________________
XAMPP Version: ________________
PHP Version: ________________
MySQL Version: ________________
Admin Password: ________________ (KEEP SECURE)
Database Server: ________________
```

## Contact & Support

For issues or questions:
- Email: support@nepaltourism.com
- Phone: +977-1-4234567
- Documentation: See README.md
- Quick Start: See QUICKSTART.md

---

**✅ Setup Complete!** Once all items are checked, the system is ready for use.

