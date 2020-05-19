<?php

session_start();

if(empty($_SESSION['id_admin'])) {
	header("Location: index.php");
	exit();
}
header("Location: dashboard.php");


include("../db.php");
$found = 0;

if(isset($_GET)) {

	//Delete Company using id and redirect
	$sql = "UPDATE company SET active='1' WHERE id_company='$_GET[id]'";
	if($conn->query($sql)) {
		echo "Done";
		//exit();
	} else {
		echo "Error";
	}
	echo "string";
    //Sending Email	
	$query = mysqli_query($conn, "SELECT * FROM company WHERE id_company='$_GET[id]'");
    $num_row    = mysqli_num_rows($query);
    if($num_row<1){
        echo "Error";
    }else{
        echo "whats up"; 
    }  
} 
?>

<?php
    echo "Kashif hussain";
    $query = mysqli_query($conn, "SELECT * FROM company WHERE id_company='$_GET[id]'");
    $num_row    = mysqli_num_rows($query);
    if($num_row<1){
        echo "<tr><td colspan='2'>No Record-Found</td></tr>";
    }else{
        echo "
            <thead>
                <tr>
                    <th>SNo</th>
                    <th>Company Name</th>
                    <th>Head Office</th>
                    <th>Contact Number</th>
                    <th>Company Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            ";
        $count = 0;
        $E;
        $C;
        while ($data=mysqli_fetch_assoc($query)) {
            $count++;
            ?>
            <tr>
                <th><?php echo $count?></th>
                <td><?php echo $data['companyname']; ?></td>
                <td><?php echo $data['headofficecity']; ?></td>
                <td><?php echo $data['contactno']; ?></td>
                <td><?php echo $data['companytype']; ?></td>
                <td><?php echo $data['email']; ?></td>
            </tr>
            <?php
            $E=$data['email'];
            $C=$data['companyname'];
            }
            }

?>
<?php
echo "string";


//==================================================================================
//                                Mail
//==================================================================================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php';
$mail = new PHPMailer(true);
try {
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'seanbrocks2@gmail.com';                     // SMTP username
    $mail->Password   = 'University123';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; 
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for 

    //Recipients
    $mail->setFrom('khdhackerboy@gmail.com', 'Fastians JobPortal');
    $mail->addAddress($E);     // Add a recipient
    

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Comapny Approval';
    $mail->Body    = '<h1>Your Company is Approved<h1/>';
    $mail->AltBody = '---------';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
//==================================================================================
//                              Mail END
//==================================================================================

?>











                    
