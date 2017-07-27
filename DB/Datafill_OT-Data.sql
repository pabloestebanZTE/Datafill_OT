/* Data de servicios*/
insert into service (K_IDSERVICE, N_GERENCY, N_TYPE, N_DESCRIPTION, N_SCOPE, N_DURATION)
  values (0, 'GDRCD (Anexo 4) CORE', 'C1', '', '', '5' ),
         (1, 'GDRCD (Anexo 4) CORE', 'C2', '', '', '4' ),
         (2, 'GDRCD (Anexo 4) CORE', 'C3', '', '', '3' ),
         (3, 'GRF (Anexo 2) RF', 'D1', '', '', '0.5' ),
         (4, 'GRF (Anexo 2) RF', 'D2', '', '', '1' ),
         (5, 'GRF (Anexo 2) RF', 'D3', '', '', '2' ),
         (6, 'GRF (Anexo 2) RF', 'D4', '', '', '2' ),
         (7, 'GRF (Anexo 2) RF', 'D5', '', '', '3' ),
         (8, 'GRF (Anexo 2) RF', 'D6', '', '', '5' ),
         (9, 'GDRT (Anexo 3) TRANSMISIÓN', 'T1', '', '', '1.5' ),
         (10, 'GDRT (Anexo 3) TRANSMISIÓN', 'T2', '', '', '1.5' ),
         (11, 'GDRT (Anexo 3) TRANSMISIÓN', 'T3', '', '', '1.5' ),
         (12, 'GDRT (Anexo 3) TRANSMISIÓN', 'T4', '', '', '1.5' ),
         (13, 'GDRT (Anexo 3) TRANSMISIÓN', 'T5', '', '', '2' ),
         (14, 'GDRT (Anexo 3) TRANSMISIÓN', 'T6', '', '', '3' ),
         (15, 'GDRT (Anexo 3) TRANSMISIÓN', 'T7', '', '', '0.5' ),
         (16, 'GDRT (Anexo 3) TRANSMISIÓN', 'T8', '', '', '0.5' ),
         (17, 'GDRT (Anexo 3) TRANSMISIÓN', 'T9', '', '', '2' );

/*Data de permisos*/
  insert into permission (K_IDPERMISSION, N_NAME)
    values(0, 'Crear servicios'),
          (1, 'Listar servicios'),
          (2, 'Ver servicios por persona');

/*Data de Roles*/
  insert into role (K_IDROLE, N_NAME)
    values (0, 'PM'),
           (1, 'Ingeniero Datafill GDRT'),
           (2, 'Ingeniero Datafill GDRCD'),
           (3, 'Ingeniero Datafill GRF'),
           (4, 'Coordinador');

/*Data de usuarios*/

/*Data de sites*/
