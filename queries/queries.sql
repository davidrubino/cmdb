-- select the hostname value from the server class --
SELECT property_value.str_value
FROM property_value, property, config_item, class
WHERE property_value.property_id = property.id
AND property.name = 'hostname'
AND property_value.config_id = config_item.id
AND config_item.class_id = class.id
AND class.name = 'server';

-- select the department where Marissa works --
SELECT department.name
FROM department, employee
WHERE department.department_id = employee.dep_id
AND employee.full_name = 'Marissa Houdek';

-- select Tommy Boy's position --
SELECT position.title
FROM position, employee
WHERE position.position_id = employee.position_id
AND employee.full_name = 'tommy boy';

-- select the class name visible to David --
SELECT class.name
FROM class, employee, map_employee_config_item, config_item
WHERE employee.full_name = 'David Rubino'
AND employee.username = map_employee_config_item.employee_id
AND map_employee_config_item.config_item_id = config_item.id
AND config_item.class_id = class.id;

-- select the ip address --
SELECT property_value.str_value
FROM property_value, property
WHERE property_value.property_id = property.id
AND property.name = 'ip address';

-- select the name of all config hostnames from the server class --
SELECT property_value.str_value
FROM property_value, config_item, class, property
WHERE property_value.config_id = config_item.id
AND config_item.class_id = class.id
AND ( class.name = 'Linux' OR class.name = 'Windows'
OR class.name = 'Server' )
AND property_value.property_id = property.id
AND property.name = 'hostname';

-- select the ip address of the bashful server --
select property_values.string_value from property_values, property, config_item
where property_values.property_id = property.id 
and property.name = 'IP Address' 
and property_values.config_id = config_item.id 
and config_item.id = 
(select config_item.id from config_item, property_values where property_values.string_value='bashful');

-- select the children of the database class --
SELECT class.name from class
where class.parent_id =
(select class.id from class where class.parent_id is null and class.name = "Database")

-- select all values from the bashful server --
select property_value.id, property_value.str_value from property_value, config_item
where property_value.config_id = config_item.id
and config_item.id = 1000

-- select all properties from the server class --
select property.id, property.name from property, map_class_property, class
where property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 1

-- select the server properties and their values for the config item bashful --
select property.name, property.tab, ifnull(property_value.str_value, ifnull(property_value.date_value, property_value.float_value)) as value
from property_value, config_item, property, map_class_property, class
where property_value.config_id = config_item.id
and config_item.id = 1000
and property_value.property_id = property.id
and property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 1

-- select the linux server properties and their values for the config item bashful --
select property.name, property.tab, ifnull(property_value.str_value, ifnull(property_value.date_value, property_value.float_value)) as value
from property_value, config_item, property, map_class_property, class
where property_value.config_id = config_item.id
and config_item.id = 1000
and property_value.property_id = property.id
and property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 11

-- select the properties and their types for the class Server --
select property.name, property.tab, property.value_type
from property, map_class_property, class
where property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 1

-- select the properties and their types for the class Linux --
select property.name, property.tab, property.value_type
from property, map_class_property, class
where property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 11

-- select the user properties for david --
select user_name, user_email, user_fname, user_lname, isAdmin
from user
where user_id = 1;

-- update the password for david --
update user
set user_pass = 'rissy'
where user_name = 'david';

-- update the fully qualified name for bashful --
update property_value, property
set property_value.str_value = if(property_value.str_value is null, null, 'bashful'),
	property_value.date_value = if(property_value.date_value is null, null, 'bashful'),
	property_value.float_value = if(property_value.float_value is null, null, 'bashful')
where property_value.property_id = property.id
and property_value.config_id = 1000
and property.name = 'hostname';

-- select the name of the last property inserted into the table --
select id from property
order by id desc 
limit 1;

-- insert a new set of values into map_class_property --
insert into map_class_property
(class_id, prop_id)
values
(11, (select id from property
order by id desc 
limit 1));

-- select the name for all subclass properties unused for a specific config item --
select property.id, property.name
from property, map_class_property, class, config_item
where property.tab = 'general'
and property.id = map_class_property.prop_id
and map_class_property.class_id = class.id
and class.id = 11
and class.id = config_item.class_id
and config_item.id = 1101
and not exists
( select * from property_value
where property.id = property_value.property_id
and property_value.config_id = config_item.id )

-- select the name for all class properties unused for a specific config item --
select property.id, property.name
from property, map_class_property, class, config_item
where property.tab = 'general'
and property.id = map_class_property.prop_id
and map_class_property.class_id = 1
and map_class_property.class_id = class.parent_id
and class.id = config_item.class_id
and config_item.id = 1101
and not exists
( select * from property_value
where property.id = property_value.property_id
and property_value.config_id = config_item.id )

-- rename a class name --
update class
set name = 'SQLite'
where id = 31

-- rename config item name --
update property_value, property
set property_value.str_value = 'bashful'
where property_value.config_id = 1000
and property_value.property_id = property.id
and property.name = 'hostname'

-- delete a config item --
delete from property_value
where config_id = 1106

delete from config_item
where id = 1106

-- delete a subclass --
delete from property_value
where exists (
    select id from config_item
    where config_item.id = property_value.config_id
    and config_item.class_id = 11);

delete from config_item
where class_id = 11;

delete from map_class_property
where class_id = 11;

delete from class
where id = 11;

-- delete a class --
delete from property_value
where exists (
    select config_item.id from config_item, class
    where config_item.id = property_value.config_id
    and config_item.class_id = class.id
    and class.parent_id = 1)

delete from config_item
where exists (
    select class.id from class
    where config_item.class_id = class.id
    and class.parent_id = 1)

delete from map_class_property
where exists (
    select class.id from class
    where map_class_property.class_id = class.id
    and class.parent_id = 1)

delete from class
where parent_id = 1

delete from map_class_property
where class_id = 1

delete from class
where id = 1

-- delete a property --
delete from property_value
where exists (
    select property.id from property
    where property.id = property_value.property_id
    and property.name = "model"
    )

delete from map_class_property
where exists (
    select property.id from property
    where property.id = map_class_property.prop_id
    and property.name = "model"
    )

delete from property
where name = "model"

-- create a class --
insert into class
(name, parent_id)
values
('SQLite', 3);

-- create a config item --
insert into config_item
(id, class_id)
select max(id) + 1, 5 from config_item;

-- import values for the graph --
select id, name, type, parent_id
from graph

-- insert new folder into graph --
insert into graph
(name, type, parent_id)
values
('App Databases', 'folder', 1)

-- remove item from graph --
delete from graph
where id = 15;

-- select all config items --
select name from config_item;