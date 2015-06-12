<?php

function connect($servername, $username, $password, $dbname) {
	$conn = null;
	try {
		$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
		// set the PDO error mode to exception
		$conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connected successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo "Connection failed: " . $e -> getMessage();
	}
	return $conn;
}

function createTables($conn) {
	try {
		$sql = "
		CREATE TABLE Class (
		id int NOT NULL,
		name varchar(255),
		parent_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (parent_id) REFERENCES Class(id)
		);
		
		CREATE TABLE Config_item (
		id int NOT NULL,
		class_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id)
		);
		
		CREATE TABLE Property (
		id int NOT NULL,
		name varchar(255),
		value_type varchar(255),
		PRIMARY KEY (id)
		);
		
		CREATE TABLE Map_class_property (
		id int NOT NULL,
		class_id int,
		prop_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id),
		FOREIGN KEY (prop_id) REFERENCES Property(id)
		);
		
		CREATE TABLE Property_value (
		property_id int NOT NULL,
		config_id int NOT NULL,
		str_value varchar(255),
		date_value date,
		float_value float,
		FOREIGN KEY (property_id) REFERENCES Property(id),
		FOREIGN KEY (config_id) REFERENCES Config_item(id)
		);
		
		CREATE TABLE Position (
		position_id int NOT NULL,
		title varchar(255),
		PRIMARY KEY (position_id)
		);
		
		CREATE TABLE Department (
		department_id int NOT NULL,
		name varchar(255),
		PRIMARY KEY (department_id)
		);
		
		CREATE TABLE Employee (
		username varchar(255) NOT NULL,
		password varchar(255),
		full_name varchar(255),
		hiring_year int,
		isAdmin boolean,
		position_id int,
		dep_id int,
		PRIMARY KEY (username),
		FOREIGN KEY (position_id) REFERENCES Position (position_id),
		FOREIGN KEY (dep_id) REFERENCES Department(department_id)
		);
		
		CREATE TABLE Application (
		application_id int NOT NULL,
		name varchar(255),
		PRIMARY KEY (application_id)
		);
		
		CREATE TABLE Map_department_application (
		mapDepApp_id int NOT NULL,
		department_id int,
		application_id int,
		PRIMARY KEY (mapDepApp_id),
		FOREIGN KEY (department_id) REFERENCES Department(department_id),
		FOREIGN KEY (application_id) REFERENCES Application(application_id)
		);
	";
		// use exec() because no results are returned
		$conn -> exec($sql);
		echo "Tables created successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function closeConnection($conn) {
	$conn = null;
	echo "Connection stopped";
	echo "<br>";
	return $conn;
}

$conn = connect("localhost", "root", "america76", "test");
createTables($conn);
closeConnection($conn);
?>