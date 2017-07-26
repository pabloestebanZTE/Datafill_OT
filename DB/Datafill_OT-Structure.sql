/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     26/07/2017 11:05:09 a.m.                     */
/*==============================================================*/


drop table if exists PERMISSION;

drop table if exists ROLE;

drop table if exists SERVICE;

drop table if exists SITE;

drop table if exists SKILL;

drop table if exists SPECIFIC_SERVICE_;

drop table if exists USER;

drop table if exists USER_PERMISSIONS;

drop table if exists USER_SKILL;

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
   N_SCOPE              varchar(500) not null,
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
/* Table: SPECIFIC_SERVICE_                                     */
/*==============================================================*/
create table SPECIFIC_SERVICE_
(
   K_ID_SP_SERVICE      varchar(20) not null,
   K_IDUSER             varchar(20),
   K_IDSERVICE          int,
   K_IDSITE             int,
   D_DATE_START         datetime,
   N_DURATION           varchar(5),
   D_FINISHDATE         datetime,
   D_FORECAST           date,
   K_IDCLARO            varchar(20),
   N_DESCRIPTION        varchar(200),
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

alter table SPECIFIC_SERVICE_ add constraint FK_SERV_SPSERVICE foreign key (K_IDSERVICE)
      references SERVICE (K_IDSERVICE) on delete restrict on update restrict;

alter table SPECIFIC_SERVICE_ add constraint FK_SITE_SPSERVICE foreign key (K_IDSITE)
      references SITE (K_IDSITE) on delete restrict on update restrict;

alter table SPECIFIC_SERVICE_ add constraint FK_USER_SPSERV foreign key (K_IDUSER)
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
