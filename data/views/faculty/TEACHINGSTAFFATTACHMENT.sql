-- CREATE VIEW TEACHINGSTAFFATTACHMENT AS
SELECT 
	e.empid AS EMPLOYEE_NO
	, a.attachment_type AS AttachmentTypeCode
    , a.link AS Link
    , a.title AS AttachmentTitle
FROM attachments a
JOIN employees e ON e.id = a.empid
WHERE e.active = 1 AND e.category IN (1, 2);