-- CREATE VIEW TEACHINGSTAFFACHIEVEMENT AS
SELECT 
	e.empid AS EMPLOYEE_NO
	, a.title AS AchievementTitle
    , a.donor AS Donor
    , a.`year` AS GregorianAchievmentYear
FROM achievements a
JOIN employees e ON e.id = a.empid
WHERE e.active = 1 AND e.category IN (1, 2);