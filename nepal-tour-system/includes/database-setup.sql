-- Nepal Tourism Management System Database Schema

CREATE DATABASE IF NOT EXISTS nepal_tourism_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE nepal_tourism_db;

-- Admin Table
CREATE TABLE IF NOT EXISTS admin (
  UserName varchar(100) NOT NULL,
  Password varchar(100) NOT NULL,
  PRIMARY KEY (UserName)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users Table
CREATE TABLE IF NOT EXISTS tblusers (
  id int(11) NOT NULL AUTO_INCREMENT,
  FullName varchar(120) NOT NULL,
  EmailId varchar(100) NOT NULL UNIQUE,
  MobileNumber varchar(15) NOT NULL,
  Password varchar(100) NOT NULL,
  Address varchar(255),
  RegDate timestamp DEFAULT CURRENT_TIMESTAMP,
  UpdationDate timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tour Packages Table
CREATE TABLE IF NOT EXISTS tbltourpackages (
  PackageId int(11) NOT NULL AUTO_INCREMENT,
  PackageName varchar(200) NOT NULL,
  PackageType varchar(100) NOT NULL,
  PackageLocation varchar(150) NOT NULL,
  PackagePrice decimal(10,2) NOT NULL,
  PackageFetures varchar(300),
  PackageDetails longtext,
  PackageImage varchar(255),
  Creationdate timestamp DEFAULT CURRENT_TIMESTAMP,
  UpdationDate timestamp NULL DEFAULT NULL,
  PRIMARY KEY (PackageId)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Booking Table
CREATE TABLE IF NOT EXISTS tblbooking (
  BookingId int(11) NOT NULL AUTO_INCREMENT,
  PackageId int(11) NOT NULL,
  UserEmail varchar(100) NOT NULL,
  FromDate varchar(50) NOT NULL,
  ToDate varchar(50) NOT NULL,
  Comment varchar(300),
  RegDate timestamp DEFAULT CURRENT_TIMESTAMP,
  status int(11) DEFAULT 0,
  CancelledBy varchar(50),
  UpdationDate timestamp NULL DEFAULT NULL,
  Mode varchar(50) DEFAULT 'Online',
  amts decimal(10,2) DEFAULT 0,
  PRIMARY KEY (BookingId),
  INDEX idx_booking_package (PackageId),
  CONSTRAINT fk_booking_package
    FOREIGN KEY (PackageId)
    REFERENCES tbltourpackages(PackageId)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Enquiries Table
CREATE TABLE IF NOT EXISTS tblenquiry (
  id int(11) NOT NULL AUTO_INCREMENT,
  FullName varchar(120) NOT NULL,
  EmailId varchar(100) NOT NULL,
  MobileNumber varchar(15) NOT NULL,
  Subject varchar(200) NOT NULL,
  Description longtext,
  PostingDate timestamp DEFAULT CURRENT_TIMESTAMP,
  Status int(11) DEFAULT 0,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Issues/Tickets Table
CREATE TABLE IF NOT EXISTS tblissues (
  id int(11) NOT NULL AUTO_INCREMENT,
  UserEmail varchar(100) NOT NULL,
  Issue varchar(200) NOT NULL,
  Description longtext,
  PostingDate timestamp DEFAULT CURRENT_TIMESTAMP,
  AdminRemark longtext,
  AdminremarkDate timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  INDEX idx_issue_user (UserEmail),
  CONSTRAINT fk_issues_user
    FOREIGN KEY (UserEmail)
    REFERENCES tblusers(EmailId)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Pages Table
CREATE TABLE IF NOT EXISTS tblpages (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(50) NOT NULL,
  detail longtext,
  PRIMARY KEY (id),
  UNIQUE KEY uq_pages_type (type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default admin (idempotent)
INSERT IGNORE INTO admin (UserName, Password)
VALUES ('admin', MD5('admin123'));

-- Default pages (idempotent)
INSERT INTO tblpages (type, detail) VALUES
('terms', 'Terms and Conditions for Nepal Tourism'),
('privacy', 'Privacy Policy for protecting user data'),
('aboutus', 'Learn about our Nepal Tourism Management System'),
('contact', 'Contact us for more information')
ON DUPLICATE KEY UPDATE detail = VALUES(detail);

-- Tour packages are intentionally not seeded.
-- Admin should create packages from the admin panel.
