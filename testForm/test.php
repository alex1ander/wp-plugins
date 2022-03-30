<html>
<body>

Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?><br>
number: <?php echo $_POST["number"]; ?><br>
<?php echo date('Y-m-d'); ?>



<?php


$name = $_POST['name'];
$email = $_POST['email'];
$number = $_POST['number'];
$date = date("Y-m-d H:i:s");



include_once($_SERVER['DOCUMENT_ROOT'].'/wp-config.php' );


global $wpdb;


$wpdb->query(
	$wpdb->prepare(
		"
		INSERT INTO wp_test_orders
		( name, email, number, date )
		VALUES ( %s, %s, %s, %s )
		",
		$name,
		$email,
        $number,
        $date
	)
);

$redirect = isset($_SERVER['HTTP_REFERER'])? $_SERVER['HTTP_REFERER']:'redirect-form.html';
header("Location: $redirect");
exit();
?>
</body>
</html>