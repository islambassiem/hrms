select 
	v.empid
    , concat(e.first_name , ' '  , coalesce(e.middle_name, " ") , ' '  , coalesce(e.third_name, " "), ' '  , e.last_name) as name 
    , start_date
    , end_date
    , datediff(end_date, start_date) + 1 AS duration
    , vt.vacation_en
    , if(approval = 1 , 'approved', if(approval = 0 , 'pending', 'declined')) as approval
    , post_date
    , head_time	
    , concat('https://csmonline.net/uploads/leaves/', attachment) as attachment
from vacations v
join employees e using (empid)
join vacation_type vt on vt.vacation_type_id = v.vacation_type
order by vacation_id desc
limit 100;  