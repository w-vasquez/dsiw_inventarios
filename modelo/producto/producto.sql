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
END