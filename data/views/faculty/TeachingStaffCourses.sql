-- CREATE VIEW TEACHINGSTAFFCOURSES AS
SELECT 
	e.empid AS EMPLOYEE_NO
	, c.`name` AS CourseName
    , c.`type` AS CourseType
    , c.`issuer` AS 'Issuer'
    , year(c.`courseDate`) AS CertificateAwardingGYear
    , c.period AS CoursePeriod
    , c.city AS City
    , c.country AS CountryCode
FROM courses c
JOIN employees e ON e.empid = c.empid
WHERE e.active = 1 AND e.category IN (1, 2);