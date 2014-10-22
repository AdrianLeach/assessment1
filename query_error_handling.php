<html>
	<body>
		<?php //join query on database with error checking, output results in HTML table
			//include file containing log-in credentials
			require_once 'login.php';
			//store the connection in a variable.  connection requires 4 arguments - server(host), user, password and database name
			$db = mysqli_connect($serverLocal, $userLocal, $passLocal, $databaseLocal)
				//if the connection proves false, a message is displayed 
				or trigger_error("The connection was not successful. The returned error is: <BR>"
				//display the actual error, and then terminate the program so as not to reveal further (irrelevent) error messages 
				. mysqli_connect_error(), E_USER_ERROR);

			$query = "SELECT students.id, students.first_name, students.family_name, students.dob, 
						registers.c_id, registers.s_id, registers.id, courses.course_name 
						FROM students 
						inner join registers on students.id = registers.s_id 
						inner join courses on courses.id = registers.c_id 
						where students.first_name like 'S%'";

			//save the results of the query OR return a comprehensive error message if the query is unsuccessful. trigger_error preferable to die
			$result = mysqli_query($db, $query) 
				or trigger_error("The query failed! The SQL was:<BR/> $query.<BR/><BR/>It returned the error: "
				. mysqli_error($db) , E_USER_ERROR);  

			$table = "<table border=2>";
			$table .= "<tr><td>Student ID</td><td>First Name</td><td>Last Name</td><td>DOB</td>
						<td>Register ID</td><td>Course ID</td><td>Course Name</td></tr>";
			
			while($row = mysqli_fetch_array($result)) 
			{ 
				 $studentId = $row['s_id'];
				 $firstname = $row['first_name']; 
				 $lastname = $row['family_name'];
				 $dob = $row['dob'];
				 $registerId = $row['id'];
				 $courseId = $row['c_id'];
				 $courseName = $row['course_name'];
				 
				 $table .= "<tr><td>$studentId</td> <td>$firstname</td> <td>$lastname</td>  
				 			<td>$dob</td> <td>$registerId</td> <td>$courseId</td> <td>$courseName</td></tr>";	
			}	print $table; 
		?>
	</body>
</html>