<?php

include 'db_connect.php';

function createUsers($conn) {
	try {
		$sql = "
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
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function dropTables($conn) {
	try {
		$sql = "
		DROP TABLE Map_department_application;
		DROP TABLE Application;
		DROP TABLE Employee;
		DROP TABLE Department;
		DROP TABLE Position;
		DROP TABLE Property_value;
		DROP TABLE Map_class_property;
		DROP TABLE Property;
		DROP TABLE Config_item;
		DROP TABLE Class;
		";
		$conn -> exec($sql);
		echo "Tables dropped successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
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
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(255),
		value_type varchar(255),
		tab varchar(255)
		);
		
		CREATE TABLE Map_class_property (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		class_id int,
		prop_id int,
		FOREIGN KEY (class_id) REFERENCES Class(id),
		FOREIGN KEY (prop_id) REFERENCES Property(id)
		);
		
		CREATE TABLE Property_value (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
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

function insertIntoClass($conn) {
	try {
		$sql = "
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(1, 'Server', NULL);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(2, 'Network', NULL);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(3, 'Database', NULL);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(4, 'Storage', NULL);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(11, 'Linux', 1);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(12, 'Windows', 1);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(21, 'Firewall', 2);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(22, 'Load Balancer', 2);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(23, 'Proxy', 2);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(24, 'Router', 2);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(31, 'MySQL', 3);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(32, 'Oracle', 3);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(33, 'SQL Server', 3);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(41, 'Network-attached storage', 4);
		
		INSERT INTO Class
		(id, name, parent_id)
		VALUES
		(42, 'Storage area network', 4);
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
		-- bashful --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1000, 11);
		
		-- doc --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1101, 11);
		
		-- dopey --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1102, 11);
		
		-- grumpy --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1103, 11);
		
		-- happy --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1104, 11);
		
		-- sleepy --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1105, 11);
		
		-- sneezy --
		INSERT INTO Config_item
		(id, class_id)
		VALUES
		(1106, 11);
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
		('cost', 'float', 'financial');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('OS maintenance cost', 'float', 'financial');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('administrator', 'string', 'labor');
		
		INSERT INTO Property
		(name, value_type, tab)
		VALUES
		('number of developers', 'float', 'labor');
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
		(1, 9);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 11);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(11, 7);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(11, 8);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(11, 10);
		
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
			(1, 1000, 'bashful', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1101, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1102, 'dopey', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1103, 'grumpy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1104, 'happy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1105, 'sleepy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(1, 1106, 'sneezy', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(2, 1000, 'bashful.kohls.com', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(3, 1000, '10.2.46.8', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(4, 1000, 'physical', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(5, 1000, 'dell', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(6, 1000, '123456789', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(7, 1000, '5.3', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(8, 1000, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(9, 1000, NULL, NULL, 790);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(10, 1000, NULL, NULL, 200);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(11, 1000, 'Mike Johnson', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(12, 1000, NULL, NULL, 3);
			";
		$conn -> exec($sql);
		echo "Values inserted into Property_value";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

//dropTables($DB_con);
//createTables($DB_con);
//insertIntoApplication($DB_con);
//insertIntoDepartment($DB_con);
//insertIntoMapDepartmentApplication($DB_con);
insertIntoClass($DB_con);
insertIntoConfigItem($DB_con);
//insertIntoProperty($DB_con);
insertIntoMapClassProperty($DB_con);
insertIntoPropertyValue($DB_con);
?>