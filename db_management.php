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
		tab varchar(255),
		PRIMARY KEY (id)
		);
		
		CREATE TABLE Map_class_property (
		id int NOT NULL,
		class_id int,
		property_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id),
		FOREIGN KEY (prop_id) REFERENCES Property(id)
		);
		
		CREATE TABLE Property_value (
		id int NOT NULL,
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
		
		CREATE TABLE User (
		username varchar(255) NOT NULL,
		password varchar(255) NOT NULL,
		first_name varchar(255) NOT NULL,
		last_name varchar(255) NOT NULL,
		PRIMARY KEY (username)
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
		(id, name, value_type, tab)
		VALUES
		(100, 'hostname', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(104, 'fully qualified name', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(105, 'ip address', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(106, 'type', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(107, 'manufacturing', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(108, 'serial number', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(109, 'version', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(110, 'satellite host', 'string', 'general');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(111, 'cost', 'string', 'financial');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(112, 'OS maintenance cost', 'string', 'financial');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(113, 'administrator', 'string', 'labor');
		
		INSERT INTO Property
		(id, name, value_type, tab)
		VALUES
		(114, 'number of developers', 'string', 'labor');
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
		(id, class_id, prop_id)
		VALUES
		(10000, 1, 100);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10003, 1, 104);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10004, 1, 105);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10005, 1, 106);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10006, 1, 107);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10007, 1, 108);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10008, 1, 111);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(10009, 1, 113);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(11001, 11, 109);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(11002, 11, 110);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(11003, 11, 112);
		
		INSERT INTO Map_class_property
		(id, class_id, prop_id)
		VALUES
		(11004, 11, 114);
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
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(10, 100, 1000, 'bashful', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(11, 100, 1101, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(12, 100, 1102, 'dopey', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(13, 100, 1103, 'grumpy', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(14, 100, 1104, 'happy', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(15, 100, 1105, 'sleepy', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(16, 100, 1106, 'sneezy', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(17, 104, 1000, 'bashful.kohls.com', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(18, 105, 1000, '10.2.46.8', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(19, 106, 1000, 'physical', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(20, 107, 1000, 'dell', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(21, 108, 1000, '123456789', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(22, 109, 1000, '5.3', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(23, 110, 1000, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(24, 111, 1000, '$790', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(25, 112, 1000, '$200/month', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(26, 113, 1000, 'Mike Johnson', NULL, NULL);
			
			INSERT INTO Property_value
			(id, property_id, config_id, str_value, date_value, float_value)
			VALUES
			(27, 114, 1000, '3', NULL, NULL);
			";
		$conn -> exec($sql);
		echo "Values inserted into Property_value";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

$conn = connect("localhost", "root", "america76", "test");
//createTables($conn);
//insertIntoApplication($conn);
//insertIntoDepartment($conn);
//insertIntoMapDepartmentApplication($conn);
//insertIntoClass($conn);
//insertIntoConfigItem($conn);
//insertIntoProperty($conn);
//insertIntoMapClassProperty($conn);
//insertIntoPropertyValue($conn);
closeConnection($conn);
?>