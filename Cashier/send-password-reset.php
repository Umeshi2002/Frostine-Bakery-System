<?php
include 'config.php';
if(isset($_POST["email"])){
 $email = $_POST["email"];

 $token =bin2hex(random_bytes(16));
 $token_hash = hash("sha256", $token);
 $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

 $sql ="UPDATE login 
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email =?";

  $stmt = $conn->prepare($sql);

  $stmt->bind_param("sss", $token_hash, $expiry, $email);
  if ($stmt->execute()) {
    echo "Password reset token generated successfully.";
} else {
    echo "Failed to generate reset token: " . $stmt->error;
}
if($conn->affected_rows){

  $mail = require __DIR__ . '/mailer.php';
  $mail->setFrom('kasunshyapabodi2002@gmail.com',"kasunshya");
  $mail->addAddress($email);
  $mail->isHTML(true);
  $mail->Subject = 'Password Reset';
  $mail->Body    = <<<END

  Click <a href='http://localhost/Frostine/reset-password.php?token=$token'>Reset Password.</a>"

  END;
try{
  $mail->send();
  echo "Message sent,please check your inbox";
  }
catch(Exception $e){
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}
}
echo "message sent,please check your inbox";
?>