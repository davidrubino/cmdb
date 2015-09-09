<?php

include 'db_connect.php';

function dropTables($conn) {
	try {
		$sql = "
		DROP TABLE Graph;
		DROP TABLE Application;
		DROP TABLE Folder;
		DROP TABLE Property_value;
		DROP TABLE Map_class_property;
		DROP TABLE Property;
		DROP TABLE Config_item;
		DROP TABLE Class;
		DROP TABLE Cabinet;
		DROP TABLE Tile;
		DROP TABLE Data_center;
		";
		$conn -> exec($sql);
		echo "Tables dropped successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function createUser($conn) {
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
		$conn -> exec($sql);
		echo "User table created successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function createTables($conn) {
	try {
		$sql = "
		CREATE TABLE Data_center (
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(255) NOT NULL,
		count_rows int NOT NULL,
		count_columns int NOT NULL,
		label_rows varchar(255) NOT NULL,
		label_columns varchar(255) NOT NULL,
		tile_dim int NOT NULL
		);
		
		CREATE TABLE Tile (
		id int NOT NULL PRIMARY KEY,
		x int NOT NULL,
		y int NOT NULL,
		label varchar(255) NOT NULL,
		grayed_out int NOT NULL,
		html_row int NOT NULL,
		html_col int NOT NULL,
		data_center_id int NOT NULL,
		FOREIGN KEY (data_center_id) REFERENCES Data_center(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Cabinet (
		id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
		height int NOT NULL,
		width int NOT NULL,
		color varchar(255) NOT NULL,
		tile_id int NOT NULL,
		FOREIGN KEY (tile_id) REFERENCES Tile(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Class (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(255),
		parent_id int,
		FOREIGN KEY (parent_id) REFERENCES Class(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Config_item (
		id int NOT NULL,
		name varchar(255),
		class_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id)
		ON DELETE CASCADE
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
		FOREIGN KEY (class_id) REFERENCES Class(id)
		ON DELETE CASCADE,
		FOREIGN KEY (prop_id) REFERENCES Property(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Property_value (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		property_id int NOT NULL,
		config_id int NOT NULL,
		str_value varchar(255),
		date_value date,
		float_value float,
		FOREIGN KEY (property_id) REFERENCES Property(id)
		ON DELETE CASCADE,
		FOREIGN KEY (config_id) REFERENCES Config_item(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Folder (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(255),
		parent_id int,
		FOREIGN KEY (parent_id) REFERENCES Folder(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Application (
		id int NOT NULL,
		name varchar(255),
		folder_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (folder_id) REFERENCES Folder(id)
		ON DELETE CASCADE
		);
		
		CREATE TABLE Graph (
		id INT ( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		name varchar(255),
		type varchar(255),
		parent_id int,
		application_id int,
		FOREIGN KEY (parent_id) REFERENCES Graph(id)
		ON DELETE CASCADE,
		FOREIGN KEY (application_id) REFERENCES Application(id)
		ON DELETE CASCADE
		);
		";
		$conn -> exec($sql);
		echo "Tables created successfully";
		echo "<br>";
	} catch(PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoDataCenter($conn) {
	try {
		$sql = "
		INSERT INTO Data_center
		(name, count_rows, count_columns, label_rows, label_columns, tile_dim)
		VALUES
		('Germantown', 10, 12, '1', 'A', 2);
		";
		$conn -> exec($sql);
		echo "Values inserted into Data_center";
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
		INSERT INTO Config_item
		(id, name, class_id)
		VALUES
		(1000, 'bashful', 5);
		
		INSERT INTO Config_item
		(id, name, class_id)
		VALUES
		(1101, 'doc', 5);
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
		(1, 4);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(1, 6);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 2);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 3);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 5);
		
		INSERT INTO Map_class_property
		(class_id, prop_id)
		VALUES
		(5, 7);
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
			(3, 1000, 'doc', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(3, 1101, 'bashful', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(4, 1000, NULL, NULL, 790);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(4, 1101, NULL, NULL, 800);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(5, 1000, NULL, NULL, 200);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(5, 1101, NULL, NULL, 100);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(6, 1000, 'Mike Johnson', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(6, 1101, 'Ritch Houdek', NULL, NULL);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(7, 1000, NULL, NULL, 3);
			
			INSERT INTO Property_value
			(property_id, config_id, str_value, date_value, float_value)
			VALUES
			(7, 1101, NULL, NULL, 1);
			";
		$conn -> exec($sql);
		echo "Values inserted into Property_value";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoFolder($conn) {
	try {
		$sql = "
		INSERT INTO Folder
		(name, parent_id)
		VALUES
		('Human Resources', NULL);
		
		INSERT INTO Folder
		(name, parent_id)
		VALUES
		('Payroll', 1);
		";
		$conn -> exec($sql);
		echo "Values inserted into Folder";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoApplication($conn) {
	try {
		$sql = "
		INSERT INTO Application
		(id, name, folder_id)
		VALUES
		(1000, 'ADP', 2);
		";
		$conn -> exec($sql);
		echo "Values inserted into Application";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

function insertIntoGraph($conn) {
	try {
		$sql = "
		INSERT INTO Graph
		(name, type, parent_id, application_id)
		VALUES
		('ADP', 'app', NULL, 1000);
		
		INSERT INTO Graph
		(name, type, parent_id, application_id)
		VALUES
		('App Servers', 'folder', 1, 1000);
		
		INSERT INTO Graph
		(name, type, parent_id, application_id)
		VALUES
		('CI', 'config_item', 2, 1000);
		
		INSERT INTO Graph
		(name, type, parent_id, application_id)
		VALUES
		('CI', 'config_item', 2, 1000);
		
		INSERT INTO Graph
		(name, type, parent_id, application_id)
		VALUES
		('CI', 'config_item', 2, 1000);
		";
		$conn -> exec($sql);
		echo "Values inserted into Graph";
		echo "<br>";
	} catch (PDOException $e) {
		echo $sql . "<br>" . $e -> getMessage();
	}
}

//dropTables($DB_con);
//createTables($DB_con);
//insertIntoDataCenter($DB_con);
//insertIntoClass($DB_con);
//insertIntoConfigItem($DB_con);
//insertIntoProperty($DB_con);
//insertIntoMapClassProperty($DB_con);
//insertIntoPropertyValue($DB_con);
//insertIntoFolder($DB_con);
//insertIntoApplication($DB_con);
//insertIntoGraph($DB_con);
?>