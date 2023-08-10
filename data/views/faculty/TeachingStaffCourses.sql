-- CREATE VIEW TEACHINGSTAFFCOURSES AS
SELECT 
	e.empid AS EMPLOYEE_NO
	, c.`name` AS CourseName
    , c.`type` AS CourseType
    , c.`issuer` AS 'Issuer'
    , c.`year` AS CertificateAwardingGYear
    , c.period AS CoursePeriod
    , c.city AS City
    , c.country AS CountryCode
FROM courses c
JOIN employees e ON e.id = c.employee_id
WHERE e.active = 1 AND e.category IN (1, 2);