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

           
