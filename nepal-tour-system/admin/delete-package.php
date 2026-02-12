<?php
session_start();
error_reporting(0);
include('../includes/config.php');

if(strlen($_SESSION['alogin']) == 0)
{
    header('location:index.php');
}
else
{
    if(isset($_GET['pid']))
    {
        $pid = intval($_GET['pid']);
        
        // Check if package has any bookings
        $sql = "SELECT COUNT(*) as booking_count FROM tblbooking WHERE PackageId = :pid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pid', $pid, PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        
        if($result->booking_count > 0)
        {
            // Package has bookings, cannot delete
            $_SESSION['error'] = "Cannot delete this package! It has " . $result->booking_count . " booking(s) associated with it.";
            header('location:manage-packages.php');
        }
        else
        {
            // Delete package images from database (if you have an images table)
            // Uncomment if you have a package images table
            // $sql = "DELETE FROM tblpackageimages WHERE PackageId = :pid";
            // $query = $dbh->prepare($sql);
            // $query->bindParam(':pid', $pid, PDO::PARAM_INT);
            // $query->execute();
            
            // Delete the package
            $sql = "DELETE FROM tbltourpackages WHERE PackageId = :pid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':pid', $pid, PDO::PARAM_INT);
            $query->execute();
            
            $_SESSION['success'] = "Package deleted successfully!";
            header('location:manage-packages.php');
        }
    }
    else
    {
        header('location:manage-packages.php');
    }
}
?>
