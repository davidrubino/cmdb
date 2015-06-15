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
(3, 'Database', NULL);

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
(4, 'Storage', NULL);

INSERT INTO Class
(id, name, parent_id)
VALUES
(41, 'Network-attached storage', 4);

INSERT INTO Class
(id, name, parent_id)
VALUES
(42, 'Storage area network', 4);

-- bashful --
INSERT INTO Config_item
(id, class_id)
VALUES
(1000, 1);

-- network --
INSERT INTO Config_item
(id, class_id)
VALUES
(2000, 2);

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

-- mysql56 --
INSERT INTO Config_item
(id, class_id)
VALUES
(3101, 31);

-- mysql57 --
INSERT INTO Config_item
(id, class_id)
VALUES
(3102, 31);

-- telecom --
INSERT INTO Config_item
(id, class_id)
VALUES
(3201, 32);

-- kohls --
INSERT INTO Config_item
(id, class_id)
VALUES
(3202, 32);

-- kohls --
INSERT INTO Config_item
(id, class_id)
VALUES
(3301, 33);

-- oracle --
INSERT INTO Config_item
(id, class_id)
VALUES
(3302, 33);

-- bit defender --
INSERT INTO Config_item
(id, class_id)
VALUES
(2101, 21);

-- zone alarm --
INSERT INTO Config_item
(id, class_id)
VALUES
(2102, 21);

-- apache --
INSERT INTO Config_item
(id, class_id)
VALUES
(2201, 22);

-- balance --
INSERT INTO Config_item
(id, class_id)
VALUES
(2202, 22);

-- ccproxy --
INSERT INTO Config_item
(id, class_id)
VALUES
(2301, 23);

-- anon proxy server --
INSERT INTO Config_item
(id, class_id)
VALUES
(2302, 23);

-- cisco --
INSERT INTO Config_item
(id, class_id)
VALUES
(2401, 24);

-- davidpc --
INSERT INTO Config_item
(id, class_id)
VALUES
(1201, 12);

-- ritch pc --
INSERT INTO Config_item
(id, class_id)
VALUES
(1202, 12);

-- freenas --
INSERT INTO Config_item
(id, class_id)
VALUES
(4101, 41);

-- nas4free --
INSERT INTO Config_item
(id, class_id)
VALUES
(4102, 41);

-- starwind --
INSERT INTO Config_item
(id, class_id)
VALUES
(4201, 42);

-- open-e --
INSERT INTO Config_item
(id, class_id)
VALUES
(4202, 42);

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

INSERT INTO Position
(position_id, title)
VALUES
(30, 'Software Engineer');

INSERT INTO Position
(position_id, title)
VALUES
(31, 'Production Manager');

INSERT INTO Position
(position_id, title)
VALUES
(32, 'Recruiter');

INSERT INTO Position
(position_id, title)
VALUES
(33, 'Sales Manager');

INSERT INTO Employee
(username, password, full_name, hiring_year, isAdmin, position_id, dep_id)
VALUES
('davidr', 'marissa', 'David Rubino', 2015, FALSE, 30, 12);

INSERT INTO Employee
(username, password, full_name, hiring_year, isAdmin, position_id, dep_id)
VALUES
('marissah', 'daisy', 'Marissa Houdek', 2015, FALSE, 32, 10);

INSERT INTO Employee
(username, password, full_name, hiring_year, isAdmin, position_id, dep_id)
VALUES
('tommyb', 'funny', 'Tommy Boy', 1990, TRUE, 31, 11);

INSERT INTO Employee
(username, password, full_name, hiring_year, isAdmin, position_id, dep_id)
VALUES
('ritchh', 'heather', 'Ritch Houdek', 2000, FALSE, 33, 13);

INSERT INTO Property
(id, name, value_type)
VALUES
(100, 'hostname', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(101, 'date_acquired', 'date');

INSERT INTO Property
(id, name, value_type)
VALUES
(102, 'cost', 'float');

INSERT INTO Property
(id, name, value_type)
VALUES
(103, 'cisco model', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(104, 'fully qualified name', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(105, 'ip address', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(106, 'type', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(107, 'manufacturing', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(108, 'serial number', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(109, 'version', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(110, 'satellite host', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(111, 'instance name', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(112, 'network name', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(113, 'windows version', 'string');

INSERT INTO Property
(id, name, value_type)
VALUES
(114, 'license number', 'float');

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10000, 1, 100);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10001, 1, 101);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10002, 1, 102);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(20000, 2, 101);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(20001, 2, 102);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(20002, 2, 103);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10003, 1, 104);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10004, 1, 105);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10005, 1, 106);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10006, 1, 107);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(10007, 1, 108);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(11001, 11, 109);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(11002, 11, 110);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(12001, 12, 113);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(12002, 12, 114);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(30000, 3, 111);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(30001, 3, 112);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(40000, 4, 112);

INSERT INTO Map_class_property
(id, class_id, property_id)
VALUES
(40001, 4, 109);

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

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(100, 1000, 'bashful', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(101, 2000, NULL, '2015-06-08', NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(100, 1101, 'doc', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(104, 1101, 'doc.kohls.com', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(105, 1101, '10.2.46.8', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(106, 1101, 'physical', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(107, 1101, 'dell', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(108, 1101, '#1A98D8', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(109, 1101, '5.3.1', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(100, 1102, 'dopey', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(104, 1102, 'dopey.kohls.com', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(105, 1102, '10.2.46.9', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(106, 1102, 'physical', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(107, 1102, 'hp', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(108, 1102, '#1A98D9', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(109, 1102, '5.3.2', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(100, 1103, 'grumpy', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(104, 1103, 'grumpy.kohls.com', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(105, 1103, '10.2.47.0', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(106, 1103, 'virtual', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(107, 1103, 'ibm', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(108, 1103, '#1A98DE', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(109, 1103, '5.3.3', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(110, 1103, 'dopey', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(111, 3101, 'mysql56', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(109, 3101, '6.2', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(100, 1201, 'davidpc', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(113, 1201, 'Windows 8.1', NULL, NULL);

INSERT INTO Property_value
(property_id, config_id, str_value, date_value, float_value)
VALUES
(114, 1201, '1589-KAB5-A456-8796', NULL, NULL);