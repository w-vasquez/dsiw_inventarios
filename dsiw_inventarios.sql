-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-05-2020 a las 21:20:09
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dsiw_inventarios`
--
CREATE DATABASE IF NOT EXISTS `dsiw_inventarios` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dsiw_inventarios`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `  spcategoria`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `  spcategoria` (IN `id_estante` INT, IN `Nombre` VARCHAR(25), IN `estatus` CHAR(1), IN `id_bodega` INT)  BEGIN
Insert into categoria values (id_estante ,Nombre,estatus,id_bodega);
END$$

DROP PROCEDURE IF EXISTS `  sp_ModificarBodega_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `  sp_ModificarBodega_ksn` (IN `_id_bodega` INT, IN `_Nombre` VARCHAR(50), IN `_estatus` CHAR(1), IN `_id_municipio` INT)  UPDATE bodega SET Nombre=_Nombre, estatus=_estatus ,id_municipio=_id_municipio where id_bodega =_id_bodega$$

DROP PROCEDURE IF EXISTS `  sp_Modificarcategoria_xin`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `  sp_Modificarcategoria_xin` (IN `_id_estante` INT, IN `_Nombre` VARCHAR(25), IN `_estatus` CHAR(1), IN `_id_bodega` INT)  UPDATE ecategoria SET Nombre=_Nombre,estatus=_estatus,idcategoria=categoria where idcategoria=categoria$$

DROP PROCEDURE IF EXISTS `  sp_ModificarEstante_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `  sp_ModificarEstante_ksn` (IN `_id_estante` INT, IN `_Nombre` VARCHAR(25), IN `_estatus` CHAR(1), IN `_id_bodega` INT)  UPDATE estante SET Nombre=_Nombre,estatus=_estatus,id_bodega=_id_bodega where id_estante=_id_estante$$

DROP PROCEDURE IF EXISTS `  sp_Modificar_Nivel_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `  sp_Modificar_Nivel_ksn` (IN `_id_nivel` INT, IN `_Nivel` CHAR(2), IN `_estatus` CHAR(1), IN `_id_estante` INT)  UPDATE nivel SET Nivel=_Nivel,estatus=_estatus,id_estante=_id_estante where id_nivel=_id_nivel$$

DROP PROCEDURE IF EXISTS `sp_actualizarCostoOrden_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarCostoOrden_wvp` (IN `_cto` DOUBLE(10,2), IN `_idOrden` INT)  NO SQL
UPDATE ordenes o
            SET
                o.costo_total = o.costo_total + _cto
            WHERE
                o.id_orden = _idOrden$$

DROP PROCEDURE IF EXISTS `sp_actualizarCostoUnitario_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarCostoUnitario_wvp` (IN `_idProc` INT, IN `_idNivel` INT)  NO SQL
UPDATE inventario i SET i.Costo_uni = fn_costoUnitario_wvp(i.Costo_total,i.Cantidad_existencia)
WHERE i.id_producto = _idProc AND i.id_nivel = _idNivel$$

DROP PROCEDURE IF EXISTS `sp_actualizarDespachoInventario_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarDespachoInventario_wvp` (IN `_cant` DOUBLE(11,2), IN `_cv` DOUBLE(11,2), IN `_idProc` INT, IN `_idNivel` INT)  NO SQL
UPDATE inventario 
    SET 
    	Cantidad_existencia=Cantidad_existencia-_cant,
        Costo_total = Costo_total - _cv
    WHERE
    	id_producto = _idProc AND id_nivel = _idNivel$$

DROP PROCEDURE IF EXISTS `sp_actualizarInventario_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarInventario_wvp` (IN `_cant` DOUBLE(10,2), IN `_cto` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT)  NO SQL
UPDATE inventario 
            SET
                Cantidad_existencia=Cantidad_existencia + _cant, 
                Costo_total = Costo_total + _cto
            WHERE
                id_producto = _idProc AND
                id_nivel = _idNivel$$

DROP PROCEDURE IF EXISTS `sp_actualizarMovimientoEntrada_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarMovimientoEntrada_wvp` (IN `_cant` DOUBLE(10,2), IN `_cto` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT, IN `_idMov` INT)  NO SQL
UPDATE movimientos m SET
	m.Cantidad_entrada = _cant,
    m.Costo_entrada = _cto,
    m.id_producto = _idProc,
    m.id_nivel = _idNivel
WHERE
	m.id_movimiento = _idMov$$

DROP PROCEDURE IF EXISTS `sp_actualizarMovimientoSalida_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarMovimientoSalida_wvp` (IN `_cant` DOUBLE(10,2), IN `_cto` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT)  NO SQL
BEGIN
	UPDATE movimientos m SET
        m.Cantidad_salida = _cant,
        m.Costo_salida = _cto,
        m.id_producto = _idProc,
        m.id_nivel = _idNivel
	WHERE
		m.id_movimiento = _idMov;
END$$

DROP PROCEDURE IF EXISTS `sp_actualizarYverficarUsuario1_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarYverficarUsuario1_wvp` (IN `_nom` VARCHAR(100), IN `_usu` VARCHAR(100), IN `_pwd` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_idRol` INT, IN `_idusr` INT, IN `_st` CHAR(1))  BEGIN
   DECLARE bandera CHAR DEFAULT 'F';
   DECLARE img VARCHAR(30);
   DECLARE cant INT DEFAULT 0;
   SELECT COUNT(*) INTO cant FROM usuarios WHERE (usuario = _usu AND idUsuario != _idusr);
  
   SELECT cant;

    

   
END$$

DROP PROCEDURE IF EXISTS `sp_actualizarYverficarUsuario_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizarYverficarUsuario_wvp` (IN `_nom` VARCHAR(100), IN `_usu` VARCHAR(100), IN `_pwd` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_idRol` INT, IN `_idusr` INT, IN `_st` CHAR(1))  BEGIN
   DECLARE bandera CHAR DEFAULT 'F';
   DECLARE img VARCHAR(30);
   DECLARE cant INT DEFAULT 0;
   SELECT COUNT(*) INTO cant FROM usuarios WHERE (usuario = _usu AND idUsuario != _idusr) OR (nombre = _nom AND idUsuario != _idusr);
   	
    IF (cant=0) THEN
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

DROP PROCEDURE IF EXISTS `sp_agregarProveedor_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_agregarProveedor_de` (IN `_nom` VARCHAR(100), IN `_mail` VARCHAR(100), IN `_dir` VARCHAR(100), IN `_idmun` INT)  BEGIN 
   IF NOT EXISTS (SELECT * FROM proveedores p WHERE (p.Nombre = _nom AND p.Correo = _mail)) THEN
   BEGIN
	  INSERT INTO proveedores (Nombre, Correo, Direccion, id_municipio) VALUES (_nom,_mail,_dir,_idmun);
	  SELECT 'true' as result;
   END;
   ELSE
     SELECT 'false' as result;
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_agregarTelefono_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_agregarTelefono_de` (IN `id_telef` INT, IN `Nombre` VARCHAR(25), IN `telefono` VARCHAR(25), IN `id_prove` INT)  BEGIN
Insert into telefono values (id_telef ,Nombre,telefono,id_prove);
END$$

DROP PROCEDURE IF EXISTS `sp_compraYdespachoOrden_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_compraYdespachoOrden_wvp` (IN `_com` VARCHAR(100), IN `_idbodega` INT, IN `_idconcepto` INT)  NO SQL
INSERT INTO ordenes (comentario, id_bodega, id_concepto) VALUES (_com, _idbodega, _idconcepto)$$

DROP PROCEDURE IF EXISTS `sp_conceptoTipoConceptoSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_conceptoTipoConceptoSP_wvp` ()  NO SQL
SELECT * FROM vw_tipoconcepto_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaBodegaCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaBodegaCP_wvp` (IN `_municipio` VARCHAR(100))  NO SQL
SELECT * FROM vw_bodega_wvp WHERE vw_bodega_wvp.municipio = _municipio$$

DROP PROCEDURE IF EXISTS `sp_consultaBodegaSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaBodegaSP_wvp` ()  NO SQL
select * FROM vw_bodega_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaBodega_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaBodega_wvp` (IN `_stt` CHAR(1))  BEGIN
	IF(_stt="") THEN
    	SELECT v.*, fn_status_wvp (v.estatus) as status2 FROM vw_bodegaStatus_wvp v;
    ELSE   
		SELECT  v.*, fn_status_wvp (v.estatus) as status2 FROM vw_bodegaStatus_wvp v WHERE v.estatus=_stt;
	END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_consultaCantidadOrdenes_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaCantidadOrdenes_ksn` ()  SELECT COUNT(*) as cant_ordenes FROM ordenes$$

DROP PROCEDURE IF EXISTS `sp_consultaCategoriaSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaCategoriaSP_wvp` ()  NO SQL
SELECT * FROM vw_categoria_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaCategoria_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaCategoria_ksn` ()  SELECT c.nombre as nombre_categoria, count (id_producto)  as  cantidad_productos
FROM categoria as c  INNER JOIN productos as p 
on C.id_categoria=P.id_categoria$$

DROP PROCEDURE IF EXISTS `sp_consultaEstantesSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaEstantesSP_wvp` ()  NO SQL
SELECT * from vw_estantes_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultainventarioCP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultainventarioCP_de` (IN `_producto` VARCHAR(50))  NO SQL
SELECT * FROM vw_inventario_wvp WHERE vw_inventario_wvp.producto = _producto$$

DROP PROCEDURE IF EXISTS `sp_consultainventario_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultainventario_de` ()  NO SQL
select * FROM vw_inventario_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultamovientosCP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultamovientosCP_de` (IN `_estante` VARCHAR(25))  NO SQL
SELECT * FROM vw_movimientos_wvp WHERE vw_movimientos_wvp.estante = _estante$$

DROP PROCEDURE IF EXISTS `sp_consultamovientosSP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultamovientosSP_de` ()  NO SQL
select * FROM vw_movimientos_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaMovimientoCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaMovimientoCP_wvp` (IN `_idOrden` INT)  NO SQL
SELECT * FROM vw_movimientos_wvp WHERE vw_movimientos_wvp.id_orden  =_idOrden$$

DROP PROCEDURE IF EXISTS `sp_consultanivelCP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultanivelCP_de` (IN `_estatus` VARCHAR(10))  NO SQL
SELECT * FROM vw_nivel_wvp WHERE vw_nivel_wvp.estatus = _estatus$$

DROP PROCEDURE IF EXISTS `sp_consultanivelSP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultanivelSP_de` ()  NO SQL
select * FROM vw_nivel_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaordenestotalesCP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaordenestotalesCP_de` (IN `_costo_total` DOUBLE(8,2))  NO SQL
SELECT * FROM vw_ordenestotales_wvp WHERE vw_ordenestotales_wvp.costo_total = _costo_total$$

DROP PROCEDURE IF EXISTS `sp_consultaordenestotalesSP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaordenestotalesSP_de` ()  NO SQL
select * FROM vw_ordenestotales_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaproductosCP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaproductosCP_de` (IN `_Nombre` VARCHAR(50))  NO SQL
SELECT * FROM vw_productos_wvp WHERE vw_productos_wvp.Nombre = _Nombre$$

DROP PROCEDURE IF EXISTS `sp_consultaProductosCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaProductosCP_wvp` (IN `_cod` INT)  NO SQL
SELECT * FROM vw_inventario_wvp WHERE vw_inventario_wvp.id_producto = _cod$$

DROP PROCEDURE IF EXISTS `sp_consultaproductosSP_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaproductosSP_de` ()  NO SQL
select * FROM vw_productos_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaProveedorSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaProveedorSP_wvp` ()  NO SQL
SELECT * FROM vw_proveedor_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultarDepartamento_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultarDepartamento_wvp` ()  NO SQL
select * from vw_departamentos_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaRoles_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaRoles_wvp` ()  NO SQL
SELECT * FROM vw_roles_wvp$$

DROP PROCEDURE IF EXISTS `sp_consultaTelefonoCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaTelefonoCP_wvp` (IN `_numero` INT)  NO SQL
SELECT * FROM wv_telefono_de WHERE wv_telefono_de.numero=_numero$$

DROP PROCEDURE IF EXISTS `sp_consultaTelefonoSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaTelefonoSP_wvp` ()  NO SQL
SELECT * FROM wv_telefono_de$$

DROP PROCEDURE IF EXISTS `sp_consultaTipoconcepto_CP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaTipoconcepto_CP_wvp` (IN `_tipo_concepto` INT)  NO SQL
SELECT * FROM vw_tipoconcepto_wvp WHERE vw_tipoconcepto_wvp.tipo_concepto=_tipo_concepto$$

DROP PROCEDURE IF EXISTS `sp_consultaUsuariosCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaUsuariosCP_wvp` (IN `_usuario` VARCHAR(100), IN `_pwd` VARCHAR(100))  NO SQL
SELECT * FROM vw_usuarios_wvp WHERE vw_usuarios_wvp.usuario=_usuario AND vw_usuarios_wvp.contrasenia = _pwd$$

DROP PROCEDURE IF EXISTS `sp_consultaUsuariosSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_consultaUsuariosSP_wvp` ()  NO SQL
SELECT * FROM vw_usuarios_wvp$$

DROP PROCEDURE IF EXISTS `sp_despachoMovimiento_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_despachoMovimiento_wvp` (IN `_cant` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT, IN `_idOrden` INT)  NO SQL
BEGIN
	DECLARE cu DOUBLE (10,2);
    DECLARE cv DOUBLE (10,2);
	SET cu = fn_buscarCtoUnitario_wvp(_idProc,_idNivel);
	SET cv = cu * _cant;
    
	INSERT INTO movimientos (
    	Cantidad_salida,
        Costo_salida,
        id_producto, 
        id_nivel, 
        id_orden
    ) VALUES (
       	_cant,cv, _idProc, _idNivel, _idOrden
    );
END$$

DROP PROCEDURE IF EXISTS `sp_entradaMovimiento_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_entradaMovimiento_wvp` (IN `_cant` DOUBLE(11,2), IN `_cto` DOUBLE(11,2), IN `_idprodc` INT, IN `_idnivel` INT, IN `_idorden` INT, IN `_idUsuaio` INT)  NO SQL
INSERT INTO movimientos (Cantidad_entrada,Costo_entrada,id_producto,id_nivel,id_orden,id_usuario)
VALUES (_cant,_cto,_idprodc,_idnivel,_idorden, _idUsuaio)$$

DROP PROCEDURE IF EXISTS `sp_estanteGralCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_estanteGralCP_wvp` (IN `_idbodega` INT, IN `_stt` CHAR(1))  NO SQL
BEGIN
	IF (_idbodega = 0) THEN
		select * from vw_estantegral_wvp;
    ELSE
    	select * from vw_estantegral_wvp where id_bodega = _idbodega and estatus = _stt;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_InsertarBodega_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarBodega_ksn` (IN `_nom` VARCHAR(50), IN `_dir` VARCHAR(150), IN `_idmun` INT)  BEGIN 
   IF NOT EXISTS (SELECT * FROM bodega WHERE Nombre = _nom) THEN
   BEGIN
	  INSERT INTO bodega (nombre, direccion, id_municipio) VALUES (_nom,_dir,_idmun);
	  SELECT 'true' as result;
   END;
   ELSE
     SELECT 'false' as result;
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insertarCostoOrdenesNuevoInv_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertarCostoOrdenesNuevoInv_wvp` (IN `_cto` DOUBLE(10,2), IN `_idOrden` INT)  NO SQL
UPDATE ordenes o
            SET
                o.costo_total = _cto
            WHERE
                o.id_orden = _idOrden$$

DROP PROCEDURE IF EXISTS `sp_InsertarEstante_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarEstante_ksn` (IN `_nom` VARCHAR(25), IN `_stt` CHAR(1), IN `_idbodega` INT)  BEGIN
	IF NOT EXISTS (SELECT * FROM estante e WHERE e.id_bodega = _idbodega AND e.Nombre = _nom) THEN
    	#insertar
        INSERT INTO estante (nombre, estatus, id_bodega) VALUES (_nom, _stt, _idbodega);
    	SELECT 'true' as result;
        
    ELSE
    	SELECT 'false' as result;
    END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insertarInventarioNuevoCant_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertarInventarioNuevoCant_wvp` (IN `_cant` DOUBLE(10,2), IN `_cto` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT)  NO SQL
INSERT INTO inventario 
                (Cantidad_existencia, 
                 Costo_total, 
                 id_producto, 
                 id_nivel) 
        	VALUES (
                _cant, 
                _cto, 
                _idProc, 
                _idNivel
            	)$$

DROP PROCEDURE IF EXISTS `sp_InsertarNivel_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarNivel_ksn` (IN `_nivel` VARCHAR(25), IN `_stt` CHAR(1), IN `_idestante` INT)  BEGIN 
   IF NOT EXISTS (SELECT * FROM nivel WHERE (nivel.Nivel = _nivel AND Nivel.id_estante = _idestante)) THEN
   BEGIN
	  INSERT INTO nivel (nivel.Nivel, nivel.estatus, nivel.id_estante) VALUES (_nivel,_stt,_idestante);
	  SELECT 'true' as result;
   END;
   ELSE
     SELECT 'false' as result;
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_InsertarProductos_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_InsertarProductos_wvp` (IN `_nom` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_uni` VARCHAR(50), IN `_idProv` INT, IN `_max` DOUBLE(10,2), IN `_min` DOUBLE(10,2), IN `_marca` VARCHAR(100), IN `_idCat` INT)  NO SQL
BEGIN 
   IF NOT EXISTS (SELECT * FROM productos WHERE Nombre = _nom) THEN
   BEGIN
    IF (_foto = "") THEN
    BEGIN
      INSERT INTO productos(
            Nombre,
            Unidad_medida,
            Id_proveedor,
            Cantidad_minima,
            Cantidad_maxima,
            Marca,
            id_categoria)VALUES(
            _nom,
            _uni,
            _idProv,
            _max,
            _min,
            _marca,
            _idCat);
	    SELECT 'true' as result;
    END;
    ELSE
      BEGIN
        INSERT INTO productos(
            Nombre,
            foto,
            Unidad_medida,
            Id_proveedor,
            Cantidad_minima,
            Cantidad_maxima,
            Marca,
            id_categoria)VALUES(
            _nom,
            _foto,
            _uni,
            _idProv,
            _max,
            _min,
            _marca,
            _idCat);
        SELECT 'true' as result;
      END;
     END IF;
   END;
   ELSE
     SELECT 'false' as result;
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_insertarRol_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertarRol_wvp` (IN `_rol` VARCHAR(100))  NO SQL
INSERT INTO roles (roles.rol) VALUES (_rol)$$

DROP PROCEDURE IF EXISTS `sp_insertarYverficarUsuario_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertarYverficarUsuario_wvp` (IN `_nom` VARCHAR(100), IN `_usu` VARCHAR(100), IN `_pwd` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_idRol` INT)  NO SQL
BEGIN
   IF NOT EXISTS (SELECT * FROM usuarios WHERE usuarios.usuario = _usu) THEN

        IF (_foto = "") THEN

	          INSERT INTO usuarios (nombre, usuario, contrasenia, idRol) VALUES (_nom,_usu,_pwd,_idRol);
	          SELECT 'true' as result;
       
        ELSE
	       
	    	  INSERT INTO usuarios (nombre, usuario, contrasenia, foto, idRol) VALUES (_nom,_usu,_pwd,_foto,_idRol);
	          SELECT 'true' as result;
	        
        END IF;
   
   ELSE
   
        SELECT 'false' as result;
   
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_listausuarioCP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listausuarioCP_wvp` (IN `_idusr` INT)  NO SQL
select * from vw_usuarioslista_wvp WHERE id = _idusr$$

DROP PROCEDURE IF EXISTS `sp_listaUsuarioSP_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listaUsuarioSP_wvp` ()  NO SQL
select * from vw_usuarioslista_wvp$$

DROP PROCEDURE IF EXISTS `sp_modificarProductos_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificarProductos_wvp` (IN `_nom` VARCHAR(100), IN `_foto` VARCHAR(100), IN `_uni` VARCHAR(50), IN `_idProv` INT, IN `_max` DOUBLE(10,2), IN `_min` DOUBLE(10,2), IN `_marca` VARCHAR(100), IN `_status` CHAR(1), IN `_cto` DOUBLE(10,2), IN `_idCat` INT, IN `_idProc` INT)  NO SQL
UPDATE productos
SET 
	Nombre = _nom ,
    foto = _foto,
    Unidad_medida = _uni,
    Id_proveedor = _idProv,
    Cantidad_minima = _min,
    Cantidad_maxima = _max,
    Marca = _marca,
    id_categoria = _idCat,
    estatus = _status,
    cto_uni = _cto
WHERE
	id_producto = _idProc$$

DROP PROCEDURE IF EXISTS `sp_modificarProveedor_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificarProveedor_de` (IN `_id_prove` INT, IN `_Nombre` VARCHAR(25), IN `_Apellido` VARCHAR(25), IN `_correo` VARCHAR(10), IN `_direccion` VARCHAR(100), IN `_id_municipio` INT)  UPDATE proveedores SET Nombre=_Nombre,Apellido=_Apellido ,correo=_correo,direccion=_direccion,id_municipio=_id_municipio
 where id_prove =_id_prove$$

DROP PROCEDURE IF EXISTS `sp_modificarTelefono_de`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificarTelefono_de` (IN `_id_telef` INT, IN `_Nombre` VARCHAR(25), IN `_telefono` VARCHAR(25), IN `_id_prove` INT)  UPDATE telefonos SET Nombre=_Nombre,telefono=_telefono,id_prove=_id_prove
 where t.id_telefono =_id_telef$$

DROP PROCEDURE IF EXISTS `sp_municipio_ksn`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_municipio_ksn` (IN `_iddpt` INT)  NO SQL
BEGIN
	IF (_iddpt = '')THEN
    	select * from vw_municipios;
    ELSE
    	select * from vw_municipios WHERE vw_municipios.id_departamento = _iddpt;
   END IF;
END$$

DROP PROCEDURE IF EXISTS `sp_validarExistenciaDespacho_wvp`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_validarExistenciaDespacho_wvp` (IN `_cant` DOUBLE(10,2), IN `_costo` DOUBLE(10,2), IN `_idProc` INT, IN `_idNivel` INT, IN `_idOrden` INT)  NO SQL
BEGIN
	DECLARE existencia DOUBLE(10,2);
    SELECT i.Cantidad_existencia into existencia FROM inventario i WHERE i.id_nivel = _idNivel AND i.id_producto = _idProc;
	IF existencia>=_cant THEN
    	BEGIN
    	call sp_actualizarDespachoInventario_wvp(_cant,_costo,_idProc,_idNivel);
        CALL sp_actualizarCostoOrden_wvp(
        _costo, 
        _idOrden);
        END;
    ELSE 
    	select "cant_insuficiente" as mensaje;
    END IF;
END$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `fn_buscarCtoUnitario_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_buscarCtoUnitario_wvp` (`_idProc` INT, `_idNivel` INT) RETURNS DOUBLE(10,2) NO SQL
BEGIN
	DECLARE ctoUni DOUBLE (11,2);
    SELECT i.Costo_uni INTO ctoUni FROM inventario i WHERE i.id_producto = _idProc AND i.id_nivel = _idNivel;
    RETURN ctoUni;
END$$

DROP FUNCTION IF EXISTS `fn_cantInsuficiente_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_cantInsuficiente_wvp` () RETURNS VARCHAR(50) CHARSET latin1 NO SQL
RETURN "cantidad insuficiente"$$

DROP FUNCTION IF EXISTS `fn_costoTotal_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_costoTotal_wvp` (`_orden` INT) RETURNS DOUBLE(10,2) NO SQL
BEGIN
	DECLARE suma DOUBLE (10,2);
     SELECT SUM(m.Costo_entrada) INTO suma FROM movimientos m WHERE m.id_orden = _orden; 
    RETURN suma;
    
END$$

DROP FUNCTION IF EXISTS `fn_costoUnitario_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_costoUnitario_wvp` (`_costo` DOUBLE(10,2), `_cant` DOUBLE(10,2)) RETURNS DOUBLE NO SQL
BEGIN
	DECLARE resultado DOUBLE (10,2);
    SET resultado = _costo/_cant;
   	IF (resultado = NULL ) THEN 
    	SET resultado = 0.0 ;
    END IF;
    RETURN resultado;
    	

END$$

DROP FUNCTION IF EXISTS `fn_inventarioExiste_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_inventarioExiste_wvp` (`_idProc` INT, `_idNivel` INT) RETURNS INT(11) NO SQL
BEGIN
	DECLARE cant INT;
   
    SELECT COUNT(*) INTO cant 
    FROM inventario i  
    WHERE i.id_producto = _idProc AND i.id_nivel = _idNivel;

    RETURN cant;

END$$

DROP FUNCTION IF EXISTS `fn_status_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_status_wvp` (`_cod` CHAR(1)) RETURNS VARCHAR(10) CHARSET latin1 NO SQL
CASE _cod
WHEN "A" THEN
	RETURN 'Activo';
WHEN "I" THEN
	RETURN 'Inactivo';
END CASE$$

DROP FUNCTION IF EXISTS `fn_tipoConcepto_wvp`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_tipoConcepto_wvp` (`_concep` TINYINT) RETURNS TINYINT(1) NO SQL
BEGIN
	DECLARE tipo INT;
    
    SELECT t.id_tipo_concepto INTO tipo FROM tipo_conceptos t INNER JOIN concepto c ON c.id_tipo_concepto = t.id_tipo_concepto WHERE c.id_concepto = _concep;
    
    RETURN tipo;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bodega`
--

DROP TABLE IF EXISTS `bodega`;
CREATE TABLE `bodega` (
  `id_bodega` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `direccion` varchar(150) NOT NULL,
  `id_municipio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `bodega`
--

INSERT INTO `bodega` (`id_bodega`, `Nombre`, `estatus`, `direccion`, `id_municipio`) VALUES
(1, 'bodega A', 'A', '', 1),
(2, 'bodega B', 'A', '', 2),
(3, 'bodega C', 'A', 's.s', 2),
(4, 'Bodega D', 'A', 'sivar', 251),
(5, 'Bodega E', 'A', 'Final paseo Miralvalle y pje. MÃ³naco # 28', 181);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `descripcion` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`, `estatus`, `descripcion`) VALUES
(1, 'herramientas', 'A', 'Lorem ipsum dolor sit amet, consectetur adipiscing'),
(2, 'construccion', 'A', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `concepto`
--

DROP TABLE IF EXISTS `concepto`;
CREATE TABLE `concepto` (
  `id_concepto` int(11) NOT NULL,
  `concepto` varchar(50) NOT NULL,
  `id_tipo_concepto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `concepto`
--

INSERT INTO `concepto` (`id_concepto`, `concepto`, `id_tipo_concepto`) VALUES
(1, 'Compra', 1),
(2, 'Transito', 1),
(3, 'Bodega', 1),
(4, 'Despacho', 2),
(5, 'Transito', 2),
(6, 'Traslado', 2),
(7, 'Perdida', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE `departamentos` (
  `id_departamento` int(11) NOT NULL,
  `departamento` varchar(50) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id_departamento`, `departamento`) VALUES
(1, 'Ahuachapán'),
(2, 'Santa Ana'),
(3, 'Sonsonate'),
(4, 'Usulután'),
(5, 'San Miguel'),
(6, 'Morazán'),
(7, 'La Unión'),
(8, 'La Libertad'),
(9, 'Chalatenango'),
(10, 'Cuscatlán'),
(11, 'San Salvador'),
(12, 'La Paz'),
(13, 'Cabañas'),
(14, 'San Vicente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estante`
--

DROP TABLE IF EXISTS `estante`;
CREATE TABLE `estante` (
  `id_estante` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `id_bodega` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `estante`
--

INSERT INTO `estante` (`id_estante`, `Nombre`, `estatus`, `id_bodega`) VALUES
(1, 'estante 1', 'A', 1),
(2, 'estante 2', 'A', 1),
(3, 'estante A', 'A', 2),
(4, 'estante B', 'A', 2),
(5, 'estante 3', 'A', 1),
(6, 'estante 4', 'A', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE `inventario` (
  `id_inventario` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `Cantidad_existencia` decimal(10,2) NOT NULL,
  `Costo_total` decimal(10,2) NOT NULL,
  `Costo_uni` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_producto`, `id_nivel`, `Cantidad_existencia`, `Costo_total`, `Costo_uni`) VALUES
(1, 2, 2, '130.20', '910.00', 0.00),
(2, 1, 2, '10.00', '30.00', 0.00),
(3, 3, 2, '50.00', '50.00', 0.00),
(4, 3, 1, '30.00', '25.10', 0.00),
(5, 4, 2, '323.30', '1240.00', 3.84),
(6, 2, 1, '100.00', '250.00', 2.50),
(14, 1, 1, '40.00', '100.00', 2.50);

--
-- Disparadores `inventario`
--
DROP TRIGGER IF EXISTS `tg_inventarioBD_wvp`;
DELIMITER $$
CREATE TRIGGER `tg_inventarioBD_wvp` BEFORE DELETE ON `inventario` FOR EACH ROW INSERT INTO inventario_borrado (
    cantidad, 
    costo, 
    id_producto, 
    id_nivel,
    id_inventario) 
VALUES (
	OLD.Cantidad_existencia,
    OLD.Costo_total,
    OLD.id_producto,
    OLD.id_nivel,
    OLD.id_inventario
)
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_productoAI_wvp`;
DELIMITER $$
CREATE TRIGGER `tg_productoAI_wvp` AFTER INSERT ON `inventario` FOR EACH ROW BEGIN
	DECLARE cvu DOUBLE(10,2);
    
	SELECT AVG(i.Costo_uni) INTO cvu FROM inventario i WHERE i.id_producto = NEW.id_producto;
    
    UPDATE productos p SET p.cto_uni = cvu WHERE p.id_producto = NEW.id_producto;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_productoAU_wvp`;
DELIMITER $$
CREATE TRIGGER `tg_productoAU_wvp` AFTER UPDATE ON `inventario` FOR EACH ROW BEGIN
	DECLARE cvu DOUBLE(10,2);
    
	SELECT AVG(i.Costo_uni) INTO cvu FROM inventario i WHERE i.id_producto = NEW.id_producto;
    
    UPDATE productos p SET p.cto_uni = cvu WHERE p.id_producto = NEW.id_producto;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario_borrado`
--

DROP TABLE IF EXISTS `inventario_borrado`;
CREATE TABLE `inventario_borrado` (
  `id_invBorrado` int(11) NOT NULL,
  `cantidad` double(10,2) NOT NULL,
  `costo` double(10,2) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_inventario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventario_borrado`
--

INSERT INTO `inventario_borrado` (`id_invBorrado`, `cantidad`, `costo`, `id_producto`, `id_nivel`, `fecha_registro`, `id_inventario`) VALUES
(1, 290.00, 996.80, 1, 3, '2020-03-22 11:26:04', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `movimientos`
--

DROP TABLE IF EXISTS `movimientos`;
CREATE TABLE `movimientos` (
  `id_movimiento` int(11) NOT NULL,
  `Cantidad_entrada` double(10,2) NOT NULL DEFAULT '0.00',
  `Costo_entrada` double(10,2) NOT NULL DEFAULT '0.00',
  `Cantidad_salida` double(10,2) NOT NULL DEFAULT '0.00',
  `Costo_salida` double(10,2) NOT NULL DEFAULT '0.00',
  `id_producto` int(11) NOT NULL,
  `id_nivel` int(11) NOT NULL,
  `id_orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `movimientos`
--

INSERT INTO `movimientos` (`id_movimiento`, `Cantidad_entrada`, `Costo_entrada`, `Cantidad_salida`, `Costo_salida`, `id_producto`, `id_nivel`, `id_orden`) VALUES
(1, 12.30, 200.10, 0.00, 0.00, 1, 1, 1),
(2, 30.10, 300.00, 0.00, 0.00, 2, 2, 1),
(3, 10.10, 100.00, 0.00, 0.00, 2, 2, 2),
(5, 30.10, 300.00, 0.00, 0.00, 2, 2, 2),
(6, 30.10, 100.00, 0.00, 0.00, 2, 2, 2),
(7, 10.30, 30.00, 0.00, 0.00, 1, 2, 1),
(8, 30.10, 300.00, 0.00, 0.00, 2, 2, 3),
(9, 40.00, 100.00, 0.00, 0.00, 1, 1, 1),
(10, 25.00, 25.00, 0.00, 0.00, 3, 2, 3),
(11, 25.00, 25.10, 0.00, 0.00, 3, 2, 3),
(12, 30.00, 25.10, 0.00, 0.00, 3, 1, 3),
(13, 30.10, 300.00, 0.00, 0.00, 2, 2, 3),
(14, 30.10, 200.00, 0.00, 0.00, 2, 2, 3),
(15, 30.10, 300.00, 0.00, 0.00, 4, 2, 4),
(16, 200.00, 100.00, 0.00, 0.00, 4, 2, 5),
(17, 90.00, 150.00, 0.00, 0.00, 2, 1, 5),
(18, 30.00, 100.00, 0.00, 0.00, 2, 2, 5),
(19, 10.00, 50.00, 0.00, 0.00, 4, 2, 5),
(20, 30.10, 300.00, 0.00, 0.00, 4, 2, 5),
(21, 13.00, 90.00, 0.00, 0.00, 4, 2, 5),
(28, 77.00, 770.00, 0.00, 0.00, 1, 3, 4),
(29, 77.00, 770.00, 0.00, 0.00, 1, 3, 1),
(30, 77.00, 1.00, 0.00, 0.00, 1, 3, 1),
(31, 34.00, 17.00, 0.00, 0.00, 1, 3, 1),
(32, 34.00, 17.00, 0.00, 0.00, 2, 3, 1),
(33, 100.00, 100.00, 0.00, 0.00, 1, 3, 1),
(34, 100.00, 100.00, 0.00, 0.00, 1, 4, 1),
(35, 77.00, 770.00, 0.00, 0.00, 1, 4, 6),
(36, 10.00, 100.00, 0.00, 0.00, 1, 4, 6),
(40, 10.00, 100.00, 0.00, 0.00, 1, 3, 5),
(42, 10.00, 100.00, 0.00, 0.00, 1, 4, 5),
(43, 10.00, 100.00, 0.00, 0.00, 1, 4, 5),
(44, 10.00, 100.00, 0.00, 0.00, 1, 4, 5),
(45, 10.00, 100.00, 0.00, 0.00, 1, 4, 5),
(46, 10.00, 100.00, 0.00, 0.00, 1, 3, 5),
(47, 10.00, 100.00, 0.00, 0.00, 2, 1, 5),
(48, 10.00, 100.00, 0.00, 0.00, 4, 2, 5),
(49, 0.00, 0.00, 20.00, 68.80, 1, 3, 7),
(50, 0.00, 0.00, 20.00, 68.80, 1, 3, 7),
(51, 0.00, 0.00, 10.00, 34.40, 1, 3, 7),
(52, 0.00, 0.00, 20.00, 68.80, 1, 3, 7),
(53, 30.10, 300.00, 0.00, 0.00, 4, 2, 1),
(54, 30.10, 300.00, 0.00, 0.00, 5, 2, 1);

--
-- Disparadores `movimientos`
--
DROP TRIGGER IF EXISTS `tg_InventarioAI_wvp`;
DELIMITER $$
CREATE TRIGGER `tg_InventarioAI_wvp` AFTER INSERT ON `movimientos` FOR EACH ROW BEGIN
	
    DECLARE idConcepto INT;
    
    SELECT o.id_concepto INTO idConcepto FROM ordenes o WHERE o.id_orden = NEW.id_orden;
    
    SET idConcepto = fn_tipoConcepto_wvp(idConcepto);
	CASE idConcepto
    WHEN 1 THEN
    BEGIN
		IF (fn_inventarioExiste_wvp(NEW.id_producto, NEW.id_nivel)=0) THEN
			
            #insertar
        	CALL sp_insertarInventarioNuevoCant_wvp (
                NEW.cantidad_entrada,
                NEW.costo_entrada, 
                NEW.id_producto, 
                NEW.id_nivel
            );
            
            #Actualizar orden.costo_total Nuevo Inventario
            CALL sp_insertarCostoOrdenesNuevoInv_wvp (
                NEW.costo_entrada,
                NEW.id_orden);
    	ELSE 
    		CALL sp_actualizarInventario_wvp (
                NEW.cantidad_entrada,
            	NEW.costo_entrada,
                NEW.id_producto,
                NEW.id_nivel
            	);

            #Actualizar orden.costo_total Existe Inventario
            CALL sp_actualizarCostoOrden_wvp(
                NEW.costo_entrada, 
                NEW.id_orden);

        END IF;
        CALL sp_actualizarCostoUnitario_wvp(NEW.id_producto,NEW.id_nivel);
	END;
    WHEN 2 THEN
    
        call sp_validarExistenciaDespacho_wvp(
            NEW.cantidad_salida,
            NEW.costo_salida,
            NEW.id_producto,
            NEW.id_nivel,
            NEW.id_orden);
    
	END CASE;
  
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `tg_inventarioAU_wvp`;
DELIMITER $$
CREATE TRIGGER `tg_inventarioAU_wvp` AFTER UPDATE ON `movimientos` FOR EACH ROW BEGIN
	
    DECLARE idConcepto INT;
    
    SELECT o.id_concepto INTO idConcepto FROM ordenes o WHERE o.id_orden = NEW.id_orden;
    
    SET idConcepto = fn_tipoConcepto_wvp(idConcepto);
	CASE idConcepto
    WHEN 1 THEN
    BEGIN
		IF (fn_inventarioExiste_wvp(NEW.id_producto, NEW.id_nivel)=0) THEN
			
            #insertar
        	CALL sp_insertarInventarioNuevoCant_wvp (
                NEW.cantidad_entrada,
                NEW.costo_entrada, 
                NEW.id_producto, 
                NEW.id_nivel
            );
            
            #Actualizar orden.costo_total Nuevo Inventario
            CALL sp_insertarCostoOrdenesNuevoInv_wvp (
                NEW.costo_entrada,
                NEW.id_orden);
    	ELSE 
    		CALL sp_actualizarInventario_wvp (
                NEW.cantidad_entrada,
            	NEW.costo_entrada,
                NEW.id_producto,
                NEW.id_nivel
            	);

            #Actualizar orden.costo_total Existe Inventario
            CALL sp_actualizarCostoOrden_wvp(
                NEW.costo_entrada, 
                NEW.id_orden);

        END IF;
        CALL sp_actualizarCostoUnitario_wvp(NEW.id_producto,NEW.id_nivel);
	END;
    WHEN 2 THEN
    
        call sp_validarExistenciaDespacho_wvp(
            NEW.cantidad_salida,
            NEW.costo_salida,
            NEW.id_producto,
            NEW.id_nivel,
            NEW.id_orden);
    
	END CASE;
  
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

DROP TABLE IF EXISTS `municipios`;
CREATE TABLE `municipios` (
  `id_municipio` int(11) NOT NULL,
  `municipio` varchar(50) CHARACTER SET latin1 NOT NULL,
  `id_departamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id_municipio`, `municipio`, `id_departamento`) VALUES
(1, 'Ahuachapán', 1),
(2, 'Apaneca', 1),
(3, 'Atiquizaya', 1),
(4, 'Concepción de Ataco', 1),
(5, 'El Refugio', 1),
(6, 'Guaymango', 1),
(7, 'Jujutla', 1),
(8, 'San Francisco Men?ndez', 1),
(9, 'San Lorenzo', 1),
(10, 'San Pedro Puxtla', 1),
(11, 'Tacuba', 1),
(12, 'Tur?n', 1),
(13, 'Candelaria de la Frontera', 2),
(14, 'Chalchuapa', 2),
(15, 'Coatepeque', 2),
(16, 'El Congo', 2),
(17, 'El Porvenir', 2),
(18, 'Masahuat', 2),
(19, 'Metapán', 2),
(20, 'San Antonio Pajonal', 2),
(21, 'San Sebastián Salitrillo', 2),
(22, 'Santa Ana', 2),
(23, 'Santa Rosa Guachipilín', 2),
(24, 'Santiago de la Frontera', 2),
(25, 'Texistepeque', 2),
(26, 'Acajutla', 3),
(27, 'Armenia', 3),
(28, 'Caluco', 3),
(29, 'Cuisnahuat', 3),
(30, 'Izalco', 3),
(31, 'Juay?a', 3),
(32, 'Nahuizalco', 3),
(33, 'Nahulingo', 3),
(34, 'Salcoatit?n', 3),
(35, 'San Antonio del Monte', 3),
(36, 'San Juli?n', 3),
(37, 'Santa Catarina Masahuat', 3),
(38, 'Santa Isabel Ishuatán', 3),
(39, 'Santo Domingo de Guzmán', 3),
(40, 'Sonsonate', 3),
(41, 'Sonzacate', 3),
(42, 'Alegría', 4),
(43, 'Berlín', 4),
(44, 'California', 4),
(45, 'Concepción Batres', 4),
(46, 'El Triunfo', 4),
(47, 'Ereguayquín', 4),
(48, 'Estanzuelas', 4),
(49, 'Jiquilisco', 4),
(50, 'Jucuapa', 4),
(51, 'Jucuar?n', 4),
(52, 'Mercedes Uma?a', 4),
(53, 'Nueva Granada', 4),
(54, 'Ozatl?n', 4),
(55, 'Puerto El Triunfo', 4),
(56, 'San Agust?n', 4),
(57, 'San Buenaventura', 4),
(58, 'San Dionisio', 4),
(59, 'San Francisco Javier', 4),
(60, 'Santa Elena', 4),
(61, 'Santa Mar?a', 4),
(62, 'Santiago de Mar?a', 4),
(63, 'Tecap?n', 4),
(64, 'Usulut?n', 4),
(65, 'Carolina', 5),
(66, 'Chapeltique', 5),
(67, 'Chinameca', 5),
(68, 'Chirilagua', 5),
(69, 'Ciudad Barrios', 5),
(70, 'Comacar?n', 5),
(71, 'El Tr?nsito', 5),
(72, 'Lolotique', 5),
(73, 'Moncagua', 5),
(74, 'Nueva Guadalupe', 5),
(75, 'Nuevo Ed?n de San Juan', 5),
(76, 'Quelepa', 5),
(77, 'San Antonio', 5),
(78, 'San Gerardo', 5),
(79, 'San Jorge', 5),
(80, 'San Luis de la Reina', 5),
(81, 'San Miguel', 5),
(82, 'San Rafael Oriente', 5),
(83, 'Sesori', 5),
(84, 'Uluazapa', 5),
(85, 'Arambala', 6),
(86, 'Cacaopera', 6),
(87, 'Chilanga', 6),
(88, 'Corinto', 6),
(89, 'Delicias de Concepci?n', 6),
(90, 'El Divisadero', 6),
(91, 'El Rosario', 6),
(92, 'Gualococti', 6),
(93, 'Guatajiagua', 6),
(94, 'Joateca', 6),
(95, 'Jocoaitique', 6),
(96, 'Jocoro', 6),
(97, 'Lolotiquillo', 6),
(98, 'Meanguera', 6),
(99, 'Osicala', 6),
(100, 'Perqu?n', 6),
(101, 'San Carlos', 6),
(102, 'San Fernando', 6),
(103, 'San Francisco Gotera', 6),
(104, 'San Isidro', 6),
(105, 'San Sim?n', 6),
(106, 'Sensembra', 6),
(107, 'Sociedad', 6),
(108, 'Torola', 6),
(109, 'Yamabal', 6),
(110, 'Yoloaiqu?n', 6),
(111, 'La Uni?n', 7),
(112, 'San Alejo?', 7),
(113, 'Yucuaiqu?n?', 7),
(114, 'Conchagua?', 7),
(115, 'Intipuc?', 7),
(116, 'San Jos?', 7),
(117, 'El Carmen', 7),
(118, 'Yayantique?', 7),
(119, 'Bol?var', 7),
(120, 'Meanguera del Golfo', 7),
(121, 'Santa Rosa de Lima', 7),
(122, 'Santa Rosa de Lima?', 7),
(123, 'Pasaquina?', 7),
(124, 'Anamoros?', 7),
(125, 'Nueva Esparta?', 7),
(126, 'El Sauce?', 7),
(127, 'Concepci?n de Oriente', 7),
(128, 'Polor?s', 7),
(129, 'Lislique', 7),
(130, 'Antiguo Cuscatl?n', 8),
(131, 'Chiltiup?n', 8),
(132, 'Ciudad Arce', 8),
(133, 'Col?n', 8),
(134, 'Comasagua', 8),
(135, 'Huiz?car', 8),
(136, 'Jayaque', 8),
(137, 'Jicalapa', 8),
(138, 'La Libertad', 8),
(139, 'Santa Tecla', 8),
(140, 'Nuevo Cuscatl?n', 8),
(141, 'San Juan Opico', 8),
(142, 'Quezaltepeque', 8),
(143, 'Sacacoyo', 8),
(144, 'San Jos? Villanueva', 8),
(145, 'San Mat?as', 8),
(146, 'San Pablo Tacachico', 8),
(147, 'Talnique', 8),
(148, 'Tamanique', 8),
(149, 'Teotepeque', 8),
(150, 'Tepecoyo', 8),
(151, 'Zaragoza', 8),
(152, 'Agua Caliente', 9),
(153, 'Arcatao', 9),
(154, 'Azacualpa', 9),
(155, 'Cancasque', 9),
(156, 'Chalatenango', 9),
(157, 'Cital?', 9),
(158, 'Comapala', 9),
(159, 'Concepci?n Quezaltepeque', 9),
(160, 'Dulce Nombre de Mar?a', 9),
(161, 'El Carrizal', 9),
(162, 'El Para?so', 9),
(163, 'La Laguna', 9),
(164, 'La Palma', 9),
(165, 'La Reina', 9),
(166, 'Las Flores', 9),
(167, 'Las Vueltas', 9),
(168, 'Nombre de Jes?s', 9),
(169, 'Nueva Concepci?n', 9),
(170, 'Nueva Trinidad', 9),
(171, 'Ojos de Agua', 9),
(172, 'Potonico', 9),
(173, 'San Antonio de la Cruz', 9),
(174, 'San Antonio Los Ranchos', 9),
(175, 'San Fernando', 9),
(176, 'San Francisco Lempa', 9),
(177, 'San Francisco Moraz?n', 9),
(178, 'San Ignacio', 9),
(179, 'San Isidro Labrador', 9),
(180, 'San Luis del Carmen', 9),
(181, 'San Miguel de Mercedes', 9),
(182, 'San Rafael', 9),
(183, 'Santa Rita', 9),
(184, 'Tejutla', 9),
(185, 'Cojutepeque', 10),
(186, 'Candelaria', 10),
(187, 'El Carmen', 10),
(188, 'El Rosario', 10),
(189, 'Monte San Juan', 10),
(190, 'Oratorio de Concepci?n', 10),
(191, 'San Bartolom? Perulap?a', 10),
(192, 'San Crist?bal', 10),
(193, 'San Jos? Guayabal', 10),
(194, 'San Pedro Perulap?n', 10),
(195, 'San Rafael Cedros', 10),
(196, 'San Ram?n', 10),
(197, 'Santa Cruz Analquito', 10),
(198, 'Santa Cruz Michapa', 10),
(199, 'Suchitoto', 10),
(200, 'Tenancingo', 10),
(201, 'Aguilares', 11),
(202, 'Apopa', 11),
(203, 'Ayutuxtepeque', 11),
(204, 'Cuscatancingo', 11),
(205, 'Delgado', 11),
(206, 'El Paisnal', 11),
(207, 'Guazapa', 11),
(208, 'Ilopango', 11),
(209, 'Mejicanos', 11),
(210, 'Nejapa', 11),
(211, 'Panchimalco', 11),
(212, 'Rosario de Mora', 11),
(213, 'San Marcos', 11),
(214, 'San Mart?n', 11),
(215, 'San Salvador', 11),
(216, 'Santiago Texacuangos', 11),
(217, 'Santo Tom?s', 11),
(218, 'Soyapango', 11),
(219, 'Tonacatepeque', 11),
(220, 'Zacatecoluca', 12),
(221, 'Cuyultit?n', 12),
(222, 'El Rosario', 12),
(223, 'Jerusal?n', 12),
(224, 'Mercedes La Ceiba', 12),
(225, 'Olocuilta', 12),
(226, 'Para?so de Osorio', 12),
(227, 'San Antonio Masahuat', 12),
(228, 'San Emigdio', 12),
(229, 'San Francisco Chinameca', 12),
(230, 'San Pedro Masahuat', 12),
(231, 'San Juan Nonualco', 12),
(232, 'San Juan Talpa', 12),
(233, 'San Juan Tepezontes', 12),
(234, 'San Luis La Herradura', 12),
(235, 'San Luis Talpa', 12),
(236, 'San Miguel Tepezontes', 12),
(237, 'San Pedro Nonualco', 12),
(238, 'San Rafael Obrajuelo', 12),
(239, 'Santa Mar?a Ostuma', 12),
(240, 'Santiago Nonualco', 12),
(241, 'Tapalhuaca', 12),
(242, 'Cinquera', 13),
(243, 'Dolores', 13),
(244, 'Guacotecti', 13),
(245, 'Ilobasco', 13),
(246, 'Jutiapa', 13),
(247, 'San Isidro', 13),
(248, 'Sensuntepeque', 13),
(249, 'Tejutepeque', 13),
(250, 'Victoria', 13),
(251, 'Apastepeque', 14),
(252, 'Guadalupe', 14),
(253, 'San Cayetano Istepeque', 14),
(254, 'San Esteban Catarina', 14),
(255, 'San Ildefonso', 14),
(256, 'San Lorenzo', 14),
(257, 'San Sebasti?n', 14),
(258, 'San Vicente', 14),
(259, 'Santa Clara', 14),
(260, 'Santo Domingo', 14),
(261, 'Tecoluca', 14),
(262, 'Tepetit?n', 14),
(263, 'Verapaz', 14);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nivel`
--

DROP TABLE IF EXISTS `nivel`;
CREATE TABLE `nivel` (
  `id_nivel` int(11) NOT NULL,
  `Nivel` varchar(25) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `id_estante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `nivel`
--

INSERT INTO `nivel` (`id_nivel`, `Nivel`, `estatus`, `id_estante`) VALUES
(1, '1', 'A', 1),
(2, '2', 'A', 1),
(3, '3', 'A', 1),
(4, 'Nivel 3', 'A', 2),
(5, 'Nivel 1', 'A', 4),
(6, 'Nivel 4', 'A', 1),
(7, 'Nivel 1', 'A', 2),
(8, 'Nivel 2', 'A', 2),
(9, 'Nivel 3', 'A', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

DROP TABLE IF EXISTS `ordenes`;
CREATE TABLE `ordenes` (
  `id_orden` int(11) NOT NULL,
  `fecha_crea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comentario` varchar(50) NOT NULL,
  `costo_total` double(8,2) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'I',
  `id_bodega` int(11) NOT NULL,
  `id_concepto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id_orden`, `fecha_crea`, `comentario`, `costo_total`, `estatus`, `id_bodega`, `id_concepto`, `id_usuario`) VALUES
(1, '2020-03-11 01:22:42', 'Opción de escritura', 100.00, 'I', 1, 1, 1),
(2, '2020-03-12 17:19:12', 'Prueba 2', 0.00, 'I', 1, 1, 2),
(3, '2020-03-13 04:58:05', 'Comentarios', 500.00, 'I', 2, 1, 1),
(4, '2020-03-13 23:31:45', 'Comentarios 123', 1370.00, 'I', 2, 1, 2),
(5, '2020-03-13 23:46:20', 'Prueba 2', 700.00, 'I', 1, 1, 1),
(6, '2020-03-14 20:16:48', 'Prueba 5', 100.00, 'I', 1, 1, 2),
(7, '2020-03-15 03:54:57', 'Despacho 1', 330.80, 'I', 1, 4, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `foto` varchar(50) NOT NULL DEFAULT 'producto.jpg',
  `Unidad_medida` varchar(10) NOT NULL,
  `Id_proveedor` int(11) NOT NULL,
  `Cantidad_minima` int(11) NOT NULL,
  `Cantidad_maxima` int(11) NOT NULL,
  `Marca` varchar(50) NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `cto_uni` double(10,2) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `Nombre`, `foto`, `Unidad_medida`, `Id_proveedor`, `Cantidad_minima`, `Cantidad_maxima`, `Marca`, `estatus`, `cto_uni`, `id_categoria`) VALUES
(1, 'martillo ', 'martillo.jpg', 'uni', 1, 5, 20, 'truper', 'A', 3.98, 1),
(2, 'serrucho', 'serrucho.jpg', 'uni', 2, 5, 20, 'trump', 'A', 0.00, 1),
(3, 'baterias', 'batarias.jpg', 'uni', 2, 20, 300, 'gold', 'A', 0.00, 1),
(4, 'Esmeril', 'esmaril.jpg', 'uni', 1, 30, 200, 'Trump', 'A', 3.84, 1),
(5, 'Piocha', 'piocha.jpg', 'uni', 2, 5, 200, 'truper', 'A', 9.97, 2),
(7, 'ladrillos', 'producto.jpg', 'uni', 1, 2000, 10, 'varios', 'A', 0.00, 2),
(8, 'Clavos', 'producto.jpg', 'libras', 2, 2000, 20, 'varios', 'A', 0.00, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

DROP TABLE IF EXISTS `proveedores`;
CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `Nombre` varchar(25) NOT NULL,
  `Correo` varchar(30) NOT NULL,
  `Direccion` varchar(50) NOT NULL,
  `id_municipio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `Nombre`, `Correo`, `Direccion`, `id_municipio`) VALUES
(1, 'freum, s.a. de c.v.', 'contacto@freum.com.sv', 'Av. la capilla', 1),
(2, 'vidri, s.a. de c.v.', 'informacion@vidri.com.sv', '1 calle poniente', 1),
(3, 'Carlos Alonso', 'calonso@gmail.com', '1o. Calle pte', 1),
(5, 'Carlos Tovar', 'ctovar@gmail.com', 's.s', 263),
(6, 'Arturo Mejia', 'amejia@gmail.com', 's.s.', 201),
(7, 'Diego Maradona', 'dmaradona@gmail.com', 'S.S.', 215);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `rol` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `rol`) VALUES
(1, 'admin'),
(2, 'usuario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `telefonos`
--

DROP TABLE IF EXISTS `telefonos`;
CREATE TABLE `telefonos` (
  `id_telefono` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Telefono` int(11) NOT NULL,
  `Id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_conceptos`
--

DROP TABLE IF EXISTS `tipo_conceptos`;
CREATE TABLE `tipo_conceptos` (
  `id_tipo_concepto` int(11) NOT NULL,
  `tipo_concepto` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_conceptos`
--

INSERT INTO `tipo_conceptos` (`id_tipo_concepto`, `tipo_concepto`) VALUES
(1, 'Entrada'),
(2, 'Salida');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuario` int(11) NOT NULL,
  `nombre` varchar(25) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `contrasenia` varchar(100) NOT NULL,
  `foto` varchar(50) NOT NULL DEFAULT 'user.png',
  `estatus` char(1) NOT NULL DEFAULT 'A',
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombre`, `usuario`, `contrasenia`, `foto`, `estatus`, `idRol`) VALUES
(1, 'wilfredo vasquez ', 'wvp', '202cb962ac59075b964b07152d234b70', 'picture.jpg', 'A', 1),
(2, 'daniel escamilla', 'de', '202cb962ac59075b964b07152d234b70', 'user.png', 'A', 2),
(26, 'Carlos', 'cv', 'c4ca4238a0b923820dcc509a6f75849b', 'user.png', 'A', 1),
(42, 'Karla Navas', 'kn', 'd41d8cd98f00b204e9800998ecf8427e', 'picture.jpg', 'I', 2),
(45, 'Jorge Romero', 'jr', 'c4ca4238a0b923820dcc509a6f75849b', 'picture.jpg', 'A', 1),
(48, 'Carlos Campos', 'cc', '202cb962ac59075b964b07152d234b70', 'picture.jpg', 'A', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_bodegastatus_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_bodegastatus_wvp`;
CREATE TABLE `vw_bodegastatus_wvp` (
`id_bodega` int(11)
,`Nombre` varchar(50)
,`estatus` char(1)
,`cant_estantes` bigint(21)
,`municipio` varchar(50)
,`departamento` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_bodega_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_bodega_wvp`;
CREATE TABLE `vw_bodega_wvp` (
`id_bodega` int(11)
,`Nombre` varchar(50)
,`estatus` varchar(10)
,`cant_estantes` bigint(21)
,`municipio` varchar(50)
,`departamento` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_categoria_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_categoria_wvp`;
CREATE TABLE `vw_categoria_wvp` (
`id_categoria` int(11)
,`nombre` varchar(50)
,`estatus` char(1)
,`descripcion` varchar(200)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_concepto_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_concepto_wvp`;
CREATE TABLE `vw_concepto_wvp` (
`concepto` varchar(50)
,`tipo_concepto` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_departamentos_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_departamentos_wvp`;
CREATE TABLE `vw_departamentos_wvp` (
`id_departamento` int(11)
,`departamento` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_estantegral_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_estantegral_wvp`;
CREATE TABLE `vw_estantegral_wvp` (
`id_estante` int(11)
,`Nombre` varchar(25)
,`estatus` char(1)
,`id_bodega` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_estantesproc_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_estantesproc_wvp`;
CREATE TABLE `vw_estantesproc_wvp` (
`bodega` varchar(50)
,`estante` varchar(25)
,`num_niveles` bigint(21)
,`SUM(i.Cantidad_existencia)` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_estantes_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_estantes_wvp`;
CREATE TABLE `vw_estantes_wvp` (
`ID` int(11)
,`bodega` varchar(50)
,`estante` varchar(25)
,`estatus` varchar(10)
,`num_niveles` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_inventario_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_inventario_wvp`;
CREATE TABLE `vw_inventario_wvp` (
`id_producto` int(11)
,`producto` varchar(50)
,`Marca` varchar(50)
,`Unidad_medida` varchar(10)
,`foto` varchar(50)
,`Cantidad_minima` int(11)
,`Cantidad_maxima` int(11)
,`estatus` char(1)
,`nom_provee` varchar(25)
,`id_bodega` int(11)
,`id_estante` int(11)
,`id_nivel` int(11)
,`bodega` varchar(50)
,`estante` varchar(25)
,`nivel` varchar(25)
,`Cantidad_existencia` decimal(10,2)
,`Costo_total` decimal(10,2)
,`costo_unitario` double
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_movimientos_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_movimientos_wvp`;
CREATE TABLE `vw_movimientos_wvp` (
`id_movimiento` int(11)
,`fecha` timestamp
,`id_orden` int(11)
,`productos` varchar(50)
,`estante` varchar(25)
,`Nivel` varchar(25)
,`Cantidad_entrada` double(10,2)
,`cto_uni_entrada` double
,`Costo_entrada` double(10,2)
,`cto_uni_salida` double
,`Cantidad_salida` double(10,2)
,`Costo_salida` double(10,2)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_municipios`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_municipios`;
CREATE TABLE `vw_municipios` (
`id_municipio` int(11)
,`id_departamento` int(11)
,`municipio` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_nivel_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_nivel_wvp`;
CREATE TABLE `vw_nivel_wvp` (
`id_nivel` int(11)
,`Nivel` varchar(25)
,`estatus` char(1)
,`bodega` varchar(50)
,`estante` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_productos_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_productos_wvp`;
CREATE TABLE `vw_productos_wvp` (
`id_producto` int(11)
,`Nombre` varchar(50)
,`foto` varchar(50)
,`Unidad_medida` varchar(10)
,`proveedor` varchar(25)
,`Cantidad_minima` int(11)
,`Cantidad_maxima` int(11)
,`Marca` varchar(50)
,`estatus` varchar(10)
,`cto_uni` double(10,2)
,`categoria` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_proveedor_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_proveedor_wvp`;
CREATE TABLE `vw_proveedor_wvp` (
`ID` int(11)
,`Nombre` varchar(25)
,`direccion` varchar(50)
,`correo` varchar(30)
,`municipio` varchar(50)
,`departamento` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_roles_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_roles_wvp`;
CREATE TABLE `vw_roles_wvp` (
`idRol` int(11)
,`rol` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_tipoconcepto_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_tipoconcepto_wvp`;
CREATE TABLE `vw_tipoconcepto_wvp` (
`id_tipo_concepto` int(11)
,`tipo_concepto` varchar(10)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_usuarioslista_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_usuarioslista_wvp`;
CREATE TABLE `vw_usuarioslista_wvp` (
`imagen` varchar(50)
,`ID` int(11)
,`usr` varchar(100)
,`nombre` varchar(25)
,`estatus` varchar(10)
,`idrol` int(11)
,`rol` varchar(25)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vw_usuarios_wvp`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `vw_usuarios_wvp`;
CREATE TABLE `vw_usuarios_wvp` (
`idUsuario` int(11)
,`nombre` varchar(25)
,`usuario` varchar(100)
,`contrasenia` varchar(100)
,`foto` varchar(50)
,`estatus` char(1)
,`idRol` int(11)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `wv_telefono_de`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `wv_telefono_de`;
CREATE TABLE `wv_telefono_de` (
`lugar` varchar(50)
,`numero` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_bodegastatus_wvp`
--
DROP TABLE IF EXISTS `vw_bodegastatus_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_bodegastatus_wvp`  AS  select `b`.`id_bodega` AS `id_bodega`,`b`.`Nombre` AS `Nombre`,`b`.`estatus` AS `estatus`,count(`e`.`id_bodega`) AS `cant_estantes`,`m`.`municipio` AS `municipio`,`d`.`departamento` AS `departamento` from (((`bodega` `b` left join `municipios` `m` on((`m`.`id_municipio` = `b`.`id_municipio`))) left join `departamentos` `d` on((`d`.`id_departamento` = `m`.`id_departamento`))) left join `estante` `e` on((`e`.`id_bodega` = `b`.`id_bodega`))) group by `b`.`id_bodega` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_bodega_wvp`
--
DROP TABLE IF EXISTS `vw_bodega_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_bodega_wvp`  AS  select `b`.`id_bodega` AS `id_bodega`,`b`.`Nombre` AS `Nombre`,`fn_status_wvp`(`b`.`estatus`) AS `estatus`,count(`e`.`id_bodega`) AS `cant_estantes`,`m`.`municipio` AS `municipio`,`d`.`departamento` AS `departamento` from (((`bodega` `b` join `municipios` `m` on((`m`.`id_municipio` = `b`.`id_municipio`))) join `departamentos` `d` on((`d`.`id_departamento` = `m`.`id_departamento`))) join `estante` `e` on((`e`.`id_bodega` = `b`.`id_bodega`))) group by `b`.`id_bodega` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_categoria_wvp`
--
DROP TABLE IF EXISTS `vw_categoria_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_categoria_wvp`  AS  select `categoria`.`id_categoria` AS `id_categoria`,`categoria`.`nombre` AS `nombre`,`categoria`.`estatus` AS `estatus`,`categoria`.`descripcion` AS `descripcion` from `categoria` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_concepto_wvp`
--
DROP TABLE IF EXISTS `vw_concepto_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_concepto_wvp`  AS  select `c`.`concepto` AS `concepto`,`t`.`tipo_concepto` AS `tipo_concepto` from (`concepto` `c` join `tipo_conceptos` `t` on((`t`.`id_tipo_concepto` = `c`.`id_tipo_concepto`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_departamentos_wvp`
--
DROP TABLE IF EXISTS `vw_departamentos_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_departamentos_wvp`  AS  select `departamentos`.`id_departamento` AS `id_departamento`,`departamentos`.`departamento` AS `departamento` from `departamentos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_estantegral_wvp`
--
DROP TABLE IF EXISTS `vw_estantegral_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_estantegral_wvp`  AS  select `estante`.`id_estante` AS `id_estante`,`estante`.`Nombre` AS `Nombre`,`estante`.`estatus` AS `estatus`,`estante`.`id_bodega` AS `id_bodega` from `estante` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_estantesproc_wvp`
--
DROP TABLE IF EXISTS `vw_estantesproc_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_estantesproc_wvp`  AS  select `b`.`Nombre` AS `bodega`,`e`.`Nombre` AS `estante`,count(`n`.`id_nivel`) AS `num_niveles`,sum(`i`.`Cantidad_existencia`) AS `SUM(i.Cantidad_existencia)` from (((`estante` `e` join `bodega` `b` on((`e`.`id_bodega` = `b`.`id_bodega`))) join `nivel` `n` on((`n`.`id_estante` = `e`.`id_estante`))) join `inventario` `i` on((`i`.`id_nivel` = `n`.`id_nivel`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_estantes_wvp`
--
DROP TABLE IF EXISTS `vw_estantes_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_estantes_wvp`  AS  select `b`.`id_bodega` AS `ID`,`b`.`Nombre` AS `bodega`,`e`.`Nombre` AS `estante`,`fn_status_wvp`(`e`.`estatus`) AS `estatus`,count(`n`.`id_nivel`) AS `num_niveles` from ((`estante` `e` left join `bodega` `b` on((`e`.`id_bodega` = `b`.`id_bodega`))) left join `nivel` `n` on((`n`.`id_estante` = `e`.`id_estante`))) group by `n`.`id_estante` order by `b`.`Nombre`,`e`.`Nombre` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_inventario_wvp`
--
DROP TABLE IF EXISTS `vw_inventario_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_inventario_wvp`  AS  select `p`.`id_producto` AS `id_producto`,`p`.`Nombre` AS `producto`,`p`.`Marca` AS `Marca`,`p`.`Unidad_medida` AS `Unidad_medida`,`p`.`foto` AS `foto`,`p`.`Cantidad_minima` AS `Cantidad_minima`,`p`.`Cantidad_maxima` AS `Cantidad_maxima`,`p`.`estatus` AS `estatus`,`pr`.`Nombre` AS `nom_provee`,`b`.`id_bodega` AS `id_bodega`,`e`.`id_estante` AS `id_estante`,`i`.`id_nivel` AS `id_nivel`,`b`.`Nombre` AS `bodega`,`e`.`Nombre` AS `estante`,`n`.`Nivel` AS `nivel`,`i`.`Cantidad_existencia` AS `Cantidad_existencia`,`i`.`Costo_total` AS `Costo_total`,`fn_costoUnitario_wvp`(`i`.`Costo_total`,`i`.`Cantidad_existencia`) AS `costo_unitario` from (((((`inventario` `i` join `nivel` `n` on((`n`.`id_nivel` = `i`.`id_nivel`))) join `estante` `e` on((`e`.`id_estante` = `n`.`id_estante`))) join `productos` `p` on((`p`.`id_producto` = `i`.`id_producto`))) join `proveedores` `pr` on((`pr`.`id_proveedor` = `p`.`Id_proveedor`))) join `bodega` `b` on((`b`.`id_bodega` = `e`.`id_bodega`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_movimientos_wvp`
--
DROP TABLE IF EXISTS `vw_movimientos_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_movimientos_wvp`  AS  select `m`.`id_movimiento` AS `id_movimiento`,`o`.`fecha_crea` AS `fecha`,`o`.`id_orden` AS `id_orden`,`p`.`Nombre` AS `productos`,`e`.`Nombre` AS `estante`,`n`.`Nivel` AS `Nivel`,`m`.`Cantidad_entrada` AS `Cantidad_entrada`,`fn_costoUnitario_wvp`(`m`.`Costo_entrada`,`m`.`Cantidad_entrada`) AS `cto_uni_entrada`,`m`.`Costo_entrada` AS `Costo_entrada`,`fn_costoUnitario_wvp`(`m`.`Costo_salida`,`m`.`Cantidad_salida`) AS `cto_uni_salida`,`m`.`Cantidad_salida` AS `Cantidad_salida`,`m`.`Costo_salida` AS `Costo_salida` from ((((`movimientos` `m` join `productos` `p` on((`p`.`id_producto` = `m`.`id_producto`))) join `nivel` `n` on((`n`.`id_nivel` = `m`.`id_nivel`))) join `estante` `e` on((`e`.`id_estante` = `n`.`id_estante`))) join `ordenes` `o` on((`o`.`id_orden` = `m`.`id_orden`))) order by `o`.`id_orden` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_municipios`
--
DROP TABLE IF EXISTS `vw_municipios`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_municipios`  AS  select `municipios`.`id_municipio` AS `id_municipio`,`municipios`.`id_departamento` AS `id_departamento`,`municipios`.`municipio` AS `municipio` from `municipios` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_nivel_wvp`
--
DROP TABLE IF EXISTS `vw_nivel_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_nivel_wvp`  AS  select `n`.`id_nivel` AS `id_nivel`,`n`.`Nivel` AS `Nivel`,`n`.`estatus` AS `estatus`,`b`.`Nombre` AS `bodega`,`e`.`Nombre` AS `estante` from ((`nivel` `n` join `estante` `e` on((`e`.`id_estante` = `n`.`id_estante`))) join `bodega` `b` on((`b`.`id_bodega` = `e`.`id_bodega`))) order by `b`.`Nombre`,`e`.`Nombre`,`n`.`Nivel` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_productos_wvp`
--
DROP TABLE IF EXISTS `vw_productos_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_productos_wvp`  AS  select `productos`.`id_producto` AS `id_producto`,`productos`.`Nombre` AS `Nombre`,`productos`.`foto` AS `foto`,`productos`.`Unidad_medida` AS `Unidad_medida`,`pr`.`Nombre` AS `proveedor`,`productos`.`Cantidad_minima` AS `Cantidad_minima`,`productos`.`Cantidad_maxima` AS `Cantidad_maxima`,`productos`.`Marca` AS `Marca`,`fn_status_wvp`(`productos`.`estatus`) AS `estatus`,`productos`.`cto_uni` AS `cto_uni`,`c`.`nombre` AS `categoria` from ((`productos` join `categoria` `c` on((`c`.`id_categoria` = `productos`.`id_categoria`))) join `proveedores` `pr` on((`pr`.`id_proveedor` = `productos`.`Id_proveedor`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_proveedor_wvp`
--
DROP TABLE IF EXISTS `vw_proveedor_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_proveedor_wvp`  AS  select `p`.`id_proveedor` AS `ID`,`p`.`Nombre` AS `Nombre`,`p`.`Direccion` AS `direccion`,`p`.`Correo` AS `correo`,`m`.`municipio` AS `municipio`,`d`.`departamento` AS `departamento` from ((`proveedores` `p` join `municipios` `m` on((`m`.`id_municipio` = `p`.`id_municipio`))) join `departamentos` `d` on((`d`.`id_departamento` = `m`.`id_departamento`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_roles_wvp`
--
DROP TABLE IF EXISTS `vw_roles_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_roles_wvp`  AS  select `roles`.`idRol` AS `idRol`,`roles`.`rol` AS `rol` from `roles` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_tipoconcepto_wvp`
--
DROP TABLE IF EXISTS `vw_tipoconcepto_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_tipoconcepto_wvp`  AS  select `tipo_conceptos`.`id_tipo_concepto` AS `id_tipo_concepto`,`tipo_conceptos`.`tipo_concepto` AS `tipo_concepto` from `tipo_conceptos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_usuarioslista_wvp`
--
DROP TABLE IF EXISTS `vw_usuarioslista_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuarioslista_wvp`  AS  select `u`.`foto` AS `imagen`,`u`.`idUsuario` AS `ID`,`u`.`usuario` AS `usr`,`u`.`nombre` AS `nombre`,`fn_status_wvp`(`u`.`estatus`) AS `estatus`,`r`.`idRol` AS `idrol`,`r`.`rol` AS `rol` from (`usuarios` `u` join `roles` `r` on((`u`.`idRol` = `r`.`idRol`))) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vw_usuarios_wvp`
--
DROP TABLE IF EXISTS `vw_usuarios_wvp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_usuarios_wvp`  AS  select `usuarios`.`idUsuario` AS `idUsuario`,`usuarios`.`nombre` AS `nombre`,`usuarios`.`usuario` AS `usuario`,`usuarios`.`contrasenia` AS `contrasenia`,`usuarios`.`foto` AS `foto`,`usuarios`.`estatus` AS `estatus`,`usuarios`.`idRol` AS `idRol` from `usuarios` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `wv_telefono_de`
--
DROP TABLE IF EXISTS `wv_telefono_de`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `wv_telefono_de`  AS  select `telefonos`.`Nombre` AS `lugar`,`telefonos`.`Telefono` AS `numero` from `telefonos` ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD PRIMARY KEY (`id_bodega`),
  ADD KEY `id_municipio` (`id_municipio`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD PRIMARY KEY (`id_concepto`),
  ADD KEY `id_tipo_concepto` (`id_tipo_concepto`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id_departamento`);

--
-- Indices de la tabla `estante`
--
ALTER TABLE `estante`
  ADD PRIMARY KEY (`id_estante`),
  ADD KEY `id_bodega` (`id_bodega`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_nivel` (`id_nivel`);

--
-- Indices de la tabla `inventario_borrado`
--
ALTER TABLE `inventario_borrado`
  ADD PRIMARY KEY (`id_invBorrado`);

--
-- Indices de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD PRIMARY KEY (`id_movimiento`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_nivel` (`id_nivel`),
  ADD KEY `id_orden` (`id_orden`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id_municipio`),
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD PRIMARY KEY (`id_nivel`),
  ADD KEY `id_estante` (`id_estante`);

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id_orden`),
  ADD KEY `id_bodega` (`id_bodega`),
  ADD KEY `id_concepto` (`id_concepto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `Id_proveedor` (`Id_proveedor`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_categoria_2` (`id_categoria`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`,`Nombre`),
  ADD KEY `id_municipio` (`id_municipio`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id_telefono`),
  ADD KEY `id_proveedor` (`Id_proveedor`);

--
-- Indices de la tabla `tipo_conceptos`
--
ALTER TABLE `tipo_conceptos`
  ADD PRIMARY KEY (`id_tipo_concepto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `id_rol` (`idRol`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `bodega`
--
ALTER TABLE `bodega`
  MODIFY `id_bodega` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `concepto`
--
ALTER TABLE `concepto`
  MODIFY `id_concepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id_departamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `estante`
--
ALTER TABLE `estante`
  MODIFY `id_estante` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `inventario_borrado`
--
ALTER TABLE `inventario_borrado`
  MODIFY `id_invBorrado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `movimientos`
--
ALTER TABLE `movimientos`
  MODIFY `id_movimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id_municipio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=264;

--
-- AUTO_INCREMENT de la tabla `nivel`
--
ALTER TABLE `nivel`
  MODIFY `id_nivel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id_orden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id_telefono` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_conceptos`
--
ALTER TABLE `tipo_conceptos`
  MODIFY `id_tipo_concepto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `bodega`
--
ALTER TABLE `bodega`
  ADD CONSTRAINT `bodega_ibfk_2` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`);

--
-- Filtros para la tabla `concepto`
--
ALTER TABLE `concepto`
  ADD CONSTRAINT `concepto_ibfk_1` FOREIGN KEY (`id_tipo_concepto`) REFERENCES `tipo_conceptos` (`id_tipo_concepto`);

--
-- Filtros para la tabla `estante`
--
ALTER TABLE `estante`
  ADD CONSTRAINT `estante_ibfk_1` FOREIGN KEY (`id_bodega`) REFERENCES `bodega` (`id_bodega`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `inventario_ibfk_4` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`);

--
-- Filtros para la tabla `movimientos`
--
ALTER TABLE `movimientos`
  ADD CONSTRAINT `movimientos_ibfk_2` FOREIGN KEY (`id_nivel`) REFERENCES `nivel` (`id_nivel`),
  ADD CONSTRAINT `movimientos_ibfk_4` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `movimientos_ibfk_5` FOREIGN KEY (`id_orden`) REFERENCES `ordenes` (`id_orden`);

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departamento`);

--
-- Filtros para la tabla `nivel`
--
ALTER TABLE `nivel`
  ADD CONSTRAINT `nivel_ibfk_1` FOREIGN KEY (`id_estante`) REFERENCES `estante` (`id_estante`);

--
-- Filtros para la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD CONSTRAINT `ordenes_ibfk_1` FOREIGN KEY (`id_concepto`) REFERENCES `concepto` (`id_concepto`),
  ADD CONSTRAINT `ordenes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`Id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_2` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`);

--
-- Filtros para la tabla `telefonos`
--
ALTER TABLE `telefonos`
  ADD CONSTRAINT `telefonos_ibfk_1` FOREIGN KEY (`Id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
