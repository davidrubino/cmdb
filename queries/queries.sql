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