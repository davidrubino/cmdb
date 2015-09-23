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
		id int NOT NULL PRIMARY KEY,
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
		height int,
		starting_position int,
		class_id int,
		cabinet_id int,
		PRIMARY KEY (id),
		FOREIGN KEY (class_id) REFERENCES Class(id)
		ON DELETE CASCADE,
		FOREIGN KEY (cabinet_id) REFERENCES Cabinet(id)
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

//dropTables($DB_con);
//createTables($DB_con);
?>