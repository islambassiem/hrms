-- CREATE VIEW TEACHINGSTAFFOTHEREXPERIENCE AS
SELECT 
	emp.empid AS EMPLOYEE_NO
    , e.profession AS Profession
	, e.organization_name AS OrganizationName
    , e.city AS City
    , e.country AS CountryCode
    , e.section AS Department
    , e.section AS Section
    , e.start_date AS StartWorkingDate
    , e.end_date AS EndWorkingDate
    , e.functional_tasks AS FunctionalTasks
FROM experiences_non_ksa_institutions e
JOIN employees emp ON emp.id = e.empid
WHERE emp.active = 1 AND emp.category IN (1, 2);