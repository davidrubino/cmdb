<?php

include 'db_connect.php';

function createTables($conn) {
	try {
		$sql = "
		CREATE TABLE Class (
		id int NOT NULL AUTO_INCREMENT,
		name varchar(255),
		parent_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (parent_id) REFERENCES Class(id)
		);
		
		CREATE TABLE Config_item (
		id int NOT NULL AUTO_INCREMENT,
		class_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id)
		);
		
		CREATE TABLE Property (
		id int NOT NULL AUTO_INCREMENT,
		name varchar(255),
		value_type varchar(255),
		tab varchar(255),
		PRIMARY KEY (id)
		);
		
		CREATE TABLE Map_class_property (
		id int NOT NULL AUTO_INCREMENT,
		class_id int,
		property_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id),
		FOREIGN KEY (prop_id) REFERENCES Property(id)
		);
		
		CREATE TABLE Property_value (
		id int NOT NULL AUTO_INCREMENT,
		property_id int NOT NULL,
		config_id int NOT NULL,
		str_value varchar(255),
		date_value date,
		float_value float,
		PRIMARY KEY (id),
		FOREIGN KEY (property_id) REFERENCES Property(id),
		FOREIGN KEY (config_id) REFERENCES Config_item(id)
		);
		
		CREATE TABLE Position (
		position_id int NOT NULL AUTO_INCREMENT,
		title varchar(255),
		PRIMARY KEY (position_id)
		);
		
		CREATE TABLE Department (
		department_id int NOT NULL AUTO_INCREMENT,
		name varchar(255),
		PRIMARY KEY (department_id)
		);
		
		CREATE TABLE Employee (
		username varchar(255) NOT NULL AUTO_INCREMENT,
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
		application_id int NOT NULL AUTO_INCREMENT,
		name varchar(255),
		PRIMARY KEY (application_id)
		);
		
		CREATE TABLE Map_department_application (
		mapDepApp_id int NOT NULL AUTO_INCREMENT,
		department_id int,
		application_id int,
		PRIMARY KEY (mapDepApp_id),
		FOREIGN KEY (department_id) REFERENCES Department(department_id),
		FOREIGN KEY (application_id) REFERENCES Application(application_id)
		);
		
		CREATE TABLE User (
		user_id INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
		user_name VARCHAR(25) NOT NULL , 
		user_email VARCHAR(50) NOT NULL , 
		user_pass VARCHAR(60) NOT NULL , 
		user_fname VARCHAR(60) NOT NULL, 
		user_lname VARCHAR(60) NOT NULL,
		isAdmin BOOLEAN NOT NULL,
		UNIQUE (user_name), 
		UNIQUE (user_email)
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
		INSERT INTO Application (name) VALUES
		('Domain Name System'),('Backup'),('Network Time Protocol'),
		('Oracle E-Business Suite'),('Bamboo HR'),('Offerpop');
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
		INSERT INTO Department (name) VALUES
		('Human Resources'),('Manufacturing'),('Information Technology'),
		('Marketing');
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
		(department_id, application_id)
		VALUES
		(1, 5);
		
		INSERT INTO Map_department_application
		(department_id, application_id)
		VALUES
		(2, 4);
		
		INSERT INTO Map_department_application
		(department_id, application_id)
		VALUES
		(3, 1);
		
		INSERT INTO Map_department_application
		(department_id, application_id)
		VALUES
		(3, 2);
		
		INSERT INTO Map_department_application
		(department_id, application_id)
		VALUES
		(3, 3);
		
		INSERT INTO Map_department_application
		(department_id, application_id)
		VALUES
		(4, 6);
		";
		$conn -> exec($sql);
		echo "Values inserted into Map_department_application table";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoClass($conn) {
	try {
		$sql = "
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Server', NULL);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Network', NULL);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Database', NULL);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Storage', NULL);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Linux', 1);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Windows', 1);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Firewall', 2);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Load Balancer', 2);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Proxy', 2);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Router', 2);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('MySQL', 3);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Oracle', 3);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('SQL Server', 3);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Network-attached storage', 4);
		
		INSERT INTO Class
		(name, parent_id)
		VALUES
		('Storage area network', 4);
		";
		$conn -> exec($sql);
		echo "Values inserted into Class";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoConfigItem($conn) {
	try {
		$sql = "
		INSERT INTO Config_item (class_id) VALUES
		(5), (5), (5), (5), (5), (5), (5);
		";
		$conn -> exec($sql);
		echo "Values inserted into Config_item";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoProperty($conn) {
	try {
		$sql = "
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('hostname', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('fully qualified name', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('ip address', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('type', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('manufacturing', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('serial number', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('version', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('satellite host', 'string', 'general');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('cost', 'string', 'financial');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('OS maintenance cost', 'string', 'financial');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('administrator', 'string', 'labor');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('number of developers', 'string', 'labor');
		";
		$conn -> exec($sql);
		echo "Values inserted into Property";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoMapClassProperty($conn) {
	try {
		$sql = "
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 1);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 2);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 3);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 4);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 5);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 6);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 7);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 8);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 9);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 10);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 11);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(11, 12);
		";
		$conn -> exec($sql);
		echo "Values inserted into Map_class_property";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoPropertyValue($conn) {
	try {
		$sql = "
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1, 'bashful', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 2, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 3, 'dopey', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 4, 'grumpy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 5, 'happy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 6, 'sleepy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 7, 'sneezy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(2, 1, 'bashful.kohls.com', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(3, 1, '10.2.46.8', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(4, 1, 'physical', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(5, 1, 'dell', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(6, 1, '123456789', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(7, 1, '5.3', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(8, 1, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(9, 1, '$790', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(10, 1, '$200/month', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(11, 1, 'Mike Johnson', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(12, 1, '3', NULL, NULL);
			";
		$conn -> exec($sql);
		echo "Values inserted into Property_value";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

createTables($DB_conn);
?>