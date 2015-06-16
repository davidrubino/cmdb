<?php

include 'db_connect.php';

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

function insertIntoApplication($conn) {
	try {
		$sql = "
		INSERT INTO Application
		(application_id, name)
		VALUES
		(20, 'Domain Name System');
		
		INSERT INTO Application
		(application_id, name)
		VALUES
		(21, 'Backup');
		
		INSERT INTO Application
		(application_id, name)
		VALUES
		(22, 'Network Time Protocol');
		
		INSERT INTO Application
		(application_id, name)
		VALUES
		(23, 'Oracle E-Business Suite');
		
		INSERT INTO Application
		(application_id, name)
		VALUES
		(24, 'Bamboo HR');
		
		INSERT INTO Application
		(application_id, name)
		VALUES
		(25, 'Offerpop');
		";
		$conn -> exec($sql);
		echo "Values inserted into Application table";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoDepartment($conn) {
	try {
		$sql = "
		INSERT INTO Department
		(department_id, name)
		VALUES
		(10, 'Human Resources');
		
		INSERT INTO Department
		(department_id, name)
		VALUES
		(11, 'Manufacturing');
		
		INSERT INTO Department
		(department_id, name)
		VALUES
		(12, 'Information Technology');
		
		INSERT INTO Department
		(department_id, name)
		VALUES
		(13, 'Marketing');
		";
		$conn -> exec($sql);
		echo "Values inserted into Department table";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoMapDepartmentApplication($conn) {
	try {
		$sql = "
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(50, 12, 20);
		
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(51, 12, 21);
		
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(52, 12, 22);
		
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(53, 10, 24);
		
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(54, 11, 23);
		
		INSERT INTO Map_department_application
		(mapDepApp_id, department_id, application_id)
		VALUES
		(55, 13, 25);
		";
		$conn -> exec($sql);
		echo "Values inserted into Map_department_application table";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

$conn = connect("localhost", "root", "america76", "test");
//createTables($conn);
//insertIntoApplication($conn);
insertIntoDepartment($conn);
insertIntoMapDepartmentApplication($conn);
closeConnection($conn);
?>