set @i:=0;
select 
	@i:=@i+1 '#'
 , e.empid
 , concat(e.first_name , ' '  , coalesce(e.middle_name, " ") , ' '  , coalesce(e.third_name, " "), ' '  , e.last_name) as name
 , n.id_num
 from employees e 
 join national_id n ON n.empid = e.empid
 join iqama_cards i ON i.iqama = n.id_num 
 where job_status = 1 and nationality != 101 and email is not null and email != '' and sponsorship != 3;