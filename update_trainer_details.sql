drop trigger if exists update_trainer_details;
delimiter //
CREATE TRIGGER update_trainer_details
AFTER INSERT
ON scheduled_courses
FOR EACH ROW
BEGIN
declare number_of_courses int;
select count(*) into number_of_courses from scheduled_courses where trainer_email=new.trainer_email and end_date<=new.start_date;

if(number_of_courses<=50) then
update trainer_details set job_lvl=1,salary=15000 where trainer_email=new.trainer_email;

elseif(number_of_courses>50 and number_of_courses<=150)then 
update trainer_details set job_lvl=2,salary=20000 where trainer_email=new.trainer_email;

elseif(number_of_courses>150 and number_of_courses<=300)then
update trainer_details set job_lvl=3,salary=25000 where trainer_email=new.trainer_email;

elseif(number_of_courses>300 and number_of_courses<=550)then
update trainer_details set job_lvl=4,salary=30000 where trainer_email=new.trainer_email;

elseif(number_of_courses>550 and number_of_courses<=800)then
update trainer_details set job_lvl=5,salary=35000 where trainer_email=new.trainer_email;

elseif(number_of_courses>800)then
update trainer_details set job_lvl=6,salary=40000 where trainer_email=new.trainer_email;

end if;
END;
//
delimiter ;