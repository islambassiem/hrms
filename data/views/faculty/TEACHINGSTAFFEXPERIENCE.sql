-- CREATE VIEW TEACHINGSTAFFEXPERIENCE AS
SELECT 
	e.position AS Profession
    , e.institution_code AS InstituteCode
    , e.city AS LocationCode
    , e.section AS SectionCode
    , e.major_code AS MajorCode
    , e.minor_code AS MinorCode
    , emp.empid AS EMPLOYEE_NO
    , e.academic_rank_code AS AcademicRankCode
    , e.hiring_date AS HiringDate
    , e.appointment_type AS AppointmentTypeCode
    , e.joining_date AS StartWorkingDate
    , e.resignation_date AS EndWorkingDate
    , e.employment_status AS EmploymentStatusCode
    , e.tasks AS FunctionalTasks
	, e.job_type AS JobType
FROM experiences_ksa_institutions e
JOIN employees emp ON emp.id = e.empid
WHERE emp.active = 1 AND emp.category IN (1, 2);