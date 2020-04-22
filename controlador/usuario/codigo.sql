DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarYverficarUsuario_wvp`(IN `_nom` VARCHAR(100), IN `_usu` VARCHAR(100), IN `_pwd` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_idRol` INT, IN `_idusr` INT, IN `_st` CHAR(1))
BEGIN
   DECLARE bandera CHAR DEFAULT 'F';
   DECLARE img VARCHAR(30);
   DECLARE cant INT DEFAULT 0;
   SELECT COUNT(*) INTO cant FROM usuarios WHERE (usuario = _usu AND idUsuario != _idusr) OR (nombre = _nom AND idUsuario != _idusr);
   	
    IF (cant<0) THEN
  	BEGIN
         IF (_pwd= '') THEN
          BEGIN
              IF (_foto = '') THEN
              BEGIN
                    UPDATE usuarios SET nombre = _nom, usuario = _usu, idRol = _idRol, estatus = _st WHERE idUsuario = _idusr; 
                    #SELECT 'true' as result;
                    SET bandera = 'T';
              END;
              ELSE
              BEGIN
                    UPDATE usuarios SET nombre = _nom, usuario = _usu, idRol = _idRol, foto = _foto, estatus = _st WHERE idUsuario = _idusr;
                    #SELECT 'true' as result;
                    SET bandera = 'T';
              END;  
              END IF;
          END;
         ELSE
          BEGIN
              IF (_foto = '' ) THEN

                  UPDATE usuarios SET nombre = _nom, usuario = _usu, idRol = _idRol, contrasenia = _pwd, estatus = _st  WHERE idUsuario = _idusr;
                  #SELECT 'true' as result;
                  SET bandera = 'T';

              ELSE

                  UPDATE usuarios SET nombre = _nom, usuario = _usu, idRol = _idRol, contrasenia = _pwd, foto = _foto, estatus = _st WHERE idUsuario = _idusr;
                  #SELECT 'true' as result;
                  SET bandera = 'T';

              END IF;
          END;
         END IF;
  	END;
    END IF;
    
    SELECT usuarios.foto into img FROM usuarios WHERE usuarios.idUsuario = _idusr;

    IF bandera = 'T' THEN
    	SELECT 'true' as result, img as foto;
    ELSE
        SELECT 'false' as result;
    END IF;
   
END$$
DELIMITER ;



DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarYverficarUsuario1_wvp`(IN `_nom` VARCHAR(100), IN `_usu` VARCHAR(100), IN `_pwd` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_idRol` INT, IN `_idusr` INT, IN `_st` CHAR(1))
BEGIN
   DECLARE bandera CHAR DEFAULT 'F';
   DECLARE img VARCHAR(30);
   DECLARE cant INT DEFAULT 0;
   SELECT COUNT(*) INTO cant FROM usuarios WHERE (usuario = _usu AND idUsuario != _idusr) OR (nombre = _nom AND idUsuario != _idusr);
  
   SELECT cant;

    

   
END$$
DELIMITER ;