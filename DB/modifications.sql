ALTER TABLE specific_service ADD N_ESTADO varchar(20);
ALTER TABLE specific_service ADD N_ING_SOL varchar(100);
ALTER TABLE specific_service ADD N_PROYECTO varchar(100);
ALTER TABLE specific_service ADD N_CRQ varchar(50);
ALTER TABLE specific_service ADD N_CIERRE_DESCRIPTION varchar(500);


alter table specific_service add N_REGION varchar(20);
alter table specific_service add N_CANTIDAD varchar(3);
alter table specific_service MODIFY COLUMN  K_ID_SP_SERVICE int not null AUTO_INCREMENT;


alter table specific_service MODIFY COLUMN  N_DESCRIPTION varchar(1000);
alter table specific_service MODIFY COLUMN  N_CLARO_DESCRIPTION varchar(1000);


alter table specific_service add D_CLARO_F DATE;

INSERT INTO `datafill_ot`.`role` (`K_IDROLE`, `N_NAME`) VALUES ('5', 'Ingeniero Claro');

alter table rf add N_COLOR varchar(10);

alter table rf MODIFY COLUMN  K_ASSIGNED_TO varchar(20);


alter table rf MODIFY COLUMN  N_ID varchar(10) UNIQUE  ;

ALTER TABLE ot ADD N_DRIVE varchar(200);

/*MODIFICACION 09-MARZO-2018*/

ALTER TABLE `datafill_ot`.`specific_service` 
ADD COLUMN `N_LINK_SEND` VARCHAR(200) NULL AFTER `N_CIERRE_DESCRIPTION`,
ADD COLUMN `N_LINK_EXECUTE` VARCHAR(200) NULL AFTER `N_LINK_SEND`;

ADD COLUMN `N_PRIORIDAD` VARCHAR(45) NULL AFTER `N_DRIVE`;


ALTER TABLE `datafill_ot`.`service` 
ADD COLUMN `N_LIMIT_SEND1` INT() NULL AFTER `N_DURATION`,
ADD COLUMN `N_LIMIT_SEND2` INT() NULL AFTER `N_LIMIT_SEND1`;

UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='3', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='0';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='3', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='1';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='2', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='2';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='2', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='9';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='2', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='10';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='2', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='11';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='4', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='12';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='1', `N_LIMIT_SEND2`='2' WHERE `K_IDSERVICE`='15';
UPDATE `datafill_ot`.`service` SET `N_LIMIT_SEND1`='2', `N_LIMIT_SEND2`='7' WHERE `K_IDSERVICE`='16';
