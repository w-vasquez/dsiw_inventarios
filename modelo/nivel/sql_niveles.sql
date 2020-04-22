SELECT
	n.id_nivel,
    n.Nivel,
    n.estatus,
    b.Nombre AS bodega,
    e.Nombre AS estante
FROM Nivel n JOIN
 estante e ON e.id_estante = n.id_estante JOIN
 bodega b ON b.id_bodega = e.id_bodega
ORDER BY b.Nombre, e.Nombre, n.Nivel ASC