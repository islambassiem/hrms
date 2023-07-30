with cte as (
select 
	s.empid
    , concat(e.first_name , ' '  , coalesce(e.middle_name, " ") , ' '  , coalesce(e.third_name, " "), ' '  , e.last_name) as name
    , s.basic
    , s.housing
    , s.transportation
    , round(s.basic + s.housing + s.transportation + s.food,0) as package
	, row_number() over(partition by empid order by effective desc) as rn 
from salary s
left join employees e on e.empid = s.empid)
select 
	empid
    , `name`
    , basic
    , housing
    , transportation
    , package
from cte where rn = 1;