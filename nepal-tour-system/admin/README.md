# 🏔️ Nepal Tour System - Admin Panel

## 📋 Quick Start

### Admin Login
- **URL**: `http://localhost/project/nepal-tour-system/admin/`
- **Default credentials**: Check your database `admin` table

### Main Features
1. 📦 **Manage Packages** - Add, edit, delete tour packages
2. 👥 **Manage Users** - View registered users
3. 📅 **Manage Bookings** - Confirm/cancel bookings
4. ✉️ **Manage Enquiries** - View and respond to enquiries
5. ⚠️ **Manage Issues** - Track customer issues
6. 🔐 **Change Password** - Update admin password

---

## 🆕 What's New

### ✨ Latest Updates

#### 1. Delete Package Feature
- **File**: `admin/delete-package.php`
- **Feature**: Safely delete packages with validation
- **Protection**: Cannot delete if package has bookings

#### 2. Complete CSS Overhaul
- **File**: `admin/css/style.css`
- **Changes**: Modern gradient design, animations, glass effects
- **Result**: Professional, modern admin interface

#### 3. All Pages Updated
- Consistent modern design
- Icon-rich interface
- Better data visualization
- Improved user experience

---

## 📁 File Structure

```
admin/
├── css/
│   └── style.css              # ✨ New modern design system
├── index.php                  # 🔑 Login page (updated)
├── dashboard.php              # 🏠 Main dashboard (updated)
├── manage-packages.php        # 📦 Package management (updated)
├── manage-bookings.php        # 📅 Booking management (updated)
├── manage-users.php           # 👥 User management (updated)
├── manage-enquiries.php       # ✉️ Enquiry management (updated)
├── manage-issues.php          # ⚠️ Issue management (updated)
├── change-password.php        # 🔐 Password change (updated)
├── create-package.php         # ➕ Create new package
├── edit-package.php           # ✏️ Edit package (new)
├── delete-package.php         # 🗑️ Delete package (new)
├── logout.php                 # 🚪 Logout handler
├── README.md                  # 📖 This file
├── IMPROVEMENTS.md            # 📝 Detailed improvements
└── FEATURES.md                # ✨ Feature documentation
```

---

## 🎨 Design Highlights

### Color Theme
- **Primary**: Blue gradients (#3b82f6 → #2563eb)
- **Success**: Green gradients (#10b981 → #059669)
- **Danger**: Red gradients (#ef4444 → #dc2626)
- **Warning**: Orange gradients (#f59e0b → #ea580c)
- **Purple**: Purple gradients (#8b5cf6 → #7c3aed)

### Visual Effects
- ✨ Glass morphism panels
- 🌈 Multi-layer gradient backgrounds
- 💫 Smooth animations
- 🎯 Hover effects
- 💎 Shadow depth system
- 🎭 Icon-rich interface

---

## 🚀 How to Use New Features

### Delete a Package

1. Navigate to **Manage Packages**
2. Find the package you want to delete
3. Click the red **"Delete"** button
4. Confirm in the popup dialog
5. ✅ Success: Package deleted
6. ❌ Error: Package has bookings (cannot delete)

### Edit a Package

1. Navigate to **Manage Packages**
2. Click the blue **"Edit"** button
3. Update package details
4. Click **"Update Package"**
5. ✅ Success message shown

### Manage Bookings

1. Navigate to **Manage Bookings**
2. View all bookings with status badges
3. Click **"Confirm"** to approve a booking
4. Click **"Cancel"** to reject a booking
5. Status updates immediately

### Handle Enquiries

1. Navigate to **Manage Enquiries**
2. Unread enquiries have yellow background
3. Click **"Mark Read"** to mark as handled
4. Status changes to "Read" with green badge

---

## 🔒 Security Features

### SQL Injection Protection
- ✅ PDO prepared statements everywhere
- ✅ Parameter binding for all queries
- ✅ Type hinting (INT, STR)

### Session Security
- ✅ Login required for all admin pages
- ✅ Auto-redirect if not logged in
- ✅ Session-based authentication

### XSS Protection
- ✅ HTML entity encoding
- ✅ Special character escaping
- ✅ Safe output rendering

### User Confirmation
- ✅ Dialogs for destructive actions
- ✅ Validation before deletion
- ✅ Success/error notifications

---

## 📱 Responsive Design

### Desktop (> 768px)
- Full-width layout
- Multi-column grids
- Large buttons and text

### Tablet (≤ 768px)
- Adjusted spacing
- Flexible grids
- Medium-sized elements

### Mobile (< 768px)
- Stacked layout
- Single column stats
- Touch-friendly buttons
- Horizontal table scroll

---

## 🎯 Page Overview

### 🏠 Dashboard
- Statistics cards (Users, Bookings, Enquiries, Packages)
- Quick navigation menu
- Welcome message
- Modern gradient header

### 📦 Manage Packages
- List all tour packages
- Add new package (create-package.php)
- Edit existing package (edit-package.php)
- Delete package (with validation)
- Success/error notifications

### 📅 Manage Bookings
- View all bookings
- Confirm pending bookings
- Cancel bookings
- Status indicators (Pending, Confirmed, Cancelled)
- Customer information

### 👥 Manage Users
- View all registered users
- Email and phone information
- Registration dates
- Last update tracking

### ✉️ Manage Enquiries
- View all customer enquiries
- Mark as read/unread
- Unread highlighting
- Message preview

### ⚠️ Manage Issues
- View customer support tickets
- Issue type display
- Description preview
- Posted dates

### 🔐 Change Password
- Update admin password
- Current password verification
- Password strength validation
- Success/error feedback

---

## 🐛 Troubleshooting

### Login Issues
- Check database credentials in `includes/config.php`
- Verify `admin` table exists
- Check username/password are correct

### Delete Not Working
- Ensure package has no bookings
- Check database connection
- Verify session is active

### Styling Issues
- Clear browser cache
- Check `admin/css/style.css` exists
- Verify Bootstrap CDN is loading

### Database Errors
- Check PDO connection in config
- Verify table names match
- Check column names in queries

---

## 📊 Database Tables Used

- `admin` - Admin login credentials
- `tbltourpackages` - Tour package information
- `tblbooking` - Customer bookings
- `tblusers` - Registered users
- `tblenquiry` - Customer enquiries
- `tblissues` - Customer support tickets

---

## 🔧 Configuration

### Database Config
File: `includes/config.php`

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'nepal_tour_db');
define('CURRENCY_SYMBOL', 'NPR ');
define('SITE_NAME', 'Nepal Tourism');
define('SITE_TAGLINE', 'Discover the Beauty of Nepal');
```

---

## 💡 Tips & Best Practices

### Admin Management
- ✅ Regularly check pending bookings
- ✅ Respond to enquiries promptly
- ✅ Keep package information updated
- ✅ Monitor customer issues
- ✅ Change password periodically

### Package Management
- ✅ Use descriptive package names
- ✅ Set competitive prices
- ✅ Include detailed features
- ✅ Verify before deleting
- ✅ Update outdated packages

### Booking Management
- ✅ Confirm bookings quickly
- ✅ Communicate cancellations
- ✅ Track booking trends
- ✅ Monitor popular packages

---

## 🎨 Customization

### Change Site Name
Edit: `includes/config.php`
```php
define('SITE_NAME', 'Your Tour Company');
define('SITE_TAGLINE', 'Your Tagline');
```

### Change Colors
Edit: `admin/css/style.css`
```css
:root {
  --brand: #your-color;
  --brand-2: #your-color-dark;
}
```

### Add New Pages
1. Create new PHP file in `admin/`
2. Include session check
3. Include database config
4. Use existing CSS classes
5. Add to navigation menu

---

## 📞 Support

For issues or questions:
1. Check `IMPROVEMENTS.md` for detailed changes
2. Read `FEATURES.md` for feature documentation
3. Review database table structures
4. Check browser console for errors
5. Verify database connection

---

## 📈 Future Enhancements

Potential additions:
- 📊 Analytics dashboard
- 📧 Email notifications
- 🖼️ Image upload for packages
- 📱 Mobile app integration
- 💳 Payment tracking
- 📈 Revenue reports
- 🔔 Real-time notifications
- 🗺️ Interactive maps

---

## ✅ Checklist for Admins

Daily:
- [ ] Check new bookings
- [ ] Review enquiries
- [ ] Monitor issues

Weekly:
- [ ] Update packages
- [ ] Review user feedback
- [ ] Check statistics

Monthly:
- [ ] Change password
- [ ] Review inactive packages
- [ ] Analyze trends

---

## 🎉 Enjoy Your Modern Admin Panel!

This admin panel now features:
- ✨ Beautiful modern design
- 🚀 Improved performance
- 🔒 Enhanced security
- 📱 Full responsiveness
- 🎯 Better UX
- 💎 Professional look

Happy managing! 🏔️
