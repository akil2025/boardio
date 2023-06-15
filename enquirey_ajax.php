<?php 
ob_start();
include "phpmailer/PHPMailerAutoload.php";

$servername = "localhost";
	$username = "appuser";
	$password = "App@012345$";
	$dbname = "noble"; 

/* Database connection verification */
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	   die("Connection failed: " . $conn->connect_error);
	}
	else {
		//echo "connected";
		//echo "Connected successfully".$authorization;
	}
//exit;
// Fetching Values From URL
$name = $_POST['Field1'];
$email = $_POST['Field2'];
$phone = $_POST['Field3'];
$city = $_POST['Field4'];
$surgery = $_POST['Field5'];
$source =  $_POST['Field9'];
$medium = $_POST['Field10'];
$subsource =  $_POST['subsource'];
$campaign =$_POST['Field11'];
$widget =$_POST['widget'];

 

// $accessKey = 'u$rf4b3da43722df0af7e682d191e3afefe';
// $secretKey = 'cafb7d02854c6340b7f463eafff1c5d8151d643a';
// $api_url_base = 'https://api.leadsquared.com/v2/LeadManagement.svc';

// $url = $api_url_base . '/Lead.Capture?accessKey=' . $accessKey . '&secretKey=' . $secretKey;	


$data_string = '[
					{"Attribute":"FirstName", "Value": "'.$name.'"},
					{"Attribute":"Phone", "Value": "'.$phone.'"},
					{"Attribute":"EmailAddress", "Value": "'.$email.'"},
					{"Attribute":"mx_City", "Value": "'.$city.'"},
					{"Attribute":"mx_Message", "Value": "'.$surgery.'"},
					{"Attribute":"Source", "Value": "'.$source.'"},
					{"Attribute":"SourceMedium", "Value": "'.$medium.'"},
					{"Attribute":"SourceCampaign", "Value": "'.$campaign.'"},
					{"Attribute":"mx_Sub_Source", "Value": "'.$subsource.'"},
					{"Attribute":"mx_widget", "Value": "'.$widget.'"}					
				]';



	
			try
			{
				$curl = curl_init('https://api-in21.leadsquared.com/v2/LeadManagement.svc/Lead.Create?accessKey=u$rf4b3da43722df0af7e682d191e3afefe&secretKey=cafb7d02854c6340b7f463eafff1c5d8151d643a');
				//curl_setopt($curl, CURLOPT_URL, $url);
				curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array(
															'Content-Type:application/json',
															'Content-Length:'.strlen($data_string)
															));
				$json_response = curl_exec($curl);
				//echo "<pre>";
				//print_r($json_response);exit;
				curl_close($curl);
				echo "yes";
			} catch (Exception $ex) { 
				curl_close($curl);
				echo "No";
			}
	

// echo $source;
// echo $medium;
// echo $campaign;

$created_date = date("Y-m-d H:i:s");
$sql = "INSERT INTO noble_msi (name, email, phone, city, source, medium, campaign, subsource, widget, created_date) VALUES ('".$name."','".$email."','".$phone."','".$city."','".$source."','".$medium."','".$campaign."','".$subsource."','".$widget."','".$created_date."')";

$conn->query($sql);
$conn->close();



//Create a new PHPMailer instance
$mail = new PHPMailer;

//Set up SMTP
$mail->isSMTP();
//$mail->SMTPDebug = true; 
$mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server address
$mail->SMTPAuth = true;
$mail->Username = 'noblehospitalspune@gmail.com'; // Replace with your email address
$mail->Password = 'bpngwgzwrbbmcgxc'; // Replace with your email password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Set up email content
$mail->setFrom('noblehospitalspune@gmail.com', 'Noble Hospitals Pune'); // Replace with your email address and name
$mail->addAddress('noblecares@noblehrc.com', 'Noble Hospitals'); // Replace with recipient email address and name
//$mail->addAddress('akil2025@gmail.com', 'Jugular Narendra');
$addressCC="narendra@jugularsocialmedia.com";
$mail->AddBCC($addressCC);
$mail->Subject = 'A Lead from Minimally Invasive Surgery Landing Page Form'." ";

$messagebody .= '<html><body>';
$messagebody .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$messagebody .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . $name . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . $email . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Mobile:</strong> </td><td>" . $phone . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>City:</strong> </td><td>" . $city . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Type of Condition:</strong> </td><td>" . $surgery . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Source:</strong> </td><td>" . $source . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Medium:</strong> </td><td>" . $medium . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Campaign:</strong> </td><td>" . $campaign . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Subsource:</strong> </td><td>" . $subsource . "</td></tr>";
$messagebody .= "<tr style='background: #eee;'><td><strong>Widget:</strong> </td><td>" . $widget . "</td></tr>";

		

$mail->msgHTML($messagebody);

// Send the email
if ($mail->send()) {
    // echo 'Email sent!';
    	header('Location: https://noblehrc.com/hernia-repair/thankyou.html');
} else {
   // echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
    header('Location: https://noblehrc.com/hernia-repair/');
}


 

?>