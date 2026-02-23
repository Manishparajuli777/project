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
    $packageTypes = array('Adventure', 'Cultural', 'Wildlife', 'Trekking');

    if(isset($_POST['submit']))
    {
        $pname = $_POST['packagename'];
        $ptype = $_POST['packagetype'];
        $plocation = $_POST['packagelocation'];
        $pprice = $_POST['packageprice'];
        $pfeatures = $_POST['packagefeatures'];
        $pdetails = $_POST['packagedetails'];
        $pimage = $_FILES["packageimage"]["name"];
        
        move_uploaded_file($_FILES["packageimage"]["tmp_name"], "../photo/".$_FILES["packageimage"]["name"]);
        
        if(!in_array($ptype, $packageTypes, true)) {
            $error = "Please select a valid package type.";
        } else {
            $sql = "INSERT INTO tbltourpackages(PackageName, PackageType, PackageLocation, PackagePrice, PackageFetures, PackageDetails, PackageImage) 
                    VALUES(:pname, :ptype, :plocation, :pprice, :pfeatures, :pdetails, :pimage)";
            
            $query = $dbh->prepare($sql);
            $query->bindParam(':pname', $pname, PDO::PARAM_STR);
            $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
            $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
            $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
            $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
            $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
            $query->bindParam(':pimage', $pimage, PDO::PARAM_STR);
            
            $query->execute();
            $msg = "Package Created Successfully!";
        }
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Nepal Tourism | Create Package</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<style>
body {
    background: #f4f4f4;
    padding: 20px;
}
.form-container {
    background: white;
    padding: 30px;
    border-radius: 8px;
    max-width: 800px;
    margin: auto;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.success-msg {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
.error-msg {
    background: #fee2e2;
    color: #991b1b;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
}
</style>
</head>
<body>
<div class="form-container">
    <h2>Create New Tour Package</h2>
    <?php if($msg) { echo "<div class='success-msg'>$msg</div>"; } ?>
    <?php if($error) { echo "<div class='error-msg'>$error</div>"; } ?>
    
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Package Name:</label>
            <input type="text" name="packagename" class="form-control" placeholder="e.g., Kathmandu Valley Tour" required>
        </div>
        
        <div class="form-group">
            <label>Package Type:</label>
            <select name="packagetype" class="form-control" required>
                <option value="">Select package type</option>
                <?php foreach($packageTypes as $type) { ?>
                    <option value="<?php echo htmlentities($type); ?>" <?php echo (isset($_POST['packagetype']) && $_POST['packagetype'] === $type) ? 'selected' : ''; ?>>
                        <?php echo htmlentities($type); ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        
        <div class="form-group">
            <label>Location:</label>
            <input type="text" name="packagelocation" class="form-control" placeholder="e.g., Kathmandu, Pokhara, Everest" required>
        </div>
        
        <div class="form-group">
            <label>Price (<?php echo CURRENCY_SYMBOL; ?>):</label>
            <input type="number" name="packageprice" class="form-control" placeholder="e.g., 25000" required>
        </div>
        
        <div class="form-group">
            <label>Features:</label>
            <input type="text" name="packagefeatures" class="form-control" placeholder="e.g., Free hotel pickup, Guided tours, Meals included" required>
        </div>
        
        <div class="form-group">
            <label>Description:</label>
            <textarea name="packagedetails" class="form-control" rows="5" placeholder="Detailed package description" required></textarea>
        </div>
        
        <div class="form-group">
            <label>Package Image:</label>
            <input type="file" name="packageimage" class="form-control" required>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">Create Package</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
<?php 
}
?>
