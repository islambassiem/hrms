-- CREATE VIEW EMPLOYEECOURSES AS
SELECT 
	c.`name` AS CourseName
    , c.`type` AS CourseType
    , c.`issuer` AS 'Issuer'
    , c.`year` AS CourseDate
    , c.period AS CoursePeriod
    , c.city AS City
    , c.country AS CountryCode
    , e.empid AS EMPLOYEE_NO
FROM courses c
JOIN employees e ON e.id = c.employee_id
WHERE e.active = 1 AND e.category NOT IN (1, 2, 4);