  
  
<?php header('Access-Control-Allow-Origin: *'); ?>
<?php 
	error_reporting(E_ALL ^ E_DEPRECATED);
	$uid = $_POST["user"];
	
		//$user_name = "my_app";
		//$password = "YES";
		//$database = "app";
		//$server = "127.0.0.1";
		
		//$user_name = "root";
		//$password = "lendlift";
		//$database = "lendlift_riskmodel";
		//$server = "127.0.0.1";
		
		  $user_name = "lendlift";
		  $password = "Columbia2021$";
		  $database = "lendlift_riskdemo";
		  $server = "127.0.0.1";
		
		$db_connect = mysql_connect($server, $user_name, $password);
		if ($db_connect) 
		{
			$db_handle = mysql_select_db($database, $db_connect);
			if ($db_handle)
			{
	
				// Look up the other values from the Pricing Model table based on the adjusted score.
				$myuserinput_query = "SELECT * FROM `input` WHERE  `user` =  '$uid'";
				$query_inputresult = mysql_query($myuserinput_query);
				if ($query_inputresult)
				{
					$number_records = mysql_num_rows($query_inputresult);

					while($row = mysql_fetch_array($query_inputresult))
					{	
						echo json_encode(array(
							'email' =>$row['signin'],
							'pswd' => $row['password'],
							'firstname'=>  $row['name'],
							'lastname'=>  $row['lastname'],
							'home'=>  $row['homeaddress'],
							'city'=>  $row['city'],
							'state'=>  $row['state'],
							'zip'=>  $row['zipCode'],
							'homeph'=>  $row['homephone'],
							'secph'=>  $row['secondaryphone'],
							'dob'=>  $row['dob'],
							'annincome'=>  $row['annualincome'],
							'ssn'=>  $row['ssn']

						));


					}
				}
			}
		}
		
	mysql_close($db_connect);
	


?>

