-- CREATE VIEW TEACHINGSTAFF AS
SELECT 
	e.empid AS EMPLOYEE_NO
    , e.first_name_ar AS ArabicFirstName
    , e.middle_name_ar AS ArabicSecondName
    , e.third_name_ar AS ArabicThirdName
    , e.family_name_ar AS ArabicLastName
    , e.first_name_en AS EnglishFirstName
	, e.middle_name_en AS EnglishSecondName
    , e.third_name_en AS EnglishThirdName
    , e.family_name_en AS EnglishFourhtName
    , i.`number` AS IdentityNumber
    , e.place_of_birth AS BirthPlaceCode
    , e.date_of_birth AS BirthDate
    , p.passport_number AS PassportNumber
    , e.home_country_id AS HomeCountryIdentityNumber
    , e.gender AS Gender
    , e.nationality AS NationalityCode
    , e.marital_status AS MaritalStatusCode
    , e.religion AS ReligionCode
    , a.street_name AS PostalAddress
    , a.city AS CityCode
    , a.zip_code AS ZipCode
    , c.official_email AS EmailAddress
    , c.home AS HomeTelephoneNumber
    , '920001103' AS WorkTelephoneNumber
    , c.extention AS WorkTelephoneExtentionNumber
    , c.mobile AS MobileNumber
    , IF(e.special_need IS NOT NULL, 1, 0 ) AS IsSpecialNeeds
    , e.special_need AS SpecialNeedCode
    , e.updated_at AS LastUpdateDate
FROM employees e
JOIN identifications i ON i.empid = e.id
JOIN passports p ON p.empid = e.id
JOIN addresses a ON a.empid = e.id
JOIN contacts c ON c.empid = e.id
WHERE e.active = 1 AND e.category IN (1, 2);