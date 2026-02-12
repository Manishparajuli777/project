@echo off
REM Nepal Tourism Management System - Setup Script for Windows
REM This script helps set up the MySQL database for the project

echo.
echo ========================================
echo Nepal Tourism Management System Setup
echo ========================================
echo.

REM Check if MySQL is available
where mysql >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: MySQL not found in PATH
    echo Please add MySQL to your system PATH or run XAMPP MySQL first
    echo.
    pause
    exit /b 1
)

echo Step 1: Please create database manually
echo ------------------------------------------
echo.
echo Option A: Using phpMyAdmin (Recommended)
echo 1. Open browser: http://localhost/phpmyadmin
echo 2. Click "New" database
echo 3. Name: nepal_tourism_db
echo 4. Collation: utf8_general_ci
echo 5. Click "Create"
echo 6. Go to "Import" tab
echo 7. Choose file: includes/database-setup.sql
echo 8. Click "Import"
echo.
echo Option B: Using Command Line (Advanced)
echo cd project\nepal-tour-system
echo mysql -u root -p -e "CREATE DATABASE nepal_tourism_db;"
echo mysql -u root -p nepal_tourism_db ^< includes/database-setup.sql
echo.
pause

echo.
echo Step 2: Verify Database Connection
echo -----------------------------------
REM Try to connect to database
mysql -u root -e "USE nepal_tourism_db; SHOW TABLES;" >nul 2>nul
if %ERRORLEVEL% EQU 0 (
    echo ✓ Database connection successful!
    echo ✓ Database setup complete!
) else (
    echo ✗ Database connection failed
    echo Please ensure the database was created correctly
)

echo.
echo Step 3: Test Files
echo ------------------
if exist "includes\config.php" (
    echo ✓ config.php found
) else (
    echo ✗ config.php NOT found
)

if exist "includes\database-setup.sql" (
    echo ✓ database-setup.sql found
) else (
    echo ✗ database-setup.sql NOT found
)

if exist "admin\index.php" (
    echo ✓ Admin panel files found
) else (
    echo ✗ Admin panel files NOT found
)

if exist "user\index.php" (
    echo ✓ User portal files found
) else (
    echo ✗ User portal files NOT found
)

echo.
echo Step 4: Access Application
echo ---------------------------
echo.
echo Admin Panel: http://localhost/project/nepal-tour-system/admin/
echo User Portal: http://localhost/project/nepal-tour-system/user/
echo.
echo Default Credentials:
echo Username: admin
echo Password: admin123
echo.
echo ========================================
echo Setup Complete!
echo ========================================
echo.
pause
