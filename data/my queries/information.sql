set @i:=0;
with cte as ( 
select 
	s.empid AS id
    , e.*
    , concat(e.first_name , ' '  , coalesce(e.middle_name, " ") , ' '  , coalesce(e.third_name, " "), ' '  , e.last_name) as name
    , s.basic AS b
    , s.housing AS h
    , s.transportation AS t
    , s. food AS f
    , format(round(s.basic + s.housing + s.transportation + s.food,0), 2) as package
    , national_id.id_num
    , sponsorship.sponsorship_en AS spons
    , departments.department_en AS dept
    , categories.category_en AS category
	, row_number() over(partition by empid order by effective desc) as rn 
from salary s
left join employees e on e.empid = s.empid
join national_id on national_id.empid = e.empid
join sponsorship on sponsorship.sponsorship_id = e.sponsorship
join departments on departments.department_id = e.department
join categories on categories.category_id = e.job_category
where e.job_status = 1)
select 
	@i:=@i+1 '#'
	, id
    , `name`
     , b , h , t , f  , package
    , id_num
    , spons
    , category
    , dept
	, email
    , mobile
    , ext
from cte where rn = 1;