drop function if exists add_trainer;
delimiter //
create function add_trainer(p_trainer_email varchar(30),p_phone_number bigint, p_experience float, p_skill_set varchar(30))
returns int
begin
declare job_lvl int;
declare sal float;
if exists(select * from trainer_details where trainer_email=p_trainer_email)then
return 1;
else
if(p_experience<=2.0) then
set job_lvl=1;
set sal = 15000.0;
elseif(p_experience>2.0 and p_experience<=3.5)then
set job_lvl=2;
set sal=20000.0;
elseif(p_experience>3.5 and p_experience<=5.0)then
set job_lvl=3;
set sal=25000;
elseif(p_experience>5.0 and p_experience<=8.0) then
set job_lvl=4;
set sal=30000.0;
elseif(p_experience>8.0 and p_experience<=15.0)then
set job_lvl=5;
set sal=35000.0;
elseif(p_experience>15.0) then
set job_lvl=6;
set sal=40000.0;
end if;
insert into trainer_details(trainer_email, phone_number,experience,skill_set,job_level,salary) 
values(p_trainer_email,p_phone_number,p_experience,p_skill_set,job_lvl,sal);
return 2;
end if;
end;
//
delimiter ;