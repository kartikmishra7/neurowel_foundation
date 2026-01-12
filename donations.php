<?php
//session_start();
require 'config.php';
require 'auth.php';

// Check login
$auth = new Auth();
$auth->checkLogin();

// Delete donation
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM donations WHERE id = $id");

    $_SESSION['message'] = "Donation deleted successfully";
    header("Location: donations.php");
    exit;
}

// Get all donations
$donations = mysqli_query(
    $conn,
    "SELECT * FROM donations ORDER BY donation_date DESC"
);
?>

<?php include 'header.php'; ?>

<h2>Donations</h2>

<!-- Success message -->
<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <?php 
            echo $_SESSION['message']; 
            unset($_SESSION['message']); 
        ?>
    </div>
<?php endif; ?>

<!-- Add donation button -->
<a href="add_donation.php" class="btn btn-success mb-3">
    Add Donation
</a>

<!-- Donations table -->
<table border="1" width="100%" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Donor Name</th>
        <th>Amount</th>
        <!-- <th>Project</th> -->
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

<?php while ($row = mysqli_fetch_assoc($donations)): ?>

<?php
    // Get project name
//     $projectName = "General";
//     if (!empty($row['project_id'])) {
//         $projectResult = mysqli_query(
//             $conn,
//             "SELECT title FROM projects WHERE id = ".$row['project_id']
//         );
//         if ($project = mysqli_fetch_assoc($projectResult)) {
//             $projectName = $project['title'];
//         }
//     }
// ?>

<tr>
    <td><?php echo $row['id']; ?></td>
    <td><?php echo $row['donor_name']; ?></td>
    <td><?php echo $row['amount']; ?></td>
    
    <td><?php echo $row['donation_date']; ?></td>
    <td><?php echo $row['status']; ?></td>
    <td>
        <a href="view_donation.php?id=<?php echo $row['id']; ?>">View</a>
        |
        <a href="edit_donation.php?id=<?php echo $row['id']; ?>">Edit</a>
        |
        <a href="donations.php?delete=<?php echo $row['id']; ?>"
           onclick="return confirm('Delete this donation?')">
           Delete
        </a>
    </td>
</tr>

<?php endwhile; ?>

</table>

<?php include 'footer.php'; ?>

<?
 ?>