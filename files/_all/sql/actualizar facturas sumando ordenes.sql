UPDATE tabla1 T1,
      ( SELECT descripcion, SUM(parcial) total
 FROM tabla2
  GROUP BY descripcion ) T2
   SET T1.total = T2.total
    WHERE T1.descripcion = T2.descripcion;
