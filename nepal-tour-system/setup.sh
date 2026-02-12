#!/bin/bash
# Nepal Tourism Management System - Setup Script for Linux/Mac

echo ""
echo "========================================"
echo "Nepal Tourism Management System Setup"
echo "========================================"
echo ""

# Check if MySQL is installed
if ! command -v mysql &> /dev/null; then
    echo "ERROR: MySQL not found"
    echo "Please install MySQL first"
    exit 1
fi

echo "Step 1: Create Database"
echo "------------------------"
echo ""

read -p "Enter MySQL root password (press Enter if none): " MYSQL_PASSWORD

if [ -z "$MYSQL_PASSWORD" ]; then
    MYSQL_CMD="mysql -u root"
else
    MYSQL_CMD="mysql -u root -p$MYSQL_PASSWORD"
fi

# Create database
echo "Creating database nepal_tourism_db..."
$MYSQL_CMD -e "CREATE DATABASE IF NOT EXISTS nepal_tourism_db CHARACTER SET utf8 COLLATE utf8_general_ci;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Database created successfully"
else
    echo "✗ Failed to create database"
    exit 1
fi

# Import SQL file
echo "Importing database schema..."
$MYSQL_CMD nepal_tourism_db < includes/database-setup.sql 2>/dev/null

if [ $? -eq 0 ]; then
    echo "✓ Database schema imported successfully"
else
    echo "✗ Failed to import database schema"
    exit 1
fi

echo ""
echo "Step 2: Verify Installation"
echo "---------------------------"

# Check tables
TABLE_COUNT=$($MYSQL_CMD -N nepal_tourism_db -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='nepal_tourism_db';" 2>/dev/null)

if [ "$TABLE_COUNT" -ge 7 ]; then
    echo "✓ Database tables created: $TABLE_COUNT tables"
else
    echo "✗ Database may not be configured correctly"
fi

# Check files
echo ""
if [ -f "includes/config.php" ]; then
    echo "✓ config.php found"
else
    echo "✗ config.php NOT found"
fi

if [ -f "admin/index.php" ]; then
    echo "✓ Admin panel files found"
else
    echo "✗ Admin panel files NOT found"
fi

if [ -f "user/index.php" ]; then
    echo "✓ User portal files found"
else
    echo "✗ User portal files NOT found"
fi

echo ""
echo "Step 3: Set File Permissions"
echo "----------------------------"

chmod 755 admin/packageimages/
chmod 644 includes/config.php
echo "✓ File permissions set"

echo ""
echo "Step 4: Access Application"
echo "--------------------------"
echo ""
echo "Admin Panel: http://localhost/project/nepal-tour-system/admin/"
echo "User Portal: http://localhost/project/nepal-tour-system/user/"
echo ""
echo "Default Credentials:"
echo "Username: admin"
echo "Password: admin123"
echo ""
echo "========================================"
echo "Setup Complete!"
echo "========================================"
echo ""
