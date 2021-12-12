

drop procedure if exists schedule_course;
delimiter //
create procedure schedule_course(in p_course_name varchar(50),in p_start_date date,in p_trainer_email varchar(50),in p_assessment_status varchar(50),in p_participation_limit int,in p_no_of_questions int ,in p_action varchar(50),out p_status varchar(50) )
begin
declare p_end_date date;
declare p_duration int;
declare c int;
declare p_course_id int;
select duration into p_duration from course_details where course_name=p_course_name;
set p_end_date = date_add(p_start_date,interval p_duration day);
if exists(select * from scheduled_courses where trainer_email=p_trainer_email and start_date=p_start_date and end_date=p_end_date) then
set p_status="The trainer chosen in not available";
else
if p_assessment_status = 'Yes' then
select count(*) into c from question_generation_details q inner join course_details c on q.course_id=c.course_id where course_name=p_course_name;
if c='0' then
set p_status="You cannot schedule assessment for this course!";
elseif c<p_no_of_questions then
set p_status="You do not have enough questions to schedule assessment for this course!";
end if;
end if;
if p_action='schedule' then
if exists(select * from scheduled_courses where start_date=p_start_date and course_id=p_course_id)then
set p_status="Course is already scheduled for the same dates!";
else
select course_id into p_course_id from course_details where course_name=p_course_name;
INSERT INTO `scheduled_courses` (`course_id`, `start_date`, `end_date`, `trainer_email`, `assessment_status`, `participant_limit`, `no_of_questions`) VALUES (p_course_id,p_start_date,p_end_date,p_trainer_email,p_assessment_status,p_participation_limit,p_no_of_questions);
set p_status="Course scheduled successfully!";
end if;
elseif p_action='update' then
select course_id into p_course_id from course_details where course_name=p_course_name;
update scheduled_courses set start_date=p_start_date,end_date=p_end_date,trainer_email=p_trainer_email,assessment_status=p_assessment_status,participation_limit=p_participation_limit,no_of_questions=p_no_of_questions where course_id=p_course_id;
set p_status="Course updated successfully!";
end if;
end if;
end;
//
delimiter ;