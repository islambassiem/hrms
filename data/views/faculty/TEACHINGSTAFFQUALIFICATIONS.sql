-- CREATE VIEW TEACHINGSTAFFQUALIFICATIONS AS
SELECT 
	e.empid AS EMPLOYEE_NO
	, q.qualification AS ScientificDegreeCode
    , q.major_id AS MajorCode
    , q.minor_id AS MinorCode
    , q.rating AS RatingCode
    , q.gpa AS GPA
    , q.gpa_type AS GPATypeCode
    , q.study_type AS StudyTypeCode
    , q.graduation_university AS GraduateFrom
    , q.graduation_college AS Faculty
    , q.graduation_date AS DateOfScientificDegree
    , YEAR(q.graduation_date) AS GraduationYear
    , q.city AS CityCode
    , q.graduation_country AS CountryCode
    , q.graduation_type AS ResearchTypeCode
    , q.attested AS IsLastQualificationAuthenticated
FROM qualifications q
JOIN employees e ON e.id = q.employee_id
WHERE e.active = 1 AND e.category IN (1, 2);