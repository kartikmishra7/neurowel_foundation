<?php 
include 'auth.php';
include 'config.php';
$auth=NEW Auth();
$auth->checkLogin($conn);

$id=isset($_GET['id'])?(int)$_GET['id']:0;
if($id==0){
  die("inavalid donation id");
}
$result=mysqli_query($conn, "SELECT * From donations WHERE id=$id");
$donation=mysqli_fetch_assoc($result);
?>
<?php include 'header.php'; ?>

<h2>View Donation</h2>

<table border="1" cellpadding="10">
    <tr><th>ID</th><td><?php echo $donation['id']; ?></td></tr>
    <tr><th>Donor Name</th><td><?php echo $donation['donor_name']; ?></td></tr>
    <tr><th>Email</th><td><?php echo $donation['email']; ?></td></tr>
    <tr><th>Amount</th><td><?php echo $donation['amount']; ?></td></tr>
    
    <tr><th>Date</th><td><?php echo $donation['donation_date']; ?></td></tr>
    <tr><th>Status</th><td><?php echo $donation['status']; ?></td></tr>
</table>

<br>
<a href="donations.php"> Back to Donations</a>

<?php include 'footer.php'; ?>







