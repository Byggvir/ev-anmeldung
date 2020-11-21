use evservices;

delimiter //

drop procedure if exists add_sunday_services //

create procedure add_sunday_services (n INT)
begin
  set @i=0;
  set @offset = 8 - dayofweek(CURRENT_DATE);

  repeat

    set @datum =convert(adddate(CURRENT_DATE, @offset + @i * 7),datetime);
    insert into events values
        (NULL,1,addtime(@datum,'10:00:00'),addtime(@datum,'10:00:00'),'Gottesdienst','Trinitatis','Gnadenkirche',60,3,40);
    set @i=@i+1; 

  until @i > (n + 1) end repeat; 

end
//
delimiter ;
