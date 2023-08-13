-- CREATE VIEW RESEARCH AS
SELECT 
	e.empid AS EMPLOYEE_NO
    , r.`type` AS 'Type'
    , r.`status` AS 'Status'
    , r.progress AS Status2Code
    , r.nature AS NatureCode
    , r.domain AS DomainCode
    , r.category_code AS CategoryCode
    , r.title AS Title
    , r.publishing_date AS PublishingDate
    , r.publisher AS Publisher
    , r.isbn AS ISBN
    , r.magazine AS Magazine
    , r.edition AS Edition
    , r.publication_location AS PublishingLocation
    , r.summary AS Summary
    , r.lang AS 'Language'
    , r.publishing_url AS PublishingURL
    , r.key_words AS KeyWords
	, r.PagesNumber AS PagesNumber
FROM research r
JOIN employees e ON e.id = r.empid
WHERE e.active = 1 AND e.category IN (1, 2);