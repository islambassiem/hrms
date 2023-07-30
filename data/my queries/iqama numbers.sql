select 
	e.empid
    , concat(e.first_name_ar , ' '  , coalesce(e.middle_name_ar, " ") , ' '  , coalesce(e.third_name_ar, " "), ' '  , e.last_name_ar) as name
    , national_id.id_num
from national_id
join employees e on national_id.empid = e.empid;