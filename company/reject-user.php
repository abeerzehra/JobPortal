
<?php
    include("../db.php");
    echo "B";
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id_user='$_GET[id_user]'");
    $num_row    = mysqli_num_rows($query);
    if($num_row<1){
        echo "<tr><td colspan='2'>No Record-Found</td></tr>";
    }else{
        $E;
        while ($data=mysqli_fetch_assoc($query)) {
            ?>
                <td><?php echo $data['email']; ?></td>
            <?php
            $E=$data['email'];
            }
            }
?>
<?php
echo "C";
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
    $mail->Subject = 'Interview Approval';
    $mail->Body    = 'Your application has been rejected by the authority';
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



<?php

session_start();


//Status 0 means show user and Status 1 means don't show user details for this job post.
$sql = "UPDATE apply_job_post SET status='1' WHERE id_jobpost='$_GET[id_jobpost]' AND id_user='$_GET[id_user]'";

if($conn->query($sql) === TRUE) {

	$sql1 = "SELECT * FROM job_post WHERE id_jobpost='$_GET[id_jobpost]'";
    $result1 = $conn->query($sql1);

  if($result1->num_rows > 0) {
    while($row = $result1->fetch_assoc()) 
    {
    	echo "A";
		header("Location: view-job-applications.php");
		exit();
	}
	}
	
} else {
	echo "Error!";
}
?>