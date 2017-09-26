/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     26/07/2017 12:30:55 p.m.                     */
/*==============================================================*/


/*==============================================================*/
/* Table: "ORDER"                                               */
/*==============================================================*/
create table OT
(
   K_IDORDER            varchar(20) not null,
   N_NAME               varchar(50) not null,
   D_DATE_CREATION      date not null,
   primary key (K_IDORDER)
);

/*==============================================================*/
/* Table: PERMISSION                                            */
/*==============================================================*/
create table PERMISSION
(
   K_IDPERMISSION       int not null,
   N_NAME               varchar(50) not null,
   primary key (K_IDPERMISSION)
);

/*==============================================================*/
/* Table: ROLE                                                  */
/*==============================================================*/
create table ROLE
(
   K_IDROLE             int not null,
   N_NAME               varchar(50) not null,
   primary key (K_IDROLE)
);

/*==============================================================*/
/* Table: SERVICE                                               */
/*==============================================================*/
create table SERVICE
(
   K_IDSERVICE          int not null,
   N_GERENCY            varchar(50) not null,
   N_TYPE               varchar(10) not null,
   N_DESCRIPTION        varchar(200) not null,
   N_SCOPE              varchar(1000) not null,
   N_DURATION           varchar(5) not null,
   primary key (K_IDSERVICE)
);

/*==============================================================*/
/* Table: SITE                                                  */
/*==============================================================*/
create table SITE
(
   K_IDSITE             int not null,
   N_NAME               varchar(50) not null,
   primary key (K_IDSITE)
);

/*==============================================================*/
/* Table: SKILL                                                 */
/*==============================================================*/
create table SKILL
(
   K_IDSKILL            int not null,
   N_NAME               varchar(50) not null,
   N_DESCRIPTION        varchar(200) not null,
   primary key (K_IDSKILL)
);

/*==============================================================*/
/* Table: SPECIFIC_SERVICE                                      */
/*==============================================================*/
create table SPECIFIC_SERVICE
(
   K_ID_SP_SERVICE      varchar(20) not null,
   K_IDUSER             varchar(20),
   K_IDSERVICE          int,
   K_IDSITE             int,
   K_IDORDER            varchar(20),
   D_DATE_START_P       date,
   N_DURATION           varchar(5),
   D_DATE_FINISH_P      date,
   D_FORECAST           date,
   K_IDCLARO            varchar(20) UNIQUE,
   N_DESCRIPTION        varchar(500),
   N_CLARO_DESCRIPTION  varchar(500),
   D_DATE_START_R       date,
   D_DATE_FINISH_R      date,
   D_DATE_CREATION      date,
   N_ESTADO             varchar(20),
   N_ING_SOL            varchar(100),
   N_PROYECTO           varchar(100),
   N_REGION             varchar(20),
   N_CANTIDAD           varchar(3);
   N_CRQ                varchar(50),
   N_CIERRE_DESCRIPTION varchar(500),
   primary key (K_ID_SP_SERVICE)
);

/*==============================================================*/
/* Table: USER                                                  */
/*==============================================================*/
create table USER
(
   K_IDUSER             varchar(20) not null,
   K_IDROLE             int,
   N_NAME               varchar(50) not null,
   N_LASTNAME           varchar(50) not null,
   N_MAIL               varchar(50) not null,
   N_PHONE              varchar(20) not null,
   N_CELPHONE           varchar(20) not null,
   N_PASSWORD           varchar(20) not null,
   N_USERNAME           varchar(20) not null,
   primary key (K_IDUSER)
);

/*==============================================================*/
/* Table: USER_PERMISSIONS                                      */
/*==============================================================*/
create table USER_PERMISSIONS
(
   K_IDUSER             varchar(20) not null,
   K_IDPERMISSION       int not null,
   primary key (K_IDUSER, K_IDPERMISSION)
);

/*==============================================================*/
/* Table: USER_SKILL                                            */
/*==============================================================*/
create table USER_SKILL
(
   K_IDUSER             varchar(20) not null,
   K_IDSKILL            int not null,
   primary key (K_IDUSER, K_IDSKILL)
);


/*==============================================================*/
/* Table: RF                                            */
/*==============================================================*/
create table rf
(
   K_ID_RF              int not null AUTO_INCREMENT,
   D_DATE_S             date,
   N_REQUESTED_BY       varchar(100),
   N_STATUS             varchar(50),
   N_TYPE               varchar(50),
   N_ELEMENT            varchar(100),
   D_DATE_ASSGINED      date,
   K_ASSIGNED_TO        varchar(20) not null,
   D_DATE_SENT          date,
   N_FILE               varchar(100),
   N_OBSERVATIONS       varchar(200),
   N_MODULE             varchar(50),
   N_ID                 varchar(10),
   N_REMEDY             varchar(50),
   N_ORDER_W            varchar(50),
   D_BILL               date,
   N_MONTH_B            varchar(20),
   D_RAW                date,
   D_REVIEW             date,
   D_OTGDRT             date,
   N_idBSS              varchar(30),
   N_CODE              varchar(30),
   primary key (K_ID_RF)
);

alter table SPECIFIC_SERVICE add constraint FK_ORDER_SPSERVICE foreign key (K_IDORDER)
      references OT (K_IDORDER) on delete restrict on update restrict;

alter table SPECIFIC_SERVICE add constraint FK_SERV_SPSERVICE foreign key (K_IDSERVICE)
      references SERVICE (K_IDSERVICE) on delete restrict on update restrict;

alter table SPECIFIC_SERVICE add constraint FK_SITE_SPSERVICE foreign key (K_IDSITE)
      references SITE (K_IDSITE) on delete restrict on update restrict;

alter table SPECIFIC_SERVICE add constraint FK_USER_SPSERV foreign key (K_IDUSER)
      references USER (K_IDUSER) on delete restrict on update restrict;

alter table USER add constraint FK_USER_ROLE foreign key (K_IDROLE)
      references ROLE (K_IDROLE) on delete restrict on update restrict;

alter table USER_PERMISSIONS add constraint FK_USER_PERMISSIONS foreign key (K_IDUSER)
      references USER (K_IDUSER) on delete restrict on update restrict;

alter table USER_PERMISSIONS add constraint FK_USER_PERMISSIONS2 foreign key (K_IDPERMISSION)
      references PERMISSION (K_IDPERMISSION) on delete restrict on update restrict;

alter table USER_SKILL add constraint FK_USER_SKILL foreign key (K_IDUSER)
      references USER (K_IDUSER) on delete restrict on update restrict;

alter table USER_SKILL add constraint FK_USER_SKILL2 foreign key (K_IDSKILL)
      references SKILL (K_IDSKILL) on delete restrict on update restrict;

alter table rf add constraint FK_USER_RF foreign key (K_ASSIGNED_TO)
      references USER (k_iduser) on delete restrict on update restrict;

alter table specific_service add n_region varchar(20);
alter table specific_service add n_cantidad varchar(3);
alter table specific_service MODIFY COLUMN  K_ID_SP_SERVICE int not null AUTO_INCREMENT;