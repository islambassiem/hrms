-- CREATE VIEW EMPLOYEEEXPERIENCE AS
SELECT 
	e.position AS Profession
    , e.institution_code AS InstituteCode
    , e.city AS LocationCode
    , e.section AS SectionCode
    , emp.empid AS EmployeeNumber
    , e.non_academic_rank_id AS ProfessionRankCode
    , e.hiring_date AS HiringDate
    , e.joining_date AS StartWorkingDate
    , e.resignation_date AS EndWorkingDate
    , e.tasks AS FunctionalTasks
	, e.housing_status AS AccommosationCode
    , emp.empid AS EMPLOYEE_NO
FROM experiences_ksa_institutions e
JOIN employees emp ON emp.id = e.employee_id
WHERE emp.active = 1 AND emp.category NOT IN (1, 2, 4);