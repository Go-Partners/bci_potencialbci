<?php
function UsuaData2021_mini($rut){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    /*$sql=" 	select h.d153 as rx from tbl_data_bci_2021 h where rut='$rut'";*/
    $sql=" 	select h.d5, h.d6, h.d16  from tbl_data_bci_2021 h where rut='$rut'";
    //echo $sql;
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function Sucesion_CheckUserLiderPosiciones_data($rut){
    $connexion = new DatabasePDO();

    $sql1=" select h.id from tbl_potencial_sucesion_comites_colaboradores_2024 h where h.rut='$rut' and h.id_empresa='62' limit 1 ";
    $connexion->query($sql1);
    $cod1 = $connexion->resultset();

    $sql2=" select h.id from tbl_potencial_comites_sucesion_2024 h where h.rut_lider='$rut' and h.id_empresa='62' limit 1; ";
    $connexion->query($sql2);
    $cod2 = $connexion->resultset();
    $acceso=0;
    if($cod1[0]->id>0){
        $acceso=1;
    } else {
        if($cod2[0]->id>0){
            $acceso=1;
        }
    }

    return $acceso;
}
function SucesionBitacora_2024($rut, $id_comite){
    $connexion = new DatabasePDO();    
    $sql=" select * from tbl_potencial_bitacora_sucesion_2024 where rut_colaborador='$rut' and id_comite='$id_comite' ";
    //echo "<br>".$sql;
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;    
}
function Sucesion_Colaborador_data_2024($rut)
{
    $connexion = new DatabasePDO();
    $sql = "select rut, d5 as cargo, d6 as posicion, d16 as r, d12 as jefe  from tbl_data_bci_2021 where rut='$rut'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Sucesion_Check_Comparte_Jefe_data_2024($rut, $jefe)
{
    $connexion = new DatabasePDO();
    $sql = "select rut 
            from tbl_data_bci_2021 where d12='$jefe' and rut='$rut'";
            //echo $sql;
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->rut;
}
function Suc_buscaNombreDadoComitePosition($id_comite, $posicion){
    $connexion = new DatabasePDO();

    $sql=" select h.rut,
h.nombre_completo, j.d5 as colaborador_cargo, j.d6 as colaborador_posicion,
j.d16 as nivelR
from tbl_potencial_sucesion_comites_colaboradores_2024 h
left join tbl_data_bci_2021 j on h.rut=j.rut
where h.id_comite='$id_comite' and h.posicion='$posicion' ";
        //echo $sql;exit();
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Sucesion_Num_Sucesores_2024($rut){
    $connexion = new DatabasePDO();


    $sql=" 	select count(id) as cuenta from tbl_potencial_sucesion_colaboradores_propuestos_2024 where rut_col='$rut' and estado='Es Sucesor' ";
    //echo $sql;
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}
function Potencial_Del_tbl_potencial_sucesion_colaboradores_propuestos_r2_2024($del, $perfil){

    $connexion = new DatabasePDO();


    $fecha = date("Y-m-d");

    if($perfil=="SOCIO DE NEGOCIO"){
        $rut_lider="";
    } else {
        $rut_lider=$_SESSION["user_"];
    }

    $sql = "
    update 
    tbl_potencial_sucesion_colaboradores_propuestos_2024 
    set estado='No es sucesor', rutlider='".$rut_lider."', fechalider='$fecha'
    where id='$del'";
    //echo $sql;  exit();
    $connexion->query($sql);
    $connexion->execute();
    $datos = $connexion->resultset();
    return $datos;


}
function Potencial_trae_rut_col_fromId_Sucesion_2024($id_sucesor){
    $connexion = new DatabasePDO();
    $sql   = "select rut_col from tbl_potencial_sucesion_colaboradores_propuestos_2024 where id='$id_sucesor' ";
    //echo $sql; exit();
    $connexion->query($sql);
    $cod = $connexion->resultset();


    return $cod[0]->rut_col;


}
function Potencial_Actualiza_tbl_potencial_sucesion_colaboradores_propuestos_r2_2024($id_sucesor, $tipo_sucesion_ficha){

    $connexion = new DatabasePDO();


    $hoy   = date('Y-m-d');
    $sql="update tbl_potencial_sucesion_colaboradores_propuestos_2024 set tipo_sucesion='$tipo_sucesion_ficha' where id='$id_sucesor' ";
    //echo $sql;exit;
    $connexion->query($sql);
    $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;

}
function Sucesion_EstadoComite_Cuenta_colaboradores_propuestos($id_comite){
    $connexion = new DatabasePDO();
    $sql=" 	select count(id) as cuenta 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_2024  
	      				where id_comite='$id_comite' and id_empresa='62'";

    //echo $sql;

    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod[0]->cuenta);
}
function Potencial_Busca_Colaboradores_Comite_2024($id_comite, $id_empresa){
    $connexion = new DatabasePDO();
    $sql   = "select h.*, b.d16, b.d5, b.d6 from tbl_potencial_sucesion_comites_colaboradores_2024 h 
           
           left join tbl_data_bci_2021 b on h.rut=b.rut
           
           where h.id_empresa='$id_empresa' and id_comite='$id_comite' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Insert_Col_Sucesion_CheckSave_2024($id_comite,$rut_col,$tipo,$posicion,$id_empresa, $fundamento){

    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    if($rut_col>0){
        $sql   = "insert ignore into tbl_potencial_sucesion_colaboradores_propuestos_2024 
		    		    (id_comite,rut_col,fecha,hora,tipo_sucesion,posicion,estado,id_empresa, rutlider, fechalider, fundamento)
        VALUES
        ('$id_comite','$rut_col', '$fecha', '$hora','$tipo', '$posicion','Es Sucesor','$id_empresa','".$_SESSION["user_"]."','$fecha', '$fundamento');";
        $connexion->query($sql);
        $connexion->execute();
    }
    //echo $sql; exit();
}
function Potencial_Insert_Col_Bitacora_Sucesion_CheckSave_2024($id_comite,$rut_col,$fundamento,$accion,$id_empresa){
    $connexion = new DatabasePDO();


    $fundamento=($fundamento);
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");

    $sql   = "insert ignore into tbl_potencial_bitacora_sucesion_2024 
		    
		    (rut,id_comite,rut_colaborador,comentario,accion,fecha,hora,id_empresa)
        VALUES
        ('".$_SESSION["user_"]."',  '$id_comite','$rut_col','$fundamento','$accion', '$fecha', '$hora','$id_empresa');";

    $connexion->query($sql);
    $connexion->execute();


}
function Sucesion_Dueno_O_Posicion_2024($id_comite, $rut){

    $connexion = new DatabasePDO();
    $owner_comite="";
    $sql="select id from tbl_potencial_comites_sucesion_2024 where  id_comite='$id_comite' and (rut='$rut' or gerenciaR1='$rut')";

    //echo "<br>onwer 1 $sql";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    if($cod[0]->id>0){
        $owner_comite="owner";
    } else {
        $sql="select id from tbl_potencial_sucesion_comites_colaboradores_2024 where id_comite='$id_comite' and rut='$rut'";
        //echo "<br>onwer 2 $sql";
        $connexion->query($sql);
        $cod = $connexion->resultset();
        if($cod[0]->id>0){
            $owner_comite="posicion";
        }

    }
    return ($owner_comite);
}
function PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, $rut, $id_empresa, $tipo, $posicion){
    $connexion = new DatabasePDO();
    $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_2024  
	      				where posicion='$posicion' and id_comite='$id_comite' and id_empresa='$id_empresa' and tipo_sucesion='$tipo'";
    $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_2024  
	      				where posicion='$posicion' and id_comite='$id_comite' 
	      				  and id_empresa='$id_empresa' and tipo_sucesion='$tipo'
	      				  and estado='Es Sucesor'";
       // echo "<br><br>".$sql."<br><br>";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function PotencialSucesion_Vista_Colaboradores_Tarea_Posicion_2024($id_comite, $rut, $id_empresa, $tipo, $posicion){
    $connexion = new DatabasePDO();
    $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_2024  
	      				where posicion='$posicion' and id_comite='$id_comite' and id_empresa='$id_empresa' and tipo_sucesion='$tipo'";
    $sql=" 	select count(id) as cuenta
	      				from tbl_potencial_sucesion_colaboradores_propuestos_2024  
	      				where posicion='$posicion' and id_comite='$id_comite' 
	      				  and id_empresa='62' and tipo_sucesion='$tipo'
	      				  and estado='Es Sucesor'";
     //echo "<br><br>".$sql."<br><br>";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod[0]->cuenta);
}
function Potencial_Sucesion_Colaboradores_Comites_2024_data($id_comite, $rut, $perfil, $id_empresa){

    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $query="";
    //echo "<br>perfil $perfil";
    if($perfil=="SOCIO DE NEGOCIO" OR $perfil=="SUPER USER")    {

        //echo "A";
    $sql   = "

                SELECT
                    h.* ,
                    n.nombre_completo,
                    n.posicion,
                    c.d5 as cargo,c.d6 as posicion,
                    c.d16 as r
                FROM
                    tbl_potencial_comites_sucesion_2024 h 
                    left join tbl_potencial_sucesion_comites_colaboradores_2024 n on h.id_comite=n.id_comite
                    left join tbl_data_bci_2021 c on c.rut=n.rut
                WHERE
                    h.id_comite = '$id_comite';
                
      ";
    } else {
        //echo "B";

        $owner=Sucesion_Dueno_O_Posicion_2024($id_comite, $rut);
        if($owner<>""){
            $sql   = "

                SELECT
                    h.* ,
                    n.nombre_completo,
                    n.posicion,
                    c.d5 as cargo,c.d6 as posicion,
                    c.d16 as r
                FROM
                    tbl_potencial_comites_sucesion_2024 h 
                    left join tbl_potencial_sucesion_comites_colaboradores_2024 n on h.id_comite=n.id_comite
                    left join tbl_data_bci_2021 c on c.rut=n.rut
                WHERE
                    h.id_comite = '$id_comite';
                
                     ";

            if($owner=="posicion"){

                $sql   = "

                        SELECT
                            h.*,
                            n.nombre_completo,
                            n.posicion ,
                            c.d5 as cargo,c.d6 as posicion,
                            c.d16 as r
                        FROM
                            tbl_potencial_comites_sucesion_2024 h
                            LEFT JOIN tbl_potencial_sucesion_comites_colaboradores_2024 n ON h.id_comite = n.id_comite
                            left join tbl_data_bci_2021 c on c.rut=n.rut
                        WHERE
                            h.id_comite = '$id_comite'
                            and n.rut='$rut';
                              ";
            }
        } else {
            exit("No tienes privilegios para esta vista");
        }
    }
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_Sucesion_Comites_2024_data($id_comite,$id_empresa){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql   = "
        select h.*,l.d11,l.d5 as cargo_lider,l.d6 as posicion_lider,l.d16 as r_lider,
         (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo
         from tbl_potencial_comites_sucesion_2024 h
         LEFT JOIN tbl_data_bci_2021 l on h.gerenciaR1=l.rut
         where h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
         order by (select nombre_completo    from tbl_usuario   where rut=h.rut) ASC
     ";
    //echo "sql $sql"; exit();
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function Potencial_Mis_Comites_insert_Nuevo_Comite_Sucesion_data_2024($nombre, $rut_g1, $rut, $fecha_comite, $id_empresa, $id_comite_edit)
{
    //echo "<br>Vars $nombre, $rut_g1, $rut, $fecha_comite, $id_empresa, $id_comite_edit";
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $nombre =   ($nombre);
    $sql   = " select max(id) as id_max from tbl_potencial_comites_sucesion_2024 order by id DESC limit 1 ";
    $connexion->query($sql);

    $cod        =   $connexion->resultset();
    $id_antiguo =   $cod[0]->id_max;
    $id_nuevo   =   $id_antiguo+1;
    $id_comite  =   "pot_suc_".$id_nuevo;
    $id_empresa =   $_SESSION["id_empresa"];
    $UsuaLider      =   DatosUsuario_($rut_g1, $id_empresa);
    $nombre_lider   =   $UsuaLider[0]->nombre_completo;
    $UsuaCreador    =   DatosUsuario_($rut, $id_empresa);
    $nombre_creador =   $UsuaCreador[0]->nombre_completo;

    if($id_comite_edit<>""){
        $sql   = "UPDATE tbl_potencial_comites_sucesion_2024  SET nombre='$nombre', fecha_comite='$fecha_comite' where id_comite='$id_comite_edit'";
    } else {
        $sql   = "insert ignore into tbl_potencial_comites_sucesion_2024
        (nombre, descripcion, gerenciaR1, rut, fecha_comite, fecha, hora, id_empresa, id_comite, rut_lider, nombre_lider, nombre_creador)
        VALUES
        ('$nombre','$descripcion', '$rut_g1', '$rut','$fecha_comite','$fecha','$hora', '$id_empresa',
         '$id_comite','$rut_g1','$nombre_lider','$nombre_creador');";
    }


    $connexion->query($sql);
    $connexion->execute();
   // echo "<br>".$sql."<br>";    exit("327");

    return $id_comite;
}
function Potencial_Sucesion_Mi_Sucesion_data_2024($id_empresa, $rut, $perfil){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

        $sql=" SELECT 
    h.*, 
    d1_table_rut.d1 AS rut_completo,
    d1_table_gerenciaR1.d1 AS rut_completo_r1,
    dep_table.rut AS rut_dependiente,
    COUNT(dep_table_count.rut) AS dep,
    jefe_table.d12 AS jefe_creador
FROM 
    tbl_potencial_comites_sucesion_2024 h
LEFT JOIN 
    tbl_data_bci_2021 d1_table_rut ON d1_table_rut.rut = '$rut'
LEFT JOIN 
    tbl_data_bci_2021 d1_table_gerenciaR1 ON d1_table_gerenciaR1.rut = h.gerenciaR1
LEFT JOIN 
    tbl_data_bci_2021 dep_table ON dep_table.rut = '$rut' 
    AND dep_table.d12 = d1_table_gerenciaR1.d1
LEFT JOIN 
    tbl_data_bci_2021 dep_table_count ON dep_table_count.d12 = d1_table_gerenciaR1.d1
LEFT JOIN 
    tbl_data_bci_2021 jefe_table ON jefe_table.rut = h.rut


    left join tbl_potencial_sucesion_comites_colaboradores_2024 C on h.id_comite=C.id_comite

WHERE
    ( C.rut = '$rut' ) 
    AND h.id_empresa = '62' 
GROUP BY
    h.id 
HAVING
    COUNT( dep_table_count.rut ) > 0
                      ";



    foreach ($cod as $key => $row) {
        $aux[$key] = $row->fecha_comite;
    }

    //echo $sql;
    //echo "<br>AUX<br>";
    //print_r($aux);
    //echo "<br>FIn AUX<br>";
    array_multisort($aux, SORT_DESC, $cod);

    //echo "<h3>Potencial Sucesion <br>".$sql."</h3>";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function Potencial_Sucesion_Mis_Comites_data_2024($id_empresa, $rut, $perfil){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql_jefe="select d12 from tbl_data_bci_2021 where rut='$rut'";
    $connexion->query($sql_jefe);

    $cod_jefe = $connexion->resultset();

    $rut_jefe=LimpiaRutFront($cod_jefe[0]->d12);
    //echo "<br>--> Mi Jefe $rut_jefe";
    if($perfil=="SUPER USER"){
            //echo "A";

        $sql=" SELECT 
    h.*, 
    j.d1 AS rut_completo,
    k.d1 AS rut_completo_r1,
    l.rut AS rut_dependiente,
    COUNT(m.rut) AS dep,
        k.d5 as cargo_lider,
        k.d6 as posicion_lider,
        k.d16 as nivelr_lider
FROM 
    tbl_potencial_comites_sucesion_2024 h
LEFT JOIN 
    tbl_data_bci_2021 j ON j.rut = '$rut'
LEFT JOIN 
    tbl_data_bci_2021 k ON k.rut = h.gerenciaR1
LEFT JOIN 
    tbl_data_bci_2021 l ON l.rut = '$rut' 
    AND l.d12 = k.d1
LEFT JOIN 
    tbl_data_bci_2021 m ON m.d12 = k.d1
WHERE 
    h.id_empresa = '62'
GROUP BY 
    h.id;      ";

    } else {
            //echo "B";


        $sql=" SELECT 
    h.*, 
    j.d1 AS rut_completo,
    k.d1 AS rut_completo_r1,
    l.rut AS rut_dependiente,
    COUNT(m.rut) AS dep,
    n.d12 AS jefe_creador,
    o.d12 AS mi_jefe,
       k.d5 as lider_cargo, k.d16 as nivelr_lider
FROM 
    tbl_potencial_comites_sucesion_2024 h
LEFT JOIN 
    tbl_data_bci_2021 j ON j.rut = '$rut'
LEFT JOIN 
    tbl_data_bci_2021 k ON k.rut = h.gerenciaR1
LEFT JOIN 
    tbl_data_bci_2021 l ON l.rut = '$rut' 
    AND l.d12 = k.d1
LEFT JOIN 
    tbl_data_bci_2021 m ON m.d12 = k.d1
LEFT JOIN 
    tbl_data_bci_2021 n ON n.rut = h.rut
LEFT JOIN 
    tbl_data_bci_2021 o ON o.rut = '$rut'
WHERE 
    (
        h.rut = '$rut' OR 
        h.gerenciaR1 = '$rut' OR 
        h.rut_socio_2 = '$rut' OR 
        h.rut_socio_3 = '$rut' OR 
        h.rut_socio_4 = '$rut' OR 
        n.d12 = o.d12
    ) 
AND 
    h.id_empresa = '62'
GROUP BY h.id
HAVING COUNT(m.rut) > 0
           ";
    }

   // echo $sql; exit();
    foreach ($cod as $key => $row) {
        $aux[$key] = $row->fecha_comite;
    }
    //echo "<br>AUX<br>";
    //print_r($aux);
    //echo "<br>FIn AUX<br>";
    array_multisort($aux, SORT_DESC, $cod);

    //echo "<h3>Potencial Sucesion <br>".$sql."</h3>";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function PotencialSucesion_BuscaR2_2024($rut_R1, $id_empresa){
    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql="
            select h.*, (select d1 from tbl_data_bci_2021 where rut='$rut_R1') as     rut_completo_r1,
                        (select d5 from tbl_data_bci_2021 where rut='$rut_R1') as     cargo_r1,
                        (select d6 from tbl_data_bci_2021 where rut='$rut_R1') as     posicion_r1,
                        (select d16 from tbl_data_bci_2021 where rut='$rut_R1') as    nivel_r_r1,
                       (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci where rut='$rut_R1')) as dep, 
                       U.nombre_completo from tbl_data_bci_2021 h 
                       left join tbl_usuario U on h.rut=U.rut where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1') 
                        and (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0 
                                    group by h.d6
     		
     		";

    //echo "<br>PotencialSucesion_BuscaR2_2024<br>".$sql;
    //exit();
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Comites_Suc_data_2024($id_comite,$id_empresa){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql   = "

     select h.*,
     (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo

     from tbl_potencial_comites_sucesion_2024 h

     where h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
     order by (select nombre_completo    from tbl_usuario   where rut=h.rut) ASC

     ";
    //echo "sql $sql";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function Potencial_Busca_Cantidad_Colaboradores_socio_2024($rut, $id_comite, $id_empresa){
    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");
    $sql   = "
           select count(h.id) as cuenta from tbl_potencial_sucesion_comites_colaboradores_2024 h where h.id_empresa='$id_empresa' and id_comite='$id_comite'
     ";
      //echo "<br>sqlPotencial_Busca_Cantidad_Colaboradores_socio_2024 <br> $sql<br>";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod[0]->cuenta);
}
function Potencial_EliminaComite_Sucesion_2024($id_comite) {

    $connexion = new DatabasePDO();

    $sql="update tbl_potencial_comites_sucesion_2024 set id_empresa='99' where id_comite='$id_comite' ";
    //echo $sql;exit;
    $connexion->query($sql);
    $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;

}
function Potencial_Sucesion_Select_Insert_comites_colaboradores_CheckSave_2024($rut,$posicion,$id_comite,$nombre_completo,$id_empresa)
{
    //echo "<br> Potencial_Sucesion_Select_Insert_comites_colaboradores_CheckSave_2024 -> $rut,$posicion,$id_comite,$nombre_completo,$id_empresa <br>";   //exit();
    $connexion = new DatabasePDO();
    $sql_check="select id from tbl_potencial_sucesion_comites_colaboradores_2024 where id_comite='$id_comite' and rut='$rut' and posicion ='$posicion'";
    $connexion->query($sql_check);
        // echo "<br>-> $sql_check";
    $cod = $connexion->resultset();
    if($cod[0]->id>0){

    } else{
        if($posicion<>""){
            $sql   = "insert into tbl_potencial_sucesion_comites_colaboradores_2024 (id_comite, posicion, rut, nombre_completo, id_empresa) VALUES ('$id_comite','$posicion', '$rut', '$nombre_completo','$id_empresa');";
                //echo $sql;
                //exit();
            $connexion->query($sql);
            $connexion->execute();
        }
    }
}

function UltimoCuadrantesPotencialBci_data(){
    $connexion = new DatabasePDO();
    $sql="
SELECT
    tbl_potencial_bitacora.rut_colaborador, 
    tbl_potencial_bitacora.rut as SSNN,
    tbl_potencial_bitacora.box_propuesto, 
    tbl_potencial_bitacora.comentario,
    tbl_potencial_bitacora.id_comite, 
    tbl_potencial_comites.nombre,
    tbl_potencial_bitacora.fecha,
    tbl_potencial_comites.comite_cerrado,
    tbl_potencial_comites.fecha_cerrado,
    (select COUNT(DISTINCT id_comite) from tbl_potencial_comites_colaboradores t where t.rut=tbl_potencial_bitacora.rut_colaborador and t.id_empresa='62') as total_comites_inscrito,
    (select COUNT(DISTINCT id) from tbl_potencial_bitacora n where n.perfil ='SOCIO DE NEGOCIO' and tbl_potencial_bitacora.rut_colaborador=n.rut_colaborador GROUP BY n.rut_colaborador and n.id_comite) as total_comites_mapeado
FROM
    tbl_potencial_comites
    INNER JOIN
    tbl_potencial_bitacora
    ON 
        tbl_potencial_comites.id_comite = tbl_potencial_bitacora.id_comite
        where tbl_potencial_comites.comite_cerrado ='SI' and tbl_potencial_comites.id_empresa='62' and tbl_potencial_bitacora.perfil='SOCIO DE NEGOCIO' and tbl_potencial_bitacora.rut_colaborador<>''
        order by tbl_potencial_bitacora.rut_colaborador asc,tbl_potencial_bitacora.id_comite asc
    ";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod;
}
function DatosDataBci2021($rut){
    $connexion = new DatabasePDO();
    $sql="select * from tbl_data_bci_2021  where rut='$rut'";
    //echo $sql;
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Ultimos_Lista_usuarios(){
    $connexion = new DatabasePDO();
    $sql="select distinct(rut) from tbl_potencial_comites_colaboradores  where rut<>''";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Ultimos_Lista_usuarios2(){
    $connexion = new DatabasePDO();
    $sql="Select h.rut from tbl_data_bci_2020 h 
    left join tbl_potencial_comites_colaboradores j on h.rut=j.rut where j.rut is null  and h.d103<>''";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Cantidad_Comites_Mapeados($rut_col)
{
    $connexion = new DatabasePDO();
    $sql = "select COUNT(distinct id_comite) as cuenta from tbl_potencial_bitacora where rut_colaborador='$rut_col' and perfil ='SOCIO DE NEGOCIO' order by id DESC";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}

function Cantidad_Distint_Comites_Mapeados($rut_col){
    $connexion = new DatabasePDO();
    $sql="SELECT DISTINCT (id_comite) FROM tbl_potencial_bitacora  WHERE rut_colaborador = '$rut_col'  AND perfil = 'SOCIO DE NEGOCIO'  ORDER BY id DESC";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;

}
function BuscaBoxPropuestaUltimoComite($id_comite, $rut_col){

    $connexion = new DatabasePDO();
    $sql="SELECT box_propuesto  FROM tbl_potencial_bitacora where rut_colaborador ='$rut_col' and perfil='SOCIO DE NEGOCIO' and id_comite='$id_comite' ORDER BY id desc LIMIT 1";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->box_propuesto;

}
function BuscaFechaBoxPropuestaUltimoComite($id_comite, $rut_col){

    $connexion = new DatabasePDO();
    $sql="SELECT fecha  FROM tbl_potencial_bitacora where rut_colaborador ='$rut_col' 
         and perfil='SOCIO DE NEGOCIO' and id_comite='$id_comite' ORDER BY id desc LIMIT 1";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->fecha;

}
function BuscaBoxAnterior_data_2022Comite($rut_col){
    $connexion = new DatabasePDO();
    $sql="select d103 from tbl_data_bci_2020 where rut='$rut_col'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->d103;

}
function BuscaFechaBoxAnterior_data_2022Comite($rut_col){

    $connexion = new DatabasePDO();
    $sql="select d104 from tbl_data_bci_2020 where rut='$rut_col'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->d104;

}
function BuscaBoxAnterior_data_2022ComiteSinMapeo($rut_col){
    $connexion = new DatabasePDO();
    $sql="select d103 as actual, d105 as anterior,  d104 as fecha_actual, d104 as fecha_anterior  from tbl_data_bci_2020 where rut='$rut_col'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function MenuNivel0PorEmpresa($id_empresa, $id_tema){
    $connexion = new DatabasePDO();
    if ($id_tema) {
        $sql = " select * from tbl_menu_nivel0 where id_empresa='$id_empresa' and id_tema='$id_tema'order by orden asc";
    } else {
        $sql = " select * from tbl_menu_nivel0 where id_empresa='$id_empresa' and (id_tema is null or id_tema='') order by orden asc";
    }
    //echo $sql;
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function LMS_ConsultaRutSegunEmail_data($email, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select h.* from tbl_usuario h where h.email='$email' and h.id_empresa='$id_empresa' and h.vigencia='0' and h.rut<>''";
    //echo "<br>$c_host, $c_user, $c_pass, $c_db";
    //echo "<br>$sql";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Cuadrantes_Update_2022_Data($rut,$promedio_metas_2020,$promedio_competencias_2020,$propuesta_cuadrante_2020,$fecha_propuesta_cuadrante_2020){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql = "update tbl_potencial_cuadrantes 
    set promedio_metas_2020='$promedio_metas_2020',
        promedio_competencias_2020='".$promedio_competencias_2020."',
        propuesta_cuadrante_2020='".$propuesta_cuadrante_2020."',
        fecha_propuesta_cuadrante_2020='".$fecha_propuesta_cuadrante_2020."'
    where rut='$rut'";
    $connexion->query($sql);
    $connexion->execute();
    
}
function Potencial_DataBciPosicionVsPropuestosR2(){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
	
    $sql= "select h.d15, h.d6, 
    h.d31, h.d33, h.d35,
    (select id FROM tbl_potencial_sucesion_colaboradores_propuestos_r2 where posicion=h.d6 limit 1) as ExistePropuesto
    from tbl_data_bci_2021 h
    where (h.d153='R1' or h.d153='R2' or h.d153='R3')
    and (select id FROM tbl_potencial_sucesion_colaboradores_propuestos_r2 where posicion=h.d6 limit 1) is NULL
    and (h.d6 not like '%secretaria%')
    and (h.d6 not like '%chofer%')
    and (h.d6 not like '%mayordomo%')
    group by h.d6
    order by h.d6						";
						
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_tbl_tbl_potencial_clima_2020($rut){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql=" 	select h.* from tbl_potencial_clima_2020 h where h.rut='$rut' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_tbl_tbl_potencial_clima_2021($rut){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql=" 	select h.* from tbl_potencial_clima_2021 h where h.rut='$rut' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function potencial_csv_acciones_desarrollo_api_data(){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql="  select h.rut, h.plan, h.fundamento, h.estado, h.periodo, h.rut_creador as rut_creador from tbl_potencial_sucesion_acciones_desarrollo h order by h.periodo DESC";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function potencial_csv_ultimo_cuadrante_api_data(){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql=" select rut, IF(cuadrante_2020='10','5+',cuadrante_2020) as cuadrante, fecha_cuadrante_2020 as fecha_cuadrante, periodo from tbl_potencial_cuadrantes_api";
				//echo $sql; exit();
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function potencial_csv_acciones_desarrollo_api_data_v2($filtrada){
    $connexion = new DatabasePDO();
    
       $fecha = date("Y-m-d");

    if($filtrada=="1"){
        $sql="  
           SELECT
                h.rut, 
                h.plan, 
                h.fundamento, 
                h.estado, 
                h.periodo, 
                h.rut_creador AS rut_creador, 
                k.d31, 
                k.d153
            FROM
                tbl_potencial_sucesion_acciones_desarrollo AS h
                INNER JOIN
                    tbl_data_bci_2021 k
                    ON h.rut = k.rut
                INNER JOIN
                    tbl_potencial_rut_permiso_descarga p
                    ON h.rut = p.rut_col
            WHERE
                k.d31 <> 'GERENCIA CORPORATIVA GESTION PERSONAS' and
                k.d153 <> 'R1'
                and k.d153 <>'R0'
            	and p.rut_permiso ='".$_SESSION["user_"]."'


            ORDER BY
                h.periodo DESC";
    } else {
        $sql="  
            select h.rut, h.plan, h.fundamento, h.estado, h.periodo, h.rut_creador as rut_creador 
            from tbl_potencial_sucesion_acciones_desarrollo h 
            order by h.periodo DESC";
    }


    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function potencial_csv_ultimo_cuadrante_api_data_v2($filtrada){
    $connexion = new DatabasePDO();
    
       $fecha = date("Y-m-d");

    if($filtrada=="1") {

        $sql=" 	
			SELECT
                    h.rut,
                IF
                    ( h.cuadrante_2020 = '10', '5+', h.cuadrante_2020 ) AS cuadrante,
                    h.fecha_cuadrante_2020 AS fecha_cuadrante,
                    h.periodo 
                FROM
                    tbl_potencial_cuadrantes_api h
                    INNER JOIN
                    tbl_data_bci_2021 k
                    ON 
                        h.rut = k.rut
                INNER JOIN
                    tbl_potencial_rut_permiso_descarga p
                    ON h.rut = p.rut_col                
                WHERE
                    k.d31 <> 'GERENCIA CORPORATIVA GESTION PERSONAS' and
                    k.d153 <> 'R1' and k.d153 <>'R0'
                    
                            	and p.rut_permiso ='".$_SESSION["user_"]."'
                    ";


    } else {

        $sql=" 	
						select rut, IF(cuadrante_2020='10','5+',cuadrante_2020) as cuadrante, fecha_cuadrante_2020 as fecha_cuadrante, periodo from 
                        tbl_potencial_cuadrantes_api";
    }
    

    //echo $sql; exit();
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_PreguntasRespuesta(){

				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	select h.*  from tbl_potencial_pregunta_respuesta h  ";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);		
	
}
function ControlDotacionInsertaAccesoLogin($rut, $email, $arreglo, $response_email, $key, $sesion, $token){
 		$connexion = new DatabasePDO();
		$fecha=date("Y-m-d");
		$hora  = date("H:i:s");
		$sql = "	INSERT INTO tbl_acceso_log_potencial (rut, fecha, hora, email, arreglo, response_email, key_data, sesion, token, ip) 
 						VALUES ('$rut', '$fecha', '$hora', '$email', '".json_encode($arreglo)."','".$response_email."', '".$key."', '".json_encode($sesion)."', '$token', '".$_SERVER['REMOTE_ADDR']."')";	
 						
  	$connexion->query($sql);
   	 $connexion->execute();
}
function Potencial_BuscaDesempeno_2020($rut_col){
	
				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	select h.* 
				 				from tbl_potencial_metas_desempeno_2020 h  
				 				where rut='$rut_col'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);			
	
}
function Potencial_BuscaDesempeno_2021($rut_col){
	
				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	select h.* 
				 				from tbl_potencial_metas_desempeno_2021 h  
				 				where rut='$rut_col'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);			
	
}
function sucesion_csv_informes_data_1(){
	
				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	

select h.*, 
(SELECT d31 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  GerenciaCargoasuceder,
(SELECT d33 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  FondoCargoasuceder,
(SELECT d35 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  DependenciaCargoasuceder,
h.posicion as Cargoasuceder,

(SELECT d1 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  Rutocupanteactualdelcargo,
(SELECT d7 FROM tbl_data_bci_2021 WHERE d6 = h.posicion limit 1 ) as  Nombreocupanteactualdelcargo,
(SELECT d8 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  Apellidoocupanteactualdelcargo,
(SELECT d9 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  ApellidoMocupanteactualdelcargo,
(SELECT d153 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  nivelRocupanteactualdelcargo,

Concat((SELECT d7 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1),' ',(SELECT d8 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1),' ',(SELECT d9 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1)) as NombrecompletoOcupanteacutaldelcargo, 
h.tipo_sucesion as Temporalidad,
(SELECT d1 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  RutSucesor,
Concat((SELECT d7 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ),' ',(SELECT d8 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ),' ',(SELECT d9 FROM tbl_data_bci_2021 WHERE rut = h.rut_col )) as NombreCompletoSucesor, 
(select fecha_comite from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as FechaComite,
(SELECT d31 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  GerenciaSucesor,
(SELECT d33 FROM tbl_data_bci_2021 WHERE rut = h.rut_col) as  FondoSucesor,
(SELECT d35 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  DependenciaSucesor,

(select cuadrante from tbl_potencial_cuadrantes_api_full where rut=h.rut_col) as CuadranteactualSucesor,
(select fecha from tbl_potencial_cuadrantes_api_full where rut=h.rut_col) as FechacomitecuadranteactualSucesor,

'' as Tipodemovimiento,


(select nombre from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as nombre_comite,
(select gerenciaR1 from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as rut_a_suceder,
(select comite_cerrado from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as comite_cerrado

 from tbl_potencial_sucesion_colaboradores_propuestos_r2 h where id_empresa='62' and id_comite is not null				
 and (SELECT d1 FROM tbl_data_bci_2021 WHERE rut = h.rut_col )<>''
 and (select nombre from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') is not null
 and (SELECT d1 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) <>''		
				";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);		
	
}
function sucesion_csv_informes_data_2(){
	
				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	

select h.*, 
(SELECT d31 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  GerenciaCargoasuceder,
(SELECT d33 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  FondoCargoasuceder,
(SELECT d35 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  DependenciaCargoasuceder,
h.posicion as Cargoasuceder,

(SELECT d1 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  Rutocupanteactualdelcargo,
(SELECT d7 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  Nombreocupanteactualdelcargo,
(SELECT d8 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  Apellidoocupanteactualdelcargo,
(SELECT d9 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1) as  ApellidoMocupanteactualdelcargo,

Concat((SELECT d7 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1),' ',(SELECT d8 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1),' ',(SELECT d9 FROM tbl_data_bci_2021 WHERE d6 = h.posicion  limit 1)) as NombrecompletoOcupanteacutaldelcargo, 
h.tipo_sucesion as Temporalidad,
(SELECT d1 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  RutSucesor,
Concat((SELECT d7 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ),' ',(SELECT d8 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ),' ',(SELECT d9 FROM tbl_data_bci_2021 WHERE rut = h.rut_col )) as NombreCompletoSucesor, 
(select fecha_comite from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as FechaComite,
(SELECT d31 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  GerenciaSucesor,
(SELECT d33 FROM tbl_data_bci_2021 WHERE rut = h.rut_col) as  FondoSucesor,
(SELECT d35 FROM tbl_data_bci_2021 WHERE rut = h.rut_col ) as  DependenciaSucesor,

(select cuadrante from tbl_potencial_cuadrantes_api_full where rut=h.rut_col) as CuadranteactualSucesor,
(select fecha from tbl_potencial_cuadrantes_api_full where rut=h.rut_col) as FechacomitecuadranteactualSucesor,

'' as Tipodemovimiento,


(select nombre from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as nombre_comite,
(select gerenciaR1 from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as rut_a_suceder,
(select comite_cerrado from tbl_potencial_comites_sucesion  where id_comite=h.id_comite and id_empresa='62') as comite_cerrado

 from tbl_potencial_sucesion_colaboradores_propuestos_r2 h where id_empresa='62' and id_comite is null				
				
				";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);		



}
function MiRx($rut){
	
				$connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				/*$sql=" 	select h.d153 as rx from tbl_data_bci_2021 h where rut='$rut'";*/
    $sql=" 	select h.d16 as rx from tbl_data_bci_2021 h where rut='$rut'";
     		//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod[0]->rx);		
	
}
function PotencialBuscaRutBajoRutLider($rut_lider){
	
	  $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 
				
					select h.rut from tbl_potencial_comites_colaboradores h where h.rut_lider='$rut_lider'
						union
					select h.rut from tbl_potencial_sucesion_comites_colaboradores h where h.rut_lider='$rut_lider';				
				
				";
     		
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
        return $cod;	
		
	
}
function Potencial_Cols_Por_Tipo_Cuadrante($TipoCuadrante,$gerencia,$fondo,$dependencia){
	
// echo "<br>FN Potencial_Cols_Por_Tipo_Cuadrante($TipoCuadrante,$gerencia,$fondo,$dependencia)";
 $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

if($TipoCuadrante=="2-3-6"){
	$JqueryCuad=" and (h.cuadrante='2' or  h.cuadrante='3' or  h.cuadrante='6') ";
}

if($TipoCuadrante=="5-5+"){
	$JqueryCuad=" and (h.cuadrante='5' or  h.cuadrante='5+') ";
}


if($TipoCuadrante=="1-4-7-8-9"){
	$JqueryCuad=" and (h.cuadrante='1' or  h.cuadrante='4' or  h.cuadrante='7' or  h.cuadrante='8' or  h.cuadrante='9') ";
}


				$sql=" 	select h.*
				 				from tbl_potencial_cuadrantes_api_full h  
				 				where rut<>''
				 				$JqueryCuad
				 				
				 				
				 				
				 				";
     
//echo $sql; exit();
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);	
	
	
	
}
function PotencialTraeDatosBci2021($rut){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 	select h.rut, h.d1, h.d7, h.d8, h.d9, d31 as d30, d33 as d32, d35 as d34, d145, d6
				 				from tbl_data_bci_2021 h  
				 				where rut='$rut'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);	
	
}
function PotencialBuscaAccionesSinEstado($rut, $fecha){

	  $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 
				select *  from tbl_potencial_sucesion_acciones_desarrollo 
				where 
				rut='$rut' and 
				fecha_estado>'$fecha' and 
				(estado is null or estado='En Proceso' or estado='No Iniciado')";
     		
 				//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
        return $cod;	
	
	
}
function EsSocioOLider($rut) {
	
	
			  $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 
				select id  from tbl_potencial_perfil where rut='$rut'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
        return $cod[0]->id;
	
}
function PotencialInsertUsuario($rut_ficticio_usuario,$nombre_externo,$cargo_externo, $id_empresa){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_usuario  (rut,nombre_completo,cargo, id_empresa, vigencia_descripcion)
                VALUES ('$rut_ficticio_usuario','$nombre_externo','$cargo_externo', '$id_empresa', 'Externo');";
        //echo $sql; exit();
    $connexion->query($sql);
    $connexion->execute();
	
	
}
function DatosUsuarioMax(){
	
	
		      $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 
				select (max(round(rut))) as max from tbl_usuario";
     
     		//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
        //print_r($cod);
        $max_uno=round($cod[0]->max)+1;
        
        //echo "max uno ".$max_uno."<br>";
        return $max_uno;	
	
}
function Potencial_Busca_Acciones_Desarrollo_Dado_Rut($rut){
	
	      $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" 
				select h.* 
				from tbl_potencial_sucesion_acciones_desarrollo h  
				where h.rut='$rut'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;	
	
}
function Potencial_BuscaRutCompletoDadorut($rut){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" select h.d1 as rut_completo from tbl_data_bci h  where rut='$rut'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod[0]->rut_completo);	
}
function Potencial_BuscaFullData($rut){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

				$sql=" select h.* from tbl_data_bci_2021 h  where rut='$rut'";
     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);	
}
function Potencial_Colaboradores_MiEquipo_data($rut_completo, $perfil, $id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");


     $sql   = "

     select h.* 
     
     from 
     
     tbl_data_bci h 

     where h.d12='$rut_completo'

     ";
        //echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Baja_Igual_Sube($box_propuesta, $box_lider) {
	
			//echo "<br>Potencial_Baja_Igual_Sube actual $box_propuesta, lider $box_lider";
				if($box_propuesta=="1" and  
						($box_lider=="2" or $box_lider=="3" or $box_lider=="6"  or $box_lider=="5" or $box_lider=="10")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="1" and  
						($box_lider=="4" or $box_lider=="7" or $box_lider=="8")	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="1" and  
						($box_lider=="1" or $box_lider=="9")	
				)	{	$respuesta="MANTIENE";}		
	

				if($box_propuesta=="2" and  
						($box_lider=="3")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="2" and  
						($box_lider=="6" or $box_lider=="2" )	
				)	{	$respuesta="MANTIENE";}		
	
					if($box_propuesta=="2" and  
						($box_lider=="1" or $box_lider=="5" or $box_lider=="10" or $box_lider=="4" or $box_lider=="7" or $box_lider=="8" or $box_lider=="9")	
				)	{	$respuesta="BAJA";}			
	

	
					if($box_propuesta=="3" and  
						($box_lider=="3" )	
				)	{	$respuesta="MANTIENE";}		
	
						if($box_propuesta=="3" and  
						($box_lider=="1" or $box_lider=="2" or $box_lider=="4" or $box_lider=="5" or $box_lider=="10" or $box_lider=="6" or $box_lider=="7" or $box_lider=="8" or $box_lider=="9")	
				)	{	$respuesta="BAJA";}			
	
	
	
				if($box_propuesta=="4" and  
						($box_lider=="1" or $box_lider=="2" or $box_lider=="3" or $box_lider=="5"  or $box_lider=="10" or $box_lider=="6"  or $box_lider=="9")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="4" and  
						($box_lider=="7")	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="4" and  
						($box_lider=="4" or $box_lider=="8")	
				)	{	$respuesta="MANTIENE";}			
	

	
				if($box_propuesta=="5" and  
						($box_lider=="2" or $box_lider=="3" or $box_lider=="10"  or $box_lider=="6")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="5" and  
						($box_lider=="1" or $box_lider=="4"  or $box_lider=="7" or $box_lider=="8" or $box_lider=="9" )	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="5" and  
						($box_lider=="5")	
				)	{	$respuesta="MANTIENE";}		
				
				
				if($box_propuesta=="6" and  
						($box_lider=="3")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="6" and  
						($box_lider=="1" or $box_lider=="4" or $box_lider=="5" or $box_lider=="10" or $box_lider=="7" or $box_lider=="8" or $box_lider=="9")	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="6" and  
						($box_lider=="6" or $box_lider=="2")	
				)	{	$respuesta="MANTIENE";}						
					

				if($box_propuesta=="7" and  
						($box_lider=="1" or $box_lider=="2" or $box_lider=="3" or $box_lider=="4"  or $box_lider=="5" or $box_lider=="10" or $box_lider=="6"  or $box_lider=="8" or $box_lider=="9")	
				)	{	$respuesta="SUBE";}	
	

	
					if($box_propuesta=="7" and  
						($box_lider=="7")	
				)	{	$respuesta="MANTIENE";}		



				if($box_propuesta=="8" and  
						($box_lider=="1" or $box_lider=="2" or $box_lider=="3"  or $box_lider=="5" or $box_lider=="10" or $box_lider=="6"  or $box_lider=="7" or $box_lider=="9")	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="8" and  
						($box_lider=="7")	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="8" and  
						($box_lider=="8" or $box_lider=="4")	
				)	{	$respuesta="MANTIENE";}		


				if($box_propuesta=="9" and  
						($box_lider=="2" or $box_lider=="3" or $box_lider=="4"  or $box_lider=="5" or $box_lider=="10" or $box_lider=="6" )	
				)	{	$respuesta="SUBE";}	
	
				if($box_propuesta=="9" and  
						($box_lider=="4" or $box_lider=="7" or $box_lider=="8")	
				)	{	$respuesta="BAJA";}		
	
					if($box_propuesta=="9" and  
						($box_lider=="9" or $box_lider=="1")	
				)	{	$respuesta="MANTIENE";}		
	
	
		if($box_propuesta=="" or $box_lider=="")										
				{	$respuesta="VACIO";}	
		
	
				
	return $respuesta;		
				
}
function Potencial_Mi_Cuadrante_Actual($rut_col){
	
	        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql="
				
						select 
						
						h.d103  as cuadrante_actual,
						h.d104  as fecha_actual,
						(select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020,
						(select fecha_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_cuadrante_2020

						from tbl_data_bci h	
						
						where h.rut='$rut_col'";	
				//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        
        if($cod[0]->cuadrante_2020<>""){
        	$cuadrante_actual=$cod[0]->cuadrante_2020;
        } else {
        	$cuadrante_actual=$cod[0]->cuadrante_actual;
        }
        
				return ($cuadrante_actual);	
}
function Potencial_Mi_Cuadrante_Actual_mas_Fecha($rut_col){
	
	        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql="
				
						select 
						
						h.d103  as cuadrante_actual,
						h.d104  as fecha_actual,
						(select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020,
						(select fecha_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_cuadrante_2020

						from tbl_data_bci h	
						
						where h.rut='$rut_col'";	
				//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        
        if($cod[0]->cuadrante_2020<>""){
        	$cuadrante_actual=$cod[0]->cuadrante_2020;
        	$fecha_actual=$cod[0]->fecha_cuadrante_2020;
        } else {
        	$cuadrante_actual=$cod[0]->cuadrante_actual;
        	$fecha_Explode=explode("-",$cod[0]->fecha_actual);
        	$fecha_actual=$fecha_Explode[2]."-".$fecha_Explode[1]."-".$fecha_Explode[0];
        }
        $arreglo[0]=$cuadrante_actual;
        $arreglo[1]=$fecha_actual;
        
				return ($arreglo);	
}
function Potencial_Estadisticas($id_empresa, $gerencia, $fondo, $dependencia){
	
		    $connexion = new DatabasePDO();
        
        

if($gerencia<>"")		{	$gerencia			= " and gerencia='$gerencia' ";	}
if($fondo<>"")			{	$fondo				= " and fondo='$fondo' ";	}
if($dependencia)		{	$dependencia	= " and dependencia='$dependencia' ";	}
        	
				$SQL_SU="select count(id) as cuenta from tbl_potencial_comites where id_empresa='$id_empresa'";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$numero_comites=$COD_SU[0]->cuenta;

				$SQL_SU="select count(id) as cuenta from tbl_potencial_comites where id_empresa='$id_empresa' and comite_cerrado='SI'";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$numero_comites_cerrados=$COD_SU[0]->cuenta;
				$numero_comites_abiertos=$numero_comites-$numero_comites_cerrados;

				$SQL_SU="select count(DISTINCT(rut)) as cuenta from tbl_potencial_cuadrantes_actual_2020_anterior  
				where id>0 $gerencia $fondo $dependencia
				";
				//echo $SQL_SU;
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$num_colaboradores=$COD_SU[0]->cuenta;
      
				$SQL_SU="select count(DISTINCT(rut)) as cuenta from tbl_potencial_cuadrantes_actual_2020_anterior 
				where  (cuadrante='2' or cuadrante='3' or cuadrante='6')
				$gerencia $fondo $dependencia
				";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$num_colaboradores_236=$COD_SU[0]->cuenta;

				$SQL_SU="select count(DISTINCT(rut)) as cuenta from tbl_potencial_cuadrantes_actual_2020_anterior 
				where  (cuadrante='5' or cuadrante='5+' or cuadrante='10')
				$gerencia $fondo $dependencia
				";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$num_colaboradores_5_5mas=$COD_SU[0]->cuenta;

				$SQL_SU="select count(DISTINCT(rut)) as cuenta from tbl_potencial_cuadrantes_actual_2020_anterior 
				where  (cuadrante='1' or cuadrante='4' or cuadrante='7' or cuadrante='8' or cuadrante='9')
				$gerencia $fondo $dependencia
				";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	
				$num_colaboradores_14789=$COD_SU[0]->cuenta;				


        
	$arreglo[1]=$numero_comites;
	$arreglo[2]=$numero_comites_abiertos;
	$arreglo[3]=$numero_comites_cerrados;

	$arreglo[4]=$num_colaboradores;
	$arreglo[5]=$num_colaboradores_236;
	$arreglo[6]=$num_colaboradores_5_5mas;
	$arreglo[7]=$num_colaboradores_14789;

	
	return $arreglo;
}
function Potencial_Mi_Cuadrante_Lider($rut_col){
	
	        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql="
				
select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut='$rut_col'";	
				//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        
        if($cod[0]->cuadrante_2020_lider<>""){
        	$cuadrante_actual=$cod[0]->cuadrante_2020_lider;
        } else {
        	$cuadrante_actual="";
        }
        
				return ($cuadrante_actual);	
}
function Potencial_Mi_data($id_empresa, $rut_col){
	
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="select * from tbl_potencial_cuadrantes where rut='$rut_col'";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
				return ($cod_1);	
	
}
function PanelLiderazgoResultadoFinalCompleto($res_que,$res_como){
	
		$resultado	=	round((50*$res_que+50*$res_como)/100);
	//&&echo "<br>resultado $resultado<br>$res_DS,$res_2_AE,$res_3_ASC,$res_3_PAR";
	return $resultado;
	
}
function PanelBuscoFlexPersonaYDanCotinue($rut_col, $id_empresa){
	    	$connexion = new DatabasePDO();
        
        	
        
        $sql=" select tipo_flexible from tbl_panel_liberado where rut='$rut_col'";
				//echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        if($cod[0]->tipo_flexible=="ft"){$kpi_continue="fp";}
        if($cod[0]->tipo_flexible=="fp"){$kpi_continue="ft";}
        
        return $kpi_continue;	
}
function PanelBuscaPanelCriterios($tipo, $id_empresa){
	    	$connexion = new DatabasePDO();
        
        	
        
        $sql=" select * from tbl_panel_criterios where tipo='$tipo' and id_empresa='$id_empresa'";
				//echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;
}
function PanelBuscaResultadoKpiInicioFinal($id_kpi, $rut_col, $id_empresa, $year){
	    	$connexion = new DatabasePDO();
        
        	

				//echo "<br>PanelBuscaResultadoKpiInicioFinal($id_kpi, $rut_col, $id_empresa)<br>";

   			$campo1=$id_kpi."_d";
   			$campo2=$id_kpi."_n";
   			$campo3=$id_kpi."_c";
	 	    $campo4=$id_kpi."_m";
           
				
				
				if($id_kpi=="en"){

        $sql_inicio	=" select eng_c as cumplimiento from tbl_panel_data where rut='$rut_col' and eng_c<>'' and year='$year' order by month ASC limit 1";
        $sql_final	=" select eng_c cumplimiento from tbl_panel_data where rut='$rut_col' and eng_c<>'' and year='$year' order by month DESC limit 1";
				//echo "<br>sql_inicio $sql_inicio<br>sql_final $sql_final<br>";

					
				} 
				
				elseif($id_kpi=="de"){

        $sql_inicio	=" select de_c as cumplimiento from tbl_panel_data where rut='$rut_col' and de_c<>'' and year='$year' order by month ASC limit 1";
        $sql_final	=" select sum(de_c) cumplimiento from tbl_panel_data where rut='$rut_col' and de_c<>'' and year='$year' order by month DESC limit 1";
				//echo "<br>sql_inicio $sql_inicio<br>sql_final $sql_final<br>";

					
				}				
				else {

        $sql_inicio	=" select $campo1 as dotacion,$campo2 as numerador,$campo3 as cumplimiento,$campo4 as aspiracional from tbl_panel_data where rut='$rut_col' and year='$year' order by month ASC limit 1";
        $sql_final	=" select $campo1 as dotacion,$campo2 as numerador,$campo3 as cumplimiento,$campo4 as aspiracional from tbl_panel_data where rut='$rut_col' and year='$year' order by month DESC limit 1";
				//echo "<br>sql_inicio $sql_inicio<br>sql_final $sql_final<br>";

					
				}
								//echo "<br>sql_inicio $sql_inicio<br>sql_final $sql_final<br>";

        $connexion->query($sql_inicio);        
        $cod_inicio = $connexion->resultset();
        $connexion->query($sql_final);        
        $cod_final = $connexion->resultset();
        
        $arreglo[0]=$cod_inicio;
        $arreglo[1]=$cod_final;

        
        return $arreglo;	
}
function PanelGeneraGestionDadoKpi($res_inicio, $res_final){
	    	$connexion = new DatabasePDO();
        
        	
//echo "$res_inicio, $res_final";
if($res_final>$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-level-up-alt'></i></div>";}
if($res_final==$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-exchange-alt'></i></div>";}
if($res_final<$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-level-down-alt'></i></div>";}
        
        
        return $flecha_gestion;	
}
function PanelGeneraSemaforoDadoKpi($res_inicio, $res_final, $kpi_aspiracional){
//echo "<br>$res_inicio, $res_final";
$cincoporciento=(5*$kpi_aspiracional/100);
$rango_inferior=$kpi_aspiracional-$cincoporciento;

//echo "<br>aspiracional $kpi_aspiracional, $res_inicio, $res_final, $kpi_aspiraciona";
   
   if($res_final>$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-level-up-alt'></i></div>";}
if($res_final==$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-exchange-alt'></i></div>";}
if($res_final<$res_inicio)		{$flecha_gestion	=	"<div class='panel_flecha'><i class='fas fa-level-down-alt'></i></div>";}
     
if($res_final >= $kpi_aspiracional)		{$semaforo				=	"<div class='panel_semaforo_verde'><i class='fas fa-dot-circle'></i></div>";}
if($res_final >=$rango_inferior and $res_final < $kpi_aspiracional)		{$semaforo				=	"<div class='panel_semaforo_amarillo'><i class='fas fa-dot-circle'></i></div>";}
if($res_final < $rango_inferior)			{$semaforo				=	"<div class='panel_semaforo_rojo'><i class='fas fa-dot-circle'></i></div>";}

  if($res_final>$res_inicio)	{
  	$semaforo				=	"<div class='panel_semaforo_verde'><i class='fas fa-dot-circle'></i></div>";
  }

//echo "semaforo $semaforo	";

        return $semaforo;	
}
function PanelGeneraTxtSemaforoDadoKpi($res_inicio, $res_final, $kpi_aspiracional){

$cincoporciento=(5*$kpi_aspiracional/100);
$rango_inferior=$kpi_aspiracional-$cincoporciento;

//echo "<br>aspiracional $kpi_aspiracional, $cincoporciento, rango inferior $rango_inferior";
     
if($res_final >= $kpi_aspiracional)		{$semaforo				=	"verde";}

        return $semaforo;	
}
function PanelResultadoCuentaVerdes($cuenta_verde,$cuenta_todos){
	///echo "<br>PanelResultadoCuentaVerdes cuenta_verde $cuenta_verde";
	if($cuenta_verde>=6 and $cuenta_verde<100)			{$resultado="130";}
	elseif($cuenta_verde>=5 and $cuenta_verde<6)			{$resultado="115";}	
	elseif($cuenta_verde>=4 and $cuenta_verde<5)			{$resultado="100";}	
	elseif($cuenta_verde>=3 and $cuenta_verde<4)			{$resultado="90";}
	elseif($cuenta_verde>=2 and $cuenta_verde<3)			{$resultado="60";}
	elseif($cuenta_verde>=1 and $cuenta_verde<2)			{$resultado="30";}
	elseif($cuenta_verde>=0 and $cuenta_verde<1)			{$resultado="0";}

	return $resultado;

}
function PanelBuscaResultadoKpiInicioFinalEngLid($id_kpi, $rut_col, $id_empresa, $year){
	
	//echo "<br>PanelBuscaResultadoKpiInicioFinalEng($id_kpi, $rut_col, $id_empresa, $year)";
	
	    	$connexion = new DatabasePDO();
        
        	
          
        $sql_inicio	=" select $id_kpi as dato from tbl_panel_data where rut='$rut_col' and id_empresa='$id_empresa' and $id_kpi<>'' and year='$year' order by year DESC, month DESC limit 1 ";
				//echo "<br>PanelBuscaResultadoKpiInicioFinalEngLid $sql_inicio";
        $connexion->query($sql_inicio);        
        $cod_inicio = $connexion->resultset();
        //print_r($cod_inicio);
        return $cod_inicio[0]->dato;	
}
function PanelResCompetenciaLinea($res_ae,$res_ds,$res_mp,$res_as){
	//echo "<br>PanelResCompetenciaLinea(ae $res_ae, ds $res_ds, mp $res_mp, as $res_as)";
	
	$res_ae = str_replace(',', '.', $res_ae);
	$res_ds = str_replace(',', '.', $res_ds);
	$res_mp = str_replace(',', '.', $res_mp);
	$res_as = str_replace(',', '.', $res_as);
	
		if($res_ds<>"" and $res_ae<>"" and $res_as<>"" and $res_mp<>""){
				$resultado	=	round((10*$res_ae+50*$res_ds+15*$res_mp+25*$res_as)/100,2);
				$pon_ae=10;
				$pon_ds=50;
				$pon_mp=15;
				$pon_as=25;
			}

		elseif($res_ds<>"" and $res_ae<>"" and $res_as<>"" and $res_mp==""){
				$resultado	=	round((15*$res_ae+50*$res_ds+35*$res_as)/100,2);
				$pon_ae=15;
				$pon_ds=50;
				$pon_mp=0;
				$pon_as=35;
			}

		elseif($res_ds<>"" and $res_ae<>"" and $res_as=="" and $res_mp<>""){
				$resultado	=	round((15*$res_ae+60*$res_ds+25*$res_mp)/100,2);
				$pon_ae=15;
				$pon_ds=60;
				$pon_mp=25;
				$pon_as=0;
			}

		elseif($res_ds<>"" and $res_ae=="" and $res_as<>"" and $res_mp<>""){
				$resultado	=	round((50*$res_ds+25*$res_mp+35*$res_as)/100,2);
				$pon_ae=0;
				$pon_ds=50;
				$pon_mp=25;
				$pon_as=35;
				
			}

		elseif($res_ds<>"" and $res_ae<>"" and $res_as=="" and $res_mp==""){
				$resultado	=	"NA";
				$pon_ae=0;
				$pon_ds=0;
				$pon_mp=0;
				$pon_as=0;
			}
		else {
				$resultado	=	"NA";
				$pon_ae=0;
				$pon_ds=0;
				$pon_mp=0;
				$pon_as=0;				
			}

		
		
$arreglo_resultado[0]=$resultado;
$arreglo_resultado[1]=$pon_ds;
$arreglo_resultado[2]=$pon_as;
$arreglo_resultado[3]=$pon_mp;
$arreglo_resultado[4]=$pon_ae;
	
	//echo "<br>resultado $resultado<br>";
	//exit();
	return $arreglo_resultado;
}
function PanelBuscaResultadosCompetencias($id_kpi, $rut_col, $year, $id_empresa){
	    	$connexion = new DatabasePDO();
        
        	
        
        $sql=" select evaluacion, $id_kpi as resultado from tbl_panel_data_competencias where rut='$rut_col' and year='$year' and id_empresa='$id_empresa'";
				//echo "<br>PanelBuscaResultadosCompetencias <br>sql $sql<br>";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;		
}
function PanelBuscaAspiracionalCriterio($id_kpi){
	
		    $connexion = new DatabasePDO();
        
        	

				$sql="select kpi_aspiracional from tbl_panel_criterios where id_kpi='$id_kpi' limit 1";
        //echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod[0]->kpi_aspiracional;	
	
}
//panel liderazgo
function Check_Usr_PrimerNivel_BloqueadoGGPP_soyLider($rut_col){
	
	     $connexion = new DatabasePDO();
        
        
        	
				$SQL_SU="select count(id) as cuenta from tbl_potencial_comites_colaboradores 
				where rut_lider='".$_SESSION["user_"]."' and rut='$rut_col' and id_empresa='62'";
				//echo $SQL_SU;	
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	

        return $COD_SU[0]->cuenta;	
	
	
}
function Sucesion_Update_Cierre_Posicion_lider($id_posicion){
	
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql = "update tbl_potencial_sucesion_colaboradores_propuestos_r2 
    set validado_lider='SI', fecha_validacion='".$fecha."'
    where posicion='$id_posicion'";
 //echo $sql;  exit();
   $connexion->query($sql);
   $datos = $connexion->resultset();
   $connexion->execute();
    return $datos;		
	
}
function Sucesion_Check_Posicion_validada($id_posicion){
	
		      $connexion = new DatabasePDO();
        
        
        	
				$SQL_SU="select count(id) as cuenta from tbl_potencial_sucesion_colaboradores_propuestos_r2 
				where posicion='$id_posicion' and validado_lider='SI'";
				//echo $SQL_SU;	
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	

        return $COD_SU[0]->cuenta;	
	
}
function Sucesion_Rut_Nombre_lider_posicion($id_posicion){
	
	      $connexion = new DatabasePDO();
        
        
        	
				//$SQL_SU="select rut, d7, d8, d9 from tbl_data_bci_2021 where d6='$id_posicion'";
    $SQL_SU="select rut, d7, d8, d9 from tbl_data_bci_2021 where d6='$id_posicion'";
				//echo $SQL_SU;	
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	

        return $COD_SU;			
}
function Check_Usr_PrimerNivel_Bloqueado($rut_col) {
	$bloqueado="";    
if($rut_col=="6461785" or $rut_col=="6926510"	or $rut_col=="7438369" or $rut_col=="7663689" or $rut_col=="6461785" or $rut_col=="10667871"or $rut_col=="7799138" or $rut_col=="10671495" or $rut_col=="10269066" or $rut_col=="10243251" or $rut_col=="10739385" or $rut_col=="6966517" or $rut_col=="6785528" or $rut_col=="8576943" or $rut_col=="10535909"){
 	$bloqueado=1;
 }
	    
        return $bloqueado;		
	
	
}
function Check_Usr_PrimerNivel_BloqueadoGGPP($rut_col) {
	      $connexion = new DatabasePDO();
        
        
        	
				$SQL_SU="select rut from tbl_data_bci_2021 where rut='$rut_col' and d31='GERENCIA CORPORATIVA GESTION PERSONAS'";
			
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	

        return $COD_SU[0]->rut;		

}
function BuscaGerenciaPersonasRut($rut){
    $connexion = new DatabasePDO();
    
    

    $SQL_SU="select id from tbl_data_bci_2021 where 
        (d31='GERENCIA CORPORATIVA GESTION PERSONAS' or d15='R1')  and rut='".$rut."'
                     ";
    $connexion->query($SQL_SU);
    
    $COD_SU = $connexion->resultset();

    return $COD_SU[0]->id;
}
function Potencial_SoySuper($rut){
	      $connexion = new DatabasePDO();
        
        
        	
		$SQL_SU="select id from tbl_potencial_perfil_super where rut='$rut'";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();	

        return $COD_SU[0]->id;	
	
}
function Potencial_BuscaFecha_DadoComite($id_comite){
	
	      $connexion = new DatabasePDO();
        
        

				$sql   = "select fecha_comite from tbl_potencial_comites where id_comite='$id_comite'  ";
				
    		$connexion->query($sql);
   		 		
	
        $cod = $connexion->resultset();
        return $cod;		
	
	
}
function Potencial_BuscaLideres_DadoComiteLider($id_comite,$rut_lider){
	
	      $connexion = new DatabasePDO();
        
        

				$sql   = "select * from tbl_potencial_comites_colaboradores where id_comite='$id_comite' and rut_lider='$rut_lider'  ";
				
    		$connexion->query($sql);
   		 		
	
        $cod = $connexion->resultset();
        return $cod;		
	
	
}
function Potencial_BuscaLideres_DadoComite($id_comite){
	
	      $connexion = new DatabasePDO();
        
        

				$sql   = "select * from tbl_potencial_comites_colaboradores where id_comite='$id_comite' and rut_lider<>'' group by rut_lider ";
				
    		$connexion->query($sql);
   		 		
	
        $cod = $connexion->resultset();
        return $cod;			
}
function Potencial_Sucesion_Acciones_Desarrollo_Cambioestado($AD_idEdEst, $estado, $fundamento){
	
  $connexion = new DatabasePDO();
  $fundamento=($fundamento);
  $fecha = date("Y-m-d");
  $hora  = date("H:i:s");
    $sql = "update tbl_potencial_sucesion_acciones_desarrollo h 
    set estado='".$estado."', fecha_estado='".$fecha."',
     rut_autor_estado='".$_SESSION["user_"]."', fundamento='".$fundamento."'
      where id='$AD_idEdEst' ";
		//echo $sql;
    $connexion->query($sql);
    $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;	
	
	
	
	
}
function Potencial_Delete_Acciones_Desarrollo($delad){
	
    $connexion = new DatabasePDO();
    $sql = "delete from tbl_potencial_sucesion_acciones_desarrollo where id='$delad'";
   	$connexion->query($sql);
    $connexion->execute();
    $datos = $connexion->resultset();
    return $datos;		
	
	
}
function Potencial_Acciones_Desarrollo($rut_col, $id_empresa){
	
	      $connexion = new DatabasePDO();
        
        

			

				$sql   = "select * from tbl_potencial_sucesion_acciones_desarrollo where rut='$rut_col' order by fecha DESC ";

    		$connexion->query($sql);
   		 		
	
	        $cod = $connexion->resultset();
        return $cod;		
	
	
}
function Potencial_Acciones_Desarrollo_por_comite($rut_col, $id_comite, $id_empresa){
	
	      $connexion = new DatabasePDO();
        
        

			

				$sql   = "select * from tbl_potencial_sucesion_acciones_desarrollo where rut='$rut_col' and id_comite='$id_comite' order by fecha DESC ";

    		$connexion->query($sql);
   		 		
	
	        $cod = $connexion->resultset();
        return $cod;		
	
	
}
function Potencial_Busca_Acciones_Desarrollo($rut_col){
	      $connexion = new DatabasePDO();
        
        

			

				$sql   = "select * from tbl_potencial_sucesion_acciones_desarrollo where rut='$rut_col' ";

    		$connexion->query($sql);
   		 		
	
	        $cod = $connexion->resultset();
        return $cod;	
	
}
function Potencial_Busca_Bitacora_Desarrollo($rut_col){
	      $connexion = new DatabasePDO();
        
        

			

				$sql   = "
					select h.*, 
					
					(select nombre_completo from tbl_usuario where rut=h.rut) as nombre_completo,
					(select nombre from tbl_potencial_comites_sucesion where id_comite=h.id_comite) as comite
					
					
				 from tbl_potencial_bitacora_sucesion h where h.rut_colaborador='$rut_col' 
				 group by h.accion, h.comentario
order by id DESC				  ";

				//echo $sql;

    		$connexion->query($sql);
   		 		
	
	        $cod = $connexion->resultset();
        return $cod;	
	
}
function Potencial_Insert_Acciones_Desarrollo($rut_col, $id_comite, $plan_acciones_desarrollo, $fundamento){
	      $connexion = new DatabasePDO();
        
        

					$plan_acciones_desarrollo=($plan_acciones_desarrollo);
					$fundamento=($fundamento);


		    $fecha = date("Y-m-d");
    		$hora  = date("H:i:s");

				$sql   = "insert into tbl_potencial_sucesion_acciones_desarrollo 
		    
		    (rut,id_comite,plan,fecha, rut_creador, fundamento, estado)
        VALUES
        ('$rut_col','$id_comite', '$plan_acciones_desarrollo', '$fecha','".$_SESSION["user_"]."','$fundamento','No Iniciado');";

			//

    $connexion->query($sql);
    $connexion->execute();
	
	
	
}
function Potencial_Del_tbl_potencial_sucesion_colaboradores_propuestos_r2($del, $perfil){
	   
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    
    if($perfil=="SOCIO DE NEGOCIO"){
    	$rut_lider="";
    } else {
    	$rut_lider=$_SESSION["user_"];
    }

    $sql = "
    update 
    tbl_potencial_sucesion_colaboradores_propuestos_r2 
    set estado='No es sucesor', rutlider='".$rut_lider."', fechalider='$fecha'
    where id='$del'";
 //echo $sql;  exit();
   $connexion->query($sql);
   $connexion->execute();
   $datos = $connexion->resultset();
    return $datos;	
	
	
}
function Potencial_Actualiza_tbl_potencial_sucesion_colaboradores_propuestos_r2($id_sucesor, $tipo_sucesion_ficha){
	
        $connexion = new DatabasePDO();
        
        
        $hoy   = date('Y-m-d');
        $sql="update tbl_potencial_sucesion_colaboradores_propuestos_r2 set tipo_sucesion='$tipo_sucesion_ficha' where id='$id_sucesor' ";
        //echo $sql;exit;
        $connexion->query($sql);
        $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;	
	
}
function Potencial_trae_rut_col_fromId_Sucesion($id_sucesor){
	
	
	      $connexion = new DatabasePDO();
        
        

				$sql   = "select rut_col from tbl_potencial_sucesion_colaboradores_propuestos_r2 where id='$id_sucesor' ";
				
    		$connexion->query($sql);
   		 		
	
        $cod = $connexion->resultset();
        
      
        return $cod[0]->rut_col;	

	
}
function Potencial_Insert_Col_Bitacora_Sucesion_CheckSave($rut, $perfil, $id_comite,$rut_save,$fundamento,$accion,$id_empresa){
      $connexion = new DatabasePDO();
        
        
	$fundamento=($fundamento);
		    $fecha = date("Y-m-d");
    		$hora  = date("H:i:s");

				$sql   = "insert into tbl_potencial_bitacora_sucesion 
		    
		    (rut,perfil,id_comite,rut_colaborador,comentario,accion,fecha,hora,id_empresa)
        VALUES
        ('$rut', '$perfil', '$id_comite','$rut_save','$fundamento','$accion', '$fecha', '$hora','$id_empresa');";

    $connexion->query($sql);
    $connexion->execute();
	
	
}
function Potencial_Insert_Col_Sucesion_CheckSave($id_comite,$rut_col,$tipo,$posicion,$id_empresa, $soylider){
	
	      $connexion = new DatabasePDO();
        
        
        
            $fecha = date("Y-m-d");
    		$hora  = date("H:i:s");
if($soylider>0){
					$sql   = "insert into tbl_potencial_sucesion_colaboradores_propuestos_r2 
		    
		    (id_comite,rut_col,fecha,hora,tipo_sucesion,posicion,estado,id_empresa, rutlider, fechalider)
        VALUES
        ('$id_comite','$rut_col', '$fecha', '$hora','$tipo', '$posicion','Es Sucesor','$id_empresa','".$_SESSION["user_"]."','$fecha');";
} else {
					$sql   = "insert into tbl_potencial_sucesion_colaboradores_propuestos_r2 
		    
		    (id_comite,rut_col,fecha,hora,tipo_sucesion,posicion,estado,id_empresa)
        VALUES
        ('$id_comite','$rut_col', '$fecha', '$hora','$tipo', '$posicion', 'Es Sucesor', '$id_empresa');";
}
		



    $connexion->query($sql);
    $connexion->execute();
	
}
function Potencial_Sucesion_CheckSave($rut,$posicion,$id_comite,$id_empresa){

    //echo "<br>-> Potencial_Sucesion_CheckSave $rut,$posicion,$id_comite,$id_empresa";
	      $connexion = new DatabasePDO();
        $sql_check="select id from tbl_potencial_sucesion_comites_colaboradores where id_comite='$id_comite' and rut='$rut' and posicion ='$posicion'";
        $connexion->query($sql_check);

        //echo "<br>-> $sql_check";

	    $cod = $connexion->resultset();
  if($cod[0]->id>0){}
  else{$sql   = "insert into tbl_potencial_sucesion_comites_colaboradores (id_comite, posicion, rut, id_empresa)
        VALUES
        ('$id_comite','$posicion', '$rut', '$id_empresa');";

      //echo "<br>-> $sql";

      $connexion->query($sql);
      $connexion->execute();}

	
}
function BuscaPersonas2020_v2($search){

    $connexion = new DatabasePDO();
	$search=($search);

	$sql="
		SELECT h.*, (select rut from tbl_data_bci_2021 where rut=h.rut) as databci,
    MATCH (h.nombre_completo) AGAINST ('$search') AS relevance
    FROM tbl_usuario h
    WHERE h.vigencia='0' and  MATCH (h.nombre_completo) AGAINST ('$search') and MATCH (h.nombre_completo) AGAINST ('$search') >0
		and (select rut from tbl_data_bci_2021 where rut=h.rut)>0
		limit 30
		";
	
	
	$connexion->query($sql);
	
	$datos = $connexion->resultset();
	return $datos;
}
function BuscaPersonas2020_SucesorLider($search){

    $connexion = new DatabasePDO();
    $search=($search);

    $sql="
		SELECT h.*, (select rut from tbl_data_bci_2021 where rut=h.rut) as databci,
    MATCH (h.nombre_completo) AGAINST ('$search') AS relevance
    FROM tbl_usuario h
    WHERE h.vigencia='0' and  MATCH (h.nombre_completo) AGAINST ('$search') and MATCH (h.nombre_completo) AGAINST ('$search') >0
		and (select rut from tbl_data_bci_2021 where rut=h.rut)>0
		limit 30
		";


    $connexion->query($sql);

    $datos = $connexion->resultset();
    return $datos;
}
function PotencialSucesion_Vista_Colaboradores_Posicion($id_comite, $rut, $id_empresa, $tipo, $posicion){
	
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_r2  
	      				where posicion='$posicion' and id_comite='$id_comite' and id_empresa='$id_empresa' and tipo_sucesion='$tipo'";     

 $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_r2  
	      				where posicion='$posicion' and id_empresa='$id_empresa' and tipo_sucesion='$tipo'";  								
				//echo "<br><br>".$sql."<br><br>";
	  
	      $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);			
	
	
}
function PotencialSucesion_Vista_Colaboradores($id_comite, $rut, $id_empresa, $tipo){
	
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select * 
	      				from tbl_potencial_sucesion_colaboradores_propuestos_r2  
	      				where rut='$rut' and id_comite='$id_comite' and id_empresa='$id_empresa' and tipo_sucesion='$tipo'";     
		  
	      $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);			
	
	
}
function BuscaPersonas2020($search){

	$connexion = new DatabasePDO();
	

	//$sql = "SELECT * FROM tbl_usuario WHERE nombre_completo like'%".$search."%'";
	$sql="SELECT tbl_usuario.*,
       MATCH (nombre_completo) AGAINST ('$search') AS relevance
    FROM tbl_usuario
    WHERE vigencia='0' and  MATCH (nombre_completo) AGAINST ('$search') and MATCH (nombre_completo) AGAINST ('$search') >0";
	
	//echo $sql;
	
	$connexion->query($sql);
		
	$datos = $connexion->resultset();

	return $datos;

}
function Potencial_Sucesion_Insert($id_comite, $rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
		$Usua=DatosUsuario_($rut, $id_empresa);
		$jefe=$Usua[0]->jefe;

    $sql   = "insert into tbl_potencial_sucesion_comites_colaboradores (id_comite, rut, id_empresa)
        VALUES
        ('$id_comite','$rut', '$id_empresa');";

    $connexion->query($sql);
    $connexion->execute();
}
function Potencial_Sucesion_Colaboradores_Comites_data($id_comite, $rut, $perfil, $id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

//echo "perfil $perfil";

//if($perfil=="SOCIO DE NEGOCIO") {$query=" and (select rut from tbl_potencial_comites where id_comite='$id_comite')='$rut' ";}
if($perfil=="SOCIO DE NEGOCIO") 			{}
if($perfil=="LIDER")            			{$query=" and h.rut='$rut' ";}
if($perfil=="VISUALIZADOR")           {$query=" and (
	
																								rut_jefe_socio='$rut' or 
																								rut_jefe_jefe_socio='$rut' or 
																								rut_jefe_lider='$rut' or 
																								rut_jefe_jefe_lider='$rut')

";}

if($perfil=="USUARIO")          {exit();}
     $sql   = "

     select h.*,
     (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo,
     (select nombre_completo    from tbl_usuario            where rut=h.rut_lider)                as nombre_lider,
     (select d6   from tbl_data_bci_2021            where rut=h.rut)                				as cargo_col

     from tbl_potencial_sucesion_comites_colaboradores h

     where h.id>0 $query and h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
     and (select nombre_completo    from tbl_usuario            where rut=h.rut)<>''
     
     order by (select nombre_completo    from tbl_usuario            where rut=h.rut) ASC

     ";
     //and h.posicion='GERENTE CUMPLIMIENTO CORPORATIVO Y PREVENCION'
        
       // echo "<br><br><br><br><br><br><br><br><br><br><br><br>sql<br> $sql";
        
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Sucesion_Comites_data($id_comite,$id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     select h.*,
     (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo

     from tbl_potencial_comites_sucesion h

     where h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
     order by (select nombre_completo    from tbl_usuario   where rut=h.rut) ASC

     ";
        //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Sucesion_Truncate($id_comite){
	
	
	       $connexion = new DatabasePDO();
        
        
        $sql="delete from tbl_potencial_sucesion_comites_colaboradores where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;
	
}
function PotencialSucesion_BuscaR2_old($rut_R1, $id_empresa){
         $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
     		$sql   = 
     		
     		"
     		
        select h.*,
				(select d1 from tbl_data_bci_2021 where rut='$rut_R1') as rut_completo_r1,
				(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1')) as dep

				from tbl_data_bci_2021 h

				where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1')
				and
				(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0
				group by h.d145
     		";
     		
     		$sql="
     		
select h.*, (select d1 from tbl_data_bci_2021 where rut='$rut_R1') as rut_completo_r1,
(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci where rut='$rut_R1')) as dep 
from tbl_data_bci_2021 h 
where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1') 
and (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0 
group by h.d6
     		
     		";
     		
     		//echo $sql;
     		//exit();
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;
}
function PotencialSucesion_BuscaR2($rut_R1, $id_empresa){
    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");
    $sql   =

        "
     		
        select h.*,
				(select d1 from tbl_data_bci_2021 where rut='$rut_R1') as rut_completo_r1,
				(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1')) as dep

				from tbl_data_bci_2021 h

				where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1')
				and
				(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0
				group by h.d6
     		";
    //echo $sql;
    //exit();
    $sql="
     		
select h.*, (select d1 from tbl_data_bci_2021 where rut='$rut_R1') as rut_completo_r1,
(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci where rut='$rut_R1')) as dep 
from tbl_data_bci_2021 h 
where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1') 
and (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0 
group by h.d6
     		
     		";

    //echo $sql;
    //exit();
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Sucesion_d145_databci($rut){
        $connexion = new DatabasePDO();
        $fecha = date("Y-m-d");
		/*$sql="select d6 from tbl_data_bci_2021 where rut='$rut'";*/
        $sql="select d6 from tbl_data_bci_2021 where rut='$rut'";
        $connexion->query($sql);
        $cod = $connexion->resultset();
        return ($cod[0]->d6);
}
function Potencial_Sucesion_d6_d5($rut){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql="select d5,d6 from tbl_data_bci_2021 where rut='$rut'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_Sucesion_Mis_Comites_data($id_empresa, $rut, $perfil){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
      
      	$sql_jefe="select d12 from tbl_data_bci_2021 where rut='$rut'";
        $connexion->query($sql_jefe);
                  	
				$cod_jefe = $connexion->resultset();      
      	
      	$rut_jefe=LimpiaRutFront($cod_jefe[0]->d12);
		    //echo "<br>--> Mi Jefe $rut_jefe";
				if($perfil=="SUPER USER"){

                $sql="   
				   select 

							h.*,
							(select d1 from tbl_data_bci_2021 where rut='$rut') as rut_completo,
							(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1) as rut_completo_r1,
							(select rut from tbl_data_bci_2021 where rut='$rut' and d12=(select d1 from tbl_data_bci_2021 where rut=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1))) as rut_dependiente,
							(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1)) as dep

							from tbl_potencial_comites_sucesion h

							where 
							
							 h.id_empresa='62'
							";
					
				} else {
					
				
				 $sql="   
				   select 

							h.*,
							(select d1 from tbl_data_bci_2021 where rut='$rut') as rut_completo,
							(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1) as rut_completo_r1,
							(select rut from tbl_data_bci_2021 where rut='$rut' and d12=(select d1 from tbl_data_bci_2021 where rut=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1))) as rut_dependiente,
							(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1)) as dep,							
							(select d12 from tbl_data_bci_2021 where rut=h.rut) as jefe_creador,
							(select d12 from tbl_data_bci_2021 where rut='$rut') as mi_jefe
							

							from tbl_potencial_comites_sucesion h

							where 
								 (
								h.rut='$rut' or
								h.gerenciaR1='$rut'
								or h.rut_socio_2='$rut'
								or h.rut_socio_3='$rut'
								or h.rut_socio_4='$rut'
								or((select rut from tbl_data_bci_2021 where rut='$rut' and d12=(select d1 from tbl_data_bci_2021 where rut=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1)))
								and 
									(select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.gerenciaR1))>0
								)
								    or (select d12 from tbl_data_bci_2021 where rut=h.rut)=(select d12 from tbl_data_bci_2021 where rut='$rut') 
							)
							
							and h.id_empresa='62'
							";

						}
						
			    foreach ($cod as $key => $row) {
			        $aux[$key] = $row->fecha_comite;
			    }
			    //echo "<br>AUX<br>";
			    //print_r($aux);
			    //echo "<br>FIn AUX<br>";
			    array_multisort($aux, SORT_DESC, $cod);
							
				//echo "<h3>Potencial Sucesion <br>".$sql."</h3>";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Pontencial_Busca_Snes($rut_col, $id_empresa)  {
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select * from tbl_potencial_snes  where rut='$rut_col' order by year DESC";     
		  
	      $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);		
}
function Pontencial_Busca_Met_Tri($rut_col, $id_empresa)  {
	
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select * from tbl_potencial_met_tri  where rut='$rut_col' order by year DESC";     
		  
	       $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);		
	
	
}
function TraigoDependenciaDadoGerenciaFondo($gerencia, $fondo){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select distinct(d34) as dato from tbl_data_bci  where d30='$gerencia' and d32='$fondo'
		  ";     
		  
       $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);			
}
function TraigoDependenciaDadoGerenciaFondo_2021($gerencia, $fondo){
    $connexion = new DatabasePDO();
    
    
    $sql=" 	select distinct(d35) as dato from tbl_data_bci_2021  where d31='$gerencia' and d33='$fondo'
		  ";

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function TraigoDependencia($gerencia){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select distinct(d34) as dato from tbl_data_bci  where d30='$gerencia' 
		  ";     
       $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);			
}
function TraigoDependencia_2021($gerencia){
    $connexion = new DatabasePDO();
    
    
    $sql=" 	select distinct(d35) as dato from tbl_data_bci_2021  where d31='$gerencia' 
		  ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function TraigoFondo($gerencia){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select distinct(d32) as dato from tbl_data_bci  where d30='$gerencia' 
		  ";     
       $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);			
}
function TraigoFondo_2021($gerencia){
    $connexion = new DatabasePDO();
    
    
    $sql=" 	select distinct(d33) as dato from tbl_data_bci_2021  where d31='$gerencia' 
		  ";
    echo "traifondo ".$sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function Potencial_Sucesion_Num_Sucesores($rut){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select count(id) as cuenta from tbl_potencial_sucesion_colaboradores_propuestos_r2 where rut_col='$rut' ";     
	      //echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return $cod[0]->cuenta;		
}
function Potencial_Check_Mapeado_oAnterior($rut){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select cuadrante_2020 from tbl_potencial_cuadrantes where rut='$rut' order by id DESC limit 1";     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return $cod[0]->cuadrante_2020;		
}
function CheckMapeadoCerrado($rut){
	      $connexion = new DatabasePDO();
        
        	
        $periodo=date("Y");
				$sql=" select 
				h.* 
				from tbl_potencial_cuadrantes h 
				where h.rut='$rut' and h.cerrado is NULL ";
				//echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        if(count($cod)>0){
        	//echo "<br>Analizando ".$rut;
  				$sql2=" 
			  			select h.* , 
							(select comite_cerrado from tbl_potencial_comites where id_comite=h.id_comite) as estado
							from tbl_potencial_comites_colaboradores h 
							where h.rut='$rut' and h.id_empresa='62'
							and 
							(select comite_cerrado from tbl_potencial_comites where id_comite=h.id_comite) ='SI'";      	
					//echo ".-".$sql2;
          $connexion->query($sql2);
        	      	
        	$cod2 = $connexion->resultset();	
        	if(count($cod2)>0)	{
        		$sql3="update tbl_potencial_cuadrantes set cerrado='1' where rut='$rut' ";
            $connexion->query($sql3);
                $connexion->execute();
        		           		
        	}
        }
}
function Potencial_Check_Mapeado($rut){
	      $connexion = new DatabasePDO();
        
        
        $periodo=date("Y");
	      $sql=" 	select cuadrante_2020 from tbl_potencial_cuadrantes where rut='$rut' and cerrado='1' order by id DESC limit 1";     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return $cod[0]->cuadrante_2020;		
}
function Potencial_Check_Mapeado_Cerrado($rut){
	      $connexion = new DatabasePDO();
        
        
        $periodo=date("Y");
	      $sql=" 	select id from tbl_potencial_cuadrantes where rut='$rut' and cerrado='1'  order by id DESC limit 1";   
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return $cod[0]->id;		
}
function Potencial_BuscaUltimoComitedeRut($rut){
	
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select h.id_comite, (select comite_cerrado from tbl_potencial_comites where id_comite=h.id_comite) as cerrado from tbl_potencial_comites_colaboradores h where h.rut='$rut' order by h.id DESC limit 1";   
	     // echo "<br>".$sql."<br>";  
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
       
				return $cod[0]->cerrado;			
	
	
	
}
function Potencial_Genero($rut){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select d54 as genero from tbl_data_bci where rut='$rut'";     
	      //echo $sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return $cod[0]->genero;		
}
function Potencial_Data_Bci_groupby($field){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" select $field as dato from tbl_data_bci group by $field order by $field ";
        $connexion->query($sql);
        $cod = $connexion->resultset();	
				return ($cod);
}

function Potencial_Data_Bci_2021_groupby($field){
   /* $connexion = new DatabasePDO();
    $sql=" 	select $field as dato from tbl_data_bci_2021 group by $field order by $field ";
    $connexion->query($sql);
    echo $sql;exit();
    $cod = $connexion->resultset();
    return ($cod);*/
}
function Potencial_Es_SuperUsers($rut){
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select id from tbl_potencial_perfil_super where rut='$rut' and rut<>'17810781' ";     
	      
	      
				//echo "<br>sql<br>".$sql."<br>";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod[0]->id);		
}
function Potencial_Es_Socio($rut) {
	      $connexion = new DatabasePDO();
        
        
	      $sql=" 	select id from tbl_potencial_perfil where rut='$rut' ";     
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod[0]->id);			
}
function Potencial_Busca_Nombre_Lider($rut_col,$id_comite_enc){
	
	      $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");	
        $id_comite=Decodear3($id_comite_enc);
	//echo "<br>Potencial_Busca_Nombre_Lider<br>$rut_col,$id_comite";
	        $sql="
        
        select h.rut_lider, (select d7 from tbl_data_bci where rut=h.rut_lider) as nombre, (select d8 from tbl_data_bci where rut=h.rut_lider) as apellido
 from tbl_potencial_comites_colaboradores h where h.rut='$rut_col' and h.id_comite='$id_comite'

        
        ";
        
                $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        $nombre=$cod[0]->nombre." ".$cod[0]->apellido;
				return ($nombre);	
	
}
function Potencial_Busca_Rut_Lider($rut_col,$id_comite_enc){
	
	       $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");	
        $id_comite=Decodear3($id_comite_enc);
	//echo "<br>Potencial_Busca_Nombre_Lider<br>$rut_col,$id_comite";
	        $sql="
        
        select h.rut_lider
 				from tbl_potencial_comites_colaboradores h where h.rut='$rut_col' and h.id_comite='$id_comite'

        
        ";
        
                $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        $rut_lider=$cod[0]->rut_lider;
				return ($rut_lider);	
	
}
function Pot_CheckPosicion_Clave($rut) {
	
	       $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
        
        /*$sql=" select h.id, h.posicion_clave, (select d6 from tbl_data_bci_2021 where rut='$rut') from tbl_potencial_posicion_clave h   where
				(select d6 from tbl_data_bci_2021 where rut='$rut') = h.posicion_clave ";*/
    $sql=" select h.id, h.posicion_clave, (select d6 from tbl_data_bci_2021 where rut='$rut') from tbl_potencial_posicion_clave h where
				(select d6 from tbl_data_bci_2021 where rut='$rut') = h.posicion_clave ";
        
$connexion->query($sql);
$cod = $connexion->resultset();
return ($cod[0]->id);

}
function Pot_Check_Es_Sucesor($rut) {
	
	       $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
        
        $sql="
        
        	select count(id) as cuenta
        	from
         tbl_potencial_sucesion_colaboradores_propuestos_r2 h
         where
					h.rut_col='$rut' and h.id_comite is null
        and h.id_empresa='62'

UNION 

         select count(id) as cuenta
        	from
         tbl_potencial_sucesion_colaboradores_propuestos_r2 h
         where
					h.rut_col='$rut' and h.id_comite is not null 
					and (select comite_cerrado from tbl_potencial_comites_sucesion where id_comite=h.id_comite)='SI'
        and h.id_empresa='62'   
        ";
        
        $connexion->query($sql);
        
        $cod = $connexion->resultset();	
        foreach ( $cod as $unico){
        	$cuenta=$unico->cuenta+$cuenta;
        }
				return ($cuenta);	

}
function Pot_Full_Es_Sucesor($rut) {
	
	       $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
        
        $sql="
        
	select *
        	from
         tbl_potencial_sucesion_colaboradores_propuestos_r2 h
         where
					h.rut_col='$rut' and h.id_comite is null
        and h.id_empresa='62'

UNION 
select
         *
        	from
         tbl_potencial_sucesion_colaboradores_propuestos_r2 h
         where
					h.rut_col='$rut' and h.id_comite is not null 
					and (select comite_cerrado from tbl_potencial_comites_sucesion where id_comite=h.id_comite)='SI'
        and h.id_empresa='62'   
					
        
        ";
        //and id_empresa='62'
                $connexion->query($sql);
        
        $cod = $connexion->resultset();	
				return ($cod);	

}
function Potencial_Busca_Array_reporte($filtro){
	
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="	
				
						select 
						h.rut,
						h.d1 as rut_completo, 
						h.d7 as nombre, 
						h.d8 as paterno, 
						h.d9 as materno, 
						h.d30  as gerencia,
						h.d32  as fondo,
						h.d34  as dependencia,
						h.d103  as cuadrante_actual,
						h.d104  as fecha_actual,
						h.d145 as puesto,
						h.cuadrante_2020,
						h.fecha_cuadrante_2020,
						h.Comentario1,
						h.Comentario2,
						h.Comentario3,
						h.Comentario4,
						h.Comentario5,
						h.Comentario6

						from tbl_data_bci_full h	
						
						$filtro
				";
		   


       $sql_1="
                        select
                    
                        h.rut,
                        h.fecha_cuadrante_2020 as fecha_actual,
                        h.cuadrante_2020 as cuadrante_actual,

						t.d1 as rut_completo,
						t.d7 as nombre,
						t.d8 as paterno,
						t.d9 as materno,
						t.d31  as gerencia,
						t.d33  as fondo,
						t.d35  as dependencia,
						(select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 0,1) as Comentario1,
                        (select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 1,1) as Comentario2,
                        (select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 2,1) as Comentario3,
                        (select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 3,1) as Comentario4,
                        (select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 4,1) as Comentario5,
                        (select comentario FROM tbl_potencial_bitacora where rut_colaborador=h.rut order by id DESC limit 5,1) as Comentario6

                        from tbl_potencial_cuadrantes h
                        
                        left join tbl_data_bci_2021 t on h.rut = t.rut
                        
                        where t.d1<>''
                                        $filtro
                                
                               
                               ";
                        
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
        

			 return ($cod_1);		
	
}
function Potencial_ActualizaJefedeJefe($id_comite, $rut_lider){
	
//	echo "<br>Potencial_ActualizaJefedeJefe<br>$id_comite, $rut_lider";
	
	      $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="	select rut  from tbl_potencial_comites h where id_comite='$id_comite' ";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
	
				//print_r($cod_1);
				//echo "<br>rut socio ".$cod_1[0]->rut;
				//echo "<br>rut lider ".$rut_lider;
	
				$rut_jefe_socio=PotencialBuscaJefetbl_data_bci($cod_1[0]->rut);
				$rut_jefe_jefe_socio=PotencialBuscaJefetbl_data_bci($rut_jefe_socio);
	
				$rut_jefe_lider=PotencialBuscaJefetbl_data_bci($rut_lider);
				$rut_jefe_jefe_lider=PotencialBuscaJefetbl_data_bci($rut_jefe_lider);
	
//	echo "<br>	rut_jefe_socio $rut_jefe_socio	, rut_jefe_jefe_socio $rut_jefe_jefe_socio
//				<br>  rut_jefe_lider $rut_jefe_lider	, rut_jefe_jefe_lider $rut_jefe_jefe_lider";
	
			    $sql   = "update tbl_potencial_comites_colaboradores set rut_jefe_socio='$rut_jefe_socio', rut_jefe_jefe_socio='$rut_jefe_jefe_socio' where id_comite='$id_comite'";
    			$connexion->query($sql);
                $connexion->execute();
    			
			    $sql   = "update tbl_potencial_comites_colaboradores set rut_jefe_lider='$rut_jefe_lider', rut_jefe_jefe_lider='$rut_jefe_jefe_lider' where rut_lider='$rut_lider'";
    			$connexion->query($sql);
                $connexion->execute();
	
	
	
}
function PotencialBuscaJefetbl_data_bci($rut){
	
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="	select d12 as jefe from tbl_data_bci where rut='$rut' ";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
        
        $jefe       = LimpiaRutFront($cod_1[0]->jefe);
        
				return ($jefe);		
	
}
function Potencial_BuscaLineasSinJefedeJefe($id_empresa){
	
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="	select h.* from tbl_potencial_comites_colaboradores h where h.rut_jefe_socio is NULL and h.id_empresa='$id_empresa' group by h.rut_lider, h.id_comite ";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
				return ($cod_1);	
	
}
function Potencial_EliminaBitacora($id) {

        $connexion = new DatabasePDO();
        
        
        $sql="delete from tbl_potencial_bitacora where id='$id' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_PromedioBanco($rut){
				//$rut="18393769";

	      $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="select * from tbl_potencial_tipo_perfil where rut='$rut' limit 1";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
        $tipo_perfil	=		$cod_1[0]->tipo_perfil;
        
        //echo "select * from tbl_potencial_tipo_perfil where rut='$rut' limit 1 $tipo_perfil " ;
        
 				$sql_2="select * from tbl_potencial_tipo_perfil_dato where tipoperfil='$tipo_perfil'";
        $connexion->query($sql_2);
        
        $cod_2 = $connexion->resultset();       
        $i=0;
        foreach ($cod_2 as $unico){
        	$arreglo[$i]=$unico->dato;
        	$i++;
        }
        //print_r($arreglo);
        
				return ($arreglo);	
	
}
function Potencial_Colaboradores_Matriz_tbl_potencial_cuadrantes_data($id_empresa, $rut_col){

    //echo "<br>Potencial_Colaboradores_Matriz_tbl_potencial_cuadrantes_data($id_empresa, $rut_col)";
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$sql_1="select h.* , 
                            (select cuadrante_anterior from tbl_potencial_cuadrantes_api where rut=h.rut) as cuadrante_anterior,
                            (select d105 from tbl_data_bci_2020 where rut=h.rut) as anterior_2020
       
       
				from tbl_potencial_cuadrantes h where h.rut='$rut_col'";

       // echo "<br><br>Query 1 ".$sql_1;
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();
        //print_r($cod_1);        exit();
        if($cod_1[0]->cuadrante_anterior==""){
            $cod_1[0]->cuadrante_anterior=$cod_1[0]->anterior_2020;
        }


                if($cod_1[0]->cuadrante_2020<>"" ){
                    return ($cod_1);
                } else {


                    $sql_1="select h.* , 
                        (select d105 from tbl_data_bci_2020 where rut=h.rut) as cuadrante_anterior,
                        
                        (select d103 from tbl_data_bci_2020 where rut=h.rut) as cuadrante_actual_2020,
                        (select d104 from tbl_data_bci_2020 where rut=h.rut) as fecha_cuadrante_actual_2020
       
				from tbl_potencial_cuadrantes h where h.rut='$rut_col'";
                    $connexion->query($sql_1);
                    

                    //echo "<br><br>Query 2 ".$sql_1;

                    $cod_1 = $connexion->resultset();
                    $cod_1[0]->cuadrante_2020=$cod_1[0]->cuadrante_actual_2020;
                    $cod_1[0]->fecha_cuadrante_2020=$cod_1[0]->fecha_cuadrante_actual_2020;

                    return ($cod_1);
                }
}
function Potencial_Colaboradores_Matriz_tbl_potencial_api_data($rut_col){
	
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
        
        
        
				$sql_1="select * from tbl_potencial_cuadrantes_api where rut='$rut_col'";
				echo "<br>$sql_1";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
				return ($cod_1);	
	
}
function Potencial_comite_update_tbl_data_bci_socio($nuevo_cuadrante,$comentario, $id_comite,  $rut, $id, $id_empresa , $perfil, $rut_col){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    if($perfil=="SOCIO DE NEGOCIO")     {   $query=" set cuadrante_2020='$nuevo_cuadrante', fecha_cuadrante_2020='$fecha' ";}
    if($perfil=="LIDER")     {   $query=" set cuadrante_2020='$nuevo_cuadrante', fecha_cuadrante_2020='$fecha' ";}
    //if($perfil=="LIDER")     {   $query=" set propuesta_lider='$nuevo_cuadrante' ";}
    $comentario=($comentario);

    $sql   = "update tbl_potencial_cuadrantes
    $query
    where rut='$rut_col'";
    $connexion->query($sql);
    $connexion->execute();
    
    //echo "<br>sql $sql";
    
    
    
     //$sql   = "     select h.rut from tbl_potencial_matriz h where h.id='$id' and h.id_empresa='$id_empresa' limit 1     ";
    //echo "<br>sql $sql";
        //$connexion->query($sql);
       // 
       // $cod = $connexion->resultset();
        //$rut_col    =   $cod[0]->rut;

     $sql   = "
     select count(id) as cuenta from tbl_potencial_bitacora h where h.rut='$rut' and rut_colaborador='$rut_col'
     and box_propuesto='$nuevo_cuadrante' and comentario='$comentario' and h.id_empresa='$id_empresa' limit 1
     ";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $cuenta    =   $cod[0]->cuenta;
        if($cuenta==0){
    $sql   = "insert into tbl_potencial_bitacora
        (rut,   perfil, id_comite,   rut_colaborador,comentario,  box_propuesto,fecha,hora, id_empresa)
        VALUES
        ('$rut','$perfil', '$id_comite','$rut_col',    '$comentario','$nuevo_cuadrante','$fecha','$hora','$id_empresa');";
     }
    //echo "<br>sql $sql";
    $connexion->query($sql);
    $connexion->execute();


}
function Potencial_comite_update_tbl_data_bci_lider($nuevo_cuadrante,$comentario, $id_comite,  $rut, $id, $id_empresa , $perfil, $rut_col){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
		    $fecha = date("Y-m-d");
    		$hora  = date("H:i:s");
    
    		$query=" set cuadrante_2020_lider='$nuevo_cuadrante', fecha_cuadrante_2020_lider='$fecha' ";
    		$comentario=($comentario);

    $sql   = "update tbl_potencial_cuadrantes
    $query
    where rut='$rut_col'";
    $connexion->query($sql);
    $connexion->execute();
    //echo "<br>sql $sql";
    
    //echo "<br>sql $sql";
    
     //$sql   = "     select h.rut from tbl_potencial_matriz h where h.id='$id' and h.id_empresa='$id_empresa' limit 1     ";
    //echo "<br>sql $sql";
        //$connexion->query($sql);
       // 
       // $cod = $connexion->resultset();
        //$rut_col    =   $cod[0]->rut;

     $sql   = "
     select count(id) as cuenta from tbl_potencial_bitacora h where h.rut='$rut' and rut_colaborador='$rut_col'
     and box_propuesto='$nuevo_cuadrante' and comentario='$comentario' and h.id_empresa='$id_empresa' limit 1
     ";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $cuenta    =   $cod[0]->cuenta;
        if($cuenta==0){
    $sql   = "insert into tbl_potencial_bitacora
        (rut,   perfil, id_comite,   rut_colaborador,comentario,  box_propuesto,fecha,hora, id_empresa)
        VALUES
        ('$rut','$perfil', '$id_comite','$rut_col',    '$comentario','$nuevo_cuadrante','$fecha','$hora','$id_empresa');";
     }
    
    $connexion->query($sql);
    $connexion->execute();


}
function Potencial_Cuadrantes_Data($rut){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");


				$sql_1="select h.*, (select cuadrante_anterior from tbl_potencial_cuadrantes_api where rut=h.rut) as cuadrante_anterior from 
                        tbl_potencial_cuadrantes h where h.rut='$rut'";
        $connexion->query($sql_1);
        
        $cod_1 = $connexion->resultset();	
				return ($cod_1);
}
function Potencial_Update_data_tbl_bci($promedio_metas,$promedio_competencias,$box_propuesta,$rut, $cerrado){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
				$periodo=date("Y");
				$sql_1="select * from tbl_potencial_cuadrantes where rut='$rut'";
        $connexion->query($sql_1);
        
        
        $cod_1 = $connexion->resultset();
        
        if($cod_1[0]->id>0){
         $sql   = "update tbl_potencial_cuadrantes
								    set promedio_metas_2020='$promedio_metas',
								    promedio_competencias_2020='$promedio_competencias',
								    propuesta_cuadrante_2020='$box_propuesta', cerrado='$cerrado'
    							where rut='$rut' ";   	
        } else {
      $sql   = "	insert into tbl_potencial_cuadrantes
					        (rut, promedio_metas_2020, promedio_competencias_2020, propuesta_cuadrante_2020, cerrado)
					        VALUES
					        ('$rut','$promedio_metas','$promedio_competencias','$box_propuesta','$cerrado');";
        }
			$connexion->query($sql);
    $connexion->execute();

   if($cod_1[0]->fecha_propuesta_cuadrante_2020==""){
   	 $hoy   = date('Y-m-d');
   	
				   	 $sql   = "update tbl_potencial_cuadrantes
				   						 set fecha_propuesta_cuadrante_2020='$hoy', cerrado='$cerrado'
									    where rut='$rut'";  
    	$connexion->query($sql);
       $connexion->execute();
   }
        $connexion->query($sql);
    $connexion->execute();
       // echo "<h1>sql<BR>$sql<br></h1>";
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Colaboradores_Matriz_tbl_data_bci_data($id_empresa, $rut){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     				select h.* from tbl_data_bci h where h.rut='$rut' 

     ";
        //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Colaboradores_Matriz_tbl_data_bci_2021_data($id_empresa, $rut){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     				select h.* from tbl_data_bci_2021 h where h.rut='$rut' 

     ";
        //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Colaboradores_Matriz_Fields_tbl_data_bci_data($rut){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     				select h.rut,
     				
     				h.d133 as resultado_desempeno, 
     				h.d59 as meta_2016,
     				h.d60 as meta_2017,
     				h.d61 as meta_2018,
     				h.d62 as meta_2015,
     				h.d63 as meta_2019,
     				
     				h.d132 as competencia_2019,
     				h.d98 as competencia_miscolaboradores_2018,
     				
     				h.d103 as cuadrante_actual,
     				h.d104 as fecha_cuadrante_actual,
     				
     				h.d105 as cuadrante_anterior,
     				h.d106 as meses_cuadrante_anterior,
     				
     				h.d127 as d127,
     				h.d128 as d128,
     				h.d129 as d129,
     				h.d130 as d130,
     			
     				
     				h.d79 as d79,
     				h.d80 as d80,
     				h.d77 as d77,
     				
     				h.d87 as d87,
     				h.d77 as d77
     				
     				
     				
     				
     				
     				from tbl_data_bci h where h.rut='$rut' 

     ";
      //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Update_Cierre_Comite($id_comite) {

        $connexion = new DatabasePDO();
        
        
        $hoy   = date('Y-m-d');
        $sql="update tbl_potencial_comites set comite_cerrado='SI', fecha_cerrado='$hoy' where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_Sucesion_Update_Cierre_Comite($id_comite) {

        $connexion = new DatabasePDO();
        
        
        $hoy   = date('Y-m-d');
        $sql="update tbl_potencial_comites_sucesion set comite_cerrado='SI', fecha_cerrado='$hoy' where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_EliminaComite($id_comite) {

        $connexion = new DatabasePDO();
        
        
        $sql="update tbl_potencial_comites set id_empresa='99' where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_EliminaComite_Sucesion($id_comite) {

        $connexion = new DatabasePDO();
        
        
        $sql="update tbl_potencial_comites_sucesion set id_empresa='99' where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_Mis_Comites_insert_Nuevo_Comite_data($nombre, $rut, $fecha_comite, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $nombre =   ($nombre);
        $sql   = " select max(id) as id_max from tbl_potencial_comites order by id DESC limit 1 ";
        $connexion->query($sql);

        $cod = $connexion->resultset();
        
       // print_r($cod); exit();
        $id_antiguo=$cod[0]->id_max;
        $id_nuevo=  $id_antiguo+1;
        
        $id_comite="pot_".$rut_lider."_".$id_nuevo;

    		$sql   = "insert into tbl_potencial_comites
        (nombre, descripcion, rut, fecha_comite, fecha, hora, id_empresa, id_comite, rut_lider, nombre_lider)
        VALUES
        ('$nombre','$descripcion','$rut','$fecha_comite','$fecha','$hora', '$id_empresa',
         '$id_comite','$rut_lider','$nombre_lider');";
        //echo $sql; exit();exit();
    $connexion->query($sql);
    $connexion->execute();
}

function Potencial_Perfil_Usuarios($rut, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     		$sql   = " select h.id from tbl_potencial_perfil h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
     		$sql1   = " select h.id from tbl_potencial_comites_colaboradores h where h.rut_lider='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql1 $sql1"; 
        $connexion->query($sql1);
        
        $cod1 = $connexion->resultset();


     		$sql2   = " select h.id from tbl_potencial_comites_colaboradores h where 
     		(h.rut_jefe_socio='$rut' or h.rut_jefe_jefe_socio='$rut' or h.rut_jefe_lider='$rut' or h.rut_jefe_jefe_lider='$rut')
     		 and h.id_empresa='$id_empresa'  limit 1";
     		//echo $sql2;
     		//exit();
        $connexion->query($sql2);
        
        $cod2 = $connexion->resultset();
       
        //echo "<br>cod1[0]->id>0 lider ".$cod1[0]->id." and cod[0]->id>0 ".$cod[0]->id."";

				if($cod2[0]->id>0){
					$perfil="VISUALIZADOR";
				}

				if($cod1[0]->id>0 and $cod[0]->id>0){
        	$perfil="SOCIO DE NEGOCIO";
        }

				if($cod1[0]->id==0 and $cod[0]->id>0){
        	$perfil="SOCIO DE NEGOCIO";
        }
        
        if($cod1[0]->id>0 and $cod[0]->id==0){
        	$perfil="LIDER";
        }
    
         if($cod1[0]->id==0 and $cod[0]->id==0 and $cod2[0]->id==0){
        	$perfil="";
        }    
        
        if($perfil==""){
        	
        	//check 
        $sqlSU   = " select h.id from tbl_potencial_perfil_super h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql $sql"; 
        $connexion->query($sqlSU);
        
        $codSU = $connexion->resultset();
        	if($codSU[0]->id > 0){
        		$perfil="SUPER USER";
        	}
        	
        }
        
        //echo "perfil $perfil"; exit();
  
  			//vista socio 2 y 3
         if($perfil==""){

        $sqlSOc_2_3   = " select h.id from tbl_potencial_comites h where (h.rut='$rut' or h.rut_socio_2='$rut' or h.rut_socio_3='$rut' or h.rut_socio_4='$rut') 
        and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql $sql"; 
        $connexion->query($sqlSOc_2_3);
        
        $codSOc_2_3 = $connexion->resultset();
        	if($codSOc_2_3[0]->id > 0){
        		$perfil="SOCIO DE NEGOCIO";
        	}         	
         	
         	
        } 			
        
        return $perfil;
}
function Potencial_Perfil_Sucesion_Usuarios($rut, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     		$sql   = " select h.id from tbl_potencial_perfil h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        
     		$sql1   = " select h.id from tbl_potencial_sucesion_comites_colaboradores h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql1 $sql1"; 
        $connexion->query($sql1);
        
        $cod1 = $connexion->resultset();


     		$sql2   = " select h.id from tbl_potencial_sucesion_comites_colaboradores h where 
     		(h.rut_jefe_socio='$rut' or h.rut_jefe_jefe_socio='$rut' or h.rut_jefe_lider='$rut' or h.rut_jefe_jefe_lider='$rut')
     		 and h.id_empresa='$id_empresa'  limit 1";
     		//echo $sql2;
     		//exit();
        $connexion->query($sql2);
        
        $cod2 = $connexion->resultset();
       
        //echo "<br>cod1[0]->id>0 lider ".$cod1[0]->id." and cod[0]->id>0 ".$cod[0]->id."";

				if($cod2[0]->id>0){
					$perfil="VISUALIZADOR";
				}

				if($cod1[0]->id>0 and $cod[0]->id>0){
        	$perfil="SOCIO DE NEGOCIO";
        }

				if($cod1[0]->id==0 and $cod[0]->id>0){
        	$perfil="SOCIO DE NEGOCIO";
        }
        
        if($cod1[0]->id>0 and $cod[0]->id==0){
        	$perfil="LIDER";
        }
    
         if($cod1[0]->id==0 and $cod[0]->id==0 and $cod2[0]->id==0){
        	$perfil="";
        }    
        
        //if($perfil==""){
        	//check 
        $sqlSU   = " select h.id from tbl_potencial_perfil_super h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql tbl_potencial_perfil_super <br> $sql <br>"; 
        $connexion->query($sqlSU);
        
        $codSU = $connexion->resultset();
        	if($codSU[0]->id > 0){
        		$perfil="SUPER USER";
        	}
        	
        //}
        
        //echo "perfil $perfil"; exit();
  
  			//vista socio 2 y 3
         if($perfil==""){

        $sqlSOc_2_3   = " select h.id from tbl_potencial_comites_sucesion h where (h.rut='$rut' or h.gerenciaR1='$rut' or h.rut_socio_2='$rut' or h.rut_socio_3='$rut' or h.rut_socio_4='$rut') 
        and h.id_empresa='$id_empresa'  limit 1";
        //echo "<br>sql $sql"; 
        $connexion->query($sqlSOc_2_3);
        
        $codSOc_2_3 = $connexion->resultset();
        	if($codSOc_2_3[0]->id > 0){
        		$perfil="SOCIO DE NEGOCIO";
        	}         	
         	
         	
        } 			
        
        return $perfil;
}
function Pot_Check_Usr_No_mapeables($rut_col){
	
	       $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");


     $sql   = "

    	select rut from tbl_data_bci
	    where rut='$rut_col' and d30='GERENCIA CORPORATIVA GESTION PERSONAS'

			limit 1
     ";
      //echo "<br>sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod[0]->rut);
	
	
}
function Potencial_Bitacora_Comites_data($id_comite, $rut, $perfil, $id_empresa){
         $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
if($perfil=="SOCIO DE NEGOCIO") {$query=" and (select rut from tbl_potencial_comites where id_comite='$id_comite')='$rut' ";}
if($perfil=="LIDER")            {$query="and  (select rut_lider from tbl_potencial_comites_colaboradores where id_comite='$id_comite' and rut=h.rut_colaborador)
='$rut' ";}
if($perfil=="USUARIO")          {exit();}

     $sql   = "

    select h.*,
        (select nombre_completo from tbl_usuario where rut=h.rut) as nombre_completo,
        (select avatar from tbl_usuario where rut=h.rut) as avatar,
        (select nombre_completo from tbl_usuario where rut=h.rut_colaborador) as nombre_completo_col,
        (select avatar from tbl_usuario where rut=h.rut_colaborador) as avatar_col

    from tbl_potencial_bitacora h

    where h.id>0 $query
    and (select count(id) from tbl_potencial_comites_colaboradores  where id_comite='$id_comite' and rut=h.rut_colaborador)>0
    and h.id_comite='$id_comite' and h.id_empresa='$id_empresa'  order by (select nombre_completo from tbl_usuario where rut=h.rut_colaborador), id DESC

     ";
      //echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);
}
function Potencial_Bitacora_Comites_FullRut_data($rut_col,  $id_empresa){
         $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");


     $sql   = "

    select h.*,
    		(select nombre from tbl_potencial_comites where id_comite=h.id_comite) as comite,
    		(select fecha_comite from tbl_potencial_comites where id_comite=h.id_comite) as fecha_comite,
        (select nombre_completo from tbl_usuario where rut=h.rut) as nombre_completo,
        (select avatar from tbl_usuario where rut=h.rut) as avatar,
        (select nombre_completo from tbl_usuario where rut=h.rut_colaborador) as nombre_completo_col,
        (select avatar from tbl_usuario where rut=h.rut_colaborador) as avatar_col,
        'Potencial' as tipo_bitacora

    from tbl_potencial_bitacora h

     where rut_colaborador='$rut_col'

		UNION
		
    select h.*,
    		(select nombre from tbl_potencial_comites_sucesion where id_comite=h.id_comite) as comite,
    		(select fecha_comite from tbl_potencial_comites_sucesion where id_comite=h.id_comite) as fecha_comite,
        (select nombre_completo from tbl_usuario where rut=h.rut) as nombre_completo,
        (select avatar from tbl_usuario where rut=h.rut) as avatar,
        (select nombre_completo from tbl_usuario where rut=h.rut_colaborador) as nombre_completo_col,
        (select avatar from tbl_usuario where rut=h.rut_colaborador) as avatar_col,
        'Sucesion' as tipo_bitacora

    from tbl_potencial_bitacora_sucesion h

     where rut_colaborador='$rut_col'		
     
    order by fecha DESC

     ";
    
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);
}
function BuscaPotencialActualizado($id, $id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "
     select h.propuesta_lider,h.propuesta_socio,h.propuesta_final  from tbl_potencial_matriz h where h.id='$id' and h.id_empresa='$id_empresa'  order by id DESC
     ";
      //echo "<br>sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
$box="";
if($cod[0]->propuesta_lider<>'')    {$box=$cod[0]->propuesta_lider;}
if($cod[0]->propuesta_socio<>'')    {$box=$cod[0]->propuesta_socio;}
if($cod[0]->propuesta_final<>'')    {$box=$cod[0]->propuesta_final;}




        return ($box);

}
function Potencial_BuscaColaborador($id, $id_empresa)
{
            $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "
select h.*,

(select rut_lider from tbl_potencial_comites_colaboradores where rut=h.rut and id_comite=h.id_comite) as rut_lider,
(select rut from tbl_potencial_comites where id_comite=h.id_comite) as rut_socio
 from tbl_potencial_matriz h where h.id='$id' and h.id_empresa='$id_empresa'";
 //echo "<br>sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;
}
function potencial_comite_update_socio($nuevo_cuadrante,$comentario, $id_comite,  $rut, $id, $id_empresa , $perfil){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    if($perfil=="SOCIO DE NEGOCIO")     {   $query=" set propuesta_socio='$nuevo_cuadrante' ";}
    if($perfil=="LIDER")     {   $query=" set propuesta_lider='$nuevo_cuadrante' ";}
    $comentario=($comentario);

    $sql   = "update tbl_potencial_matriz
    $query
    where id='$id' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    $connexion->execute();
    //echo "<br>sql $sql";
     $sql   = "
     select h.rut from tbl_potencial_matriz h where h.id='$id' and h.id_empresa='$id_empresa' limit 1
     ";
    //echo "<br>sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $rut_col    =   $cod[0]->rut;

     $sql   = "
     select count(id) as cuenta from tbl_potencial_bitacora h where h.rut='$rut' and rut_colaborador='$rut_col'
     and box_propuesto='$nuevo_cuadrante' and comentario='$comentario' and h.id_empresa='$id_empresa' limit 1
     ";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $cuenta    =   $cod[0]->cuenta;
        if($cuenta==0){
    $sql   = "insert into tbl_potencial_bitacora
        (rut,   perfil, id_comite,   rut_colaborador,comentario,  box_propuesto,fecha,hora, id_empresa)
        VALUES
        ('$rut','$perfil', '$id_comite','$rut_col',    '$comentario','$nuevo_cuadrante','$fecha','$hora','$id_empresa');";
     }
    //echo "<br>sql $sql";
    $connexion->query($sql);
    $connexion->execute();


}
function Potencial_Lista_Colaboradores_Reales($id_comite, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
        
	$sql   = "
			select count(h.id) as cuenta
			
			from 
				
			tbl_potencial_comites_colaboradores h
	
			where 
			
			h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
  ";

	//echo "<br>Potencial_Lista_Colaboradores_Reales $sql ";
	
  $connexion->query($sql);
  
  $cod = $connexion->resultset();
  return ($cod[0]->cuenta);	
}
function Potencial_lista_colabordores_comite($cuadrante, $id_comite, $rut, $perfil, $id_empresa) {

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");



$queryw="";
if($perfil=="LIDER")                        { $queryw=" AND  (select count(id) from tbl_potencial_comites_colaboradores where rut=h.rut and rut_lider='$rut' and id_comite='$id_comite' limit 1) >0 ";}
//if($perfil=="SOCIO DE NEGOCIO")             { $queryw=" AND  (select count(id) from tbl_potencial_comites where rut='$rut' and id_comite='$id_comite' limit 1) >0";}
if($perfil=="USUARIO")                      { $queryw=""; exit();}


if($_SESSION["user_"]=="10365815"){
	
	
	$query_rod=" and h.rut='13461734' ";
	$query_rod="  ";

} else {
	$query_rod="  ";
}





if($cuadrante=="10"){
$sql   = "

	select h.* ,
	(select promedio_metas_2020 from tbl_potencial_cuadrantes where rut=h.rut) as promedio_metas_2020,
	(select promedio_competencias_2020 from tbl_potencial_cuadrantes where rut=h.rut) as promedio_competencias_2020,
	(select propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as propuesta_cuadrante_2020,
	(select fecha_propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_propuesta_cuadrante_2020,
	(select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020,
	(select fecha_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_cuadrante_2020,
	(select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020_lider,
	(select d103 from tbl_data_bci where rut=h.rut) as cuadrante_actual_bci

	from 

	tbl_potencial_comites_colaboradores h

	where h.id_comite='$id_comite'
	and (
					(select propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante' 
					or (select propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='5+' 
					or (select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante' 
					or (select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='5+' 
 				  or (select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut=h.rut)='5+'
					or (select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante'

					or (select d103 from tbl_data_bci where rut=h.rut)='$cuadrante'
					or (select d103 from tbl_data_bci where rut=h.rut)='5+'
	)
	
	
	$queryw
	
	$query_rod
     ";	
} else {
$sql   = "

	select h.* ,
	(select promedio_metas_2020 from tbl_potencial_cuadrantes where rut=h.rut) as promedio_metas_2020,
	(select promedio_competencias_2020 from tbl_potencial_cuadrantes where rut=h.rut) as promedio_competencias_2020,
	(select propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as propuesta_cuadrante_2020,
	(select fecha_propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_propuesta_cuadrante_2020,
	(select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020,
	(select fecha_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut) as fecha_cuadrante_2020,
	(select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut=h.rut) as cuadrante_2020_lider,
	(select d103 from tbl_data_bci where rut=h.rut) as cuadrante_actual_bci

	from 

	tbl_potencial_comites_colaboradores h

	where h.id_comite='$id_comite'
	and (
					(select propuesta_cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante' 
					or (select cuadrante_2020 from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante'
					or (select cuadrante_2020_lider from tbl_potencial_cuadrantes where rut=h.rut)='$cuadrante'
					or (select d103 from tbl_data_bci where rut=h.rut)='$cuadrante'
	)
	
	
	$queryw
	
	$query_rod
     ";	
}
 	


  $connexion->query($sql);
  
  $cod = $connexion->resultset();
  return ($cod);



}
function Potencial_Update_data($meta,$competencia,$box_propuesta,$id, $id_comite, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");


    $sql   = "update tbl_potencial_matriz
    set niv_cumplimiento_metas='$meta',
    niv_competencias='$competencia',
    propuesta='$box_propuesta',
    id_comite='$id_comite'
    where id='$id' and id_empresa='$id_empresa'";
    echo "sql $sql"; exit();
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return ($cod);

}
function potencial_colaboradores_comite($id_comite, $id_empresa) {

        $connexion = new DatabasePDO();
        
        
        $sql="delete from tbl_potencial_comites_colaboradores where id_comite='$id_comite' ";
        //echo $sql;exit;
        $connexion->query($sql);
    $connexion->execute();
        $cod = $connexion->resultset();
        return $cod;

}
function Potencial_insert_colaboradores($rut_col,$rut_lider,$id_comite,$hoy,$id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
//$Usua=DatosUsuario_($rut, $id_empresa);
//$jefe=$Usua[0]->jefe;
         $sql   = "

            select count(h.id) as cuenta from tbl_potencial_comites_colaboradores h
            where h.id_empresa='$id_empresa' and  rut='$rut_col' and rut_lider='$rut_lider' and id_comite='$id_comite'

        ";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        //echo "sql $sql";
        if($cod[0]->cuenta==0 and $rut_col<>'' and $rut_lider<>''){
    			$sql   = "insert into tbl_potencial_comites_colaboradores (rut,rut_lider,id_comite,fecha,id_empresa)
  	      VALUES
	        ('$rut_col','$rut_lider','$id_comite','$hoy','$id_empresa');";
			    // echo "<br>".$sql;
			    $connexion->query($sql);
            $connexion->execute();
    		}
}
function Potencial_Mis_Comites_insert_data($nombre, $descripcion, $rut, $rut_lider, $nombre_lider, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $nombre =   ($nombre);
        $sql   = "

            select h.id from tbl_potencial_comites h where h.id_empresa='$id_empresa' order by id DESC limit 1

        ";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $id_antiguo=$cod[0]->id;
        $id_nuevo=  $id_antiguo+1;
        $id_comite="pot_".$rut_lider."_".$cod[0]->id;

    $sql   = "insert into tbl_potencial_comites
        (nombre, descripcion, rut, fecha, hora, id_empresa, id_comite, rut_lider, nombre_lider)
        VALUES
        ('$nombre','$descripcion','$rut','$fecha','$hora', '$id_empresa',
         '$id_comite','$rut_lider','$nombre_lider');";
        //echo $sql; exit();exit();
    $connexion->query($sql);
    $connexion->execute();
}
function Potencial_Busca_Cantidad_Colaboradores_lider($rut, $id_comite, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
     $sql   = "
           select count(h.id) as cuenta from tbl_potencial_comites_colaboradores_2024 h where h.id_empresa='$id_empresa' and rut_lider='$rut' and id_comite='$id_comite'
     ";
        //echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod[0]->cuenta);
}
function PotencialBuscaLideres($id_comite, $id_empresa){
         $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
     $sql   = "
           select h.rut_lider from tbl_potencial_comites_colaboradores h where h.id_empresa='$id_empresa' and id_comite='$id_comite'  group by h.rut_lider
     ";
//        echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return $cod;
}
function Potencial_Busca_Cantidad_Colaboradores_socio($rut, $id_comite, $id_empresa){
        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
     $sql   = "
           select count(h.id) as cuenta from tbl_potencial_comites_colaboradores h where h.id_empresa='$id_empresa' and id_comite='$id_comite'
     ";
     //   echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod[0]->cuenta);
}
function Potencial_Mis_Comites_data($id_empresa, $rut, $perfil,$mijefe, $periodo){

				//echo "<br>$id_empresa, $rut, $perfil,$mijefe";
				$year=date("Y");
				if($periodo=="now"){
					$Query_Now_H=" and Year(h.fecha)='".$year."' ";
					$Query_Now_J=" and Year(j.fecha)='".$year."' ";
				}
                    elseif($periodo=="historico"){

                        $Query_Now_H=" and Year(h.fecha)<>'".$year."' ";
                        $Query_Now_J=" and Year(j.fecha)<>'".$year."' ";
                    }
                
				else {
                    $Query_Now_H=" ";
                    $Query_Now_J=" ";
				}


        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");
      
				$sql_update_99 = "update tbl_potencial_comites_colaboradores h
													set h.id_empresa='99'
													where (select id_empresa from tbl_potencial_comites where id_comite=h.id_comite) <>h.id_empresa";

        $connexion->query($sql_update_99);
    $connexion->execute();
        
					$Query="";
					if($perfil=="USUARIO")					        {	EXIT();	}
					if($perfil=="")									{	EXIT();	}
					if($perfil=="SOCIO DE NEGOCIO")	{ $Query=" and h.rut='$rut' ";	}
					if($perfil=="LIDER")						{ $Query=" and (select count(id) from tbl_potencial_comites_colaboradores where rut_lider='$rut' and id_comite=h.id_comite) >0 ";	}

				//	if($perfil=="SOCIO DE NEGOCIO"){ $Query=" and h.rut='$rut' ";}
				if($perfil=="SOCIO DE NEGOCIO"){
			     $sql   = "	select h.* from tbl_potencial_comites h where id>0 $Query and h.id_empresa='$id_empresa'  order by fecha_comite DESC	";
				  } else {
			    
					}

			 $sql="   
			     select h.*, 
			     (select id_comite from tbl_potencial_comites where id_comite=h.id_comite) as id_comite_real,
			     (select rut from tbl_potencial_comites where id_comite=h.id_comite) as socio,
			     (select fecha_comite from tbl_potencial_comites where id_comite=h.id_comite) as fecha_comite,
			     (select nombre from tbl_potencial_comites where id_comite=h.id_comite) as nombre
										
			      from tbl_potencial_comites_colaboradores h where 
      
						(h.rut_lider='$rut' or rut_jefe_socio='$rut' or rut_jefe_socio='$rut_jefe' or rut_jefe_jefe_socio='$rut' or rut_jefe_lider='$rut' or rut_jefe_jefe_lider='$rut' 
						or (select rut from tbl_potencial_comites where id_comite=h.id_comite)='$rut'
						or (select rut_socio_2 from tbl_potencial_comites where id_comite=h.id_comite)='$rut'
						or (select rut_socio_3 from tbl_potencial_comites where id_comite=h.id_comite)='$rut'
						or (select rut_socio_4 from tbl_potencial_comites where id_comite=h.id_comite)='$rut'
						or (select rut_backup_socio from tbl_potencial_comites where id_comite=h.id_comite)='$rut'
						or rut_jefe_socio='$mijefe'
						)
						and (select id_comite from tbl_potencial_comites where id_comite=h.id_comite)<>''
						and h.id_empresa='62'
					$Query_Now_H
					
					group by h.id_comite
					

				UNION 


				     select j.id_comite as id , j.id_comite, 
							j.rut as rut,
							j.id_empresa as id_empresa,
							null as rut_lider,
							j.fecha as fecha,
							null as fecha_comite,
							null as hora_inicio_comite,
							null as hora_termino_comite,
							null as lugar,
							null as rut_jefe_socio,
							null as rut_jefe_jefe_socio,
							null as rut_jefe_lider,
							null as rut_jefe_jefe_lider,
							null as rut_backup_socio,
							j.id_comite as id_comite_real,
							j.rut as socio,
							j.fecha_comite as fecha_comite1,
							j.nombre as nombre
							

				    
				     
				      from tbl_potencial_comites j
				  				       where (select count(id) from tbl_potencial_comites_colaboradores where id_comite=j.id_comite)='0'
    
								and (j.rut='$rut')
								and j.id_empresa='62'
								$Query_Now_J
								group by j.id_comite
				
			";

		$SQL_SU="select id from tbl_potencial_perfil_super where rut='$rut'";
        $connexion->query($SQL_SU);
        
        $COD_SU = $connexion->resultset();
        
        if($COD_SU[0]->id>0){
         $sql="   
				     select h.*, 
				     (select id_comite from tbl_potencial_comites where id_comite=h.id_comite) as id_comite_real,
				     (select rut from tbl_potencial_comites where id_comite=h.id_comite) as socio,
				     (select fecha_comite from tbl_potencial_comites where id_comite=h.id_comite) as fecha_comite,
				     (select nombre from tbl_potencial_comites where id_comite=h.id_comite) as nombre
				     
				      from tbl_potencial_comites_colaboradores h 
				      
				      where (select id_comite from tbl_potencial_comites where id_comite=h.id_comite)<>''
								and h.id_empresa='62'		
									$Query_Now_H
							group by h.id_comite
											
							UNION

				     select j.id_comite as id , j.id_comite, 
							j.rut as rut,
							j.id_empresa as id_empresa,
							null as rut_lider,
							j.fecha as fecha,
							null as fecha_comite,
							null as hora_inicio_comite,
							null as hora_termino_comite,
							null as lugar,
							null as rut_jefe_socio,
							null as rut_jefe_jefe_socio,
							null as rut_jefe_lider,
							null as rut_jefe_jefe_lider,
							null as rut_backup_socio,
							j.id_comite as id_comite_real,
							j.rut as socio,
							j.fecha_comite as fecha_comite1,
							j.nombre as nombre

				      from tbl_potencial_comites j
				      
				       where (select count(id) from tbl_potencial_comites_colaboradores where id_comite=j.id_comite)='0'
				       and j.id_empresa='62'
											$Query_Now_J
							group by j.id_comite
					
			";	
        }

        //echo "<br>Potencial <br>".$sql;
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
   	    	$fecha_comite[$clave] = $fila->fecha_comite;
			$fecha[$clave] 				= $fila->fecha;
            foreach ($cod as $key => $row) {
                $aux[$key] = $row->fecha_comite;
            }
             array_multisort($aux, SORT_DESC, $cod);

        return ($cod);

}
function Potencial_Colaboradores_Matriz_data($id_empresa, $rut){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     select h.* from tbl_potencial_matriz h where h.rut='$rut' and h.id_empresa='$id_empresa'  order by id DESC

     ";
        //echo "sql $sql"; exit();
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Comites_data($id_comite,$id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     select h.*,
     (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo

     from tbl_potencial_comites h

     where h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
     order by (select nombre_completo    from tbl_usuario   where rut=h.rut) ASC

     ";
        //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function Potencial_Comites_Suc_data($id_comite,$id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

     $sql   = "

     select h.*,
     (select nombre_completo    from tbl_usuario            where rut=h.rut)                as nombre_completo

     from tbl_potencial_comites_sucesion h

     where h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
     order by (select nombre_completo    from tbl_usuario   where rut=h.rut) ASC

     ";
        //echo "sql $sql"; 
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function DatosNombreCargoDataBci2021($rut){
    $connexion = new DatabasePDO();
    
    
    $fecha      = date("Y-m-d");
    $sql        = "select h.d7 as nombre, h.d8 as apaterno, h.d9 as amaterno, h.d6 as cargo from tbl_data_bci_2021 h where h.rut='$rut'";
    $connexion->query($sql);
    
    //echo $sql;
    $cod        = $connexion->resultset();
    //print_r($cod);
    $arreglo[0]= $cod[0]->nombre." ".$cod[0]->apaterno." ".$cod[0]->amaterno;
    $arreglo[1]= $cod[0]->cargo;
    return ($arreglo);
}
function DatosAvatarTblUsuario2022($rut){
    $connexion = new DatabasePDO();
    
    
    $fecha      = date("Y-m-d");
    $sql        = "select h.avatar from tbl_usuario h where h.rut='$rut'";
    $connexion->query($sql);
    
    $cod        = $connexion->resultset();

    return ($cod[0]->avatar);
}
function Potencial_Colaboradores_Comites_data($id_comite, $rut, $perfil, $id_empresa){

        $connexion = new DatabasePDO();
        
           $fecha = date("Y-m-d");

//echo "perfil $perfil";

//if($perfil=="SOCIO DE NEGOCIO") {$query=" and (select rut from tbl_potencial_comites where id_comite='$id_comite')='$rut' ";}
if($perfil=="SOCIO DE NEGOCIO") 			{}
if($perfil=="LIDER")            			{$query=" and 
	
	
	(
			h.rut_lider='$rut'  or
			h.rut_jefe_lider='$rut'  or
			h.rut_jefe_jefe_lider='$rut' 
			
		)
	
	
	
	";}
if($perfil=="VISUALIZADOR")           {$query=" and (
	
																								rut_jefe_socio='$rut' or 
																								rut_jefe_jefe_socio='$rut' or 
																								rut_jefe_lider='$rut' or 
																								rut_jefe_jefe_lider='$rut')

";}

if($perfil=="USUARIO")          {exit();}
     $sql   = "

     select h.*


     from tbl_potencial_comites_colaboradores h

     where h.id>0 $query and h.id_comite='$id_comite' and h.id_empresa='$id_empresa'
   

     ";

        //     (select nombre_completo    from tbl_usuario            where rut=h.rut)                      as nombre_completo,
    //     (select nombre_completo    from tbl_usuario            where rut=h.rut_lider)                as nombre_lider,
    //     (select d6    from tbl_data_bci_2021            where rut=h.rut)                			  as cargo_col

        //  and (select nombre_completo    from tbl_usuario            where rut=h.rut)<>''
        //     order by (select nombre_completo    from tbl_usuario            where rut=h.rut) ASC
        //echo "sql $sql";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
        return ($cod);

}
function InsertaExperienciaLaboral($rut, $id_empresa, $ec_11, $ec_12, $ec_13)
{
    $connexion = new DatabasePDO();
    
    
    $hoy   = date('Y-m-d');
    $fecha = date("Y-m-d");
      $ec_13=($ec_13);

    $hora  = date("H:i:s");
    $sql   = "insert into tbl_checklist_experiencias_laborales (rut, id_empresa, tareas, empresa, duracion)
        VALUES
        ( '$rut', '$id_empresa', '$ec_11', '$ec_12', '$ec_13');";

    $connexion->query($sql);
    $connexion->execute();
}
function DatosExperienciasLaborales($id_empresa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "    select * from tbl_checklist_experiencias_laborales where rut='$rut' and id_empresa='$id_empresa'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function InsertaEstudiosFormales($rut, $id_empresa, $ec_tes, $ec_fi, $ec_tit, $ec_ft, $ec_cf, $ec_sta, $ec_tes_otro, $ec_tit_otro, $ec_cf_otro)
{
    $connexion = new DatabasePDO();
    
    
    $hoy   = date('Y-m-d');
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_checklist_estudios_formales (rut, id_empresa, tipo_estudio, fecha_inicio, nombre_estudio, fecha_termino, casa_estudio, situacion_actual, otro_estudio, otro_nombre_estudio, otra_casa_estudio )
        VALUES
        ( '$rut', '$id_empresa', '$ec_tes', '$ec_fi', '$ec_tit', '$ec_ft', '$ec_cf', '$ec_sta', '$ec_tes_otro', '$ec_tit_otro', '$ec_cf_otro');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosOtrosEstudiosFormales($id_empresa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "   SELECT
    tbl_checklist_estudios_formales.*, nombre_estudio.nombre_item, nombre_casa_estudio.nombre_item as descripcion_casa_estudio
FROM
    tbl_checklist_estudios_formales

left join tbl_checklist_item as nombre_estudio on nombre_estudio.id_item=tbl_checklist_estudios_formales.nombre_estudio and nombre_estudio.tipo='titulos'
left join tbl_checklist_item as nombre_casa_estudio on nombre_casa_estudio.id_item=tbl_checklist_estudios_formales.casa_estudio and nombre_casa_estudio.tipo='centro_formacion'

WHERE
    rut = '$rut'
AND tbl_checklist_estudios_formales.id_empresa = '$id_empresa'";


    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function BuscaAgradecimientobasadoenId($id, $id_empresa){
    $connexion = new DatabasePDO();
    
    
    $sql="

    select h.*
    from tbl_reconoce_gracias h
    where h.id_empresa='$id_empresa' and h.id='$id' ";
    //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    //echo "<br>LMS_BuscarJuego_todosCasosPistas $sql";
    return $cod;
}
function TraigoOrganigramasPorEmpresa($id_empresa){

    $connexion = new DatabasePDO();
    
    
    $sql="select * from tbl_organigrama_gerencia where id_empresa='$id_empresa'";
    //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    //echo "<br>$sql";
    return $cod;

}
function InsertTblAnalitica($rut, $id_empresa, $ambiente, $detalle)
{
    $connexion = new DatabasePDO();
    
    
    $fecha      = date("Y-m-d");
    $hora       = date("H:i:s");
    $fechahora  = date("Y-m-d H:i:s");

    $sql   = "
INSERT INTO tbl_analitica
(rut,     ambiente,    detalle,    fecha,    hora,    fechahora,    id_empresa)
" . "VALUES
('$rut', '$ambiente', '$detalle', '$fecha', '$hora', '$fechahora', '$id_empresa')";
//echo "<br><br>$sql<br><br>";sleep(10);
    $connexion->query($sql);
    $connexion->execute();
}
function BacBuseliminaResponsable($id_solicitud, $id_empresa){

    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sis_seguimiento_situaciones
     set rut_res='', estado_registro='Sin Iniciar' where id='$id_solicitud' and id_empresa='$id_empresa'
    ";

   // echo $sql;
    $connexion->query($sql);
    $connexion->execute();

}
function BuscaUsuarios_NoGerentes($rut, $id_empresa){

         $connexion = new DatabasePDO();
        
        
        $sql="SELECT
    count(id) as cuenta
FROM
    tbl_usuario
WHERE
    rut = '$rut'  and id_empresa='$id_empresa'
AND cargo NOT LIKE '%gte%'
AND cargo NOT LIKE '%grte%'

AND cargo NOT LIKE '%GERENTE%'
AND cargo NOT LIKE '%gerente%'
AND cargo NOT LIKE '%Jefe de Ventas 1%'
AND cargo NOT LIKE '%Jefe de Ventas 2%'
AND cargo NOT LIKE '%Jefe de Ventas 3%'
AND cargo NOT LIKE '%Jefe de Ventas 4%' ";

                            // echo "sql $sql";  sleep(2);
        $connexion->query($sql);
        
        $cod = $connexion->resultset();

        //print_r($cod);    sleep(4);
        return $cod[0]->cuenta;

}
function BuscoRespuestasDadoRutCursoInscripcion($rut, $id_curso, $id_inscripcion,$id_objeto){

   $connexion = new DatabasePDO();
    
    
    $sql="select count(id) as cuenta from tbl_evaluaciones_respuestas where rut='$rut' and id_objeto='$id_objeto';";
              // echo "sql $sql";  sleep(2);
    $connexion->query($sql);
    
    $cod = $connexion->resultset();


        $sql="select count(id) as cuenta from tbl_evaluaciones_respuestas where rut='$rut' and id_objeto='$id_objeto' and id_inscripcion='$id_inscripcion';
;";
                            // echo "sql $sql";  sleep(2);
        $connexion->query($sql);
        
        $cod2 = $connexion->resultset();
$borrar=0;

if($cod[0]->cuenta>0 and $cod2[0]->cuenta==0)  {$borrar=1;}
    //print_r($cod);    sleep(4);
    return $borrar=1;;


}
function ActualizaIdInscripcionNull_RUT($rut)
    {
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_inscripcion_cierre h set id_inscripcion=h.id_curso where (select modalidad from tbl_lms_curso where id=h.id_curso)='1' and
            (h.id_inscripcion is null OR h.id_inscripcion='')  and h.rut='$rut'
    ";

   // echo $sql;
    $connexion->query($sql);
        $connexion->execute();
}
function BuscaInscripcionCierreDuplicadosRut($rut)
    {
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT h.rut, h.id_inscripcion, h.id_curso,
    (select modalidad from tbl_lms_curso where id=h.id_curso), COUNT(*)

    FROM tbl_inscripcion_cierre h

    where   h.rut='$rut' and

    (select modalidad from tbl_lms_curso where id=h.id_curso) is not NULL
    and (select modalidad from tbl_lms_curso where id=h.id_curso)<>'4'
    GROUP BY h.rut, h.id_inscripcion, h.id_curso
    HAVING COUNT(*) > 1
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    foreach($cod as $unico)
        {
        $buscaInstanciasCierre = BuscaInstanciasCierreDadoCursoInscrRutRut($unico->rut, $unico->id_inscripcion, $unico->id_curso);
        foreach($buscaInstanciasCierre as $uniIdCierre)
            {
            echo "<br /> rut " . $uniIdCierre->rut . " id curso " . $uniIdCierre->id_curso . " id inscripcion " . $uniIdCierre->id_inscripcion . "
                    nota " . $uniIdCierre->nota . " avance " . $uniIdCierre->avance . " estado " . $uniIdCierre->estado . " estado descripcion " . $uniIdCierre->estado_descripcion . " id_empresa " . $uniIdCierre->id_empresa;
            }

        // echo "<br /><hr><br />";

        }

    return $cod;
    }
function BuscaInstanciasCierreDadoCursoInscrRutRut($rut, $id_inscripcion, $id_curso)
    {
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT h.rut, h.id_curso, h.id_inscripcion, h.nota, h.avance, h.estado, h.estado_descripcion
            FROM tbl_inscripcion_cierre h
        where rut='$rut' and h.id_curso='$id_curso' and h.id_inscripcion='$id_inscripcion'

        order by h.nota ASC, h.avance ASC, h.estado DESC, h.estado_descripcion ASC, h.id_inscripcion ASC
";
    $sql = "update tbl_inscripcion_cierre h set id_empresa='999'  where rut='$rut' and h.id_curso='$id_curso' and h.id_inscripcion='$id_inscripcion'

        order by h.nota ASC, h.avance ASC, h.estado DESC, h.estado_descripcion ASC, h.id_inscripcion ASC limit 1";


    $connexion->query($sql);
        $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;
    }
function VerificaUsuarioEmail($email, $id_empresa){


   $connexion = new DatabasePDO();
    
    
    $sql="select rut from tbl_usuario where email='$email' and id_empresa='$id_empresa'";
              // echo "sql $sql";  sleep(2);
    $connexion->query($sql);
    
    $cod = $connexion->resultset();

    //print_r($cod);    sleep(4);
    return $cod[0]->rut;

}
function VerificaUsuarioUserRut($user, $id_empresa){


   $connexion = new DatabasePDO();
    
    
    $sql="select rut from tbl_usuario where rut='$user'";
              // echo "sql $sql";  sleep(2);
    $connexion->query($sql);
    
    $cod = $connexion->resultset();

    //print_r($cod);    sleep(4);
    return $cod[0]->rut;

}
function LogEmailInsertUsuario($rut,$nombre,$email,$rut_empresa,$codigo,$id_empresa){


    $connexion = new DatabasePDO();        

    $sql = "select id  from tbl_usuario where id_empresa='$id_empresa' and rut='$rut'";
    //echo $sql;
    $connexion->query($sql);
        $cod = $connexion->resultset();
    //print_r($cod);    //sleep(5);
    $nombre=($nombre);

    if ($cod[0]->id > 0) {

    $sql = " UPDATE tbl_usuario set nombre_completo='$nombre', email='$email', empresa_holding='$rut_empresa', division='$codigo'
        where rut='" . $rut. "' ";
    } else {
        $sql = "INSERT INTO tbl_usuario (rut, id_empresa, nombre_completo, email, empresa_holding, division) " . "
        VALUES        ('$rut', '$id_empresa',  '$nombre','$email', '$rut_empresa', '$codigo');";
    }
//    echo  "<br> $c_host, $c_user, $c_pass, $c_db";
//    echo "<br>";
 //echo $sql; sleep(2);

    $connexion->query($sql);   $connexion->execute();     return $codigo;

}
function VerficicaPreguntaMedFinalizada($id_empresa, $id_encuesta, $id_medicion, $rut, $rut_colaborador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
        count(tbl_enc_elearning_preg.id) as numpreg, count(tbl_enc_elearning_respuestas.respuesta)  as numres
        FROM
        tbl_enc_elearning_preg

        left join
        tbl_enc_elearning_respuestas
        on tbl_enc_elearning_respuestas.rut='$rut'

        and tbl_enc_elearning_respuestas.id_medicion='$id_medicion'
        and tbl_enc_elearning_respuestas.id_encuesta='$id_encuesta'

        and tbl_enc_elearning_respuestas.id_pregunta=tbl_enc_elearning_preg.id_pregunta
        WHERE
        tbl_enc_elearning_preg.id_encuesta = '$id_encuesta'
        AND tbl_enc_elearning_preg.id_empresa = '$id_empresa'
        ";
    //echo "<br>$sql";
    $connexion->query($sql);
    
    $cod        = $connexion->resultset();
    $finalizado = 0;
    if ($cod[0]->numpreg <= $cod[0]->numres and $cod[0]->numpreg > 0) {
        $finalizado = 1;
    }
    return $finalizado;
}
function BuscaJefeDadoRut($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select h.jefe from tbl_usuario h where h.rut='$rut' and h.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function ValidaJefeDirecto($rut_destinatario,$rut_remitente,$id_empresa){

    $connexion = new DatabasePDO();
    
    
    $sql="select jefe from tbl_usuario where rut='$rut_destinatario' and id_empresa='$id_empresa'";
     $connexion->query($sql);
    
    $cod = $connexion->resultset();


    if($cod[0]->jefe==$rut_remitente){
    return 1;}
    else {
    return 0;
    }

}
function TraePalabraSqlInjection()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sql_injection";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function buscaPalabraSqlInjection($palabra)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sql_injection where palabra='$palabra' or palabra like '%$palabra%'";
    //echo "buscaPalabraSqlInjection<br>";

    //echo $sql;
    //echo "<br>";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SaveLogEmails($id_empresa, $tipo, $subject, $to, $nombreto, $fecha, $statusCode, $headers, $response, $tipomensaje, $rut, $key)
{
    $connexion = new DatabasePDO();
    
    
    $nuevo_id  = $ultimo_id[0]->id;
    $nuevo_id  = $nuevo_id + 1;
    $codigo    = $id_empresa . "_mp" . $nuevo_id;
    //".json_encode($statusCode)."
    //".json_encode($headers)."
    //".json_encode($response)."
    //".json_encode($to)."
    //".json_encode($subject)."
    $sql       = "INSERT INTO tbl_log_emails (
    tipo, asunto,
    rut,  id_empresa,
    fecha, statusCode,
    headers, body,dato, email) " . "VALUES  (
    '$tipomensaje', '',
    '$rut','$id_empresa',
    '$fecha','',
    '','',
    '$key', '')";



    $connexion->query($sql);
    $connexion->execute();
}
function DatosUsuario_($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select h.*


    from tbl_usuario h

    where rut='$rut' and id_empresa='$id_empresa'
    ";
    //echo "<br><br><br>$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function BuscaEmail($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select email from tbl_usuario where rut='$rut'

    ";
    //echo "<br>$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function buscarArchivoSubCatFull($id_categoria)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT h.* from

    tbl_biblio_archivos h

    where h.id_categoria='$id_categoria'     order by titulo


    ";
//
//echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return ($cod);
}
function TotalUsuariosPorRutJefeResponsable($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select     h.*,
    (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut)  as cuenta
    from tbl_usuario h
    where h.responsable='$rut'
    and h.vigencia='0'
    order by (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut) desc, h.nombre asc
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EsJefeResponsabletblUsuario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select count(id) as cuenta from tbl_usuario where responsable='$rut' and id_empresa='$id_empresa'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}
function EsLiderEjecutivotblUsuario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select count(id) as cuenta from tbl_usuario where lider='$rut' and id_empresa='$id_empresa'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}
function TotalMensajesPorRutEmpresaAgenteFiltroAgente($rut, $id_empresa, $rut_agente)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select tbl_mensajes_principal.*,
    tbl_usuario.nombre as nombre_creador, tbl_usuario.apaterno, tbl_usuario.amaterno,
    tbl_mensaje_tipo.nombre as nombre_titulo,
    (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
    from tbl_mensajes_principal

    inner join tbl_usuario
    on tbl_usuario.rut=tbl_mensajes_principal.rut_creador


    inner join tbl_mensaje_tipo
    on tbl_mensaje_tipo.id=tbl_mensajes_principal.tipo_mensaje

    where

    tbl_mensajes_principal.id_empresa='$id_empresa' and
    tbl_usuario.jefe='$rut_agente'


    order by id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosMiAgente($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    tbl_usuario.jefe,
    datos_agente.nombre_completo,
    datos_agente.telefono,
    datos_agente.cargo,
    datos_agente.email
    FROM
    tbl_usuario
    INNER JOIN tbl_usuario AS datos_agente ON datos_agente.rut = tbl_usuario.jefe
    WHERE
    tbl_usuario.rut = '$rut' and tbl_usuario.id_empresa='$id_empresa'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TagsPorMPEmpresa($id_mp, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_mp_tag where id_mp='$id_mp' and id_empresa='$id_empresa'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function com_mp_save_groupseguido($rut, $id_empresa, $tipo, $idcat)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT count(id) as cuenta FROM tbl_mp_interacciones WHERE tipo = '$tipo'
    AND rut = '$rut' AND id_empresa = '$id_empresa' AND contenido = '$idcat'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    if ($cod[0]->cuenta == 0) {
        $hoy = date("Y-m-d");
        $sql = "INSERT INTO tbl_mp_interacciones (rut, fecha, id_empresa, contenido, tipo) values
    ('$rut','$hoy','$id_empresa','$idcat', '$tipo') ";
        $connexion->query($sql);
        $connexion->execute();
    }
    return $cod;
}
function com_mp_del_groupseguido($rut, $id_empresa, $tipo, $idcat)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "delete FROM tbl_mp_interacciones WHERE tipo = '$tipo'
    AND rut = '$rut' AND id_empresa = '$id_empresa' AND contenido = '$idcat'    ";
    $connexion->query($sql);
    $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;
}
function com_mp_revisa_grupo_seguido($id_categoria, $tipo, $id_empresa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT count(id) as cuenta FROM tbl_mp_interacciones WHERE tipo = '$tipo'
    AND rut = '$rut' AND id_empresa = '$id_empresa' AND contenido = '$id_categoria'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MPO_Compestadistica($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select h.id_empresa,
    (select count(id) from tbl_mp where id_empresa='$id_empresa' and id_estado>=5) as CuentaPublicaciones,
    (select count(id) from tbl_mp_interacciones where id_empresa='$id_empresa' and tipo='VISITA' group by tipo) as CuentaVisitas,
    (select count(id) from tbl_mp_interacciones where id_empresa='$id_empresa' and tipo='MEGUSTA' group by tipo) as CuentaMeGusta,
    (select count(id) from tbl_mp_interacciones where id_empresa='$id_empresa' and tipo='COMENTARIO' group by tipo) as CuentaComentarios

    from tbl_mp_interacciones h where h.id_empresa='$id_empresa' group by h.id_empresa


    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaTagsIVPH($tag, $id_empresa, $id_mp)
{
    $connexion = new DatabasePDO();
    
    
    $ultimo_id = ObtengoUltimoRegistroMP($id_empresa);
    $nuevo_id  = $ultimo_id[0]->id;
    $nuevo_id  = $nuevo_id + 1;
    $sql       = "INSERT INTO tbl_mp_tag(id_mp, tag, id_empresa) " . "VALUES ('$id_mp', '$tag', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function ListadoIvphPorRutEmpresaPlanes($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    tbl_mp.*,
    tbl_usuario.nombre_completo as nombre_autor,
    basecoach.nombre_completo as nombre_coach

    FROM
    tbl_mp
    inner join tbl_planes_ingresados
    on tbl_planes_ingresados.id_mp=tbl_mp.id_mp
    and tbl_planes_ingresados.responsable='$rut'

    inner join tbl_usuario
    on tbl_usuario.rut=tbl_mp.rut


    inner join tbl_usuario as basecoach
    on basecoach.rut=tbl_mp.coach
    WHERE
    tbl_mp.id_empresa = '$id_empresa'
    and tbl_mp.nombre<>''
    GROUP BY tbl_mp.id
    order by tbl_mp.id desc

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoIvphPorRutEmpresaInteracciones($rut, $id_empresa, $id_mp)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_mp) {
        $sql_filtro = " and tbl_mp.id='$id_mp'";
    }
    $sql = "SELECT
    tbl_mp.*,
    tbl_usuario.nombre_completo as nombre_autor,
    basecoach.nombre_completo as nombre_coach

    FROM
    tbl_mp
    inner join tbl_mp_equipo
    on tbl_mp_equipo.id_mp=tbl_mp.id_mp
    and tbl_mp_equipo.rut='$rut'

    inner join tbl_usuario
    on tbl_usuario.rut=tbl_mp.rut

    inner join tbl_usuario as basecoach
    on basecoach.rut=tbl_mp.coach
    WHERE
    tbl_mp.id_empresa = '$id_empresa'
    and tbl_mp.nombre<>''
    $sql_filtro

    order by tbl_mp.id desc

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SGD_ExisteAe($evaluado, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select * from tbl_sgd_relaciones where evaluado='$evaluado' and evaluador='$evaluado' and id_proceso='$id_proceso' and id_empresa='$id_empresa'
    ";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function COMPASS_VerificoParaInformeFinal($evaluado, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    SELECT
    tbl_sgd_relaciones.evaluado,
    tbl_sgd_relaciones.evaluador,
    tbl_sgd_finalizados_evaluado_evaluador.fecha,
    (
    SELECT
    count(DISTINCT(objetivo))
    FROM
    tbl_sgd_fijacion
    WHERE
    tbl_sgd_fijacion.evaluado = tbl_sgd_relaciones.evaluado
    AND tbl_sgd_fijacion.evaluador = tbl_sgd_relaciones.evaluador
    AND tbl_sgd_fijacion.id_proceso = tbl_sgd_relaciones.id_proceso
    AND tbl_sgd_fijacion.tipo = 'objetivo'

    )AS total_fijacion_objetivos,

    (
    SELECT
    count(DISTINCT(areas_desarrollo))
    FROM
    tbl_sgd_fijacion
    WHERE
    tbl_sgd_fijacion.evaluado = tbl_sgd_relaciones.evaluado
    AND tbl_sgd_fijacion.evaluador = tbl_sgd_relaciones.evaluador
    AND tbl_sgd_fijacion.id_proceso = tbl_sgd_relaciones.id_proceso
    AND tbl_sgd_fijacion.tipo = 'plan'

    )AS total_fijacion_planes


    FROM
    tbl_sgd_relaciones
    LEFT JOIN tbl_sgd_finalizados_evaluado_evaluador ON tbl_sgd_finalizados_evaluado_evaluador.evaluado = tbl_sgd_relaciones.evaluado
    AND tbl_sgd_finalizados_evaluado_evaluador.evaluador = tbl_sgd_relaciones.evaluador
    WHERE
    tbl_sgd_relaciones.evaluado = '$evaluado'
    and tbl_sgd_relaciones.id_proceso = '$id_proceso'
    AND tbl_sgd_relaciones.evaluado <> tbl_sgd_relaciones.evaluador

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InteresesDesarrolloEvaluadoEvaluador($evaluado, $evaluador, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    SELECT
    tbl_sgd_respuestas_desarrollo_carrera.*,tbl_sgd_desarrollo_carrera.interes as nombre_interes
    FROM
    tbl_sgd_respuestas_desarrollo_carrera
    inner join tbl_sgd_desarrollo_carrera
    on tbl_sgd_desarrollo_carrera.id=tbl_sgd_respuestas_desarrollo_carrera.id_desarrollo_carrera
    WHERE
    tbl_sgd_respuestas_desarrollo_carrera.evaluado= '$evaluado'
    and tbl_sgd_respuestas_desarrollo_carrera.evaluador= '$evaluador'
    and tbl_sgd_respuestas_desarrollo_carrera.id_proceso= '$id_proceso'
    and tbl_sgd_respuestas_desarrollo_carrera.id_empresa= '$id_empresa'

    group by tbl_sgd_respuestas_desarrollo_carrera.id_desarrollo_carrera


    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UltimoMensajeMensajeria($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    SELECT
    tbl_mensajes_principal.*
    FROM
    tbl_mensajes_principal
    WHERE
    tbl_mensajes_principal.rut_creador = '$rut'
    AND tbl_mensajes_principal.id_empresa = '$id_empresa'
    ORDER BY
    tbl_mensajes_principal.id DESC
    LIMIT 1
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosAvanceEvaluadoEvaluador($evaluado, $evaluador, $id_proceso, $perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    SELECT
    (
    SELECT
    count(*)
    FROM
    tbl_objetivos_individuales
    WHERE
    tbl_objetivos_individuales.rut = '$evaluado'
    AND tbl_objetivos_individuales.id_proceso = '$id_proceso'
    )AS total_objetivos,
    (
    SELECT
    count(*)
    FROM
    tbl_sgd_respuestas
    WHERE
    tbl_sgd_respuestas.evaluado = '$evaluado'
    AND tbl_sgd_respuestas.evaluador = '$evaluador'
    AND tbl_sgd_respuestas.id_proceso = '$id_proceso'
    AND id_objetivo IS NOT NULL
    )AS total_respuestas_objetivos,
    (
    SELECT
    count(*)
    FROM
    tbl_sgd_respuestas
    WHERE
    tbl_sgd_respuestas.evaluado = '$evaluado'
    AND tbl_sgd_respuestas.evaluador = '$evaluador'
    AND tbl_sgd_respuestas.id_proceso = '$id_proceso'
    AND id_objetivo IS NULL
    )AS total_respuestas_competencias,
    (
    SELECT
    count(*)
    FROM
    tbl_sgd_preguntas
    INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = tbl_sgd_preguntas.id_competencia
    INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id
    AND rel_sgd_perfil_competencias.perfil_evaluacion = '$perfil'
    )AS total_preguntas
    FROM
    tbl_sgd_relaciones
    WHERE
    tbl_sgd_relaciones.evaluado = '$evaluado'
    AND tbl_sgd_relaciones.evaluador = '$evaluador'
    AND tbl_sgd_relaciones.id_proceso = '$id_proceso'


    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminaDesarrolloDeCarrera($evaluado, $evaluador, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_sgd_respuestas_desarrollo_carrera
    WHERE evaluado= '$evaluado' and
    evaluador='$evaluador' and
    id_proceso='$id_proceso' and
    id_empresa='$id_empresa' ");
    $connexion->query($sql);
    $connexion->execute();
}
function TienedesarrolloCarrera($evaluado, $evaluador, $id_proceso, $id_empresa, $id_desarrollo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select * from tbl_sgd_respuestas_desarrollo_carrera
    where evaluado='$evaluado' and
    evaluador='$evaluador' and
    id_empresa='$id_empresa' and
    id_proceso='$id_proceso'
    and id_desarrollo_carrera='$id_desarrollo'


    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminaFijacionPlanasasasas($evaluado, $evaluador, $id_proceso, $id_empresa, $numero, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_sgd_fijacion
    WHERE evaluado= '$evaluado' and
    evaluador='$evaluador' and
    id_proceso='$id_proceso' and
    id_empresa='$id_empresa' and
    numero='$numero' and
    tipo='$tipo'");
    $connexion->query($sql);
    $connexion->execute();
}
function VerificoFijacionObjetivosPlanes($evaluado, $evaluador, $id_proceso, $id_empresa, $tipo, $numero)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select * from tbl_sgd_fijacion
    where evaluado='$evaluado' and
    evaluador='$evaluador' and
    id_empresa='$id_empresa' and
    id_proceso='$id_proceso'
    and numero='$numero' and
    tipo='$tipo'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaPlanFijacion($evaluado, $evaluador, $id_proceso, $id_empresa, $area_desarrollo, $acciones_requeridas, $numero)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_fijacion
    set
    areas_desarrollo='$area_desarrollo',
    acciones_requeridas='$acciones_requeridas'
    where evaluado='$evaluado'
    and evaluador='$evaluador'
    and id_empresa='$id_empresa'
    and id_proceso='$id_proceso'
    and tipo='plan'
    and numero='$numero'    ";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaFijacion($evaluado, $evaluador, $id_proceso, $id_empresa, $objetivo, $medicion, $numero)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_fijacion
    set
    objetivo='$objetivo',
    medicion_cumplimiento='$medicion'
    where evaluado='$evaluado'
    and evaluador='$evaluador'
    and id_empresa='$id_empresa'
    and id_proceso='$id_proceso'
    and tipo='objetivo'
    and numero='$numero'    ";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeRelacionesSinAeDO($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select tbl_sgd_relaciones.*
    from tbl_sgd_relaciones
    inner join tbl_usuario
    on tbl_sgd_relaciones.evaluado=tbl_usuario.rut
    where tbl_sgd_relaciones.id_proceso='$id_proceso'
    and tbl_sgd_relaciones.evaluador='$evaluador'
    and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
    and (tbl_usuario.perfil_evaluacion='DO')

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function AbreEvaluacionSGD($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_sgd_sesion_evaluacion WHERE evaluado= '$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'");
    $connexion->query($sql);
    $connexion->execute();
}
function BorroSesionEvaluacion2($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "DELETE FROM tbl_sgd_sesion_evaluacion WHERE evaluador='" . $evaluador . "'  and id_proceso='$id_proceso'";
    $connexion->query($sql);
    $connexion->execute();
}
function ListadoIvphPorRutEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    tbl_usuario.nombre_completo as nombre_autor,

    tbl_mp.*,
    (select avg(seguimiento_grado_cumplimiento) from tbl_planes_ingresados where id_mp=tbl_mp.id_mp)as promedio_avances_plan,
    (select count(*) from tbl_mp_equipo where tbl_mp.id_mp=tbl_mp_equipo.id_mp) as total_equipo,
    (select count(*) from tbl_planes_ingresados where tbl_planes_ingresados.id_mp=tbl_mp.id_mp) as total_planes,
    basecoach.nombre_completo as nombre_coach
    FROM
    tbl_mp
    INNER JOIN tbl_mp_categorias on tbl_mp_categorias.id_categoria = tbl_mp.id_categoria

    inner join tbl_usuario
    on tbl_usuario.rut=tbl_mp.rut

    inner join tbl_usuario as basecoach
    on basecoach.rut=tbl_mp.coach


    WHERE
    tbl_mp.rut = '$rut'
    AND tbl_mp.id_empresa = '$id_empresa'




    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ComentariosFinalesEncSatis($id_objeto, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_enc_satis_comentarios_finales where id_objeto='$id_objeto' and id_empresa='$id_empresa' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function AlternativasDadoId2($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_alternativas

    where id='$id'";

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalcursosPorUsuaroEmpresa($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    rel_lms_malla_persona.rut,
    rel_lms_malla_persona.id_malla,
    rel_lms_malla_curso.id_curso,
    tbl_lms_curso.nombre, tbl_inscripcion_cierre.estado
    FROM
    rel_lms_malla_persona
    INNER JOIN rel_lms_malla_curso ON rel_lms_malla_curso.id_malla = rel_lms_malla_persona.id_malla
    inner join tbl_lms_curso
    on tbl_lms_curso.id=rel_lms_malla_curso.id_curso
    left join tbl_inscripcion_cierre
    on tbl_inscripcion_cierre.rut=rel_lms_malla_persona.rut and tbl_inscripcion_cierre.id_curso=rel_lms_malla_curso.id_curso and tbl_inscripcion_cierre.id_empresa=rel_lms_malla_curso.id_empresa

    WHERE
    rel_lms_malla_persona.rut = '$rut'
    and rel_lms_malla_persona.id_empresa='$id_empresa'
    and rel_lms_malla_curso.id_malla='$id_malla'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscaMallaapartirRutCursoObjeto($rut, $id_curso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select h.*,
    (select id_malla from rel_lms_malla_persona where rut='$rut' and id_malla=h.id_malla)
    from rel_lms_malla_curso h where h.id_curso='$id_curso' and h.id_empresa='$id_empresa'
    and (select id_malla from rel_lms_malla_persona where rut='$rut' and id_malla=h.id_malla)=h.id_malla
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscaMallaapartirRutObjeto($rut, $id_objeto, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "    select h.*,
    (select id_malla from rel_lms_malla_persona where rut='$rut' and id_malla=h.id_malla)
    from rel_lms_malla_curso h where h.id_curso=(select id_curso from tbl_objeto where id='$id_objeto') and h.id_empresa='$id_empresa'
    and (select id_malla from rel_lms_malla_persona where rut='$rut' and id_malla=h.id_malla)=h.id_malla";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalNivelPorUsuaroEmpresa($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT    h.*,
    (select idorden from tbl_gamificado_nivel where idnivel=h.id_nivel) as idorden
    FROM
    tbl_nivel_finalizado h
    WHERE
    h.rut = '$rut'   and h.id_malla='$id_malla' order by id DESC limit 1";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function buscapuntosydesafiospormallarut($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select sum(h.puntos) as puntosganados FROM tbl_gamificado_puntos h where h.rut='$rut' and h.id_malla='$id_malla' and h.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalNivelesMalla($id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select count(id) as cuenta

    from tbl_gamificado_nivel

    where idmalla='$id_malla' and idempresa='$id_empresa'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscaTotalOBjetosCursosIdMalla($id_empresa, $id_malla, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    SELECT count(tbl_objeto.id) as cuentaobjetostotales,
    (select count(id) from tbl_objetos_finalizados where rut='$rut' and id_objeto=tbl_objeto.id) as cuentafinalizados
    FROM tbl_objeto
    INNER JOIN rel_lms_malla_curso ON tbl_objeto.id_curso = rel_lms_malla_curso.id_curso
    where rel_lms_malla_curso.id_malla = '$id_malla'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function buscaCursosFinalizados_Totales($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select h.*,
    (select estado from tbl_inscripcion_cierre where rut='$rut' and id_curso=h.id_curso) as estado

    from rel_lms_malla_curso h

    where h.id_malla='$id_malla' and h.opcional<>1
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function NivelesFinalizadosSinMalla($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select h.*, count(id) as cuenta

    from tbl_nivel_finalizado h

    where h.rut='$rut'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function NivelesFinalizados($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select h.*, count(id) as cuenta

    from tbl_nivel_finalizado h

    where h.rut='$rut' and h.id_malla='$id_malla'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscoMallaDadoProgramaRut($rut, $id_empresa, $id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


    select h.*,
    (select id_programa from rel_lms_malla_curso where id_malla=h.id_malla limit 1)
    from rel_lms_malla_persona h
    where h.rut='$rut' and h.id_empresa='$id_empresa'
    AND (select id_programa from rel_lms_malla_curso where id_malla=h.id_malla limit 1)='$id_programa'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}

function BuscaAvanceMallaPrograma($rut, $id_empresa, $id_malla){

    $connexion = new DatabasePDO();
    
    
    $sql = "

   select avg(h.avance) as avance from tbl_lms_reportes h where rut='$rut' and id_malla='$id_malla' and id_empresa='$id_empresa'

    ";

    //echo "<br><br>$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->avance;


}


function BuscoMallaDadoClasProgramaRut($rut, $id_empresa, $id_programa, $id_clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select h.*,
    (select id_programa from rel_lms_malla_curso where id_malla=h.id_malla limit 1),
    (SELECT    id_clasificacion    FROM    rel_lms_malla_curso    WHERE    id_malla = h.id_malla    LIMIT 1    ) as id_clasificacion

    from rel_lms_malla_persona h

    where h.rut='$rut' and h.id_empresa='$id_empresa'
    and (SELECT    id_clasificacion    FROM    rel_lms_malla_curso    WHERE    id_malla = h.id_malla and id_clasificacion='$id_clasificacion'    limit 1)='$id_clasificacion'
    AND (select id_programa from rel_lms_malla_curso where id_malla=h.id_malla limit 1)='$id_programa'

    ";

    //echo "<br><br>$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscaNivelAccionBoton($id_empresa, $codigo, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select * from tbl_gamificado_nivel_botones where id_empresa='$id_empresa' and tipo='$tipo' and codigo='$codigo'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BuscaCursodesdeGamificadoNivel($id_malla, $id_empresa, $id_orden)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select * from tbl_gamificado_nivel where idempresa='$id_empresa' and idmalla='$id_malla' and idorden='$id_orden'
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function buscaNivelRol($rut, $id_empresa, $id_malla, $nivel_actual)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select h.id, h.descripcion,
    (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual') as idnivel,
    (select idcurso from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual') as idcurso_actual,
    (select textodescripcion from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual') as template_detalle_cursoCap,

    (select nombre from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as nivelnombre,
    (select imagenbackhome from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as imagenbackhome,
    (select imagenbackhometemplate from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as imagenbackhometemplate,

    (select menuactivo from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as menuactivo,
    (select nivelactivo from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as nivelactivo,
    (select cursoactivo from tbl_gamificado_niveles_descripcion where idnivel= (select idnivel from tbl_gamificado_nivel where idmalla='$id_malla' and idorden='$nivel_actual')) as cursoactivo,

    (select descripcion from tbl_lms_malla where id='$id_malla') as descripcionRol

    from tbl_lms_malla h

    where h.id='$id_malla' and h.id_empresa='$id_empresa'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPlanesPorMp($id_mp, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select
    tbl_planes_ingresados.*,
    tbl_usuario.nombre_completo
    from tbl_planes_ingresados
    inner join tbl_usuario
    on tbl_usuario.rut=tbl_planes_ingresados.responsable
    where tbl_planes_ingresados.id_mp='$id_mp'
    and tbl_planes_ingresados.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoPlanMP($id_mp, $id_empresa, $rut, $causa_raiz, $plan, $responsable, $fecha)
{
    $connexion = new DatabasePDO();
    
    
    $ultimo_id = ObtengoUltimoRegistroMP($id_empresa);
    $nuevo_id  = $ultimo_id[0]->id;
    $nuevo_id  = $nuevo_id + 1;
    $sql       = "INSERT INTO tbl_planes_ingresados(id_mp, id_empresa, evaluado, causa_raiz, plan, responsable, fecha) " . "VALUES ('$id_mp', '$id_empresa', '$rut', '$causa_raiz', '$plan', '$responsable', '$fecha');";
    $connexion->query($sql);
    $connexion->execute();
}
function Obtenerpracticascompartidos($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select h.*
    from tbl_objeto_comentarios h where rut='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalEquipoPorMp($id_mp, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    tbl_mp_equipo.*, tbl_usuario.nombre_completo
    FROM
    tbl_mp_equipo

    inner join tbl_usuario
    on tbl_usuario.rut=tbl_mp_equipo.rut
    WHERE
    tbl_mp_equipo.id_mp = '$id_mp'
    AND tbl_mp_equipo.id_empresa = '$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoColaboadoresEquipoMP($rut, $id_empresa, $id_mp)
{
    $connexion = new DatabasePDO();
    
    
    $ultimo_id = ObtengoUltimoRegistroMP($id_empresa);
    $nuevo_id  = $ultimo_id[0]->id;
    $nuevo_id  = $nuevo_id + 1;
    $sql       = "INSERT INTO tbl_mp_equipo(id_mp, rut, id_empresa) " . "VALUES ('$id_mp', '$rut', '$id_empresa' );";
    $connexion->query($sql);
    $connexion->execute();
}
function cuposdiponibles($codigo_inscripcion, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select count(h.id) as cuenta,
    (select cupos from tbl_inscripcion_curso where codigo_inscripcion='$codigo_inscripcion' and id_empresa='$id_empresa') as cupos
    from tbl_inscripcion_usuarios h
    where h.id_inscripcion='$codigo_inscripcion'
    and (h.estadoinscripcion='PREINSCRITO' or h.estadoinscripcion='INSCRITO')  and h.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaComentariosfinalesSGD($evaluado, $evaluador, $id_empresa, $id_proceso, $comentario, $sucesor)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_comentarios_finales
    set
    comentario='$comentario',
    sucesor='$sucesor'
    where evaluado='$evaluado'
    and evaluador='$evaluador'
    and id_empresa='$id_empresa'
    and id_proceso='$id_proceso'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaPoder($rut, $id_empresa, $malla, $clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $ultimo_id = ObtengoUltimoRegistroMP($id_empresa);
    $nuevo_id  = $ultimo_id[0]->id;
    $nuevo_id  = $nuevo_id + 1;
    $sql       = "INSERT INTO tbl_poderes(rut, id_empresa, id_malla, id_clasificacion) " . "VALUES ('$rut', '$id_empresa', '$malla', '$clasificacion');";
    $connexion->query($sql);
    $connexion->execute();
}
function ListaCursosDisponibleYDatosPorCurso($rut, $id_empresa, $id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select h.*,
    (select nombre from tbl_lms_curso where id=h.id_curso) as nombre_curso,
    (select descripcion from tbl_lms_curso where id=h.id_curso) as descripcion_curso,
    (select imagen from tbl_lms_curso where id=h.id_curso) as imagen_curso,

    (select descriptor from tbl_lms_curso where id=h.id_curso) as descriptor,
    (select descripcion from tbl_lms_curso where id=h.id_curso) as descripcion,
    (select acercade from tbl_lms_curso where id=h.id_curso) as acercade,
    (select objetivo_curso from tbl_lms_curso where id=h.id_curso) as objetivo_curso,

    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='INSCRITO' ) as Inscritos,
    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='PREINSCRITO') as Preinscritos,
    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='LISTAESPERA') as ListaEspera

    from tbl_inscripcion_curso h
    where h.id_empresa='$id_empresa'
    and h.id_curso='$id_curso'
    and
    (select modalidad from tbl_lms_curso where id=h.id_curso)='5'
    ORDER BY UNIX_TIMESTAMP(fecha_inicio) ASC
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListaCursosDisponibleYDatosPorCursoInscripcion($rut, $id_empresa, $id_curso, $id_inscripcion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select h.*,
    (select nombre from tbl_lms_curso where id=h.id_curso) as nombre_curso,
    (select descripcion from tbl_lms_curso where id=h.id_curso) as descripcion_curso,
    (select imagen from tbl_lms_curso where id=h.id_curso) as imagen_curso,

    (select descriptor from tbl_lms_curso where id=h.id_curso) as descriptor,
    (select descripcion from tbl_lms_curso where id=h.id_curso) as descripcion,
    (select acercade from tbl_lms_curso where id=h.id_curso) as acercade,
    (select objetivo_curso from tbl_lms_curso where id=h.id_curso) as objetivo_curso,

    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='INSCRITO' ) as Inscritos,
    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='PREINSCRITO') as Preinscritos,
    (select count(id) from tbl_inscripcion_usuarios where id_inscripcion=h.codigo_inscripcion and estadoinscripcion='LISTAESPERA') as ListaEspera

    from tbl_inscripcion_curso h
    where h.id_empresa='$id_empresa'
    and h.codigo_inscripcion='$id_inscripcion'
    and
    (select modalidad from tbl_lms_curso where id=h.id_curso)='5'
    ORDER BY UNIX_TIMESTAMP(fecha_inicio) ASC
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaEstadoAccionPendiente($rut, $id_empresa, $codigo_inscripcion, $id_curso, $rut_jefe, $estado)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_lms_acciones_pendientes
    set   estado='$estado'
    where rut_jefe='$rut_jefe' and rut_colaborador='$rut' and id_empresa='$id_empresa' and id_curso='$id_curso' and codigo_inscripcion='$codigo_inscripcion'";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaInscripcipnCurso($rut, $id_curso, $id_empresa, $id_inscripcion, $estadoinscripcion)
{
    $connexion = new DatabasePDO();
    
    if ($estadoinscripcion == "1") {
        $sql_inscrito = "estadoinscripcion='INSCRITO', inscrito='1'";
    } else {
        $sql_inscrito = "estadoinscripcion='RECHAZADO', inscrito = null ";
    }
    $sql = "update tbl_inscripcion_usuarios
    set $sql_inscrito
    where rut='$rut' and id_inscripcion='$id_inscripcion' and id_empresa='$id_empresa' and id_curso='$id_curso'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaInscripcionCursos($rut, $id_empresa, $codigo_inscripcion, $id_curso, $tipo, $rut_jefatura, $cupos_disponibles)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select count(id) as cuenta from tbl_inscripcion_postulantes  where id_inscripcion='$codigo_inscripcion' and id_empresa='$id_empresa'
    and id_curso='$id_curso' and rut='rut'";
    $connexion->query($sql);
    
    $cod    = $connexion->resultset();
    $cuenta = $cod->cuenta;
    if ($cuenta == 0) {
        $sql = "INSERT INTO tbl_inscripcion_postulantes (
    rut,
    id_curso,
    id_empresa,
    id_inscripcion,
    estadoinscripcion,
    inscrito,
    fecha,
    hora) " . "VALUES ('$rut', '$id_curso', '$id_empresa', '$codigo_inscripcion','$tipo', '1','" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
        $connexion->query($sql);
        $connexion->execute();
        InsertaAccionPendiente($rut, $rut_jefatura, "", $id_curso, $id_empresa, "0", "", "", "1", $codigo_inscripcion);
    }
}
function ActualizaInscripcionPostulacionCursos($rut, $id_empresa, $codigo_inscripcion, $id_curso, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "UPDATE  tbl_inscripcion_postulantes

    set preinscrito='$tipo',

    fecha='" . date("Y-m-d") . "', hora='" . date("H:i:s") . "'

    where id_inscripcion='$codigo_inscripcion' and id_empresa='$id_empresa'
    and id_curso='$id_curso' and rut='$rut'";
    $connexion->query($sql);
    $connexion->execute();
    $cod    = $connexion->resultset();
    $cuenta = $cod->cuenta;
}
function buscaidinscripcioncurso($idc, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select h.* from tbl_inscripcion_curso h where h.codigo_inscripcion='$idc' and h.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminoAccionesPendientes($rut, $id_objeto, $id_curso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_lms_acciones_pendientes WHERE rut_colaborador= '$rut' and id_objeto='$id_objeto' and id_curso='$id_curso' and id_empresa='$id_empresa'");
    $connexion->query($sql);
    $connexion->execute();
}
function Lms_Busca_Tareas_Pendientes_data($rut_colaborador, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
    h.*,
    (select nombre from tbl_lms_curso where id=h.id_curso and id_empresa=h.id_empresa) as nombre_curso,
    (select titulo from tbl_objeto where id=h.id_objeto and id_curso=h.id_curso) as nombre_objeto,
    (select descripcion from tbl_objeto where id=h.id_objeto and id_curso=h.id_curso) as descripcion_objeto

    FROM
    tbl_lms_tareas h
    WHERE
    AND h.rut= '$rut_colaborador'
    AND h.id_empresa = '$id_empresa'
    and h.estado='0'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneTareasPorObjeroCursoempresaRut($rut, $id_empresa, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  * from tbl_lms_tareas where rut='$rut' and id_empresa='$id_empresa' and id_curso='$id_curso' and id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaTareaColaborador($rut, $id_empresa, $id_curso, $id_objeto, $nombre_archivo, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_lms_tareas(rut, comentario, nombre_documento, fecha, hora, id_empresa, id_curso, id_objeto) " . "VALUES ('$rut', '$comentario', '$nombre_archivo', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa', '$id_curso', '$id_objeto');";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaNotaAeMedioCiclo($id_objetivo, $nota_ae)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_objetivos_individuales
    set   nota_medio_ciclo_ae='$nota_ae'
    where id='$id_objetivo'";
    $connexion->query($sql);
    $connexion->execute();
}
function UsuarioEnBasePersonaPorEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario  where rut='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosBiografiaProfesionalPorEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario_biografia where rut='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosBiografiaProfesional($rut, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario_biografia where rut='$rut' and id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosBiografiaProfesionalUnico($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario_biografia where rut='$rut' limit 1";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function buscaUserBciData($email, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario where email='$email' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioSeEncuentraEnProcesoEvaluacion($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_relaciones where (evaluado='$rut' or evaluador='$rut') and id_proceso='$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneAccionesPEndientesSinObjetos($rut, $id_empresa, $id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  * from tbl_lms_acciones_pendientes where rut_colaborador='$rut' and id_empresa='$id_empresa' and id_curso='$id_curso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneAccionesPEndientes($rut, $id_empresa, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  * from tbl_lms_acciones_pendientes where rut_colaborador='$rut' and id_empresa='$id_empresa' and id_curso='$id_curso' and id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaAccionPendiente($rut_colaborador, $rut_jefatura, $id_objeto, $id_curso, $id_empresa, $estado, $comentario, $nombre_archivo, $inscripcion_curso, $codigo_inscripcion)
{
    $connexion = new DatabasePDO();
    
    
    if ($inscripcion_curso == "1") {
        $sql = "INSERT INTO tbl_lms_acciones_pendientes(
    rut_jefe, rut_colaborador, id_empresa, id_curso, id_objeto, estado, fecha, hora, comentario, nombre_documento, inscripcion_curso, codigo_inscripcion
    ) VALUES (
    '$rut_jefatura',
    '$rut_colaborador',
    '$id_empresa',
    '$id_curso',
    '$id_objeto',
    '$estado',
    '" . date("Y-m-d") . "',
    '" . date("H:i:s") . "',
    '" . $comentario . "',
    '" . $nombre_archivo . "',
    '1',
    '$codigo_inscripcion');";
    } else {
        $sql = "INSERT INTO tbl_lms_acciones_pendientes(
    rut_jefe, rut_colaborador, id_empresa, id_curso, id_objeto, estado, fecha, hora, comentario, nombre_documento
    ) VALUES (
    '$rut_jefatura',
    '$rut_colaborador',
    '$id_empresa',
    '$id_curso',
    '$id_objeto',
    '$estado',
    '" . date("Y-m-d") . "',
    '" . date("H:i:s") . "',
    '" . $comentario . "',
    '" . $nombre_archivo . "');";
    }
    $connexion->query($sql);
    $connexion->execute();
}
function EsJefetblUsuario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select count(id) as cuenta from tbl_usuario where jefe='$rut' and id_empresa='$id_empresa'
    ";
    //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}

function EsJefeLidertblUsuario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
    select count(id) as cuenta from tbl_usuario where (jefe='$rut' or lider='$rut') and id_empresa='$id_empresa'
    ";
    //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->cuenta;
}

function EliminoRespuestasTrivias($rut, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_evaluaciones_sesion WHERE rut= '$rut' and id_objeto='$id_objeto'");
    $connexion->query($sql);
    $connexion->execute();
    $sql = sprintf("DELETE from tbl_evaluaciones_respuestas WHERE rut= '$rut' and id_objeto='$id_objeto'");
    $connexion->query($sql);
    $connexion->execute();
}
function PreguntasEvalDadoIdObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_evaluaciones.nombre_evaluacion, tbl_evaluaciones_preguntas.pregunta, tbl_evaluaciones_preguntas.id_grupo_alternativas, tbl_evaluaciones_preguntas.orden as orden_preguntas from tbl_evaluaciones
    inner join tbl_evaluaciones_preguntas
    on tbl_evaluaciones_preguntas.evaluacion=tbl_evaluaciones.id
    where id_objeto='$id_objeto'
    order by orden_preguntas asc
    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaAlternativaPAraEvalPreguntas($id_grupo_alternativas, $alternativa, $correcta, $orden)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluaciones_alternativas(
    id_grupo_alternativas, alternativa, correcta, orden
    ) " . "VALUES (
    '$id_grupo_alternativas', '$alternativa', '$correcta', '$orden'


    );";
    $connexion->query($sql);
    $connexion->execute();
}
function ObtenerUltimoGrupoAlternativa()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select max(id_grupo_alternativas)as numero_mayor from tbl_evaluaciones_alternativas    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaPreguntasPorEvaluacion($pregunta, $id_evaluacion, $orden, $id_grupo_alternativas)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluaciones_preguntas(
    pregunta, tipo, evaluacion, orden, id_grupo_alternativas
    ) " . "VALUES ('$pregunta', '1', '$id_evaluacion', '$orden', '$id_grupo_alternativas'


    );";
    $connexion->query($sql);
    $connexion->execute();
}
function EvaluacionDadoIdObjeto($id_empresa, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "

    select * from tbl_evaluaciones where id_empresa='$id_empresa' and id_curso='$id_curso' and id_objeto='$id_objeto'

    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CreoEvaluacionPorObjeto($id_empresa, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluaciones(
    nombre_evaluacion, id_empresa, id_curso, id_objeto
    ) " . "VALUES ('$id_objeto', '$id_empresa', '$id_curso', '$id_objeto'
    );";
    $connexion->query($sql);
    $sql = "select max(id) as ultimo_id_evaluacion from tbl_evaluaciones ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    $sql = "update tbl_objeto set id_evaluacion='" . $cod[0]->ultimo_id_evaluacion . "' where id='$id_objeto'";
    $connexion->query($sql);
    $connexion->execute();
    return $cod;
}
function TraigoIdEncuestaDadoIdCurso($id_empresa, $id_curso)
{
    $connexion = new DatabasePDO();
    $sql = " select tbl_lms_programas_bbdd.id_enc_sat from rel_lms_malla_curso
left join tbl_lms_programas_bbdd
on tbl_lms_programas_bbdd.id_programa=rel_lms_malla_curso.id_programa
where id_curso='$id_curso' and rel_lms_malla_curso.id_empresa='$id_empresa' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoObjetoCheckin($arreglo, $id_empresa, $id_curso, $orden, $id_curso_real){
    $connexion = new DatabasePDO();
    if ($id_curso_real) {
        $datos_encuesta = TraigoIdEncuestaDadoIdCurso($id_empresa, $id_curso_real);
        if ($datos_encuesta[0]->id_enc_sat) {
            $id_encuesta = $datos_encuesta[0]->id_enc_sat;
        } else {
            $id_encuesta = $arreglo->id_encuesta;
        }
    } else {
        $id_encuesta = $arreglo->id_encuesta;
    }
    if ($arreglo->tipo_objeto <> "6") {
        $id_encuesta = 0;
    }
    $sql = "INSERT INTO tbl_objeto(
     id,
     tipo_objeto,
     titulo,
     titulo_relator,
     descripcion,
     id_curso,
     extension_objeto,
     id_encuesta,
     orden,
     imagen,
     id_empresa,
     titulo_principal,
     pregunta_principal,
     bajada_principal,
     titulo_secundario,
     bajada_secundario,
     subtitulo_principal,
     bajada_subtitulo_principal,
     opcional,
     checkin,
     url_volver_checkin
     ) " . "VALUES (
     '" . $id_curso . "_" . $arreglo->id . "',
     '" . $arreglo->tipo_objeto . "',
     '" . $arreglo->titulo . "',
     '" . $arreglo->titulo_relator . "',
     '" . $arreglo->descripcion . "',
     '" . $id_curso . "',
     '" . $arreglo->extension_objeto . "',
     '" . $id_encuesta . "',
     '" . $orden . "',
     '" . $arreglo->imagen . "',
     '" . $id_empresa . "',
     '" . $arreglo->titulo_principal . "',
     '" . $arreglo->pregunta_principal . "',
     '" . $arreglo->bajada_principal . "',
     '" . $arreglo->titulo_secundario . "',
     '" . $arreglo->bajada_secundario . "',
     '" . $arreglo->subtitulo_principal . "',
     '" . $arreglo->bajada_subtitulo_principal . "',
     '" . $arreglo->opcional . "',
     '" . $arreglo->checkin . "',
     '" . $arreglo->url_volver_checkin . "'
)    ;";
    $connexion->query($sql);
    $connexion->execute();
}
function CHECK_TraeObjetosPAraIngresar()
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select * from tbl_checkin_objeto ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CHECK_ObjetosPorCurso($id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto where id_curso='$id_curso'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MP_TraigoSubCategoriasDadoCategoria($id_categoria, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_mp_subcategorias where id_empresa='$id_empresa' and id_categoria='$id_categoria'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ComentariosPorMallaEmpresaLimit($id_malla, $id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $lmite = "limit $limit";
    }
    $sql = "
     select
     tbl_objeto_comentarios.*, nombre_completo, tbl_lms_curso.nombre as valor_categoria




     from tbl_objeto_comentarios
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objeto_comentarios.rut


     inner join tbl_lms_curso
     on tbl_lms_curso.id=tbl_objeto_comentarios.id_curso


     where tbl_objeto_comentarios.id_empresa='$id_empresa' and id_malla='$id_malla'
     order by id desc
     $lmite


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ComentariosPorMallaEmpresa($id_malla, $id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limite = "limit $limit";
    }
    $sql = "
     select
     tbl_objeto_comentarios.*, nombre_completo, tbl_lms_curso.nombre as valor_categoria,
     (select count(*) as total from tbl_objeto_comentarios_megusta where tbl_objeto_comentarios_megusta.id_comentario=tbl_objeto_comentarios.id ) as total_megusta


     from tbl_objeto_comentarios
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objeto_comentarios.rut


     inner join tbl_lms_curso
     on tbl_lms_curso.id=tbl_objeto_comentarios.id_curso


     where tbl_objeto_comentarios.id_empresa='$id_empresa' and id_malla='$id_malla'
     order by total_megusta desc
     $limite";
    $sql = "
     select
     tbl_objeto_comentarios.*, nombre_completo, tbl_lms_curso.nombre as valor_categoria,
     (select count(*) as total from tbl_objeto_comentarios_megusta where tbl_objeto_comentarios_megusta.id_comentario=tbl_objeto_comentarios.id ) as total_megusta


     from tbl_objeto_comentarios
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objeto_comentarios.rut


     inner join tbl_lms_curso
     on tbl_lms_curso.id=tbl_objeto_comentarios.id_curso


     where tbl_objeto_comentarios.id_empresa='$id_empresa' and id_malla='$id_malla'
     order by total_megusta desc
     $limite";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoComentarioPorMallaEmpresa($rut, $comentario, $id_curso, $id_malla, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $existe_comentario = ComentariosPorObjetoDuplicado($id_objeto, $comentario, $rut);
    if (!$existe_comentario) {
        $sql = "INSERT INTO tbl_objeto_comentarios(rut, comentario, fecha, hora, id_malla, id_empresa, id_curso) " . "VALUES ('$rut', '$comentario', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_malla', '$id_empresa', '$id_curso');";
        $connexion->query($sql);
        $connexion->execute();
    } else {
        echo "<script>
     alert('Comentario ya existe');
     </script>";
    }
}
function ObtenerCursosDadoMalla2($id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select tbl_lms_curso.nombre, tbl_lms_curso.id from rel_lms_malla_curso
     inner join tbl_lms_curso
     on tbl_lms_curso.id=rel_lms_malla_curso.id_curso
     where rel_lms_malla_curso.id_malla='$id_malla' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerRankigPorAvanceMallaempresa($limit, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_empresa == 52) {
        $sql = "


select tbl_inscripcion_cierre.rut, nombre_completo, cargo, avg(tbl_inscripcion_cierre.avance) as promedio, rel_lms_malla_persona.rut,
     rel_lms_malla_persona.id_malla,
(    select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut limit 1) as cuentacomentarios,
     (select sum(medallas) from tbl_gamificado_puntos where rut=tbl_inscripcion_cierre.rut limit 1) as cuentamedallas,
     (select sum(puntos) from tbl_gamificado_puntos where rut=tbl_inscripcion_cierre.rut limit 1) as cuentapuntos,
(
     round(


count(*)*
        (1+avg(tbl_inscripcion_cierre.avance)) * (1 + (select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut limit 1)/5) * (1+(select medallas from tbl_gamificado_puntos_consolidado where rut=tbl_inscripcion_cierre.rut limit 1)/5)
        )


        ) as valor


     from tbl_inscripcion_cierre




inner join rel_lms_malla_persona
on rel_lms_malla_persona.rut=tbl_inscripcion_cierre.rut
inner join tbl_usuario
on tbl_usuario.rut=tbl_inscripcion_cierre.rut
where id_malla='$id_malla' and tbl_inscripcion_cierre.id_empresa='$id_empresa'
group BY tbl_inscripcion_cierre.rut
order by


(    select sum(medallas) from tbl_gamificado_puntos where rut=tbl_inscripcion_cierre.rut limit 1) desc,
(    select sum(puntos) from tbl_gamificado_puntos where rut=tbl_inscripcion_cierre.rut limit 1) desc


limit 3";
    } else {
        $sql = "


select tbl_inscripcion_cierre.rut, nombre_completo, cargo, avg(tbl_inscripcion_cierre.avance) as promedio, rel_lms_malla_persona.rut,
     rel_lms_malla_persona.id_malla,








(    select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut) as cuentacomentarios,
(    select medallas from tbl_gamificado_puntos_consolidado where rut=tbl_inscripcion_cierre.rut) as cuentamedallas,


(
     round(


count(*)*
     (1+avg(tbl_inscripcion_cierre.avance)) * (1 + (select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut)/5) * (1+(select medallas from tbl_gamificado_puntos_consolidado where rut=tbl_inscripcion_cierre.rut)/5)
     )


     ) as valor


     from tbl_inscripcion_cierre




inner join rel_lms_malla_persona
on rel_lms_malla_persona.rut=tbl_inscripcion_cierre.rut
inner join tbl_usuario
on tbl_usuario.rut=tbl_inscripcion_cierre.rut
where id_malla='$id_malla' and tbl_inscripcion_cierre.id_empresa='$id_empresa'
group BY tbl_inscripcion_cierre.rut
order by valor desc
limit $limit";
    }
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerRankigPorAvanceMallaempresaIndividual($limit, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select h.rut, nombre_completo, cargo, avg(h.avance) as promedio,
rel_lms_malla_persona.rut, rel_lms_malla_persona.id_malla,
(    select sum(puntos) from tbl_gamificado_puntos where rut=h.rut and id_empresa=h.id_empresa and id_malla='$id_malla') as puntos




     from tbl_inscripcion_cierre h


     inner join rel_lms_malla_persona on rel_lms_malla_persona.rut=h.rut
     inner join tbl_usuario on tbl_usuario.rut=h.rut where id_malla='$id_malla'
     and h.id_empresa='$id_empresa'


     GROUP BY h.rut order by puntos desc limit $limit";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PuntosPersonalesHomeBciRev_data($rut, $id_empresa, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select tbl_inscripcion_cierre.rut, nombre_completo, cargo, avg(tbl_inscripcion_cierre.avance) as promedio, rel_lms_malla_persona.rut,
rel_lms_malla_persona.id_malla,
(    select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut) as cuentacomentarios,
(    select medallas from tbl_gamificado_puntos_consolidado where rut=tbl_inscripcion_cierre.rut) as cuentamedallas,


(
     round(
count(*)*
     (1+avg(tbl_inscripcion_cierre.avance)) * (1 + (select count(id) from tbl_objeto_comentarios where rut=tbl_inscripcion_cierre.rut)/5) * (1+(select medallas from tbl_gamificado_puntos_consolidado where rut=tbl_inscripcion_cierre.rut)/5)
     )
     ) as valor


from tbl_inscripcion_cierre


inner join rel_lms_malla_persona
on rel_lms_malla_persona.rut=tbl_inscripcion_cierre.rut
inner join tbl_usuario
on tbl_usuario.rut=tbl_inscripcion_cierre.rut
where id_malla='$id_malla' and tbl_inscripcion_cierre.id_empresa='$id_empresa' and tbl_inscripcion_cierre.rut='$rut'


group BY tbl_inscripcion_cierre.rut
order by valor desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MegustaPorComentarioReply($id_comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto_comentarios_reply_megusta
     where id_comentario='$id_comentario' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarMegustaPorComentarioDeObjetoReply($id_comentario, $rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objeto_comentarios_reply_megusta(id_comentario, rut, id_empresa, fecha, hora) " . "VALUES ('$id_comentario', '$rut', '$id_empresa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function MegustaPorComentarioRutReply($id_comentario, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select * from tbl_objeto_comentarios_reply_megusta
     where id_comentario='$id_comentario' and rut='$rut' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerUltimocomentarioIngresadoPorObjRut($id_objeto, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select max(id) as ultimo from tbl_objeto_comentarios where id_objeto='$id_objeto' and rut='$rut'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarComentarioPorEnc2($id_empresa, $id_objeto, $rut, $id_encuesta, $comentario, $comentario2, $rut_relator)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_enc_satis_comentarios_finales(id_encuesta, id_objeto, id_empresa, rut, comentario, fecha, hora, comentario2, rut_relator) " . "VALUES ('$id_encuesta', '$id_objeto','$id_empresa', '$rut', '$comentario', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$comentario2', '$rut_relator');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertarComentarioPorEnc($id_empresa, $id_objeto, $rut, $id_encuesta, $comentario, $comentario2)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_enc_satis_comentarios_finales(id_encuesta, id_objeto, id_empresa, rut, comentario, fecha, hora, comentario2) " . "VALUES ('$id_encuesta', '$id_objeto','$id_empresa', '$rut', '$comentario', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$comentario2');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificoEncuestaFinalizadaConIDObjeto($id_encuesta, $id_empresa, $rut, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select
     *
     from tbl_enc_satis_finalizados
     where rut='$rut'
     and id_encuesta='$id_encuesta'
     and id_empresa='$id_empresa'
     and id_objeto='$id_objeto'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerCompromisosDadoIdObjeto($id_objeto, $id_empresa, $limit)
{
    $datos_empresa = DatosEmpresa($id_empresa);
    $connexion = new DatabasePDO();
    
    
    if ($limit == "") {
        $limit = " limit 10";
    } else {
        $limit = " limit $limit";
    }
    $sql = "
     SELECT
     tbl_objeto_compromisos.*, nombre_completo, tbl_usuario.rut,
     (select count(*) as total from tbl_objeto_compromisos_megusta where tbl_objeto_compromisos_megusta.id_compromiso=tbl_objeto_compromisos.id) as total_megusta
from
     tbl_objeto_compromisos
inner join tbl_usuario
on tbl_usuario.rut=tbl_objeto_compromisos.rut
where tbl_objeto_compromisos.id_objeto='$id_objeto'
order by total_megusta DESC, fecha, hora desc $limit
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MegustaPorCompromisoRut($id_compromiso, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto_compromisos_megusta
     where id_compromiso='$id_compromiso' and rut='$rut'




";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MegustaPorCompromiso($id_compromiso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto_compromisos_megusta
     where id_compromiso='$id_compromiso'




";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarMegustaPorCompromisoDeObjeto($id_compromiso, $rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objeto_compromisos_megusta(id_compromiso, rut, id_empresa, fecha, hora) " . "VALUES ('$id_compromiso', '$rut', '$id_empresa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function CompromisosPorObjetosDatos($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_objeto_compromisos.*, tbl_usuario.nombre_completo
     from tbl_objeto_compromisos
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objeto_compromisos.rut
     where tbl_objeto_compromisos.id_objeto='$id_objeto'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaCompromisoPorObjetoRut($rut, $id_objeto, $compromiso, $meta, $plan, $id_empresa, $pa1, $pc1, $pa2, $pc2, $pa3, $pc3)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "INSERT INTO tbl_objeto_compromisos(id_objeto, rut, compromiso, meta, plan, fecha, hora, pa1, pc1, pa2, pc2, pa3, pc3) " . "VALUES ('$id_objeto', '$rut', '$compromiso', '$meta', '$plan', '$fecha', '$hora', '$pa1', '$pc1', '$pa2', '$pc2', '$pa3', '$pc3');";
    $connexion->query($sql);
    $connexion->execute();
}
function ReplysPorComentarios($id_comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_objeto_comentarios_respuestas.*, tbl_usuario.nombre_completo
     from tbl_objeto_comentarios_respuestas
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objeto_comentarios_respuestas.rut
     where id_comentario='$id_comentario'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaReplyComentarioPorObjeto($id_empresa, $rut, $comentario, $id_comentario)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "INSERT INTO tbl_objeto_comentarios_respuestas(comentario, rut, id_comentario, id_empresa, fecha, hora) " . "VALUES ('$comentario', '$rut', '$id_comentario', '$id_empresa', '$fecha', '$hora');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosCursoTodos($id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_lms_curso where id='$id_curso'";
//    echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaEstadoPlanesPorProcesoEmpresa($rut, $id_proceso_plan, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT * FROM  tbl_planes_estados  WHERE evaluado= '$rut' and id_empresa='$id_empresa' and id_proceso_plan='$id_proceso_plan'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalMensajerPorObjetoMensajeria($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "    select  * from tbl_mensajes_principal where id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPreguntasDadoIdObjetoEmpresa($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select h.*, (select count(id) from tbl_evaluaciones_preguntas where evaluacion=h.id) as cuenta from tbl_evaluaciones h where h.id_objeto='$id_objeto'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalComentariosDadoIdObjetoEmpresa($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto_comentarios
     where id_objeto='$id_objeto'




";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEncuestaFinalizada2($id_encuesta, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select  * from tbl_enc_satis_finalizados where  id_encuesta='$id_encuesta' and id_empresa='$id_empresa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEncuestaFinalizadaCheckin($id_encuesta, $id_objeto, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  * from tbl_enc_satis_finalizados where  id_encuesta='$id_encuesta' and id_objeto='$id_objeto' and id_empresa='$id_empresa' group by rut";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TodasFotosPorObjetoEmpresa($id_objeto, $id_empresa)
{
    $datos_empresa = DatosEmpresa($id_empresa);
    $connexion = new DatabasePDO();
    
    
    $limit = "";
    $sql   = "select
     tbl_galeria_archivos.*,
     tbl_usuario.nombre_completo
     from tbl_galeria_archivos
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_galeria_archivos.rut_autor
     where tbl_galeria_archivos.id_objeto='$id_objeto'
     and tbl_galeria_archivos.id_empresa='$id_empresa'
     and tbl_galeria_archivos.estado is null
     order by id desc
     $limit
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoParticipantesDadoCursiEmpresaSinRelator($id_i, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_CI_participantes.* , tbl_usuario.nombre_completo, tbl_usuario.cargo


     from tbl_CI_participantes


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_CI_participantes.rut


     where tbl_CI_participantes.id_empresa='$id_empresa' and
     tbl_CI_participantes.id_curso='$id_curso' and
     tbl_CI_participantes.relator<>'1'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoParticipantesDadoInscripcionEmpresaSinRelator($id_inscripcion, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_inscripcion_usuarios.rut, tbl_inscripcion_curso.* , tbl_usuario.nombre_completo, tbl_usuario.cargo from tbl_inscripcion_curso


inner join tbl_inscripcion_usuarios on tbl_inscripcion_curso.codigo_inscripcion=tbl_inscripcion_usuarios.id_inscripcion
inner join tbl_usuario on tbl_usuario.rut=tbl_inscripcion_usuarios.rut
inner join rel_lms_inscripcion_usuario_checkin
on rel_lms_inscripcion_usuario_checkin.rut=tbl_inscripcion_usuarios.rut and rel_lms_inscripcion_usuario_checkin.codigo_imparticion=tbl_inscripcion_usuarios.id_inscripcion and
r    el_lms_inscripcion_usuario_checkin.id_empresa=tbl_inscripcion_usuarios.id_empresa




where tbl_inscripcion_curso.id_empresa='$id_empresa' and tbl_inscripcion_curso.codigo_inscripcion='$id_inscripcion' and tbl_inscripcion_usuarios.relator<>'1'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function IdCursoDadoObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select id_curso  from tbl_objeto
     where id='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->id_curso;
}
function allPersonasPorEmpresaDNC($buscar, $id_empresa, $gerencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT *
     FROM tbl_usuario
     WHERE id_empresa='$id_empresa'
     and (nombre_completo like '%" . $buscar . "%' OR rut like '%" . $buscar . "%')
     and gerencia='$gerencia'
     and  cargo not  like '%Gerente%'
     and  cargo not  like '%Subgerente%'
     and cargo not  like '%Subgrte%'




     ORDER BY nombre_completo";


    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function ObtenerCriticasPorEvaluado($rut_jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where rut_jefe='$rut_jefe'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluadoSinAePorProceso($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_relaciones.evaluado, tbl_usuario.nombre, tbl_usuario.cargo
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluador<>tbl_sgd_relaciones.evaluado
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaClaveAccesoSoloEmail($email, $id_empresa)
{
    $connexion = new DatabasePDO();
    $clave    = ($clave);
    
    
    $sql = "select * from tbl_usuario where email='" . mysql_real_escape_string($email) . "' and id_empresa='" . mysql_real_escape_string($id_empresa) . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DistinctCampoUsuario($id_empresa, $campo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select distinct($campo) as valor from tbl_usuario where id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfilPorCompetenciaPorProceso($perfil, $evaluado, $evaluador, $id_competencia, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     rel_sgd_perfil_competencias.*,
     tbl_sgd_componente.nombre AS nombre_componente,
     tbl_sgd_componente.descripcion AS descripcion_componente,
     tbl_sgd_componente.id AS id_competencia,
     tbl_sgd_componente.muestra_preguntas_informe,
     tbl_sgd_componente.id_dimension,
     (select avg(puntaje) as nota_competncia
     from tbl_sgd_respuestas
     where tbl_sgd_respuestas.id_competencia=tbl_sgd_componente.id
     and evaluado='$evaluado'
     and evaluador='$evaluador'
     and id_proceso='$id_proceso') as nota_promedio
from
     rel_sgd_perfil_competencias
inner JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id
where
     perfil_evaluacion = '$perfil' and tbl_sgd_componente.id='$id_competencia'
order by tbl_sgd_componente.orden asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfilPorProceso($perfil, $evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     rel_sgd_perfil_competencias.*,
     tbl_sgd_componente.nombre AS nombre_componente,
     tbl_sgd_componente.descripcion AS descripcion_componente,
     tbl_sgd_componente.id AS id_competencia,
     tbl_sgd_componente.muestra_preguntas_informe,
     tbl_sgd_componente.id_dimension,
     tbl_sgd_componente.sigla,




     (select avg(puntaje) as nota_competncia
     from tbl_sgd_respuestas
     where tbl_sgd_respuestas.id_competencia=tbl_sgd_componente.id
     and evaluado='$evaluado'
     and evaluador='$evaluador'
     and id_proceso='$id_proceso') as nota_promedio


from


     rel_sgd_perfil_competencias


inner JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id


where


     perfil_evaluacion = '$perfil'
order by tbl_sgd_componente.orden asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoCompetenciasDadoPerfilConNombreCompetencia($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select rel_sgd_perfil_competencias.*, tbl_sgd_componente.nombre as nombre_competencia,
     tbl_sgd_componente.id as id_competencia
     from rel_sgd_perfil_competencias
     inner join tbl_sgd_componente
     on tbl_sgd_componente.id=rel_sgd_perfil_competencias.id_componente
     where rel_sgd_perfil_competencias.perfil_evaluacion='$perfil'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorParaBitacoraPorProceso($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.perfil AS nombre_subperfil, tbl_usuario.perfil_evaluacion
from
     tbl_sgd_relaciones
left JOIN tbl_sgd_subperfiles ON tbl_sgd_subperfiles.id = tbl_sgd_relaciones.subperfil
inner join tbl_usuario
on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
where
     tbl_sgd_relaciones.evaluador = '$evaluador' and tbl_sgd_relaciones.id_proceso='$id_proceso'
order BY
     subperfil,
     tbl_sgd_relaciones.evaluado ASC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoUltimoProcesoEvaluacionDadoEmpresa($id_empresa)
{
    $datos_empresa = DatosEmpresa($id_empresa);
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_proceso_evaluacion.*
from
     tbl_sgd_proceso_evaluacion


inner join tbl_sgd_proceso_anual
on tbl_sgd_proceso_evaluacion.id_proceso_anual=tbl_sgd_proceso_anual.id
where
     tbl_sgd_proceso_anual.id_empresa = '$id_empresa'
AND tbl_sgd_proceso_anual.activo = '1'
AND (tbl_sgd_proceso_evaluacion.tipo_proceso='1' or tbl_sgd_proceso_evaluacion.tipo_proceso='2') order by tbl_sgd_proceso_evaluacion.fecha_inicio desc limit 1";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ProcesosEvalPorEmpresaYTipoEvaluacion($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_proceso_evaluacion.*, tbl_sgd_proceso_anual.ano
     from tbl_sgd_proceso_evaluacion
     inner join tbl_sgd_proceso_anual
     on tbl_sgd_proceso_anual.id=tbl_sgd_proceso_evaluacion.id_proceso_anual
     where
     tbl_sgd_proceso_evaluacion.tipo_proceso='1' and
     tbl_sgd_proceso_evaluacion.id_empresa='$id_empresa'
     order by tbl_sgd_proceso_anual.ano desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosArchivoImagenCruceObjeto($id_imagen)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select tbl_galeria_archivos.*, tbl_objeto.puntaje_otros, tbl_objeto.id_curso
     from tbl_galeria_archivos
     inner join tbl_objeto
     on tbl_objeto.id=tbl_galeria_archivos.id_objeto


     where tbl_galeria_archivos.id='$id_imagen'");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBasePersonasConRelacionEvaluadoEvaluadorSoloEvaluador($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     DISTINCT(
     tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS perfil_evaluacion,
     rut,
     nombre,
     apaterno,
     amaterno,
     nombre_completo,
     cargo,
     gerencia,
     tbl_usuario.id_empresa,
     id_area,
     tbl_sgd_relaciones.evaluador
from
     tbl_usuario
inner JOIN tbl_sgd_relaciones
on tbl_sgd_relaciones.evaluador = '$evaluador'
AND tbl_sgd_relaciones.id_proceso = '$id_proceso'
where
     rut = '$evaluador'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function NotasObjetivosPorDimension($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("SELECT
     rut, avg(resultado_transformado) as nota_promediada, tbl_objetivos_individuales.dimension,tbl_objetivos_dimension.nombre, tbl_objetivos_dimension.ponderacion
from
     tbl_objetivos_individuales
inner join tbl_objetivos_dimension
on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension
where
     rut = '$evaluado'
AND id_proceso='50'
group BY dimension    ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneInscripcionCierreDadoRutYCursoEmpresaInscripcion($rut, $id_curso, $id_inscripcion, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_inscripcion_cierre where rut='$rut' and id_curso='$id_curso' and id_inscripcion='$id_inscripcion' and id_empresa='$id_empresa'
     ";
     //echo $sql;

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}

function InsertaComentariosFinalesSGD($evaluado, $evaluador, $id_proceso, $comentario, $id_empresa, $sucesor)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_sgd_comentarios_finales(evaluado, evaluador, id_proceso, comentario, fecha, hora, id_empresa, sucesor) " . "VALUES ('$evaluado','$evaluador', '$id_proceso', '$comentario', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa', '$sucesor');";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneComentariosFinalesSGD($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_comentarios_finales where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso2SinAeSoloProceso($id_proceso, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
from
     tbl_sgd_relaciones
inner JOIN tbl_usuario ON tbl_usuario.rut = evaluado
where
     tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     order by subperfil, nombre_completo asc
     ";
    if ($arreglo_post["filtro2"]) {
        if ($arreglo_post["filtro1"] == '-' or $arreglo_post["filtro2"] == '-') {
            $filtro1_2 = "";
        } else {
            $filtro1_2 = " and tbl_usuario." . $arreglo_post["filtro1"] . "='" . $arreglo_post["filtro2"] . "'";
        }
    }
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
from
     tbl_sgd_relaciones
inner JOIN tbl_usuario ON tbl_usuario.rut = evaluado
where
     tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     $filtro1_2


     order by subperfil, nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorRangosMenorYMayorSoloPorProcesoSinAe($id_proceso, $rango_menor, $rango_mayor, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where
     tbl_sgd_respuestas.id_proceso='$id_proceso'
     and (tbl_sgd_respuestas.puntaje>=$rango_menor and tbl_sgd_respuestas.puntaje<=$rango_mayor)
     and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador
     ";
    if ($arreglo_post["filtro2"]) {
        if ($arreglo_post["filtro1"] == '-' or $arreglo_post["filtro2"] == '-') {
        } else {
            $filtro1_2 = " and tbl_usuario." . $arreglo_post["filtro1"] . "='" . $arreglo_post["filtro2"] . "'";
        }
    }
    if ($arreglo_post["tipo_reporte"] == "individuales") {
        $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_objetivos_individuales
     on tbl_objetivos_individuales.id=tbl_sgd_respuestas.id_objetivo


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_respuestas.evaluado


     where
     tbl_sgd_respuestas.id_proceso='$id_proceso'
     and (tbl_sgd_respuestas.puntaje>=$rango_menor and tbl_sgd_respuestas.puntaje<=$rango_mayor)
     and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador


     $filtro1_2
     ";
    } else {
        $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_respuestas.evaluado


     where
     tbl_sgd_respuestas.id_proceso='$id_proceso'
     and (tbl_sgd_respuestas.puntaje>=$rango_menor and tbl_sgd_respuestas.puntaje<=$rango_mayor)
     and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador


     $filtro1_2
     ";
    }
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorRangosMenorYMayorSoloPorProceso($id_proceso, $rango_menor, $rango_mayor)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where  id_proceso='$id_proceso' and (puntaje>=$rango_menor and puntaje<=$rango_mayor)
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasSoloPorProcesoSinAe($id_proceso, $filtro1, $filtro2, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    if ($filtro2) {
        if ($filtro1 == '-' or $filtro2 == '-') {
            $filtro1_2 = "";
        } else {
            $filtro1_2 = " and tbl_usuario.$filtro1='$filtro2'";
        }
    }
    $sqlBK = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where id_proceso='$id_proceso' and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador
     ";
    if ($arreglo_post["tipo_reporte"] == "individuales") {
        $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_objetivos_individuales
     on tbl_objetivos_individuales.id=tbl_sgd_respuestas.id_objetivo


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_respuestas.evaluado


     where tbl_sgd_respuestas.id_proceso='$id_proceso'
     and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador
     $filtro1_2
     ";
    } else {
        $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_respuestas.evaluado


     where tbl_sgd_respuestas.id_proceso='$id_proceso'
     and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador
     $filtro1_2
     ";
    }
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasSoloPorProceso($id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSoloProcesoParaGrafico($id_proceso, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "
     select tbl_sgd_relaciones.*
     from tbl_sgd_relaciones where tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador    ";
    if ($arreglo_post["filtro2"]) {
        if ($arreglo_post["filtro1"] == '-' or $arreglo_post["filtro2"] == '-') {
            $filtro1_2 = "";
        } else {
            $filtro1_2 = " and tbl_usuario." . $arreglo_post["filtro1"] . "='" . $arreglo_post["filtro2"] . "'";
        }
    }
    $sql = "
     select tbl_sgd_relaciones.*
     from tbl_sgd_relaciones


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     where


     tbl_sgd_relaciones.id_proceso='$id_proceso'
     and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador


     $filtro1_2


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador1SoloProceso($id_proceso, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.id_proceso='$id_proceso'
     ";
    if ($arreglo_post["filtro2"]) {
        if ($arreglo_post["filtro1"] == '-' or $arreglo_post["filtro2"] == '-') {
            $filtro1_2 = "";
        } else {
            $filtro1_2 = " and tbl_usuario." . $arreglo_post["filtro1"] . "='" . $arreglo_post["filtro2"] . "'";
        }
    }
    $sqlBKSGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.id_proceso='$id_proceso'
     $filtro1_2
     ";
    $sql      = "select distinct(tbl_sgd_relaciones.perfil_evaluacion_competencias) as id_perfil_ev
     from tbl_sgd_relaciones




     where tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.perfil_evaluacion_competencias is not null
     $filtro1_2
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSoloProceso($id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.muestra_graficos
from
     tbl_sgd_relaciones
inner join tbl_sgd_subperfiles
on tbl_sgd_subperfiles.id=tbl_sgd_relaciones.subperfil
where
     id_proceso = '$id_proceso'




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSoloProcesosinAe($id_proceso, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "SELECT
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.muestra_graficos
from
     tbl_sgd_relaciones
inner join tbl_sgd_subperfiles
on tbl_sgd_subperfiles.id=tbl_sgd_relaciones.subperfil
where
     id_proceso = '$id_proceso' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador    ";
    if ($arreglo_post["filtro2"]) {
        if ($arreglo_post["filtro1"] == '-' or $arreglo_post["filtro2"] == '-') {
            $filtro1_2 = "";
        } else {
            $filtro1_2 = " and tbl_usuario." . $arreglo_post["filtro1"] . "='" . $arreglo_post["filtro2"] . "'";
        }
    }
    $sql = "SELECT
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.muestra_graficos
     FROM
     tbl_sgd_relaciones
     inner join tbl_sgd_subperfiles
     on tbl_sgd_subperfiles.id=tbl_sgd_relaciones.subperfil


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     WHERE
     tbl_sgd_relaciones.id_proceso = '$id_proceso'
     and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     $filtro1_2
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosProcesoAnualDadoProcesoEval($id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_proceso_evaluacion.*,
t    bl_sgd_proceso_anual.ano as agno_proceso
from
     tbl_sgd_proceso_evaluacion
inner JOIN tbl_sgd_proceso_anual ON tbl_sgd_proceso_anual.id = tbl_sgd_proceso_evaluacion.id_proceso_anual
where
     tbl_sgd_proceso_evaluacion.id_proceso = '$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosRelacionEvaluadoEvaluadorProceso($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.muestra_graficos
from
     tbl_sgd_relaciones
inner join tbl_sgd_subperfiles
on tbl_sgd_subperfiles.id=tbl_sgd_relaciones.subperfil
where
     id_proceso = '$id_proceso'
AND evaluado = '$evaluado'
AND evaluador = '$evaluador'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatosRelacionEvaluadoEvaluadorProcesoSinAe($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.muestra_graficos
from
     tbl_sgd_relaciones
inner join tbl_sgd_subperfiles
on tbl_sgd_subperfiles.id=tbl_sgd_relaciones.subperfil
where
     id_proceso = '$id_proceso'
AND evaluado = '$evaluado'
AND evaluador = '$evaluador'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CursosNoIniciados($rut, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT DISTINCT
     (tbl_inscripcion_cierre.id_curso), rel_lms_malla_curso.id_malla, tbl_lms_curso.nombre as nombre_curso
from
     tbl_inscripcion_cierre
left join rel_lms_malla_curso
on tbl_inscripcion_cierre.id_curso=rel_lms_malla_curso.id_curso and rel_lms_malla_curso.id_malla='$id_malla'
inner join tbl_lms_curso
on tbl_lms_curso.id=tbl_inscripcion_cierre.id_curso
where
     rut = '$rut' and rel_lms_malla_curso.id_malla is null      AND rel_lms_malla_curso.id_malla IS NULL
AND tbl_inscripcion_cierre.estado<>1
AND tbl_inscripcion_cierre.estado<>2
AND tbl_inscripcion_cierre.estado<>3
limit 3
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_VE_ESTADO_NO_INICIADOS($rut, $id_curso, $id_inscripcion, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_inscripcion_cierre where id_curso='$id_curso' AND
i    d_empresa='$id_empresa' and id_inscripcion='$id_inscripcion' and rut='$rut'


     ";
    $connexion->query($sql);
    
    $cod                   = $connexion->resultset();
    $estado                = $cod[0]->estado;
    $porcentaje_asistencia = $cod[0]->porcentaje_asistencia;
    $nota                  = $cod[0]->nota;
    if ($estado === NULL) {
        $sql = "


select * from tbl_inscripcion_cierre where id_curso='$id_curso' AND
i    d_empresa='$id_empresa' and rut='$rut'


     ";
        $connexion->query($sql);
        
        $cod                   = $connexion->resultset();
        $estado                = $cod[0]->estado;
        $porcentaje_asistencia = $cod[0]->porcentaje_asistencia;
        $nota                  = $cod[0]->nota;
        if ($estado === NULL) {
        } else {
        }
    } else {
    }
    return array(
        $estado,
        $porcentaje_asistencia,
        $nota
    );
}
function OtrosCursosNoMalla($rut, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT DISTINCT
     (tbl_inscripcion_cierre.id_curso), rel_lms_malla_curso.id_malla, tbl_lms_curso.nombre as nombre_curso, tbl_inscripcion_cierre.estado as estado
from
     tbl_inscripcion_cierre
left join rel_lms_malla_curso
on tbl_inscripcion_cierre.id_curso=rel_lms_malla_curso.id_curso and rel_lms_malla_curso.id_malla='$id_malla'
inner join tbl_lms_curso
on tbl_lms_curso.id=tbl_inscripcion_cierre.id_curso
where
     rut = '$rut' and rel_lms_malla_curso.id_malla is null
AND tbl_inscripcion_cierre.estado>0




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoTemplatePaginaDadoId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_paginas_templates
     where id='$id'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanValidadosDadoIdProcesoSoloEvaluado($id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select distinct(evaluado) from tbl_objetivos_validaciones
     where id_proceso='$id_proceso' and evaluado='$evaluado'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanValidadosDadoEvaluadorIdProcesoEvaluado($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select distinct(evaluado) from tbl_objetivos_validaciones
     where evaluador='$evaluador' and id_proceso='$id_proceso' and evaluado='$evaluado'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanValidadosDadoEvaluadorIdProceso($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select distinct(evaluado) from tbl_objetivos_validaciones
     where evaluador='$evaluador' and id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorParaBitacora($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.perfil AS nombre_subperfil, tbl_usuario.perfil_evaluacion
from
     tbl_sgd_relaciones
left JOIN tbl_sgd_subperfiles ON tbl_sgd_subperfiles.id = tbl_sgd_relaciones.subperfil
inner join tbl_usuario
on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
where
     tbl_sgd_relaciones.evaluador = '$evaluador'
order BY
     subperfil,
     tbl_sgd_relaciones.evaluado ASC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosVerificaCompetenciaIngresada($rut, $id_dimension, $competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select id from tbl_objetivos_individuales
     where rut='$rut' and dimension='$id_dimension' and competencia='$competencia'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosVerificaConductaCritica($rut, $id_dimension, $conducta_critica)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select id from tbl_objetivos_individuales
     where rut='$rut' and dimension='$id_dimension' and conducta_critica='$conducta_critica'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosDimensionDadoId($id_dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_dimension where id=$id_dimension";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaPonderacionesPorRutYDimension($rut, $id_dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select sum(ponderacion) as suma_ponderaciones from tbl_objetivos_individuales
     where rut='$rut' and dimension='$id_dimension'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEvaluadoPRocesoEmpresaFinalizadoObjetivos($evaluado, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select distinct(evaluado) from tbl_objetivos_indviduales_finalizado where evaluado='$evaluado' and id_empresa='$id_empresa' and id_proceso='$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEvaluadoEvaluadorPRocesoEmpresaFinalizadoObjetivos($evaluado, $evaluador, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select distinct(evaluado) from tbl_objetivos_indviduales_finalizado where evaluador='$evaluador' and evaluado='$evaluado' and id_empresa='$id_empresa' and id_proceso='$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEvaluadosFinalizadosPorEvaluador($rut_fijador, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select distinct(tbl_objetivos_indviduales_finalizado.evaluado), tbl_usuario.nombre_completo
     from tbl_objetivos_indviduales_finalizado


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_objetivos_indviduales_finalizado.evaluado
     where tbl_objetivos_indviduales_finalizado.evaluador='$rut_fijador'
     and tbl_objetivos_indviduales_finalizado.id_empresa='$id_empresa'
     and tbl_objetivos_indviduales_finalizado.id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarobjetivoIndividualFinalizadoPorDimensionEmpresaConEvaluador($rut, $id_dimension, $id_empresa, $rut_fijador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_indviduales_finalizado(evaluado, fecha, hora, id_dimension, id_empresa, evaluador, id_proceso) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_dimension', '$id_empresa', '$rut_fijador', '$id_proceso');";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaObjetivoV2DadoId($id_objetivo, $objetivo, $accion_clave, $ponderacion, $conducta_critica, $comentarios, $acciones_desarrollo, $responsable, $fecha_limite, $acciones_realizadas, $impacto, $tipo_accion, $competencia, $metrica, $meta, $nocumple, $cumple, $sobresale)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_objetivos_individuales
     set
     descripcion_objetivo='$objetivo',
     ponderacion='$ponderacion',
     accion_clave='$accion_clave',
     conducta_critica='$conducta_critica',
     comentarios='$comentarios',
     acciones_desarrollo='$acciones_desarrollo',
     responsable='$responsable',
     fecha_limite='$fecha_limite',
     acciones_realizadas='$acciones_realizadas',
     impacto='$impacto',
     tipo_accion='$tipo_accion',
     competencia='$competencia',
     metrica='$metrica',
     meta='$meta',
     nocumple='$nocumple',
     cumple='$cumple',
     sobresale='$sobresale'
where id='$id_objetivo'
";
    $connexion->query($sql);
    $connexion->execute();
}
function CompetenciasDadoPerfilParaObjetivos($id_perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_componente where id_perfil='$id_perfil'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadorPorCriteriosV2($id_proceso, $campo_criterio, $valor_criterio, $tipo_resumen)
{
    $connexion = new DatabasePDO();
    
    
    if ($tipo_resumen == "evaluadoEvaluador") {
        $tabla = "tbl_usuario";
    } else {
        $tabla = "base_evaluador";
    }
    $sqlBK_SGD = "




     SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas,
(    SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = tbl_sgd_relaciones.evaluado
     AND tbl_sgd_respuestas.evaluador = tbl_sgd_relaciones.evaluador
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_usuario.perfil_evaluacion
     and tbl_sgd_respuestas.id_proceso='$id_proceso'
     ) as pagina
from
     tbl_sgd_relaciones
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
inner JOIN tbl_usuario AS base_evaluador ON base_evaluador.rut = tbl_sgd_relaciones.evaluador
where
     tbl_sgd_relaciones.id_proceso = '$id_proceso'
AND $tabla.$campo_criterio='$valor_criterio'
";
    $sql       = "
select
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS total_preguntas,
(    SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = tbl_sgd_relaciones.evaluado
     AND tbl_sgd_respuestas.evaluador = tbl_sgd_relaciones.evaluador
     AND tbl_sgd_respuestas.id_proceso = '$id_proceso'
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     ) as pagina
from
     tbl_sgd_relaciones
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
inner JOIN tbl_usuario AS base_evaluador ON base_evaluador.rut = tbl_sgd_relaciones.evaluador
where
     tbl_sgd_relaciones.id_proceso = '$id_proceso'
AND $tabla.$campo_criterio='$valor_criterio'






";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadoEvaluadorEvalIndividualV2($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina as paginaBk,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas,
(    SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = '$evaluado'
     AND tbl_sgd_respuestas.evaluador = '$evaluador'
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_usuario.perfil_evaluacion
     ) as pagina
from
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador'
AND tbl_sgd_sesion_evaluacion.evaluado = '$evaluado'
AND tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
where
     tbl_sgd_relaciones.evaluador = '$evaluador'
AND tbl_sgd_relaciones.evaluado = '$evaluado'
AND tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $sql       = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina as paginaBk,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS total_preguntas,
(    SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = '$evaluado'
     AND tbl_sgd_respuestas.evaluador = '$evaluador'
     AND tbl_sgd_respuestas.id_proceso = '$id_proceso'
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     ) as pagina
from
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador'
AND tbl_sgd_sesion_evaluacion.evaluado = '$evaluado'
AND tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
where
     tbl_sgd_relaciones.evaluador = '$evaluador'
AND tbl_sgd_relaciones.evaluado = '$evaluado'
AND tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanValidadosPorDimension($evaluado, $id_dimension, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_validaciones where evaluado='$evaluado' and id_dimension='$id_dimension' and id_empresa='$id_empresa'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaValidacionJefeDelJefePorDimension($evaluado, $evaluador, $validador, $id_dimension, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_validaciones(evaluado, evaluador, validador, fecha, hora, id_dimension, id_empresa, id_proceso) " . "VALUES ('$evaluado', '$evaluador', '$validador',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_dimension', '$id_empresa', '$id_proceso');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeEvaluadoresDadoValidadorFijObjetivos($validador, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select distinct(tbl_sgd_relaciones.evaluador), nombre_completo, cargo from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluador
     where validador='$validador' and tbl_sgd_relaciones.id_empresa='$id_empresa'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaComentariosPorDimension($fijador, $evaluado, $dimension, $id_empresa, $acciones_realizadas, $impacto)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_objetivos_dimensiones_comentarios
     set
     acciones_realizadas='$acciones_realizadas',
     impacto='$impacto'
     where evaluado='$evaluado'
     and evaluador='$fijador'
     and id_dimension='$dimension'
     and id_empresa='$id_empresa'
     ";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaComentariosPorDimension($fijador, $evaluado, $id_dimension, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select * from tbl_objetivos_dimensiones_comentarios where evaluado='$evaluado' and id_dimension='$id_dimension' and id_empresa='$id_empresa' and evaluador='$fijador'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaComentariosPorDimension($fijador, $evaluado, $dimension, $id_empresa, $acciones_realizadas, $impacto)
{
    $connexion = new DatabasePDO();

    $sql = "INSERT INTO tbl_objetivos_dimensiones_comentarios(evaluado, evaluador, id_dimension, id_empresa, acciones_realizadas, impacto) " . "VALUES ('$evaluado', '$fijador', '$dimension', '$id_empresa', '$acciones_realizadas', '$impacto');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaDimensionFinalizadaObjetivosPorEvaluado($rut, $id_empresa)
{
    $connexion = new DatabasePDO();

    $sql = "select * from tbl_objetivos_indviduales_finalizado where evaluado='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaDimensionFinalizadaObjetivos($rut, $id_dimension, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select * from tbl_objetivos_indviduales_finalizado where evaluado='$rut' and id_dimension='$id_dimension' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarobjetivoIndividualFinalizadoPorDimensionEmpresa($rut, $id_dimension, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_objetivos_indviduales_finalizado(evaluado, fecha, hora, id_dimension, id_empresa) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_dimension', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function ObjetivosPodDimensionEmpresaUsuario($rut, $id_empresa, $dimension, $id_perfil_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
select
     tbl_sgd_componente.nombre as nombre_competencia,
     tbl_objetivos_dimension.nombre as nombre_dimension_pdf,
     tbl_objetivos_individuales.*,
     tbl_sgd_componente_conducta.conducta as nombre_conducta,
     tbl_objetivos_metricas.metrica as descripcion_metrica
from
     tbl_objetivos_individuales
left join tbl_sgd_componente
on tbl_sgd_componente.id_componente_reporte=tbl_objetivos_individuales.competencia and
t    bl_sgd_componente.id_perfil='$id_perfil_competencia' and tbl_sgd_componente.id_empresa='$id_empresa'


left join tbl_sgd_componente_conducta
on tbl_sgd_componente_conducta.id_conducta=.tbl_objetivos_individuales.conducta_critica
AND tbl_sgd_componente_conducta.id_empresa='$id_empresa'


inner join tbl_objetivos_dimension
on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension


left join tbl_objetivos_metricas ON tbl_objetivos_metricas.id_metrica = tbl_objetivos_individuales.descripcion_objetivo




where
     tbl_objetivos_individuales.id_empresa = '$id_empresa'
AND tbl_objetivos_individuales.rut = '$rut'
AND tbl_objetivos_individuales.dimension = '$dimension'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosPodDimensionEmpresaUsuarioBK($rut, $id_empresa, $dimension, $id_perfil_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
select
     tbl_sgd_componente.nombre as nombre_competencia,
     tbl_objetivos_individuales.*,
     tbl_sgd_componente_conducta.conducta as nombre_conducta
from
     tbl_objetivos_individuales
left join tbl_sgd_componente
on tbl_sgd_componente.id_componente_reporte=tbl_objetivos_individuales.competencia and
t    bl_sgd_componente.id_perfil='$id_perfil_competencia'


left join tbl_sgd_componente_conducta on tbl_sgd_componente_conducta.id_conducta=.tbl_objetivos_individuales.conducta_critica
where
     tbl_objetivos_individuales.id_empresa = '$id_empresa'
AND tbl_objetivos_individuales.rut = '$rut'
AND tbl_objetivos_individuales.dimension = '$dimension'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosPodDimensionEmpresaUsuarioSumaPonderacion($rut, $id_empresa, $dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
select


     sum(tbl_objetivos_individuales.ponderacion) as suma_ponderaciones
from
     tbl_objetivos_individuales
left join tbl_sgd_componente
on tbl_sgd_componente.id=tbl_objetivos_individuales.conducta_critica
where
     tbl_objetivos_individuales.id_empresa = '$id_empresa'
AND tbl_objetivos_individuales.rut = '$rut'
AND tbl_objetivos_individuales.dimension = '$dimension'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarObjetivoV2Log($evaluado, $id_empresa, $dimension, $descripcion_objetivo, $accion_clave, $conducta_critica, $comentarios, $acciones_desarrollo, $responsable, $fecha_limite, $ponderacion, $acciones_realizadas, $impacto, $tipo_accion, $competencia, $metrica, $meta, $nocumple, $cumple, $sobresale)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_individuales_log
     (
     rut,
     dimension,
     id_empresa,
     descripcion_objetivo,
     accion_clave,
     fecha,
     hora,
     conducta_critica,
     comentarios,
     acciones_desarrollo,
     responsable,
     fecha_limite,
     ponderacion,
     acciones_realizadas,
     impacto,
     tipo_accion,
     competencia,
     metrica,
     meta,
     nocumple,
     cumple,
     sobresale) " . "VALUES
     ('$evaluado', '$dimension', '$id_empresa', '$descripcion_objetivo', '$accion_clave',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$conducta_critica', '$comentarios',
     '$acciones_desarrollo',
     '$responsable',
     '$fecha_limite',
     '$ponderacion',
     '$acciones_realizadas',
     '$impacto',
     '$tipo_accion',
     '$competencia',
     '$metrica',
     '$meta',
     '$nocumple',
     '$cumple',
     '$sobresale'


     );";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertarObjetivoV2($evaluado, $id_empresa, $dimension, $descripcion_objetivo, $accion_clave, $conducta_critica, $comentarios, $acciones_desarrollo, $responsable, $fecha_limite, $ponderacion, $acciones_realizadas, $impacto, $tipo_accion, $competencia, $metrica, $meta, $nocumple, $cumple, $sobresale)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_individuales
     (
     rut,
     dimension,
     id_empresa,
     descripcion_objetivo,
     accion_clave,
     fecha,
     hora,
     conducta_critica,
     comentarios,
     acciones_desarrollo,
     responsable,
     fecha_limite,
     ponderacion,
     acciones_realizadas,
     impacto,
     tipo_accion,
     competencia,
     metrica,
     meta,
     nocumple,
     cumple,
     sobresale) " . "VALUES
     ('$evaluado', '$dimension', '$id_empresa', '$descripcion_objetivo', '$accion_clave',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$conducta_critica', '$comentarios',
     '$acciones_desarrollo',
     '$responsable',
     '$fecha_limite',
     '$ponderacion',
     '$acciones_realizadas',
     '$impacto',
     '$tipo_accion',
     '$competencia',
     '$metrica',
     '$meta',
     '$nocumple',
     '$cumple',
     '$sobresale'


     );";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalVisitasDadoRutCaseEmpresaFront($rut, $id_empresa, $case)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select count(id) as total_visitas from tbl_log_sistema where rut='$rut' and ambiente='$case' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeIndicadoresDelDia()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_indicadores_deldia";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarMensajeLineaDirecta($rut, $mensaje, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_mensaje_linea_directa(rut, id_empresa, mensaje, fecha, hora) " . "VALUES ('$rut', '$id_empresa', '$mensaje', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalReconocimientosPorCategoriaGenericoPorAno($id_categoria, $id_empresa, $ano)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_salonfama_publicados.*, tbl_salonfama_categorias.nombre AS nombre_categoria,
     tbl_salonfama_categorias.titulo_listado AS titulo_pagina,
     tbl_salonfama_categorias.descripcion AS descripcion_categoria,
     imagen,
     tbl_usuario.nombre,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_usuario.nombre_completo,
     tbl_usuario.cargo,
     tbl_salonfama_categorias.template_row AS template_row,
     tbl_salonfama_categorias.imagen_form,
     tbl_salonfama_categorias.imagen_inicio_pagina


from
     tbl_salonfama_publicados
inner JOIN tbl_salonfama_categorias ON tbl_salonfama_categorias.id = tbl_salonfama_publicados.id_tipo_reconocimiento
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_salonfama_publicados.rut
where
     idempresa = '$id_empresa'  and tbl_salonfama_publicados.ano='$ano'
AND id_tipo_reconocimiento = '$id_categoria'
order BY


     tbl_salonfama_publicados.id DESC


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerSalonPorCategoriaYEmpresaPorAno($id_empresa, $id_categoria, $limit, $ano)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    $sql = "


     SELECT
     tbl_salonfama_categorias.nombre,
     tbl_salonfama_categorias.imagen,
     tbl_salonfama_categorias.proceso_actual,
     tbl_salonfama_categorias.proceso_anterior,
     tbl_salonfama_publicados.*, tbl_usuario.nombre AS nombre_persona,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_usuario.ubicacion,
     tbl_usuario.cargo,
     tbl_salonfama_valores.nombre as nombre_valor
from
     tbl_salonfama_publicados
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_salonfama_publicados.rut
inner JOIN tbl_salonfama_categorias ON tbl_salonfama_categorias.id = tbl_salonfama_publicados.id_tipo_reconocimiento
left join tbl_salonfama_valores on tbl_salonfama_valores.id=tbl_salonfama_publicados.id_valor
where
     tbl_salonfama_publicados.idempresa = '$id_empresa' and tbl_salonfama_publicados.ano='$ano'
AND tbl_salonfama_publicados.id_tipo_reconocimiento = '$id_categoria'
order BY
     RAND()
$limit










     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DimensionesObjetivosPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_objetivos_dimension where id_empresa=$id_empresa order by orden asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadoEvaluadorEvalIndividual($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_componente.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente


     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas
from
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador' and tbl_sgd_sesion_evaluacion.evaluado='$evaluado'
AND tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
inner JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
where
     tbl_sgd_relaciones.evaluador = '$evaluador'
AND tbl_sgd_relaciones.evaluado = '$evaluado'
AND tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraePlanesValidados($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_planes_ingresados.*, tbl_sgd_componente.nombre as nombre_competencia, tbl_planes_plazos.nombre as plazo_nombre
     from tbl_planes_ingresados
     inner join tbl_sgd_componente
     on tbl_sgd_componente.id=tbl_planes_ingresados.id_competencia
     inner join tbl_planes_plazos
     on tbl_planes_plazos.id=.tbl_planes_ingresados.plazo


     where evaluado='$evaluado' and jefe_sugiere is not null order by tbl_planes_ingresados.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_cursosPoriNSCRIPCIONUSUARIO($rut, $malla, $clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_lms_curso.id AS codigo_curso,
     tbl_lms_curso.nombre nombre_curso,
     tbl_lms_curso.modalidad ,
     tbl_lms_clasificacion.clasificacion,
     tbl_lms_clasificacion.id_clasificacion AS codigo_clasificacion,
     tbl_inscripcion_cierre.nota,
     tbl_inscripcion_cierre.porcentaje_asistencia,
     tbl_inscripcion_cierre.estado,
     tbl_inscripcion_usuarios.id_inscripcion,
     tbl_inscripcion_curso.fecha_inicio as fecha_inicio_insc,
     tbl_inscripcion_curso.fecha_termino as fecha_termino_insc
from
     tbl_inscripcion_usuarios
inner JOIN tbl_lms_curso ON tbl_inscripcion_usuarios.id_curso = tbl_lms_curso.id
inner JOIN tbl_lms_clasificacion ON tbl_lms_clasificacion.id_clasificacion = rel_lms_malla_curso.id_clasificacion
inner join tbl_inscripcion_curso on tbl_inscripcion_curso.codigo_inscripcion=tbl_inscripcion_usuarios.id_inscripcion
inner JOIN rel_lms_malla_curso ON rel_lms_malla_curso.id_curso = tbl_lms_curso.id
AND rel_lms_malla_curso.id_malla = '$malla'
left JOIN tbl_inscripcion_cierre ON tbl_inscripcion_cierre.id_inscripcion = tbl_inscripcion_usuarios.id_inscripcion
AND tbl_inscripcion_cierre.rut = '$rut'
where
     tbl_inscripcion_usuarios.rut = '$rut'
AND rel_lms_malla_curso.id_clasificacion = '$clasificacion'
order BY
     tbl_inscripcion_curso.fecha_inicio desc


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_cursosPorClasificacion($rut, $malla, $clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_lms_curso.id AS codigo_curso,
     tbl_lms_curso.nombre nombre_curso,
     tbl_lms_curso.proveedor as proveedor_curso ,
     tbl_lms_curso.modalidad ,
     tbl_lms_curso.imagen ,
     tbl_lms_curso.descripcion as descripcion_curso ,
     tbl_lms_clasificacion.clasificacion,
     tbl_lms_clasificacion.id_clasificacion AS codigo_clasificacion,
     tbl_inscripcion_cierre.nota,
     tbl_inscripcion_cierre.porcentaje_asistencia,
     tbl_inscripcion_cierre.estado,
     tbl_inscripcion_usuarios.id_inscripcion,
     tbl_inscripcion_curso.fecha_inicio as fecha_inicio_insc,
     tbl_inscripcion_curso.fecha_termino as fecha_termino_insc,
     tbl_gamificado_nivel.idnivel
from
     tbl_inscripcion_usuarios
inner JOIN tbl_lms_curso ON tbl_inscripcion_usuarios.id_curso = tbl_lms_curso.id
inner JOIN rel_lms_malla_curso ON rel_lms_malla_curso.id_curso = tbl_lms_curso.id
AND rel_lms_malla_curso.id_malla = '$malla'






inner JOIN tbl_lms_clasificacion ON tbl_lms_clasificacion.id_clasificacion = rel_lms_malla_curso.id_clasificacion
inner join tbl_inscripcion_curso on tbl_inscripcion_curso.codigo_inscripcion=tbl_inscripcion_usuarios.id_inscripcion






left JOIN tbl_inscripcion_cierre ON tbl_inscripcion_cierre.id_inscripcion = tbl_inscripcion_usuarios.id_inscripcion
AND tbl_inscripcion_cierre.rut = '$rut'


left JOIN tbl_gamificado_nivel
on tbl_gamificado_nivel.idcurso=tbl_lms_curso.id
where
     tbl_inscripcion_usuarios.rut = '$rut'
AND rel_lms_malla_curso.id_clasificacion = '$clasificacion'
order BY
     tbl_inscripcion_curso.fecha_inicio desc


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_cursosPorClasificacionMalla($malla, $clasificacion, $filtro_desde_admin)
{
    $connexion = new DatabasePDO();
    
    
    if ($clasificacion) {
        $filtro_clasificacion = " and h.id_clasificacion = '$clasificacion'";
    } else {
        $filtro_clasificacion = " ";
    }
    if ($filtro_desde_admin["curso"]) {
        $filtro_id_curso = " and h.id_curso='" . $filtro_desde_admin["curso"] . "'";
    } else {
        $filtro_id_curso = " ";
    }

$sql = "

     SELECT
h    .*,
(    select nombre from tbl_lms_curso where id=h.id_curso) as nombre_curso,
(    select imagen_back from tbl_lms_curso where id=h.id_curso) as imagen_back,
(    select imagen from tbl_lms_curso where id=h.id_curso) as imagen,
(    select fecha_inicio from tbl_lms_curso where id=h.id_curso) as fecha_inicio,
(    select valortotal from tbl_lms_curso where id=h.id_curso) as valortotal,
(    select idmoodle from tbl_lms_curso where id=h.id_curso) as idmoodle,
(    select currentorg from tbl_lms_curso where id=h.id_curso) as currentorg,
(    select id_scorm from tbl_lms_curso where id=h.id_curso) as id_scorm,
(    select scoid from tbl_lms_curso where id=h.id_curso) as scoid,
(    select cm from tbl_lms_curso where id=h.id_curso) as cm,
(    select urlmoodle from tbl_lms_curso where id=h.id_curso) as urlmoodle,
(    select puntos_maximo from tbl_lms_curso where id=h.id_curso) as puntos_maximo,
(    select modalidad from tbl_lms_curso where id=h.id_curso) as modalidad,
(    select descripcion from tbl_lms_curso where id=h.id_curso) as descripcion_curso,
(    select descriptor from tbl_lms_curso where id=h.id_curso) as descriptor_curso,
(    select inactivo from tbl_lms_curso where id=h.id_curso) as inactivo_curso,
(    select proveedor from tbl_lms_curso where id=h.id_curso) as proveedor_curso,
(    select numnivel
     from tbl_gamificado_nivel
     inner join tbl_gamificado_niveles_descripcion
     on tbl_gamificado_niveles_descripcion.idnivel=tbl_gamificado_nivel.idnivel
     where tbl_gamificado_nivel.idcurso=h.id_curso  and tbl_gamificado_nivel.idmalla='$malla') as numnivel,

     (select count(id) from tbl_inscripcion_curso where id_curso=h.id_curso) as cuentaCursos


from
     rel_lms_malla_curso h




where


     h.id_malla = '$malla' $filtro_clasificacion $filtro_id_curso


     order by h.orden_curso


     ";

    // echo "CAPACITACION_cursosPorClasificacionMalla ".$sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_cursosPorClasificacionRut($rut, $clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select
     tbl_lms_curso.id AS id_curso,
     tbl_lms_curso.nombre nombre_curso,
     tbl_lms_curso.modalidad,
     tbl_lms_curso.idmoodle,
     tbl_lms_curso.currentorg,
     tbl_lms_curso.id_scorm,
     tbl_lms_curso.scoid,
    tbl_lms_curso.cm,
     tbl_lms_curso.urlmoodle,
     tbl_lms_clasificacion.clasificacion,
     tbl_lms_clasificacion.id_clasificacion AS codigo_clasificacion,
     tbl_inscripcion_cierre.nota,
     tbl_inscripcion_cierre.porcentaje_asistencia,
     tbl_inscripcion_cierre.estado,
     tbl_inscripcion_cierre.fecha_inicio,
     tbl_inscripcion_cierre.fecha_termino,
     tbl_inscripcion_cierre.id_inscripcion
from
     tbl_inscripcion_cierre
inner JOIN tbl_lms_curso ON tbl_inscripcion_cierre.id_curso = tbl_lms_curso.id
inner JOIN tbl_lms_clasificacion ON tbl_lms_clasificacion.id_clasificacion = tbl_lms_curso.clasificacion


AND tbl_inscripcion_cierre.rut = '$rut'
where
     tbl_inscripcion_cierre.rut = '$rut'
AND tbl_lms_curso.clasificacion = '$clasificacion'
order BY
tbl_inscripcion_cierre.fecha_inicio DESC
     ";

    // echo $sql;

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_VE_ESTADO($rut, $id_curso, $id_inscripcion, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_inscripcion_cierre where id_curso='$id_curso' AND
i    d_empresa='$id_empresa' and id_inscripcion='$id_inscripcion' and rut='$rut'


     ";
    $connexion->query($sql);
    
    $cod                   = $connexion->resultset();
    $estado                = $cod[0]->estado;
    $porcentaje_asistencia = $cod[0]->porcentaje_asistencia;
    $nota                  = $cod[0]->nota;
    if ($estado === NULL) {
        $sql = "


select * from tbl_inscripcion_cierre where id_curso='$id_curso' AND
i    d_empresa='$id_empresa' and rut='$rut'


     ";
        $connexion->query($sql);
        
        $cod                   = $connexion->resultset();
        $estado                = $cod[0]->estado;
        $porcentaje_asistencia = $cod[0]->porcentaje_asistencia;
        $nota                  = $cod[0]->nota;
        if ($estado === NULL) {
        } else {
        }
    } else {
    }
    return array(
        $estado,
        $porcentaje_asistencia,
        $nota
    );
}
function CAPACITACION_clasificacionesPorMallaRut($rut, $malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     distinct(rel_lms_malla_curso.id_clasificacion),
     tbl_lms_clasificacion.clasificacion AS nombre_clasificacion,
     tbl_lms_clasificacion.descripcion AS descripcion_clasificacion,
     tbl_lms_clasificacion.color,
     tbl_lms_clasificacion.imagen,
     tbl_lms_clasificacion.imagen_back,
     tbl_lms_clasificacion.color2


from
     tbl_inscripcion_usuarios


     inner join tbl_lms_curso
     on tbl_lms_curso.id=tbl_inscripcion_usuarios.id_curso
     inner join tbl_lms_clasificacion
     on tbl_lms_clasificacion.id_clasificacion=rel_lms_malla_curso.id_clasificacion
     inner join rel_lms_malla_curso
     on rel_lms_malla_curso.id_curso=tbl_lms_curso.id


where
     tbl_inscripcion_usuarios.rut = '$rut' and rel_lms_malla_curso.id_malla='$malla'
     order by orden_clasificacion asc
     ";

    // echo $sql; exit();
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_clasificacionesPorInscripcionUsuario($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     distinct(tbl_lms_curso.clasificacion),
     tbl_lms_clasificacion.clasificacion AS nombre_clasificacion,
     tbl_lms_clasificacion.color,
     tbl_lms_clasificacion.imagen,
     tbl_lms_clasificacion.imagen_back,
     tbl_lms_clasificacion.color2


from
     tbl_inscripcion_usuarios
inner join tbl_lms_curso
on tbl_lms_curso.id=tbl_inscripcion_usuarios.id_curso
inner join tbl_lms_clasificacion
on tbl_lms_clasificacion.id_clasificacion=tbl_lms_curso.clasificacion


where
     tbl_inscripcion_usuarios.rut = '$rut'
     order by tbl_lms_clasificacion.orden asc


     ";
    $sql = "


     SELECT
     distinct(tbl_lms_curso.clasificacion) as id_clasificacion,
     tbl_lms_clasificacion.clasificacion AS nombre_clasificacion,
     tbl_lms_clasificacion.color,
     tbl_lms_clasificacion.imagen,
     tbl_lms_clasificacion.imagen_back,
     tbl_lms_clasificacion.color2


from
     tbl_inscripcion_usuarios
inner join tbl_lms_curso
on tbl_lms_curso.id=tbl_inscripcion_usuarios.id_curso
inner join tbl_lms_clasificacion
on tbl_lms_clasificacion.id_clasificacion=tbl_lms_curso.clasificacion


where
     tbl_inscripcion_usuarios.rut = '$rut'
     order by tbl_lms_clasificacion.orden asc


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_clasificacionesPorMalla($malla, $id_empresa, $id_clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $filtro_id_clasificacion = "";
    if ($id_clasificacion) {
        $filtro_id_clasificacion = " and rel_lms_malla_curso.id_clasificacion='$id_clasificacion'";
    }
    $sql = "


     SELECT DISTINCT
     (rel_lms_malla_curso.id_clasificacion),
     tbl_lms_clasificacion.clasificacion AS nombre_clasificacion,
     tbl_lms_clasificacion.descripcion AS descripcion_clasificacion,
     tbl_lms_clasificacion.color,
     tbl_lms_clasificacion.imagen,
     tbl_lms_clasificacion.imagen_back,
     tbl_lms_clasificacion.imagennivel,
     tbl_lms_clasificacion.textonivel,
     tbl_lms_clasificacion.descripcionnivel,
     tbl_lms_clasificacion.opcional,
     tbl_lms_clasificacion.inactivo,

     tbl_lms_clasificacion.color2
from
     rel_lms_malla_curso
inner JOIN tbl_lms_curso ON tbl_lms_curso.id = rel_lms_malla_curso.id_curso
inner JOIN tbl_lms_malla ON tbl_lms_malla.id = rel_lms_malla_curso.id_malla




inner JOIN tbl_lms_clasificacion ON tbl_lms_clasificacion.id_clasificacion = rel_lms_malla_curso.id_clasificacion
where
     rel_lms_malla_curso.id_malla = '$malla' and tbl_lms_curso.id_empresa='$id_empresa' and tbl_lms_clasificacion.id_empresa='$id_empresa'
     $filtro_id_clasificacion
AND
     rel_lms_malla_curso.id_curso = tbl_lms_curso.id
AND (tbl_lms_clasificacion.opcional is null or tbl_lms_clasificacion.opcional='')
order BY
     tbl_lms_clasificacion.orden ASC
     ";

     //echo $sql; exit();
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_malla_porUsuario($rut, $id_malla, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_malla) {
        $filtro_malla = " and rel_lms_malla_persona.id_malla='$id_malla'";
    }
    $sql = "SELECT
     rel_lms_malla_persona.*,
     tbl_lms_malla.nombre as nombre_malla,
     tbl_lms_malla.descripcion as descripcion_malla,


     tbl_lms_malla.template as template_malla,






     tbl_lms_malla.columnas_clasificacion
from
     rel_lms_malla_persona
left join tbl_lms_malla on tbl_lms_malla.id=rel_lms_malla_persona.id_malla
where
     rut = '$rut' $filtro_malla
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_clasificacionesPorMallaClasificacionOpcional($malla, $id_empresa, $id_clasificacion)
{
    $connexion = new DatabasePDO();
    
    
    $filtro_id_clasificacion = "";
    if ($id_clasificacion) {
        $filtro_id_clasificacion = " and rel_lms_malla_curso.id_clasificacion='$id_clasificacion'";
    }
    $sql = "


     SELECT DISTINCT
     (rel_lms_malla_curso.id_clasificacion),
     tbl_lms_clasificacion.clasificacion AS nombre_clasificacion,
     tbl_lms_clasificacion.descripcion AS descripcion_clasificacion,
     tbl_lms_clasificacion.color,
     tbl_lms_clasificacion.imagen,
     tbl_lms_clasificacion.imagen_back,
     tbl_lms_clasificacion.color2
from
     rel_lms_malla_curso
inner JOIN tbl_lms_curso ON tbl_lms_curso.id = rel_lms_malla_curso.id_curso
inner JOIN tbl_lms_malla ON tbl_lms_malla.id = rel_lms_malla_curso.id_malla




inner JOIN tbl_lms_clasificacion ON tbl_lms_clasificacion.id_clasificacion = rel_lms_malla_curso.id_clasificacion
where
     rel_lms_malla_curso.id_malla = '$malla' and tbl_lms_curso.id_empresa='$id_empresa' and tbl_lms_clasificacion.id_empresa='$id_empresa'
     $filtro_id_clasificacion
AND
     rel_lms_malla_curso.id_curso = tbl_lms_curso.id
AND tbl_lms_clasificacion.opcional = 1
order BY
     tbl_lms_clasificacion.orden ASC
     ";  // echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CAPACITACION_DatosGeneralesPorUsuario($rut, $filtros_desde_admin)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select h.* from rel_lms_malla_persona h where h.rut='$rut'     ";
    $connexion->query($sql);
    
    $malla         = $connexion->resultset();
    $id_malla      = $malla[0]->id_malla;
    $sumaTodos     = 0;
    $sumaAprobado  = 0;
    $sumaReprobado = 0;
    $sumaProceso   = 0;
    if ($filtros_desde_admin["curso"]) {
        $filtro_curso = " and h.id_curso='" . $filtros_desde_admin["curso"] . "'";
    } else {
        $filtro_curso = "";
    }
    $sql = " select
     h.*,
     (select estado from tbl_inscripcion_cierre where rut='$rut' and id_curso=h.id_curso limit 1) as estado


     from rel_lms_malla_curso h


     where h.id_malla='$id_malla' $filtro_curso  and h.opcional is null";

//      echo $sql;
    $connexion->query($sql);
    
    $curso = $connexion->resultset();
    foreach ($curso as $curso_unico) {
        if ($curso_unico->estado == 1) {
            $sumaAprobado++;
        }
        if ($insccierre_unico->estado === "0") {
            $sumaReprobado++;
        }
        if ($curso_unico->estado == 3) {
            $sumaProceso++;
        }
        $sumaTodos++;
    }
    if (count($curso) == 0) {
        $sql = "select estado from tbl_inscripcion_cierre where rut='$rut' ";
        $connexion->query($sql);
        
        $insccierre = $connexion->resultset();
        foreach ($insccierre as $insccierre_unico) {
            if ($insccierre_unico->estado == 1) {
                $sumaAprobado++;
            }
            if ($insccierre_unico->estado === "0") {
                $sumaReprobado++;
            }
            if ($insccierre_unicoSM->estado == 3) {
                $sumaProceso++;
            }
            $sumaTodos++;
        }
    }
    return array(
        $sumaTodos,
        $sumaAprobado,
        $sumaReprobado,
        $sumaProceso
    );
}
function TraeDatosPorFeedback($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_feedback_evaluado where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaFeedbackEvaluadoFinalizado($evaluado, $evaluador, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_sgd_feedback_finalizado
     (evaluado, evaluador, id_proceso, id_empresa, fecha, hora) values
     ('$evaluado', '$evaluador', '$id_proceso', '$id_empresa', '$fecha', '$hora')";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaFeedbackEvaluado($evaluado, $evaluador, $id_proceso, $id_empresa, $realizado, $pregunta1, $pregunta2, $pregunta3, $pregunta4)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_sgd_feedback_evaluado
     (evaluado, evaluador, id_proceso, id_empresa, realizado, pregunta1, pregunta2, pregunta3, pregunta4, fecha, hora) values
     ('$evaluado', '$evaluador', '$id_proceso', '$id_empresa', '$realizado', '$pregunta1', '$pregunta2', '$pregunta3', '$pregunta4', '$fecha', '$hora')";
    $connexion->query($sql);
    $connexion->execute();
}
function VErificaFeedbackFinalizado($evaluado, $evaluador, $id_proceso, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_feedback_finalizado where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioPorCompetenciaDadoEvaluadoEvaluadoProcesoIdCOmpReporte($evaluado, $evaluador, $id_proceso, $id_componente_reporte)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select avg(puntaje) as promedio_comp from tbl_sgd_respuestas
inner join tbl_sgd_componente
on tbl_sgd_componente.id=tbl_sgd_respuestas.id_competencia
where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso' and tbl_sgd_componente.id_componente_reporte='$id_componente_reporte'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalIdCompetenciasSoloCompetencias($sql)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     distinct(tbl_sgd_componente.id), nombre, descripcion, id_dimension, id_componente_reporte, sigla
from
     rel_sgd_perfil_competencias
inner JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
where
     $sql
order BY
     tbl_sgd_componente.nombre ASC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadoEvaluador($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas




FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador'
and tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador' and tbl_sgd_relaciones.evaluado = '$evaluado'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorIdProcesoAnual($id_anual)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS total_preguntas,
tbl_sgd_proceso_evaluacion.id_proceso_anual
FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = tbl_sgd_relaciones.evaluador
and tbl_sgd_sesion_evaluacion.id_proceso = tbl_sgd_relaciones.id_proceso
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
INNER JOIN tbl_usuario AS base_evaluador ON base_evaluador.rut = tbl_sgd_relaciones.evaluador
inner join tbl_sgd_proceso_evaluacion on tbl_sgd_proceso_evaluacion.id_proceso=tbl_sgd_relaciones.id_proceso
where tbl_sgd_proceso_evaluacion.id_proceso_anual='$id_anual'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorSoloProceso($id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS total_preguntas
FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = tbl_sgd_relaciones.evaluador
and tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
INNER JOIN tbl_usuario AS base_evaluador ON base_evaluador.rut = tbl_sgd_relaciones.evaluador
WHERE
     tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluador($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas




FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador'
and tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     pagina,
     tbl_usuario.perfil_evaluacion,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas




FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = '$evaluador'
and tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso' and tbl_sgd_sesion_evaluacion.evaluado=tbl_sgd_relaciones.evaluado
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadorV2($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "SELECT
     tbl_usuario.nombre_completo,
     tbl_usuario.perfil_evaluacion,
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_usuario.perfil_evaluacion
     )AS total_preguntas,
     (
     SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = tbl_usuario.rut
     AND tbl_sgd_respuestas.evaluador = '$evaluador'
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_usuario.perfil_evaluacion
     ) as pagina
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $sql       = "SELECT
     tbl_usuario.nombre_completo,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     tbl_sgd_relaciones.evaluado,
     tbl_sgd_relaciones.evaluador,
     (
     SELECT
     count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM
     rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE
     perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS total_preguntas,
     (
     SELECT
     count(tbl_sgd_respuestas.id) as total
     FROM
     tbl_sgd_respuestas
     INNER JOIN rel_sgd_perfil_competencias
     ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_respuestas.id_competencia
     WHERE
     tbl_sgd_respuestas.evaluado = tbl_usuario.rut
     AND tbl_sgd_respuestas.evaluador = '$evaluador'
     and tbl_sgd_respuestas.id_proceso='$id_proceso'
     AND rel_sgd_perfil_competencias.perfil_evaluacion = tbl_sgd_relaciones.perfil_evaluacion_competencias
     ) as pagina
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosEvaluadoEvaluadorParaAvancePorEvaluadorPorCriterios($id_proceso, $campo_criterio, $valor_criterio, $tipo_resumen)
{
    $connexion = new DatabasePDO();
    
    
    if ($tipo_resumen == "evaluadoEvaluador") {
        $tabla = "tbl_usuario";
    } else {
        $tabla = "base_evaluador";
    }
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado, tbl_sgd_relaciones.evaluador, pagina, tbl_usuario.perfil_evaluacion,
     (SELECT count(tbl_sgd_preguntas.id)AS total_preguntas
     FROM rel_sgd_perfil_competencias
     INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
     INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
     WHERE perfil_evaluacion = tbl_usuario.perfil_evaluacion )AS total_preguntas
FROM
     tbl_sgd_relaciones
left JOIN tbl_sgd_sesion_evaluacion ON tbl_sgd_sesion_evaluacion.evaluador = tbl_sgd_relaciones.evaluador
and tbl_sgd_sesion_evaluacion.id_proceso = '$id_proceso'
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
inner join tbl_usuario as base_evaluador on base_evaluador.rut=tbl_sgd_relaciones.evaluador
WHERE


tbl_sgd_relaciones.id_proceso = '$id_proceso' and $tabla.$campo_criterio='$valor_criterio'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaComentarioPorCompetencia($evaluado, $evaluador, $id_competencia, $id_empresa, $id_proceso, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_comentario_competencia
     set
     comentario='$comentario'
     where evaluado='$evaluado'
     and evaluador='$evaluador'
     and id_competencia='$id_competencia'
     and id_empresa='$id_empresa'
     and id_proceso='$id_proceso'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaComentarioPorCompetencia($evaluado, $evaluador, $id_competencia, $id_empresa, $id_proceso, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_sgd_comentario_competencia
     (evaluado, evaluador, id_competencia, id_empresa, id_proceso, comentario, fecha, hora) values
     ('$evaluado', '$evaluador', '$id_competencia', '$id_empresa', '$id_proceso', '$comentario', '$fecha', '$hora')";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneComentarioPorCompetencia($evaluado, $evaluador, $id_competencia, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_comentario_competencia where evaluado='$evaluado' and evaluador='$evaluador' and id_competencia='$id_competencia' and id_empresa='$id_empresa' and id_proceso='$id_proceso'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneComentarioPorCompetenciaEvaluadoEvaluador($evaluado, $evaluador, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_comentario_competencia where evaluado='$evaluado' and evaluador='$evaluador'  and id_empresa='$id_empresa' and id_proceso='$id_proceso' order by id_competencia asc


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeObjetivosIndividualesDadoRutConPondV2($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_objetivos_individuales.*
FROM
     tbl_objetivos_individuales
WHERE
     rut = '$rut' and tbl_objetivos_individuales.dimension<>70
order BY
     tbl_objetivos_individuales.id DESC";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeObjetivosIndividualesDadoRutConPond($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objetivos_individuales.*, tbl_objetivos_dimension.nombre as nombre_dimension
     from tbl_objetivos_individuales
     inner join tbl_objetivos_dimension
     on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension
     where rut='$rut' and ponderacion is not null order by tbl_objetivos_individuales.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeObjetivosIndividualesDadoRutSinPond($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objetivos_individuales.*, tbl_objetivos_dimension.nombre as nombre_dimension
     from tbl_objetivos_individuales
     inner join tbl_objetivos_dimension
     on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension
     where rut='$rut' and ponderacion is null order by tbl_objetivos_individuales.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalReconocimientosPorCategoriaGenerico($id_categoria, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_salonfama_publicados.*, tbl_salonfama_categorias.nombre AS nombre_categoria,
     tbl_salonfama_categorias.titulo_listado AS titulo_pagina,
     tbl_salonfama_categorias.descripcion AS descripcion_categoria,
     imagen,
     tbl_usuario.nombre,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_usuario.nombre_completo,
     tbl_usuario.cargo,
     tbl_salonfama_categorias.template_row AS template_row,
     tbl_salonfama_categorias.imagen_form,
     tbl_salonfama_categorias.imagen_inicio_pagina


FROM
     tbl_salonfama_publicados
INNER JOIN tbl_salonfama_categorias ON tbl_salonfama_categorias.id = tbl_salonfama_publicados.id_tipo_reconocimiento
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_salonfama_publicados.rut
WHERE
     idempresa = '$id_empresa'
and id_tipo_reconocimiento = '$id_categoria'
order BY


     tbl_salonfama_publicados.id DESC


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso2PorCalibradorSinAe($rut_calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.calibrador = '$rut_calibrador' and tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     order by subperfil, nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso2PorCalibrador($rut_calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.calibrador = '$rut_calibrador' and tbl_sgd_relaciones.id_proceso='$id_proceso'
     order by subperfil, nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeLiberadoEvaluadoEvaluadorProceso($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_calibracion_liberados where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeLiberadoEvaluadoEvaluadorCalibrador($evaluado, $evaluador, $calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_calibracion_liberados where evaluado='$evaluado' and evaluador='$evaluador' and calibrador='$calibrador' and id_proceso='$id_proceso'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorRangosMenorYMayorPorCalibrador($calibrador, $id_proceso, $rango_menor, $rango_mayor)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     inner join tbl_sgd_relaciones
     on tbl_sgd_relaciones.evaluado=tbl_sgd_respuestas.evaluado
     and tbl_sgd_relaciones.evaluador=tbl_sgd_respuestas.evaluador
     and tbl_sgd_relaciones.id_proceso=tbl_sgd_respuestas.id_proceso


     where tbl_sgd_relaciones.calibrador='$calibrador' and tbl_sgd_respuestas.id_proceso='$id_proceso' and (tbl_sgd_respuestas.puntaje>=$rango_menor and tbl_sgd_respuestas.puntaje<=$rango_mayor)
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorCalibrador($calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_respuestas.*
FROM
     tbl_sgd_respuestas
INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id = tbl_sgd_respuestas.id_pregunta
inner join tbl_sgd_relaciones on tbl_sgd_respuestas.evaluado=tbl_sgd_relaciones.evaluado and tbl_sgd_respuestas.evaluador = tbl_sgd_relaciones.evaluador and tbl_sgd_respuestas.id_proceso=tbl_sgd_relaciones.id_proceso


WHERE
     calibrador = '$calibrador'
and tbl_sgd_respuestas.id_proceso = '$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorCalibradorSinAe($calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_respuestas.*
FROM
     tbl_sgd_respuestas
INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id = tbl_sgd_respuestas.id_pregunta
inner join tbl_sgd_relaciones on tbl_sgd_respuestas.evaluado=tbl_sgd_relaciones.evaluado and tbl_sgd_respuestas.evaluador = tbl_sgd_relaciones.evaluador and tbl_sgd_respuestas.id_proceso=tbl_sgd_relaciones.id_proceso


WHERE
     calibrador = '$calibrador'
and tbl_sgd_respuestas.id_proceso = '$id_proceso' and tbl_sgd_respuestas.evaluado<>tbl_sgd_respuestas.evaluador
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoCompetenciasDadoPerfilInnerCompetencia($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_componente.nombre
FROM
     rel_sgd_perfil_competencias


inner join tbl_sgd_componente on tbl_sgd_componente.id=rel_sgd_perfil_competencias.id_componente
WHERE
     perfil_evaluacion = $perfil";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoCompetenciasDadoPerfil($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from rel_sgd_perfil_competencias where perfil_evaluacion='$perfil'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaLiberadosDesdeCalibracion($evaluado, $evaluador, $validador, $calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "insert into tbl_calibracion_liberados (evaluado, evaluador, validador, calibrador, id_proceso, fecha, hora) values ('$evaluado', '$evaluador', '$validador', '$calibrador', '$id_proceso', '$fecha', '$hora')";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeCantidadLiberadosPorEvaluador($rut_evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_calibracion_liberados where evaluador='$rut_evaluador' and id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeCantidadLiberadosPorCalibrador($rut_calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_calibracion_liberados where calibrador='$rut_calibrador' and id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSinAeCalibrador($calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_relaciones where id_proceso='$id_proceso' and calibrador='$calibrador' and evaluado<>evaluador
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSinAeConDatos($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_relaciones.*, baseevaluado.nombre_completo, baseevaluado.sucursal,
     baseevaluado.perfil_competencia,
     baseevaluado.fecha_ingreso as fecha_ingreso_evaluado,
     baseevaluado.cargo as cargo_evaluado,
     baseevaluador.nombre_completo AS nombre_evaluador_1,
     basevalidador.nombre_completo AS nombre_validador
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario AS baseevaluado ON baseevaluado.rut = tbl_sgd_relaciones.evaluado
INNER JOIN tbl_usuario AS baseevaluador ON baseevaluador.rut = tbl_sgd_relaciones.evaluador
left JOIN tbl_usuario AS basevalidador ON basevalidador.rut = tbl_sgd_relaciones.validador
WHERE
     tbl_sgd_relaciones.id_proceso = '$id_proceso'
and tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.evaluado <> tbl_sgd_relaciones.evaluador


order by baseevaluado.sucursal desc, baseevaluado.nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSinAe($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_relaciones.*
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_sgd_relaciones.evaluado=tbl_usuario.rut
     where tbl_sgd_relaciones.id_proceso='$id_proceso'
     and tbl_sgd_relaciones.evaluador='$evaluador'
     and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     and (
     tbl_usuario.perfil_evaluacion='' or
     tbl_usuario.perfil_evaluacion is null or
     tbl_usuario.perfil_evaluacion='SI')


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeRelacionesSinAeSinProceso($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_relaciones.evaluado,
     baseevaluado.nombre_completo,
     baseevaluado.cargo as cargo_evaluado,
     baseevaluado.fecha_ingreso as fecha_ingreso_evaluado
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario AS baseevaluado ON baseevaluado.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.evaluado <> tbl_sgd_relaciones.evaluador
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeCantidadDeCalibracionesPorEvaluadorSinAe($rut_calibrador, $id_proceso, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_relaciones where calibrador='$rut_calibrador' and id_proceso='$id_proceso' and evaluador='$evaluador' and evaluado<>evaluador
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeCantidadDeCalibracionesPorEvaluador($rut_calibrador, $id_proceso, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_relaciones where calibrador='$rut_calibrador' and id_proceso='$id_proceso' and evaluador='$evaluador'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeCantidadDeCalibraciones($rut_calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_relaciones where calibrador='$rut_calibrador' and id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeCantidadDeCalibracionesSinAe($rut_calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_relaciones where calibrador='$rut_calibrador' and id_proceso='$id_proceso' and evaluado<>evaluador
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorRangosMenorYMayorPorEvaluado($evaluador, $id_proceso, $rango_menor, $rango_mayor, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where evaluador='$evaluador' and evaluado='$evaluado' and id_proceso='$id_proceso' and (puntaje>=$rango_menor and puntaje<=$rango_mayor)
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoRespuestasCrucePreguntasPorEvaluado($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_sgd_respuestas.*
     from tbl_sgd_respuestas
     inner join tbl_sgd_preguntas
     on tbl_sgd_preguntas.id=tbl_sgd_respuestas.id_pregunta
     where evaluador='$evaluador' and id_proceso='$id_proceso' and evaluado='$evaluado'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TitulosDinamicosPorEmpresaEnv($id_empresa, $case)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_case_titulo where id_empresa='$id_empresa' and sw='$case' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadoresPorProcesoDadoCalibrador($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     distinct(tbl_sgd_relaciones.evaluador) as rut,


     perfil_evaluacion
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluador
WHERE
     tbl_sgd_relaciones.calibrador = '$rut' and tbl_sgd_relaciones.id_proceso='$id_proceso'   and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     order by nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaBitacorasPositivasNegativas($rut, $valor)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_bitacora_textos WHERE evaluado='$rut' and realizado='$valor' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificoEnTablaDeDirectores($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_rut_directores_reportes_directos WHERE rut='$rut' and id_empresa='$id_empresa' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaUsuarioMundo($rut, $campo, $valor, $operador_logico)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_mundos where id='$id_mundo'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosPorIdDeMundo($id_mundo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_mundos where id='$id_mundo'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeSubCarpetasPerfiladas($id, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $datos_usuario = UsuarioEnBasePersonas($rut, $rutcontodo);
    $sql           = "
select
     tbl_galeria.*,tbl_mundos.nombre as nombre_mundos, tbl_comunidades.nombre as nombre_comunidades
FROM
     tbl_galeria


left join tbl_mundos
on tbl_mundos.id=tbl_galeria.id_mundo


left JOIN tbl_comunidades
on tbl_comunidades.id=tbl_galeria.id_comunidad




WHERE
     tbl_galeria.id_categoria = '$id'
order BY
     tbl_galeria.id DESC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeSlidersPorNoticias($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_empresa == 22) {
        $datos_usuario_session = UsuarioEnBasePersonas($_SESSION["user_"], $rutcontodo);
        if ($datos_usuario_session[0]->unidad_negocio == "Sucursales") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='2')";
        } else if ($datos_usuario_session[0]->unidad_negocio == "Santiago") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='1')";
        }
    }
    $sql = "
     select *
     from tbl_noticias
     where id_empresa='$id_empresa' and slider_activo>0
     and estado='1'  $filtro_mundo
     order by slider_activo, id asc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeSlidersPorNoticiasBK($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select *
     from tbl_noticias
     where id_empresa='$id_empresa'
     and slider_activo>0
     and estado='1'


     order by slider_activo asc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntaEncuestaParaTNT()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objeto_pregunta.*
     from tbl_objeto_pregunta
where
i    d_empresa='22'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntaEncuestaParaPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objeto_pregunta.*
     from tbl_objeto_pregunta
where
i    d_empresa='$id_empresa' and activo='1'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador1PorProcesoPorCalibrador($calibrador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.calibrador='$calibrador' and tbl_sgd_relaciones.id_proceso='$id_proceso'
     ";
    $sql       = "select distinct(tbl_sgd_relaciones.perfil_evaluacion_competencias) as id_perfil_ev
     from tbl_sgd_relaciones
     where tbl_sgd_relaciones.calibrador='$calibrador'
     and tbl_sgd_relaciones.id_proceso='$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador1PorProceso($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.id_proceso='$id_proceso'
     ";
    $sql       = "SELECT DISTINCT
     (
     tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS id_perfil_ev
FROM
     tbl_sgd_relaciones


WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador1PorProcesoEvaluado($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.id_proceso='$id_proceso' and tbl_sgd_relaciones.evaluado='$evaluado'
     ";
    $sql       = "SELECT DISTINCT
     (
     tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS id_perfil_ev
FROM
     tbl_sgd_relaciones


WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
and tbl_sgd_relaciones.evaluado = '$evaluado'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminoMensajesDeBuzonPorId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_mensajes_principal WHERE id = '$id'");
    $connexion->query($sql);
    $connexion->execute();
}
function TiposDestinatariosPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "    select nombre, id as tipo_destinatario from tbl_mensajes_destinatarios where id_empresa='$id_empresa' order by orden asc    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalMensajesPorRutEmpresaPorTipoDestinatario($rut, $id_empresa, $filtro_destinatario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_mensajes_principal.*,
     tbl_usuario.nombre as nombre_creador, tbl_usuario.apaterno, tbl_usuario.amaterno, tbl_mensajes_destinatarios.nombre as nombre_tipo_destinatario,
     tbl_mensaje_tipo.nombre as nombre_titulo,
     (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
     from tbl_mensajes_principal


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_mensajes_principal.rut_creador


     inner join tbl_mensajes_destinatarios
     on tbl_mensajes_destinatarios.id=tbl_mensajes_principal.id_tipo_destinatario


     inner join tbl_mensaje_tipo
     on tbl_mensaje_tipo.id=tbl_mensajes_principal.tipo_mensaje


     where tbl_mensajes_principal.rut_creador='$rut' and tbl_mensajes_principal.id_empresa='$id_empresa' and tbl_mensajes_principal.id_tipo_destinatario='$filtro_destinatario'


     order by id desc


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalMensajesPorRutDestinatarioPerfilado($rut, $id_empresa, $filtro_destinatario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_mensajes_principal.*, tbl_usuario.nombre as nombre_creador,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_mensaje_tipo.nombre AS nombre_titulo,
     tbl_mensajes_destinatarios.nombre AS nombre_tipo_destinatario,
     (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
FROM
     tbl_mensajes_destinatarios_usuarios
INNER JOIN tbl_mensajes_principal ON tbl_mensajes_principal.id_tipo_destinatario = tbl_mensajes_destinatarios_usuarios.tipo_destinatario
INNER JOIN tbl_usuario ON tbl_usuario.rut = rut_creador
INNER JOIN tbl_mensajes_destinatarios ON tbl_mensajes_destinatarios.id = tbl_mensajes_principal.id_tipo_destinatario
INNER JOIN tbl_mensaje_tipo ON tbl_mensaje_tipo.id = tbl_mensajes_principal.tipo_mensaje
WHERE
     tbl_mensajes_destinatarios_usuarios.rut = '$rut'
and tbl_mensajes_principal.id_empresa = '$id_empresa' and tbl_mensajes_principal.id_tipo_destinatario='$filtro_destinatario'
order by tbl_mensajes_principal.id desc
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DAtosDestinatariosPorUsuario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_mensajes_destinatarios_usuarios.*, tbl_mensajes_destinatarios.nombre
FROM
     tbl_mensajes_destinatarios_usuarios


INNER JOIN tbl_mensajes_destinatarios ON tbl_mensajes_destinatarios.id = tbl_mensajes_destinatarios_usuarios.tipo_destinatario WHERE
     rut = '$rut'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosCompetenciaDadoId($id_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_sgd_componente where id='$id_competencia'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PerfilesDadoCompetencias($id_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "    SELECT
     rel_sgd_perfil_competencias.*, tbl_sgd_perfiles_ponderaciones.descripcion as nombre_perfil
FROM
     rel_sgd_perfil_competencias
inner join tbl_sgd_perfiles_ponderaciones
on tbl_sgd_perfiles_ponderaciones.perfil=rel_sgd_perfil_competencias.perfil_evaluacion
WHERE
     id_componente = '$id_competencia'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfil21($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     rel_sgd_perfil_competencias.*, tbl_sgd_componente.nombre AS nombre_componente, tbl_sgd_componente.descripcion AS descripcion_componente,
     tbl_sgd_componente.id_dimension
FROM
     rel_sgd_perfil_competencias
INNER JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id
WHERE
     perfil_evaluacion = '$perfil' order by tbl_sgd_componente.id_dimension
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntasPorCompetenciaConRespuestaPorPregunta($id_competencia, $evaluado, $evaluador, $id_proceso, $id_pregunta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_preguntas.*, tbl_sgd_respuestas.respuesta, tbl_sgd_respuestas.puntaje, tbl_sgd_respuestas.comentario
FROM
     tbl_sgd_preguntas
INNER JOIN tbl_sgd_respuestas ON tbl_sgd_respuestas.id_pregunta = tbl_sgd_preguntas.id
and tbl_sgd_respuestas.evaluado = '$evaluado'
and tbl_sgd_respuestas.evaluador = '$evaluador' and tbl_sgd_respuestas.id_proceso='$id_proceso'
WHERE
     tbl_sgd_preguntas.id_competencia = '$id_competencia' and tbl_sgd_preguntas.id='$id_pregunta'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfilPorCompetencia($perfil, $evaluado, $evaluador, $id_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     rel_sgd_perfil_competencias.*,
     tbl_sgd_componente.nombre AS nombre_componente,
     tbl_sgd_componente.descripcion AS descripcion_componente,
     tbl_sgd_componente.id AS id_competencia,
     tbl_sgd_componente.muestra_preguntas_informe,
     tbl_sgd_componente.id_dimension,
     (select avg(puntaje) as nota_competncia from tbl_sgd_respuestas where tbl_sgd_respuestas.id_competencia=tbl_sgd_componente.id and evaluado='$evaluado' and evaluador='$evaluador') as nota_promedio
FROM
     rel_sgd_perfil_competencias
INNER JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id
WHERE
     perfil_evaluacion = '$perfil' and tbl_sgd_componente.id='$id_competencia'
order by tbl_sgd_componente.orden asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function IngresaSeguimientoPorPlan($id_plan, $grado_cumplimiento, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_planes_ingresados
     set
     seguimiento_grado_cumplimiento='$grado_cumplimiento',
     seguimiento_comentario='$comentario'
     where id='$id_plan'";
    $connexion->query($sql);
    $connexion->execute();
}
function IngresaComentariosJefePorPlan($id_plan, $sugiere, $comentario)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_planes_ingresados
     set
     jefe_sugiere='$sugiere',
     jefe_comentario='$comentario'
     where id='$id_plan'";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaEstadoPlanes($rut)
{
    $connexion = new DatabasePDO();
    $sql = "
     SELECT * FROM  tbl_planes_estados  WHERE evaluado= '$rut'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaEstadoPlanes($rut, $id_proceso_plan, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "insert into
     tbl_planes_estados (evaluado, id_empresa, id_proceso_plan)
     values ('$rut', '$id_empresa', '$id_proceso_plan')";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalCompetenciasPorPerfil($id_perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT * FROM  rel_sgd_perfil_competencias  WHERE perfil_evaluacion= '$id_perfil'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntasPorCompetencia($id_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT * FROM  tbl_sgd_preguntas  WHERE tbl_sgd_preguntas.id_competencia = '$id_competencia'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalIdCompetenciasIndividual($sql)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT DISTINCT
     (id_componente),
     tbl_sgd_componente.nombre,
     tbl_sgd_componente.descripcion as descripcion_competencia,
     tbl_sgd_componente.imagen as imagen_competencia,
     tbl_sgd_componente.color as color_competencia,


     tbl_sgd_componente.muestra as muestra_competencia,
     tbl_sgd_dimensiones.muestra as muestra_dimension,
     tbl_sgd_dimensiones.nombre as nombre_dimension,
     tbl_sgd_preguntas.tiene_comentarios,
     tbl_sgd_preguntas.comentario_obligatorio


FROM
     rel_sgd_perfil_competencias
INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente
INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id
INNER JOIN tbl_sgd_dimensiones on tbl_sgd_dimensiones.id=tbl_sgd_componente.id_dimension
WHERE
     $sql
order BY
     tbl_sgd_componente.orden ASC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador1PorEvaluado($evaluador, $evaluado, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.evaluado='$evaluado' and tbl_sgd_relaciones.id_proceso='$id_proceso'
     ";
    $sql       = "SELECT DISTINCT
     (
     tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS id_perfil_ev
FROM
     tbl_sgd_relaciones


WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
and tbl_sgd_relaciones.evaluado = '$evaluado'
and tbl_sgd_relaciones.id_proceso = '$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaPlan($id_plan, $rut, $id_competencia, $actividad_a_desarrollar, $resultado_esperado, $fecha_inicio, $fecha_termino, $plazos)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_planes_ingresados
     set
     id_competencia='$id_competencia',
     nombre_competencia='$nombre_competencia',
     actividad_desarrollar='$actividad_a_desarrollar',
     resultado_esperado='$resultado_esperado',
     fecha_inicio='$fecha_inicio',
     fecha_termino='$fecha_termino',
     plazo='$plazos'


     where id='$id_plan'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaPlanes($rut, $competencia, $actividad_a_desarrollar, $resultado_esperado, $fecha_inicio, $fecha_termino, $plazos, $id_empresa, $id_proceso, $id_proceso_anual, $id_proceso_evaluacion)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "INSERT INTO tbl_planes_ingresados(evaluado, id_competencia, nombre_competencia, actividad_desarrollar, resultado_esperado, fecha_inicio, fecha_termino, plazo, fecha, hora, id_empresa, id_proceso, id_proceso_anual, id_proceso_evaluacion) " . "VALUES ('$rut', '$competencia', '$nombre_competencia', '$actividad_a_desarrollar', '$resultado_esperado', '$fecha_inicio', '$fecha_termino', '$plazos', '$fecha', '$hora', '$id_empresa', '$id_proceso', '$id_proceso_anual', '$id_proceso_evaluacion');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeDatosPorPlanes($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_planes_ingresados.*, tbl_sgd_componente.nombre as nombre_competencia, tbl_planes_plazos.nombre as plazo_nombre
     from tbl_planes_ingresados
     inner join tbl_sgd_componente
     on tbl_sgd_componente.id=tbl_planes_ingresados.id_competencia
     inner join tbl_planes_plazos
     on tbl_planes_plazos.id=.tbl_planes_ingresados.plazo


     where evaluado='$evaluado' order by tbl_planes_ingresados.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasPorPerfilConNombre($id_perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     rel_sgd_perfil_competencias.*, tbl_sgd_componente.nombre as nombre_competencia
FROM
     rel_sgd_perfil_competencias
inner join tbl_sgd_componente
on tbl_sgd_componente.id=rel_sgd_perfil_competencias.id_componente
WHERE
     perfil_evaluacion = '$id_perfil'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerCantidadMeGustaPorObjetoYUsuario($id_objeto, $tipo_objeto, $id_empresa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_megusta_registro where id_empresa='$id_empresa' and $tipo_objeto='$id_objeto' and rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerCantidadMeGustaPorObjeto($id_objeto, $tipo_objeto, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_megusta_registro where id_empresa='$id_empresa' and $tipo_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRegistroMegusta($id_objeto, $rut, $id_empresa, $tipo_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "INSERT INTO tbl_megusta_registro(rut, id_empresa, fecha, hora, $tipo_objeto) " . "VALUES ('$rut', '$id_empresa', '$fecha', '$hora', '$id_objeto');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaRegistroMegustaFavoritaMP($id_mp, $rut, $id_empresa, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "INSERT INTO tbl_mp_interacciones(id_mp, rut, id_empresa, tipo, fecha)
     VALUES ('$id_mp', '$rut', '$id_empresa', '$tipo', '$fecha');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeCampoPorSucursalEmpresa($nombre_campo, $id_sucursal, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select $nombre_campo as valor from tbl_sucursales where id_empresa='$id_empresa' and id='$id_sucursal'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoCamposParaSucursalPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sucursales_relacion where idempresa='$id_empresa' and orden is not null order by orden asc  ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoPuntajeDadoAlternativa($alternativa, $perfil, $id_empresa, $dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_matriz_criterios where id_empresa='$id_empresa' and perfil='$perfil' and alternativa_seleccionada='$alternativa' and dimension='$dimension'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VeoSiEstaEnTblClave($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_clave where rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizarVisitasPorNoticia($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_noticias set visitas=visitas+1 where id='$id'";
    $connexion->query($sql);
    $connexion->execute();
}
function ComunidadesPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select * from tbl_comunidades where id_empresa='$id_empresa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function MundosPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = " select * from tbl_mundos where id_empresa='$id_empresa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosEspecificosConRespuestaEvaluadoEvaluadorProcesoPorDimension($evaluado, $evaluador, $id_proceso, $id_dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     SELECT
     tbl_objetivos_dimension.nombre AS nombre_dimension,
     tbl_objetivos_dimension.ponderacion AS ponderacion_dimension,
     tbl_sgd_respuestas.*, tbl_objetivos_individuales.descripcion_objetivo,
     tbl_objetivos_individuales.dimenfsion,
     tbl_objetivos_individuales.ponderacion,
     tbl_objetivos_individuales.nota_descripcion,
     tbl_objetivos_individuales.metrica,
     (select sum(ponderacion) as suma_ponderaciones from tbl_objetivos_individuales as tabla_obj_ind where tabla_obj_ind.rut='$evaluado' and tabla_obj_ind.dimension='$id_dimension' ) as suma_ponderaciones_por_dimension
FROM
     tbl_sgd_respuestas
INNER JOIN tbl_objetivos_individuales ON tbl_objetivos_individuales.id = tbl_sgd_respuestas.id_objetivo
INNER JOIN tbl_objetivos_dimension ON tbl_objetivos_dimension.id = tbl_objetivos_individuales.dimension
WHERE
     tbl_sgd_respuestas.evaluado = '$evaluado'
and tbl_sgd_respuestas.evaluador = '$evaluador'
and tbl_sgd_respuestas.id_proceso = '$id_proceso'
and tbl_objetivos_individuales.dimension = '$id_dimension'
order BY
     nombre_dimension ASC
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioPorDimensionObjetivos($evaluado, $evaluador, $id_dimension, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     avg(puntaje) as promedio_por_dimension
FROM
     tbl_sgd_respuestas
INNER JOIN tbl_objetivos_individuales ON tbl_sgd_respuestas.id_objetivo = tbl_objetivos_individuales.id
WHERE
     tbl_sgd_respuestas.evaluado = '$evaluado'
and tbl_objetivos_individuales.dimension = '$id_dimension'
and tbl_sgd_respuestas.evaluador = '$evaluador'
and tbl_sgd_respuestas.id_proceso = '$id_proceso'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso2($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso, calibrador
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut' and tbl_sgd_relaciones.id_proceso='$id_proceso'
     order by subperfil, nombre_completo asc
     ";
    $sql       = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     id_proceso,
     calibrador


     FROM
     tbl_sgd_relaciones
     INNER JOIN
     tbl_usuario ON tbl_usuario.rut = evaluado
     WHERE
     tbl_sgd_relaciones.evaluador = '$rut'
     AND tbl_sgd_relaciones.id_proceso = '$id_proceso'
     and (
     tbl_usuario.perfil_evaluacion='' or
     tbl_usuario.perfil_evaluacion is null or
     tbl_usuario.perfil_evaluacion='SI')
     ORDER BY
     subperfil,
     nombre_completo, nombre, apaterno ASC
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso2SinAe($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut'
     and tbl_sgd_relaciones.id_proceso='$id_proceso' and
     tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     and
     (
     tbl_usuario.perfil_evaluacion='' or
     tbl_usuario.perfil_evaluacion is null or
     tbl_usuario.perfil_evaluacion='SI')
     order by subperfil, nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluadoEvaluadorProProcesoSoloEvaluador($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_finalizados_evaluado_evaluador where evaluador='$evaluador' and id_proceso='$id_proceso'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluadoEvaluadorProProceso($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_finalizados_evaluado_evaluador where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalUsuariosPorempresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario where id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeAsuntoDeMensaje($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_mensaje_tipo where id='$id'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function RespuestasPorMensaje($id_mensaje)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_mensajes_respuestas.*, tbl_usuario.nombre, tbl_usuario.apaterno, tbl_usuario.amaterno, tbl_usuario.cargo
     from tbl_mensajes_respuestas
     inner join tbl_usuario
     on tbl_usuario.rut=rut_creador where id_mensaje='$id_mensaje'
     order by tbl_mensajes_respuestas.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function MensajeAtendidoPorAdmin($id_mensaje)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_mensajes_respuestas where id_mensaje='$id_mensaje' and tipo_creador='1'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRespuestaMensajeria($id_mensaje, $rut_creador, $mensaje, $id_empresa, $tipo_creador)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $sql   = "


insert into tbl_mensajes_respuestas(id_mensaje, rut_creador, mensaje, fecha, hora, id_empresa, tipo_creador)
values('$id_mensaje', '$rut_creador', '$mensaje', '$fecha', '$hora', '$id_empresa', '$tipo_creador')




     ";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalMensajesPorRutDestinatario($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_mensajes_principal.*, tbl_usuario.nombre as nombre_creador,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_mensaje_tipo.nombre AS nombre_titulo,
     tbl_mensajes_destinatarios.nombre AS nombre_tipo_destinatario,
     (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
FROM
     tbl_mensajes_destinatarios_usuarios
INNER JOIN tbl_mensajes_principal ON tbl_mensajes_principal.id_tipo_destinatario = tbl_mensajes_destinatarios_usuarios.tipo_destinatario
INNER JOIN tbl_usuario ON tbl_usuario.rut = rut_creador
INNER JOIN tbl_mensajes_destinatarios ON tbl_mensajes_destinatarios.id = tbl_mensajes_principal.id_tipo_destinatario
INNER JOIN tbl_mensaje_tipo ON tbl_mensaje_tipo.id = tbl_mensajes_principal.tipo_mensaje
WHERE
     tbl_mensajes_destinatarios_usuarios.rut = '$rut'
and tbl_mensajes_principal.id_empresa = '$id_empresa'
order by tbl_mensajes_principal.id desc
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EsDestinatarioMensajeria($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_mensajes_destinatarios_usuarios where rut='$rut'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoTipoCorreoPorProcesoEmpresa($id_empresa, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_correos where id_empresa='$id_empresa' and tipo_mensajeria='$tipo' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EtapasPorProceso($id_procceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("




     SELECT
     tbl_sgd_proceso_etapa.*, tbl_sgd_proceso_tipo.codigo
FROM
     tbl_sgd_proceso_etapa
INNER JOIN tbl_sgd_proceso_evaluacion ON tbl_sgd_proceso_evaluacion.id_proceso = tbl_sgd_proceso_etapa.id_proceso
INNER JOIN tbl_sgd_proceso_tipo ON tbl_sgd_proceso_tipo.id = tbl_sgd_proceso_evaluacion.tipo_proceso
WHERE
     tbl_sgd_proceso_etapa.id_proceso = '$id_procceso'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosLinks($id_links)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_links_interes where id='$id_links'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizarVisitasLinks($id_link)
{
    $connexion = new DatabasePDO();
    $sql = " update tbl_links_interes set visitas=visitas+1 where id='$id_link'";
    $connexion->query($sql);
    $connexion->execute();
}
function ObjetivosEspecificosConRespuestaEvaluadoEvaluadorProceso2($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    $sql = sprintf("
        SELECT
     tbl_objetivos_dimension.nombre AS nombre_dimension,
     tbl_sgd_respuestas.*, tbl_objetivos_individuales.descripcion_objetivo,
     tbl_objetivos_individuales.dimension,
     tbl_objetivos_individuales.ponderacion,
     tbl_objetivos_individuales.id as id_objetivo_original,
     tbl_objetivos_individuales.nota_descripcion,
     tbl_objetivos_individuales.nota_ev,
     tbl_objetivos_individuales.metrica
FROM
     tbl_objetivos_individuales
left JOIN tbl_sgd_respuestas ON tbl_objetivos_individuales.id = tbl_sgd_respuestas.id_objetivo and tbl_sgd_respuestas.evaluado='$evaluado' and tbl_sgd_respuestas.evaluador='$evaluador' and tbl_sgd_respuestas.id_proceso='$id_proceso'
INNER JOIN tbl_objetivos_dimension ON tbl_objetivos_dimension.id = tbl_objetivos_individuales.dimension
WHERE
tbl_objetivos_individuales.rut='$evaluado'
order BY
     nombre_dimension ASC




     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioRespuestasCompPorProceso($evaluado, $evaluador, $competencia, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("select
     avg(puntaje) as nota_competencia,
     id_competencia,
     id_dimension
     from tbl_sgd_respuestas
     where evaluado='$evaluado' and evaluador='$evaluador' and id_competencia ='$competencia' and id_proceso='$id_proceso'");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function LinksInteresPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_links_interes where id_empresa='$id_empresa'    and activo='0'


     order by visitas desc


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntasPorCompetenciaConRespuesta($id_competencia, $evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_sgd_preguntas.*, tbl_sgd_respuestas.respuesta, tbl_sgd_respuestas.puntaje, tbl_sgd_respuestas.comentario
FROM
     tbl_sgd_preguntas
INNER JOIN tbl_sgd_respuestas ON tbl_sgd_respuestas.id_pregunta = tbl_sgd_preguntas.id
and tbl_sgd_respuestas.evaluado = '$evaluado'
and tbl_sgd_respuestas.evaluador = '$evaluador' and tbl_sgd_respuestas.id_proceso='$id_proceso'
WHERE
     tbl_sgd_preguntas.id_competencia = '$id_competencia'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValidoTokem($tokem)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_registro_login where tokem='$tokem'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRegistroLogin($arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $fecha = date("Y-m-d");
    $hora  = date("H:i:s");
    $tokem = base64_encode($arreglo_post["user"] . "&" . $fecha . "&" . $hora);
    $sql   = "INSERT INTO tbl_registro_login(rut, nombre, cargo, celular, email, fecha_ingreso, rut_jefe, nombre_jefe, cargo_jefe, correo_jefe, tokem, fecha, hora, id_empresa) " . "VALUES ('" . ($arreglo_post["user"]) . "',
     '" . ($arreglo_post["nombre"]) . "',
     '" . ($arreglo_post["cargo"]) . "',
     '" . ($arreglo_post["celular"]) . "',
     '" . ($arreglo_post["email"]) . "',
     '" . ($arreglo_post["fecha_ingreso"]) . "',
     '" . ($arreglo_post["rut_jefe"]) . "',
     '" . ($arreglo_post["nombre_jefe"]) . "',
     '" . ($arreglo_post["cargo_jefe"]) . "',
     '" . ($arreglo_post["correo_jefe"]) . "',
     '$tokem',
     '" . $fecha . "',
     '" . $hora . "',
     '58');";
    $connexion->query($sql);
    $connexion->execute();
    return ($tokem);
}
function InsertaVioBanner($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_banner_visto(rut, id_empresa, fecha, hora) " . "VALUES ('$rut', '$id_empresa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaVioBannerDinamicoPorAmbiente($rut, $id_empresa, $ambiente)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_banner_visto(rut, id_empresa, fecha, hora, ambiente) " . "VALUES ('$rut', '$id_empresa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$ambiente');";
    $connexion->query($sql);
    $connexion->execute();
}
function VioBannerPorAmbiente($rut, $id_empresa, $ambiente)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_banner_visto where rut='$rut' and id_empresa='$id_empresa' and ambiente='$ambiente'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VioBanner($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_banner_visto where rut='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DDatosEncSatis($id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  * from tbl_enc_satis where idencuesta='$id_encuesta'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosPreguntaObjetoDadoId($id_pregunta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objeto_pregunta.*
     from tbl_objeto_pregunta
where
i    d='$id_pregunta'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntaDadoIdObjeto($id_objeto, $tipo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select tbl_objeto_pregunta.*
     from tbl_objeto_pregunta
where
i    d_objeto='$id_objeto' and tipo='$tipo'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ArchivosDadoIdObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_biblio_archivos.*
     from tbl_biblio_archivos
     inner join tbl_biblio_categorias
     on tbl_biblio_categorias.id=tbl_biblio_archivos.id_categoria


     where tbl_biblio_categorias.id_objeto='$id_objeto'




";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BloqueCitaPorObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
select * from tbl_objeto_bloque_cita where id_objeto='$id_objeto'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function BloqueTextoPorObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




select * from tbl_objeto_bloque_texto where id_objeto='$id_objeto'






";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function RelMallaProgramaPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     rel_malla_programa.*, tbl_programa.nombre AS nombre_programa,
     tbl_programa.id AS id_programa
FROM
     rel_malla_programa
inner join tbl_programa on tbl_programa.id=rel_malla_programa.id_programa
inner join tbl_lms_malla
on tbl_lms_malla.id=rel_malla_programa.id_malla
WHERE
     tbl_lms_malla.id_empresa = '$id_empresa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DataPorIndicador($id_indicador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_indicadores_data where id_indicador='$id_indicador'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeIndicadores($id_empresa, $variable)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_indicadores where idempresa='$id_empresa' and gerencia='$variable'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtieneMovimientosNuevosIngresos($id_categoria, $limit, $variable)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    if ($variable) {
        $comunidad = " and tbl_usuario.id_comunidad='$variable'";
    } else {
    }
    $sql = "


     select tbl_movimientos_publicados.*, tbl_usuario.nombre, tbl_usuario.apaterno, tbl_usuario.amaterno
     from tbl_movimientos_publicados
     inner join tbl_usuario on  tbl_usuario.rut=tbl_movimientos_publicados.rut
     where id_categoria='$id_categoria' $comunidad




order BY
     RAND()
$limit


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtieneMovimientosNuevosIngresosPorEmpresaBKBK($id_categoria, $limit, $variable, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    if ($variable) {
        $comunidad = " and tbl_usuario.id_comunidad='$variable'";
    } else {
    }
    $sql = "


     select tbl_movimientos_publicados.*, tbl_usuario.nombre, tbl_usuario.apaterno, tbl_usuario.amaterno, tbl_usuario.ubicacion
     from tbl_movimientos_publicados
     inner join tbl_usuario on  tbl_usuario.rut=tbl_movimientos_publicados.rut and tbl_usuario.id_empresa='$id_empresa'
     where id_categoria='$id_categoria' $comunidad




order BY
     RAND()
$limit


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtieneMovimientosNuevosIngresosPorEmpresa($id_categoria, $limit, $variable, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    if ($variable) {
        $comunidad = " and tbl_usuario.id_comunidad='$variable'";
    } else {
    }
    $sql = "


     select tbl_movimientos_publicados.*, tbl_usuario.nombre, tbl_usuario.apaterno, tbl_usuario.amaterno, tbl_usuario.ubicacion
     from tbl_movimientos_publicados
     inner join tbl_usuario on  tbl_usuario.rut=tbl_movimientos_publicados.rut and tbl_usuario.id_empresa='$id_empresa'
     where id_categoria='$id_categoria' $comunidad




order BY
     RAND()
$limit


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarLogNoticia($rut, $id_noticia, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_noticias_log(rut, id_empresa, id_noticia, fecha, hora) " . "VALUES ('$rut', '$id_empresa', '$id_noticia', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeUltimasFotosSubidas($limit)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select * from tbl_galeria_archivos order by id desc limit $limit


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeUltimasFotosSubidasPorEmpresa($limit, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


select
     tbl_galeria_archivos.*
FROM
     tbl_galeria_archivos
inner join tbl_galeria
on tbl_galeria.id=tbl_galeria_archivos.id_categoria
where tbl_galeria.id_empresa=$id_empresa
order BY
     id DESC
limit $limit
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalMensajesPorRutEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_mensajes_principal.*,
     tbl_usuario.nombre as nombre_creador, tbl_usuario.apaterno, tbl_usuario.amaterno, tbl_mensajes_destinatarios.nombre as nombre_tipo_destinatario,
     tbl_mensaje_tipo.nombre as nombre_titulo,
     (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
     from tbl_mensajes_principal


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_mensajes_principal.rut_creador


     inner join tbl_mensajes_destinatarios
     on tbl_mensajes_destinatarios.id=tbl_mensajes_principal.id_tipo_destinatario


     inner join tbl_mensaje_tipo
     on tbl_mensaje_tipo.id=tbl_mensajes_principal.tipo_mensaje


     where tbl_mensajes_principal.rut_creador='$rut' and tbl_mensajes_principal.id_empresa='$id_empresa'


     order by id desc


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarMensaje($rut, $titulo, $mensaje, $tipo_mensaje, $id_empresa, $destinatario, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_mensajes_principal(rut_creador, titulo, mensaje, tipo_mensaje, fecha, hora, id_empresa, id_tipo_destinatario, id_curso, id_objeto) " . "VALUES ('$rut', '$titulo', '$mensaje', '$tipo_mensaje', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa', '$destinatario', '$id_curso', '$id_objeto');";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalMensajesPorRutEmpresaAgente($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select tbl_mensajes_principal.*,
     tbl_usuario.nombre as nombre_creador, tbl_usuario.apaterno, tbl_usuario.amaterno,
     tbl_mensaje_tipo.nombre as nombre_titulo,
     (select count(*) as total_respuestas from tbl_mensajes_respuestas where id_mensaje=tbl_mensajes_principal.id) as total_comen
     from tbl_mensajes_principal


     inner join tbl_usuario
     on tbl_usuario.rut=tbl_mensajes_principal.rut_creador




     inner join tbl_mensaje_tipo
     on tbl_mensaje_tipo.id=tbl_mensajes_principal.tipo_mensaje


     where tbl_mensajes_principal.rut_creador='$rut' and tbl_mensajes_principal.id_empresa='$id_empresa'


     order by id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarMensaje_agente($rut, $titulo, $mensaje, $tipo_mensaje, $id_empresa, $destinatario, $id_curso, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_mensajes_principal(rut_creador, titulo, mensaje, tipo_mensaje, fecha, hora, id_empresa, id_tipo_destinatario, id_curso, id_objeto) " . "VALUES ('$rut', '$titulo', '$mensaje', '$tipo_mensaje', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa', '$destinatario', '$id_curso', '$id_objeto');";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalUsuariosPorRutJefe($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select     h.*,
     (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut)  as cuenta
 from tbl_usuario h
 where h.jefe='$rut' or h.responsable='$rut'
     and h.vigencia='0'
 order by (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut) desc, h.nombre asc


";
//echo $sql; exit();
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalUsuariosPorRutLiderEjecutivos($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select     h.*,
     (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut)  as cuenta


     from tbl_usuario h


     where h.lider='$rut'
     and h.vigencia='0'


     order by (select count(id) from tbl_lms_acciones_pendientes where rut_colaborador=h.rut) desc, h.nombre asc


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalReconocimientosPorCategoria($id_categoria, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     tbl_salonfama_publicados.*, tbl_salonfama_categorias.nombre AS nombre_categoria,
     tbl_salonfama_categorias.titulo_listado AS titulo_pagina,
     tbl_salonfama_categorias.descripcion AS descripcion_categoria,
     tbl_salonfama_valores.nombre AS nombre_valor,
     imagen,
     tbl_usuario.nombre,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_usuario.nombre_completo,
     tbl_usuario.cargo,
     tbl_salonfama_categorias.template_row AS template_row,
     tbl_salonfama_categorias.imagen_form,
     tbl_salonfama_categorias.imagen_inicio_pagina,
     tbl_salonfama_conductas.nombre as nombre_conducta_valor
FROM
     tbl_salonfama_publicados
INNER JOIN tbl_salonfama_categorias ON tbl_salonfama_categorias.id = tbl_salonfama_publicados.id_tipo_reconocimiento
INNER JOIN tbl_salonfama_valores ON tbl_salonfama_valores.id = tbl_salonfama_publicados.id_valor
left join tbl_salonfama_conductas on tbl_salonfama_conductas.id=tbl_salonfama_publicados.id_conducta
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_salonfama_publicados.rut
WHERE
     idempresa = '$id_empresa'
and id_tipo_reconocimiento = '$id_categoria'
order BY
     nombre_valor,
     tbl_salonfama_publicados.id DESC


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalReconocimientosPorRut($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select
     tbl_salonfama_publicados.*, tbl_salonfama_categorias.nombre as nombre_categoria, tbl_salonfama_categorias.descripcion as descripcion_categoria, imagen
     from tbl_salonfama_publicados
     inner join tbl_salonfama_categorias
     on tbl_salonfama_categorias.id=tbl_salonfama_publicados.id_tipo_reconocimiento
     where rut='$rut' and idempresa='$id_empresa'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerCumpleanosPorMesPorEmpresaTodos($id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    $sql = "


select nombre, apaterno, amaterno, cargo, fecha_nacimiento, rut, nombre_completo
from tbl_usuario
where extract(month from fecha_nacimiento) = extract(month from current_date)


AND id_empresa='$id_empresa' order by extract(day from fecha_nacimiento)  $limit






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerCumpleanosPorMesPorEmpresa($id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    $sql = "


select nombre, cargo, fecha_nacimiento, rut, nombre_completo, apaterno, amaterno
from tbl_usuario
where extract(month from fecha_nacimiento) = extract(month from current_date)
AND
     extract(day from fecha_nacimiento) >= extract(day from current_date)
AND id_empresa='$id_empresa' order by extract(day from fecha_nacimiento)  $limit






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerCumpleanosPorDiaPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
select nombre, fecha_nacimiento, cargo, rut, ubicacion, nombre_completo, apaterno, amaterno
from tbl_usuario
where extract(month from fecha_nacimiento) = extract(month from current_date) and
     extract(day from fecha_nacimiento) = extract(day from current_date)
AND id_empresa='$id_empresa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerSalonPorCategoriaYEmpresa($id_empresa, $id_categoria, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = "limit $limit";
    } else {
        $limit = "";
    }
    $sql = "


     SELECT
     tbl_salonfama_categorias.nombre,
     tbl_salonfama_categorias.imagen,
     tbl_salonfama_publicados.*, tbl_usuario.nombre AS nombre_persona,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno,
     tbl_usuario.cargo,
     tbl_salonfama_valores.nombre as nombre_valor
FROM
     tbl_salonfama_publicados
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_salonfama_publicados.rut
INNER JOIN tbl_salonfama_categorias ON tbl_salonfama_categorias.id = tbl_salonfama_publicados.id_tipo_reconocimiento
left join tbl_salonfama_valores on tbl_salonfama_valores.id=tbl_salonfama_publicados.id_valor
WHERE
     tbl_salonfama_publicados.idempresa = '$id_empresa'
and tbl_salonfama_publicados.id_tipo_reconocimiento = '$id_categoria'
order BY
     RAND()
$limit










     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CategoriasSalonDeLaFamaPorEmpresaTipoBanners($id_empresa, $tipo_banners)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_salonfama_categorias
     where id_empresa='$id_empresa' and tipo_banners='$tipo_banners'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CategoriasSalonDeLaFamaPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_salonfama_categorias
     where id_empresa='$id_empresa' and tipo_banners='1'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalSalonDeLaFamaPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select
     tbl_salonfama_categorias.nombre,
     tbl_salonfama_categorias.imagen,
     tbl_salonfama_publicados.*,
     tbl_usuario.nombre,
     tbl_usuario.apaterno,
     tbl_usuario.amaterno
     from
     tbl_salonfama_publicados
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_salonfama_publicados.rut


inner join tbl_salonfama_categorias
on tbl_salonfama_categorias.id=tbl_salonfama_publicados.id_tipo_reconocimiento
where tbl_salonfama_publicados.idempresa='$id_empresa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncSatisTopBottom($id_inscripcion, $limit, $order)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_enc_satis.idencuesta,
     tbl_enc_satis.nombre,
     tbl_enc_satis_dim.iddimension,
     tbl_enc_satis_dim.dimension,
tbl_enc_satis_preg.idpregunta,
     tbl_enc_satis_preg.pregunta,


A    VG(tbl_enc_satis_opc.puntaje) as promedio_por_pregunta
FROM
     tbl_enc_satis_respuestas
INNER JOIN tbl_enc_satis_preg ON tbl_enc_satis_preg.idpregunta = tbl_enc_satis_respuestas.id_pregunta
INNER JOIN tbl_enc_satis_dim ON tbl_enc_satis_dim.iddimension = tbl_enc_satis_preg.iddimension
INNER JOIN tbl_enc_satis ON tbl_enc_satis.idencuesta = tbl_enc_satis_dim.idencuesta
inner join tbl_enc_satis_opc on tbl_enc_satis_opc.idopcion=tbl_enc_satis_preg.idopcion and tbl_enc_satis_respuestas.respuesta=tbl_enc_satis_opc.opcion
where tbl_enc_satis_respuestas.id_inscripcion='$id_inscripcion'


group BY tbl_enc_satis_preg.idpregunta
order BY promedio_por_pregunta $order limit $limit




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncSatisPromedioPorDimension($id_inscripcion, $id_dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_enc_satis.idencuesta,
     tbl_enc_satis.nombre,
     tbl_enc_satis_dim.iddimension,


     tbl_enc_satis_dim.dimension,
     AVG(tbl_enc_satis_opc.puntaje) as promedio
FROM
     tbl_enc_satis_respuestas
INNER JOIN tbl_enc_satis_preg ON tbl_enc_satis_preg.idpregunta = tbl_enc_satis_respuestas.id_pregunta
INNER JOIN tbl_enc_satis_dim ON tbl_enc_satis_dim.iddimension = tbl_enc_satis_preg.iddimension
INNER JOIN tbl_enc_satis ON tbl_enc_satis.idencuesta = tbl_enc_satis_dim.idencuesta
inner join tbl_enc_satis_opc on tbl_enc_satis_opc.idopcion=tbl_enc_satis_preg.idopcion and tbl_enc_satis_respuestas.respuesta=tbl_enc_satis_opc.opcion
where tbl_enc_satis_respuestas.id_inscripcion='$id_inscripcion'


group BY tbl_enc_satis_dim.iddimension
order BY tbl_enc_satis.idencuesta,    tbl_enc_satis_dim.iddimension




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DimensionPorEncuesta($id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_enc_satis.idencuesta,
     tbl_enc_satis.nombre,
     tbl_enc_satis_dim.iddimension,
     tbl_enc_satis_dim.dimension


FROM
     tbl_enc_satis_dim


INNER JOIN tbl_enc_satis ON tbl_enc_satis.idencuesta = tbl_enc_satis_dim.idencuesta
WHERE
     tbl_enc_satis.idencuesta = '$id_encuesta'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoRegistroFinEncSatis($rut, $id_encuesta, $id_empresa, $id_inscripcion, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_enc_satis_finalizados(rut, id_encuesta, id_empresa, fecha, hora, id_inscripcion, id_objeto) " . "VALUES ('$rut', '$id_encuesta', '$id_empresa',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_inscripcion', '$id_objeto');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosPreguntaPorId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select tbl_evaluaciones_preguntas.*, tbl_evaluaciones_tipo_preguntas.feedback
     from
     tbl_evaluaciones_preguntas
     left join tbl_evaluaciones_tipo_preguntas
     on tbl_evaluaciones_tipo_preguntas.id=tbl_evaluaciones_preguntas.tipo
     where
     tbl_evaluaciones_preguntas.id='$id'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosEnvioCorreoPorProceso($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select * from tbl_correos_usuarios_proceso where rut='$rut' and id_proceso='$id_proceso' and estado=0


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosEnvioCorreoPorProcesoReenvio($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select * from tbl_correos_usuarios_proceso where rut='$rut' and id_proceso='$id_proceso' and estado=1


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TRaigoTresNoticiasMismaCategoria($id_empresa, $id_categoria, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = " limit $limit";
    } else {
        $limit = "";
    }
    $sql = "select *from tbl_noticias where id_empresa='$id_empresa' and categoria='$id_categoria' $limit ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TRaigoUltimas3Noticias($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select *from tbl_noticias where id_empresa='$id_empresa' order by id desc limit 3 ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoNoticasMasVistas($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_noticias where id_empresa='$id_empresa' order by visitas desc limit 3 ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CategoriasNoticiasPorEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select
     tbl_noticias_categorias.*,
     (select count(*) as total from tbl_noticias where categoria=tbl_noticias_categorias.id and tbl_noticias.id_empresa='$id_empresa') as total_noticia,
     (select count(*) as total_sub_catego from tbl_noticias_subcategorias where tbl_noticias_subcategorias.id_categoria=tbl_noticias_categorias.id) as tota_sub_cart
     from
     tbl_noticias_categorias
     where
     tbl_noticias_categorias.id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaVotoUnico($id, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_galeria_votos(id_archivo, id_usuario) " . "VALUES ('$id', '$rut');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaMenuN2($nombre, $link, $id_menun1, $tipo_link)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_menu_nivel2(id_nivel1, nombre, link, tipo_link) " . "VALUES ('$id_menun1', '$nombre', '$link', '$tipo_link');";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizoPrioridadNositicasPrincipales($id, $prioridad)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_noticias_principales set prioridad='$prioridad' where id='$id'";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaDatosMenuN1($nombre, $link, $id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_menu_nivel1 set nombre='$nombre', link='$link'  where id='$id'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaMenuN1($nombre, $link, $id_empresa, $tipo_link)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_menu_nivel1(nombre, link, id_empresa) " . "VALUES ('$nombre', '$link', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosMenuN1($id_menu)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select
     *
     from tbl_menu_nivel1
     where id='$id_menu'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosMenuNivelDadoId($id_nivel, $nivel)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select
     tbl_menu_nivel" . $nivel . ".*,
     tbl_paginas_templates.template  as pagina_a_mostrar,
     tbl_paginas_templates.variable,
     tbl_paginas_templates.contenido
     from tbl_menu_nivel" . $nivel . "
     inner join tbl_paginas_templates
     on tbl_paginas_templates.id=link
     where tbl_menu_nivel" . $nivel . ".id='$id_nivel'


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosMenuNivel2DadoNivel1($id_nivel1)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select
     *
     from tbl_menu_nivel2
     where id_nivel1='$id_nivel1'
     order by orden


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosMenuNivel1DadoEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "




     select
     tbl_menu_nivel1.*, (select count(*) as total from tbl_menu_nivel2 where id_nivel1=tbl_menu_nivel1.id) as total_nivel2
     from tbl_menu_nivel1
     where id_empresa='$id_empresa' order by orden asc


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncTraePaginaMayor($id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     max(DISTINCT(pagina)) AS pagina_mayor
FROM
     tbl_enc_satis_preg
inner join tbl_enc_satis_dim
on tbl_enc_satis_dim.iddimension=tbl_enc_satis_preg.iddimension
inner join tbl_enc_satis
on tbl_enc_satis.idencuesta=tbl_enc_satis_dim.idencuesta
where tbl_enc_satis.idencuesta='$id_encuesta'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoRegistroRespuestaEncSatis($rut, $id_pregunta, $respuesta, $id_encuesta, $id_empresa, $id_inscripcion, $id_objeto, $rut_relator)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_enc_satis_respuestas(id_encuesta, id_pregunta, id_empresa, rut, respuesta, fecha, hora, id_inscripcion, id_objeto, rut_relator) " . "VALUES ('$id_encuesta', '$id_pregunta', '$id_empresa', '$rut', '$respuesta', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_inscripcion', '$id_objeto', '$rut_relator');";
    $connexion->query($sql);
    $connexion->execute();
}
function EliminoColaboradoresDNCDadoId($rut_colaborador, $rut_jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_dnc_colaboradores_por_objetivo WHERE rut = '$rut_colaborador' and rut_jefe='$rut_jefe'");
    $connexion->query($sql);
    $connexion->execute();
}
function EliminoColaboradoresDadaSugerencia($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_dnc_colaboradores_por_objetivo WHERE id_sugerencia = '$id'");
    $connexion->query($sql);
    $connexion->execute();
}
function EliminarSugerenciaDadoId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_dnc_sugerencias_por_objetivo WHERE id = '$id'");
    $connexion->query($sql);
    $connexion->execute();
}
function EncActualizaRegistroSesion($rut, $id_empresa, $pagina, $id_objeto, $id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_enc_satis_sesion set pagina='$pagina', fecha='" . date("Y-m-d") . "', hora='" . date("H:i:s") . "' where rut='$rut' and id_empresa='$id_empresa' and id_objeto='$id_objeto' and idencuesta='$id_encuesta'";
    $connexion->query($sql);
    $connexion->execute();
}
function EncInsertaRegistroSesion($rut, $id_empresa, $pagina, $id_inscripcion, $id_objeto, $id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_enc_satis_sesion(rut, pagina, id_empresa, fecha, hora, id_inscripcion, id_objeto, idencuesta) " . "VALUES ('$rut', '$pagina', '$id_empresa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_inscripcion', '$id_objeto', '$id_encuesta');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosEmpresaHolding($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_empresa_holding where rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncTieneSesion($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_enc_satis_sesion where rut='$rut' and id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncTieneSesionPorEncuesta($rut, $id_empresa, $id_encuesta, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_enc_satis_sesion where rut='$rut' and id_empresa='$id_empresa' and idencuesta='$id_encuesta' and id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncTieneSesionPorObjeto($rut, $id_empresa, $id_objeto, $id_encuesta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_enc_satis_sesion where rut='$rut' and id_empresa='$id_empresa' and id_objeto='$id_objeto'  and idencuesta='$id_encuesta' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function allPersonasPorEmpresa($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * FROM tbl_usuario
     WHERE id_empresa='$id_empresa'
     and (nombre_completo like '%" . $buscar . "%' OR rut like '%" . $buscar . "%')
     and vigencia='0'
     ORDER BY nombre_completo";

    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}

function allPersonasPorEmpresaSinDivPersona($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * FROM tbl_usuario
     WHERE id_empresa='$id_empresa'
     and ( rut like '%" . $buscar . "%')
     and vigencia='0' and division<>'Division Personas y Organizacion'
     ORDER BY nombre_completo";

     //echo $sql;exit();

    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function allPersonasPorEmpresaSinDivPersonaJefe($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * FROM tbl_usuario
     WHERE id_empresa='$id_empresa'
     and ( rut like '%" . $buscar . "%')
     and vigencia='0' and division<>'Division Personas y Organizacion'  and (select count(id) from tbl_usuario where ( jefe like '%" . $buscar . "%') )>0
     ORDER BY nombre_completo";

     //echo $sql;exit();

    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}


function allArchivosBibliotecaPorEmpresaMPDATA($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    $nombrearray = explode(" ", $buscar);
    $nombrep1    = $nombrearray[0];
    $nombrep2    = $nombrearray[1];
    $nombrep3    = $nombrearray[2];
    $nombrep4    = $nombrearray[3];
    if ($nombrep2 <> '') {
        $andp1         = " or ";
        $query_nombre2 = " h.titulo like '%" . $nombrep2 . "%'  or  h.descripcion like '%" . $nombrep2 . "%'";
    }
    if ($nombrep3 <> '') {
        $andp2         = " or ";
        $query_nombre3 = " h.titulo like '%" . $nombrep3 . "%'  or  h.descripcion like '%" . $nombrep3 . "%'";
    }
    if ($nombrep4 <> '') {
        $andp3         = " or ";
        $query_nombre4 = " h.titulo like '%" . $nombrep4 . "%'  or  h.descripcion like '%" . $nombrep4 . "%'";
    }
    
    
    $sql = "SELECT h.*,
     (select categoria from tbl_biblio_categorias where id=h.id_categoria) as NombreSubCat,
     (select categoria from tbl_biblio_categorias where id=(select id_categoria from tbl_biblio_categorias where id=h.id_categoria)) as NombreCat




     FROM tbl_biblio_archivos h
     WHERE
     (select id_empresa from tbl_biblio_categorias where id=h.id_categoria)='$id_empresa'




     and
     (h.titulo like '%" . $nombrep1 . "%' or h.descripcion like '%" . $nombrep1 . "%'
     $andp1
     $query_nombre2
     $andp2
     $query_nombre3
     $andp3
     $query_nombre4








     )




     ORDER BY h.titulo";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function allPersonasPorEmpresaMP($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    $nombrearray = explode(" ", $buscar);
    $nombrep1    = $nombrearray[0];
    $nombrep2    = $nombrearray[1];
    $nombrep3    = $nombrearray[2];
    $nombrep4    = $nombrearray[3];
    if ($nombrep2 <> '') {
        $andp1         = " and ";
        $query_nombre2 = " nombre_completo like '%" . $nombrep2 . "%' ";
    }
    if ($nombrep3 <> '') {
        $andp2         = " and ";
        $query_nombre3 = " nombre_completo like '%" . $nombrep3 . "%' ";
    }
    if ($nombrep4 <> '') {
        $andp3         = " and ";
        $query_nombre4 = " nombre_completo like '%" . $nombrep4 . "%' ";
    }
    
    
    $sql = "SELECT * FROM tbl_usuario
     WHERE id_empresa='$id_empresa'


     and
     (nombre_completo like '%" . $nombrep1 . "%' $andp1
     $query_nombre2 $andp2
     $query_nombre3 $andp3
     $query_nombre4)


     and vigencia='0'
     ORDER BY nombre_completo";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function allPersonasPorEmpresaMP_GOPLAY($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    $nombrearray = explode(" ", $buscar);
    $nombrep1    = $nombrearray[0];
    $nombrep2    = $nombrearray[1];
    $nombrep3    = $nombrearray[2];
    $nombrep4    = $nombrearray[3];
    if ($nombrep2 <> '') {
        $andp1         = " and ";
        $query_nombre2 = " nombre_completo like '%" . $nombrep2 . "%' ";
    }
    if ($nombrep3 <> '') {
        $andp2         = " and ";
        $query_nombre3 = " nombre_completo like '%" . $nombrep3 . "%' ";
    }
    if ($nombrep4 <> '') {
        $andp3         = " and ";
        $query_nombre4 = " nombre_completo like '%" . $nombrep4 . "%' ";
    }
    
    
    $sql = "SELECT * FROM tbl_usuario
     WHERE id_empresa='$id_empresa'


     and
     (nombre_completo like '%" . $nombrep1 . "%' $andp1
     $query_nombre2 $andp2
     $query_nombre3 $andp3
     $query_nombre4)


     and rut<>'" . $_SESSION["user_"] . "'
     and vigencia='0'
     ORDER BY nombre_completo";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function allSucursalesPorEmpresa($buscar, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * FROM tbl_sucursales WHERE id_empresa='$id_empresa' and (nombre like '%" . $buscar . "%') ORDER BY nombre";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function allPersonas($buscar)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * FROM tbl_usuario WHERE nombre_completo like '%" . $buscar . "%' OR rut like '%" . $buscar . "%' ORDER BY nombre_completo";
    $connexion->query($sql);
    
    $datos = $connexion->resultset();
    return $datos;
}
function DatosExtensionDeObjeto($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetos_extension


     where id='$id'";

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncOpcionesDadoId($id_opciones)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_enc_satis_opc where idopcion='$id_opciones' order by orden asc






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EncTraigoPreguntasDadaPaginaIdEncuesta($id_encuesta, $pagina)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select


     tbl_enc_satis_preg_tipo.template, tbl_enc_satis_preg_tipo.template_opcion,


     tbl_enc_satis_preg.*, tbl_enc_satis_dim.dimension as nombre_dimension, tbl_enc_satis_dim.visible


from


tbl_enc_satis_preg






inner join tbl_enc_satis_dim


on tbl_enc_satis_dim.iddimension=tbl_enc_satis_preg.iddimension






INNER JOIN tbl_enc_satis


on tbl_enc_satis.idencuesta=tbl_enc_satis_dim.idencuesta


inner join tbl_enc_satis_preg_tipo on tbl_enc_satis_preg_tipo.id=tbl_enc_satis_preg.tipo_pregunta








where pagina='$pagina' and tbl_enc_satis.idencuesta='$id_encuesta'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerEncuestaDadiIdObjeto($id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  tbl_enc_satis.*


     from tbl_objeto


     inner join tbl_enc_satis


     on tbl_enc_satis.idencuesta=tbl_objeto.id_encuesta


     where tbl_objeto.id='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerEncuestaDadaEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select  tbl_enc_satis.*


     from rel_empresa_encuesta


     inner join tbl_enc_satis


     on tbl_enc_satis.idencuesta=rel_empresa_encuesta.id_encuesta


     where rel_empresa_encuesta.id_empresa='$id_empresa' and tbl_enc_satis.idencuesta";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoRegistroIngresoPorCorreo($rut, $token)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_correos_registros_externos(rut, token, fecha) " . "VALUES ('$rut', '$token', '" . date("Y-m-d") . " " . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertoRegistroEnvioCorreo($rut, $token_individual, $id_inscripcion, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_correos_registros_envios(rut, token_enviado, fecha_envio_correo, id_inscripcion, id_proceso_masivo) " . "VALUES ('$rut', '$token_individual', '" . date("Y-m-d") . " " . date("H:i:s") . "', '$id_inscripcion', '$id_proceso');";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaSugerencia($id_sugerencia, $post)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_dnc_sugerencias_por_objetivo
    set tipo='" . $post["tipo"] . "',
    prioridad='" . $post["prioridad"] . "',
    tipo_accion='" . $post["tipo_accion"] . "',
    descripcion_accion='" . ($post["descripcion_accion"]) . "',
    tematica_select='" . $post["tematica_select"] . "',
    tematica_texto='" . ($post["tematica_texto"]) . "',
    priorizar_tematica='" . ($post["priorizar_tematica"]) . "',
    contenido1='" . ($post["contenido1"]) . "',
    contenido2='" . ($post["contenido2"]) . "',
    contenido3='" . ($post["contenido3"]) . "',
    contenido4='" . ($post["contenido4"]) . "',
    contenido5='" . ($post["contenido5"]) . "'
    where id='$id_sugerencia';";
    $connexion->query($sql);
    $connexion->execute();
}
function EliminarColaboradoresSinSugerencia($rut_jefe)
{
    $connexion = new DatabasePDO();
    $sql = sprintf("DELETE from tbl_dnc_colaboradores_por_objetivo WHERE id_sugerencia is null");
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaUsuariosPorSugerencia($rut_jefe, $id_sugerencia)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_dnc_colaboradores_por_objetivo set id_sugerencia='$id_sugerencia' where rut_jefe='$rut_jefe' and id_sugerencia is null;";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaObjetivoPorJefatura($rut_jefe, $objetivo, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_dnc_objetivos_por_jefe set objetivo='$objetivo', id_empresa='$id_empresa' where rut_jefe='$rut_jefe';";
    $connexion->query($sql);
    $connexion->execute();
}
function UltimaSugerenciaIngresada($jefe)
{
    $connexion = new DatabasePDO();
    $sql = "select max(id) as ultimo from tbl_dnc_sugerencias_por_objetivo where rut_jefe='$jefe'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerSugerenciasDadoIdObjetivo($id_objetivo)
{
    $connexion = new DatabasePDO();
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where id_objetivo='$id_objetivo' order by numero_sugerencia asc";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function SugerenciaPorId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where id='$id'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraigoElAbierto($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where rut_jefe='$jefe' and  cerrado='0'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TRaigoSugerenciasPorObjetivo($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where rut_jefe='$jefe'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TRaigoSugerenciasCerradas($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_sugerencias_por_objetivo where rut_jefe='$jefe' where cerrado='1'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function AgregocolPorJefeDNCConIdSug($evaluado, $dato, $evaluador, $id_sugerencia, $rut_evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_colaboradores_por_objetivo(rut, nombre, rut_jefe, prioridad, id_sugerencia) " . "VALUES ('$rut_evaluado', '$evaluado', '$evaluador', '$dato', '$id_sugerencia');";
    $connexion->query($sql);
    $connexion->execute();
}
function AgregocolPorJefeDNC($evaluado, $dato, $evaluador, $rut_evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_colaboradores_por_objetivo(rut, nombre, rut_jefe, prioridad) " . "VALUES ('$rut_evaluado', '$evaluado', '$evaluador', '$dato');";
    $connexion->query($sql);
    $connexion->execute();
}
function UsuariosPorSugerenciaJefe($jefe, $id_sugerencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_colaboradores_por_objetivo where rut_jefe='$jefe' and id_sugerencia ='$id_sugerencia'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuariosPorSugerenciaJefeYColaborador($jefe, $colaborador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_colaboradores_por_objetivo where rut_jefe='$jefe' and rut='$colaborador'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuariosPorJefeObjDnc($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_colaboradores_por_objetivo where rut_jefe='$jefe' and id_sugerencia is null";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaSugerencia($rut, $arreglo_datos, $numero_sugerencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_sugerencias_por_objetivo(id_objetivo, tipo, descripcion, prioridad, tipo_accion, descripcion_accion, rut_jefe, tematica_select, tematica_texto, numero_sugerencia, contenido1, contenido2, contenido3, contenido4, priorizar_tematica, contenido5) " . "VALUES ('" . $arreglo_datos["ido"] . "','" . $arreglo_datos["tipo"] . "', '" . ($arreglo_datos["descripcion"]) . "', '" . ($arreglo_datos["prioridad"]) . "', '" . ($arreglo_datos["tipo_accion"]) . "', '" . ($arreglo_datos["descripcion_accion"]) . "', '$rut', '" . ($arreglo_datos["tematica_select"]) . "', '" . ($arreglo_datos["tematica_texto"]) . "', '$numero_sugerencia',
     '" . ($arreglo_datos["contenido1"]) . "',
     '" . ($arreglo_datos["contenido2"]) . "',
     '" . ($arreglo_datos["contenido3"]) . "',
     '" . ($arreglo_datos["contenido4"]) . "',
     '" . ($arreglo_datos["priorizar_tematica"]) . "',
     '" . ($arreglo_datos["contenido5"]) . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneObjetivosIngresadosDNCFinalizado($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos_por_jefe_finalizado where rut_jefe='$jefe'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneObjetivosIngresadosDNC($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos_por_jefe where rut_jefe='$jefe'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminarRegistroFinalizadoObjetivo($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_dnc_objetivos_por_jefe_finalizado WHERE rut_jefe='" . $rut . "' ");
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaObjetivoPorJefaturaFinalizado($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_objetivos_por_jefe_finalizado(rut_jefe, fecha, hora, id_empresa) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaObjetivoPorJefatura($rut, $objetivo, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_objetivos_por_jefe(objetivo, rut_jefe, fecha, hora, id_empresa) " . "VALUES ('$objetivo', '$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function TienePersonasInactivas($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_noevaluables where evaluador='$evaluador'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminarObjetivoDadoDimensionRut($dimension, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_objetivos_individuales WHERE rut='" . $rut . "' and dimension='$dimension' ");
    $connexion->query($sql);
    $connexion->execute();
}
function EliminarObjetivoDadoId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_objetivos_individuales WHERE id='" . $id . "' ");
    $connexion->query($sql);
    $connexion->execute();
}
function ObtenerObjetivosDeRechazoUltimo($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_comentarios_rechazo where evaluado='$evaluado' order by id desc limit 1";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EliminaRegistroEvaluadrAjuste($evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("DELETE from tbl_objetivos_ajustes_jefe WHERE evaluador='" . $evaluador . "' and evaluado='$evaluado'");
    $connexion->query($sql);
    $connexion->execute();
}
function ObtenerObjetivosDeRechazo($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_comentarios_rechazo where evaluado='$evaluado'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaComentarioRechazo($evaluado, $evaluador, $validador, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_comentarios_rechazo(evaluado, evaluador, validador, fecha, hora, comentario) " . "VALUES ('$evaluado', '$evaluador', '$validador',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$comentario');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaValidacionJefeDelJefe($evaluado, $evaluador, $validador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_validaciones(evaluado, evaluador, validador, fecha, hora) " . "VALUES ('$evaluado', '$evaluador', '$validador',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function EsValidador($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_relaciones where validador='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EsValidador2($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_relaciones where validador='$rut' and evaluador<>validador";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoUltimaNotaObjetivoEmpresa($id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT


     avg((


     SELECT


     nota


     FROM


     tbl_sgd_notas_empresa


     WHERE


     tbl_sgd_notas_empresa.id_proceso = '$id_proceso'


     AND tbl_sgd_notas_empresa.id_objetivo = tbl_objetivos_empresa.id ORDER BY fecha desc limit 1


     ) ) as promedio_objetivos_corporativos


FROM


     tbl_objetivos_empresa






where id_empresa='$id_empresa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoUltimaNotaObjetivoArea($id_area, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT


     tbl_objetivos_area.*, (


     SELECT


     tbl_sgd_notas_area.nota


     FROM


     tbl_sgd_notas_area


     WHERE


     tbl_objetivos_area.id = tbl_sgd_notas_area.id_objetivo and tbl_sgd_notas_area.id_proceso='$id_proceso'


     ORDER BY


     fecha DESC


     LIMIT 1


     ) as nota_area


FROM


     tbl_objetivos_area


WHERE


     tbl_objetivos_area.id_area = '$id_area'


and tbl_objetivos_area.id_empresa = '$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoDimensionesDadoPerfil($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("select DISTINCT (id_dimension) from tbl_sgd_componente


inner join rel_sgd_perfil_competencias


on rel_sgd_perfil_competencias.id_componente=tbl_sgd_componente.id


where rel_sgd_perfil_competencias.perfil_evaluacion='$perfil'");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioRespuestasComp($evaluado, $evaluador, $competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("select avg(puntaje) as nota_competencia, id_competencia, id_dimension from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_competencia ='$competencia'");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioObjetivosRepuestas($evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("select avg(respuesta) as nota_objetivos from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo is not null");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosEspecificosConRespuesta($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("






select tbl_sgd_respuestas.*, tbl_objetivos_individuales.descripcion_objetivo , tbl_objetivos_individuales.ponderacion


from tbl_sgd_respuestas


inner join tbl_objetivos_individuales


on tbl_objetivos_individuales.id=tbl_sgd_respuestas.id_objetivo


where evaluado='$rut'


     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaEvaluadorFinalizado($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_sgd_finalizados_evaluador(evaluador, id_proceso, fecha, hora) " . "VALUES ('$evaluador', '$id_proceso', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaEvaluadoEvaluadorFinalizado($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_sgd_finalizados_evaluado_evaluador(evaluado, evaluador, fecha, hora, id_proceso) " . "VALUES ('$evaluado' ,'$evaluador', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_proceso');";
    $connexion->query($sql);
    $connexion->execute();
}
function ObtenerJefeRel($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("






     select * from tbl_sgd_relaciones where evaluado='$evaluado' and subperfil='2'






     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerJefeRelPorProcesoAE($evaluado, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_relaciones where evaluado='$evaluado' and id_proceso='$id_proceso' and evaluado=evaluador
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerJefeRelPorProceso($evaluado, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select *
     from tbl_sgd_relaciones
     where evaluado='$evaluado'
     and id_proceso='$id_proceso'
     and evaluado<>evaluador
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerJefeRel2($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("






     select tbl_usuario.*


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluador


     where tbl_sgd_relaciones.evaluado='$evaluado' and tbl_sgd_relaciones.subperfil='2'






     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluadoEvaluador($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("






     select * from tbl_sgd_finalizados_evaluado_evaluador where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluadorPorProcesoSinAe($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_finalizados_evaluado_evaluador
     where evaluador='$evaluador'
     and id_proceso='$id_proceso'
     and evaluado<>evaluador
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluadorPorProceso($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_finalizados_evaluador where evaluador='$evaluador' and id_proceso='$id_proceso'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function FinalizadoEvaluador($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_finalizados_evaluador where evaluador='$evaluador'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosCriterioPorPerfil($id_empresa, $perfil, $tipo_perfil, $dimension)
{
    $connexion = new DatabasePDO();
    
    
    if ($dimension == 0 && !$tipo_perfil) {
        $sql = sprintf("
     select * from tbl_sgd_matriz_criterios
     where id_empresa='$id_empresa' and perfil='$perfil'  and dimension='$dimension' and tipo_objeto is null
     ");
    } else if ($tipo_perfil) {
        $sql = sprintf("
     select * from tbl_sgd_matriz_criterios
     where id_empresa='$id_empresa' and perfil='$perfil' and tipo_objeto='$tipo_perfil'
     ");
    } else if ($dimension >= 0) {
        $sql = sprintf("
     select * from tbl_sgd_matriz_criterios
     where id_empresa='$id_empresa' and perfil='$perfil'  and dimension='$dimension'
     ");
    } else {
        $sql = sprintf("
     select * from tbl_sgd_matriz_criterios
     where id_empresa='$id_empresa' and perfil='$perfil' and tipo_objeto='$tipo_perfil'
     ");
    }
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosCriterio($id_empresa, $perfil, $dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("
     select * from tbl_sgd_matriz_criterios
     where id_empresa='$id_empresa' and perfil='$perfil' and dimension='$dimension'
     ");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosDadoIDPregunta($id_pregunta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = sprintf("SELECT
     tbl_sgd_preguntas.id as id_pregunta,
     tbl_sgd_componente.id as id_componente,
     tbl_sgd_dimensiones.id as id_dimension
     FROM
     tbl_sgd_preguntas
     inner join tbl_sgd_componente
     on tbl_sgd_componente.id=tbl_sgd_preguntas.id_competencia
     inner join tbl_sgd_dimensiones
     on tbl_sgd_dimensiones.id=tbl_sgd_componente.id_dimension
     WHERE
     tbl_sgd_preguntas.id = $id_pregunta");
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaRespuestas($evaluado, $evaluador, $respuesta, $id_pregunta, $perfil, $subperfil, $id_proceso, $id_empresa, $dimension, $componente, $criterios, $comentario_por_pregunta)
{
    $connexion = new DatabasePDO();
    $datos_evaluado = UsuarioEnBaseDePersonasInnerEmpresa($evaluado);
    $database       = new database($c_host, $c_user, $c_pass);
    
    $sql = "update tbl_sgd_respuestas set
     respuesta='$respuesta',
     criterio='" . $criterios[0] . "',
     puntaje='" . $criterios[1] . "',
     comentario='$comentario_por_pregunta',
     cargo_evaluado='" . $datos_evaluado[0]->cargo . "',
     campo1_evaluado='" . $datos_evaluado[0]->{$datos_evaluado[0]->campo1} . "',
     campo2_evaluado='" . $datos_evaluado[0]->{$datos_evaluado[0]->campo2} . "',
     campo3_evaluado='" . $datos_evaluado[0]->{$datos_evaluado[0]->campo3} . "',
     fecha='" . date("Y-m-d") . "',
     hora='" . date("H:i:s") . "'
     where
     evaluado='$evaluado' and
     evaluador='$evaluador' and
     id_pregunta='$id_pregunta' and
     id_proceso='$id_proceso';";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "update tbl_sgd_respuestas_log set
     respuesta='$respuesta',
     criterio='" . $criterios[0] . "',
     puntaje='" . $criterios[1] . "',
     comentario='$comentario_por_pregunta'
     where
     evaluado='$evaluado' and
     evaluador='$evaluador' and
     id_pregunta='$id_pregunta' and
     id_proceso='$id_proceso';";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaRespuestasObj2($evaluado, $evaluador, $respuesta, $id_objetivo, $criterio, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_respuestas set respuesta='$respuesta', criterio='" . $criterio[0] . "', puntaje='" . $criterio[1] . "' where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo' and id_proceso='$id_proceso';";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "update tbl_sgd_respuestas_log set respuesta='$respuesta', criterio='" . $criterio[0] . "', puntaje='" . $criterio[1] . "' where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo' and id_proceso='$id_proceso';";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaRespuestasObj1($evaluado, $evaluador, $respuesta, $id_objetivo, $criterio, $comentario_por_objetivo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_respuestas set respuesta='$respuesta', criterio='" . $criterio[0] . "', puntaje='" . $criterio[1] . "', comentario='" . $comentario_por_objetivo . "' where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "update tbl_sgd_respuestas_log set respuesta='$respuesta', criterio='" . $criterio[0] . "', puntaje='" . $criterio[1] . "' where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaRespuestas($evaluado, $evaluador, $nota, $id_pregunta, $perfil, $subperfil, $id_proceso, $id_empresa, $dimension, $componente, $criterios, $comentario_por_pregunta)
{
    $connexion = new DatabasePDO();
    $datos_evaluado = UsuarioEnBaseDePersonasInnerEmpresa($evaluado);
    $database       = new database($c_host, $c_user, $c_pass);
    
    $sql = "
     INSERT INTO
     tbl_sgd_respuestas
     (evaluado, evaluador, id_pregunta, respuesta, perfil, subperfil, id_proceso, id_empresa, id_dimension, id_competencia, criterio, puntaje, comentario, fecha, hora) " . "VALUES
     ('$evaluado', '$evaluador',  '$id_pregunta', '$nota', '$perfil', '$subperfil', '$id_proceso', '" . $_SESSION["id_empresa"] . "', '$dimension', '$componente', '" . $criterios[0] . "', '" . $criterios[1] . "', '$comentario_por_pregunta', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "INSERT INTO tbl_sgd_respuestas_log(evaluado, evaluador, id_pregunta, respuesta, perfil, subperfil, id_proceso, id_empresa, id_dimension, id_competencia, criterio, puntaje, comentario) " . "VALUES ('$evaluado', '$evaluador',  '$id_pregunta', '$nota', '$perfil', '$subperfil', '$id_proceso', '" . $_SESSION["id_empresa"] . "', '$dimension', '$componente', '" . $criterios[0] . "', '" . $criterios[1] . "', '$comentario_por_pregunta');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaRespuestasObj($evaluado, $evaluador, $nota, $id_objetivo, $criterios, $id_proceso, $comentario_por_objetivo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_sgd_respuestas(evaluado, evaluador, id_objetivo, respuesta, criterio, puntaje, id_proceso, id_empresa, fecha, hora, comentario) " . "VALUES ('$evaluado', '$evaluador',  '$id_objetivo', '$nota', '" . $criterios[0] . "', '" . $criterios[1] . "', '$id_proceso', '" . $_SESSION["id_empresa"] . "', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $comentario_por_objetivo . "');";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "INSERT INTO tbl_sgd_respuestas_log(evaluado, evaluador, id_objetivo, respuesta, criterio, puntaje, id_proceso, id_empresa, fecha, hora) " . "VALUES ('$evaluado', '$evaluador',  '$id_objetivo', '$nota', '" . $criterios[0] . "', '" . $criterios[1] . "', '$id_proceso', '" . $_SESSION["id_empresa"] . "', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalIdCompetencias($sql)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " SELECT DISTINCT
 (id_componente),
 tbl_sgd_componente.nombre,
     tbl_sgd_componente.descripcion as descripcion_competencia,
     tbl_sgd_componente.muestra as muestra_competencia,
     tbl_sgd_preguntas.pregunta,
     tbl_sgd_preguntas.descripcion,
     tbl_sgd_preguntas.id as id_pregunta,
     tbl_sgd_preguntas.id_alternativa,
     tbl_sgd_dimensiones.muestra as muestra_dimension,
     tbl_sgd_dimensiones.nombre as nombre_dimension,
     tbl_sgd_preguntas.tiene_comentarios,
     tbl_sgd_preguntas.comentario_obligatorio


FROM


     rel_sgd_perfil_competencias


INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente


INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id


INNER JOIN tbl_sgd_dimensiones on tbl_sgd_dimensiones.id=tbl_sgd_componente.id_dimension


WHERE


     $sql


order BY


     tbl_sgd_componente.orden ASC


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPreguntasPorSql($sql)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT DISTINCT


     (id_componente),


     tbl_sgd_componente.nombre, tbl_sgd_preguntas.pregunta, tbl_sgd_preguntas.id_alternativa


FROM


     rel_sgd_perfil_competencias


INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = rel_sgd_perfil_competencias.id_componente


INNER JOIN tbl_sgd_preguntas ON tbl_sgd_preguntas.id_competencia = tbl_sgd_componente.id


WHERE


     $sql


order BY


     id_componente ASC


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizoSesion($evaluado, $evaluador, $pagina, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_sgd_sesion_evaluacion set pagina='$pagina' where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso';";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertoSesion($evaluado, $evaluador, $pagina, $proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_sgd_sesion_evaluacion(evaluado, evaluador, pagina, id_proceso, fecha, hora) " . "VALUES ('$evaluado', '$evaluador',  '$pagina', '$proceso', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TotalPerfilesDadoEvaluador1($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev
     from tbl_sgd_relaciones
     inner join tbl_usuario
     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
     where tbl_sgd_relaciones.evaluador='$evaluador'
";
    $sql       = "SELECT DISTINCT
     (
     tbl_sgd_relaciones.perfil_evaluacion_competencias
     )AS id_perfil_ev
FROM
     tbl_sgd_relaciones
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalPerfilesDadoEvaluador($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select distinct(tbl_usuario.perfil_evaluacion) as id_perfil_ev,


(    select count(*) from rel_sgd_perfil_competencias where rel_sgd_perfil_competencias.perfil_evaluacion=id_perfil_ev) as cantidad_componentes


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     where tbl_sgd_relaciones.evaluador='$evaluador'


order by cantidad_componentes DESC LIMIT 1






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SesionSGD($evaluado, $evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_sesion_evaluacion where evaluado='$evaluado' and evaluador='$evaluador' and id_proceso='$id_proceso'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SesionSGDSoloEvaluadorEvaluado($evaluador, $id_proceso, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_sesion_evaluacion where  evaluador='$evaluador' and id_proceso='$id_proceso' and evaluado='$evaluado'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SesionSGDSoloEvaluador($evaluador, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_sesion_evaluacion where  evaluador='$evaluador' and id_proceso='$id_proceso' and evaluado=''
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaNotaObj($id_objetivo, $nota)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_objetivos_individuales set nota_ev='$nota' where id='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
}
function EvaluadosDadoEvaluadorEvaluado($evaluador, $evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_sgd_relaciones where evaluador='$evaluador' and evaluado='$evaluado' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluadoCruceFinalizadoIndividual($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_relaciones.evaluado, tbl_usuario.nombre, tbl_usuario.cargo


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     inner join tbl_objetivos_indviduales_finalizado


     on tbl_objetivos_indviduales_finalizado.evaluado=tbl_sgd_relaciones.evaluado


     where tbl_sgd_relaciones.evaluador='$evaluador'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluado($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_relaciones.evaluado, tbl_usuario.nombre, tbl_usuario.cargo


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     where tbl_sgd_relaciones.evaluador='$evaluador'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluadoSinAeParaPestanaMisValidaciones($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.evaluado,
tbl_usuario.nombre,
tbl_usuario.cargo
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluado <> tbl_sgd_relaciones.evaluador
and validador = '$evaluador'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluadoSinAe($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_relaciones.evaluado, tbl_usuario.nombre, tbl_usuario.cargo


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.evaluador<>tbl_sgd_relaciones.evaluado






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluadorConDatosDeEvaluadoYValidador($evaluador, $validador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_sgd_relaciones.evaluado, tbl_usuario.nombre, tbl_usuario.cargo


     from tbl_sgd_relaciones


     inner join tbl_usuario


     on tbl_usuario.rut=tbl_sgd_relaciones.evaluado


     where tbl_sgd_relaciones.evaluador='$evaluador' and tbl_sgd_relaciones.validador='$validador'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluadosDadoEvaluador($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT
     tbl_sgd_relaciones.*, tbl_sgd_subperfiles.perfil AS nombre_subperfil, tbl_usuario.perfil_evaluacion
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_sgd_subperfiles ON tbl_sgd_subperfiles.id = tbl_sgd_relaciones.subperfil
inner join tbl_usuario
on tbl_usuario.rut=tbl_sgd_relaciones.evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$evaluador'
order BY
     subperfil,
     tbl_sgd_relaciones.evaluado ASC




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerSiEsEvaluador($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario where evaluador='$rut'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenertituloCase($var)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_case_titulo where sw='$var'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosUsuarioLeftJefeDeTblUsuario($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_usuario.*,
     base_jefe.nombre as nombre_jefe,
     base_jefe.apaterno as apaterno_jefe,
     base_jefe.amaterno as amaterno_jefe


FROM
     tbl_usuario


left join tbl_usuario as base_jefe
on base_jefe.rut=tbl_usuario.jefe


WHERE
     tbl_usuario.rut = '$rut'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosUsuarioLeftJefe($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT tbl_usuario.*,
     basejefe.nombre_completo as nombre_evaluador, tbl_sgd_perfiles_ponderaciones.descripcion as nombre_perfil
     from tbl_usuario
     left join tbl_usuario as basejefe
     on basejefe.rut = tbl_usuario.evaluador
     left join tbl_sgd_perfiles_ponderaciones
     on tbl_usuario.perfil_evaluacion=tbl_sgd_perfiles_ponderaciones.perfil
     where tbl_usuario.rut='$rut'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRegistroTomoConocimientoCompetencia($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_aceptacion_competencias(rut, fecha, hora) " . "VALUES ('$rut',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TomoConocimientoEvaluadoCompetencias($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * from tbl_objetivos_aceptacion_competencias where rut='$rut' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRegistroTomoConocimiento($rut, $reunion, $comentario, $conoc)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_aceptacion(rut, reunion_jefatura, comentario_reunion_jefatura, conocimiento_objetivo, fecha, hora) " . "VALUES ('$rut', '$reunion', '$comentario', '$conoc',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TomoConocimientoEvaluado($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * from tbl_objetivos_aceptacion where rut='$rut'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraePonderacionesPorPerfil($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * from tbl_sgd_perfiles_ponderaciones where perfil='$perfil'    ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneRespuestaCompetencia($evaluado, $evaluador, $id_pregunta)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_pregunta='$id_pregunta'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneRespuestaCompetenciaProProceso($evaluado, $evaluador, $id_pregunta, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_pregunta='$id_pregunta' and id_proceso='$id_proceso'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneRespuestaCompetenciaObjetivo($evaluado, $evaluador, $id_objetivo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TieneRespuestaCompetenciaObjetivoPorProceso($evaluado, $evaluador, $id_objetivo, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo' and id_proceso='$id_proceso'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function AlternativasDadoIdGrupo($id_grupo_alternativa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT * from tbl_sgd_alternativas


     where id_grupo_alternativa='$id_grupo_alternativa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntasDadaCompetencia($id_competencia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     SELECT * from tbl_sgd_preguntas


     where id_competencia='$id_competencia'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoDimension($dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     select * from tbl_sgd_componente where id_dimension='$dimension'










     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfil2($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     SELECT


     rel_sgd_perfil_competencias.*, tbl_sgd_componente.nombre AS nombre_componente, tbl_sgd_componente.descripcion AS descripcion_componente,


     tbl_sgd_componente.id_dimension,


     (select avg(puntaje) as nota_competncia from tbl_sgd_respuestas where tbl_sgd_respuestas.id_competencia=tbl_sgd_componente.id and evaluado='$evaluado' and evaluador='$evaluador') as nota_promedio


FROM


     rel_sgd_perfil_competencias


INNER JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id


WHERE


     perfil_evaluacion = '$perfil' order by tbl_sgd_componente.id_dimension










     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CompetenciasDadoPerfil($perfil, $evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     SELECT


     rel_sgd_perfil_competencias.*,
     tbl_sgd_componente.nombre AS nombre_componente,
     tbl_sgd_componente.descripcion AS descripcion_componente,
     tbl_sgd_componente.id AS id_competencia,
     tbl_sgd_componente.muestra_preguntas_informe,
     tbl_sgd_componente.id_dimension,
     tbl_sgd_componente.sigla,




     (select avg(puntaje) as nota_competncia from tbl_sgd_respuestas where tbl_sgd_respuestas.id_competencia=tbl_sgd_componente.id and evaluado='$evaluado' and evaluador='$evaluador') as nota_promedio


FROM


     rel_sgd_perfil_competencias


INNER JOIN tbl_sgd_componente ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_componente.id


WHERE


     perfil_evaluacion = '$perfil'
order by tbl_sgd_componente.orden asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeMatrizCompPregAlter($perfil)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     SELECT


     rel_sgd_perfil_competencias.perfil_evaluacion,


     tbl_sgd_componente.nombre as nombre_competencia,


     tbl_sgd_preguntas.pregunta as nombre_pregunta,


     tbl_sgd_alternativas.alternativa


FROM


     tbl_sgd_preguntas


INNER JOIN tbl_sgd_alternativas ON tbl_sgd_alternativas.id_grupo_alternativa = tbl_sgd_preguntas.id_alternativa


INNER JOIN tbl_sgd_componente ON tbl_sgd_componente.id = tbl_sgd_preguntas.id_competencia


INNER JOIN rel_sgd_perfil_competencias ON rel_sgd_perfil_competencias.id_componente = tbl_sgd_preguntas.id_competencia


WHERE


     rel_sgd_perfil_competencias.perfil_evaluacion = '$perfil' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRegistroFinalizadoRevisionJefeObjf($evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_ajustes_jefe(evaluado, evaluador, fecha, hora) " . "VALUES ('$evaluado', '$evaluador',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaSiObjetivosEstanValidadosDadoEvaluador($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
 select * from tbl_objetivos_validaciones
 where evaluador='$evaluador' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanValidados($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objetivos_validaciones


     where evaluado='$evaluado'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanAjustadosEvaluador($evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objetivos_ajustes_jefe


     where evaluador='$evaluador'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaSiObjetivosEstanAjustados($evaluado)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objetivos_ajustes_jefe


     where evaluado='$evaluado'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorSinAe($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_relaciones where evaluador='$rut'  and evaluado<>evaluador


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorSinAeYValidador($evaluador, $validador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_sgd_relaciones where evaluador='$evaluador' and validador='$validador'  and evaluado<>evaluador


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluador($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select
     evaluado as rut,
     evaluador,
     perfil_evaluacion_competencias as perfil_evaluacion
     from tbl_sgd_relaciones where evaluador='$rut'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorSinMiPerfil($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut'
and tbl_sgd_relaciones.evaluado <> tbl_sgd_relaciones.evaluador
order by nombre_completo asc
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProceso($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut'
     order by nombre_completo asc




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeEvaluadosDadoEvaluadorPorProcesoSinAe($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK_SGD = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador, perfil_evaluacion, id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut' and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     order by nombre_completo asc
     ";
    $sql       = "
     SELECT
     evaluado AS rut,
     tbl_sgd_relaciones.evaluador,
     nombre_completo,
     tbl_sgd_relaciones.perfil_evaluacion_competencias as perfil_evaluacion,
     id_proceso
FROM
     tbl_sgd_relaciones
INNER JOIN tbl_usuario ON tbl_usuario.rut = evaluado
WHERE
     tbl_sgd_relaciones.evaluador = '$rut'
     and tbl_sgd_relaciones.evaluado<>tbl_sgd_relaciones.evaluador
     and (
     tbl_usuario.perfil_evaluacion='' or
     tbl_usuario.perfil_evaluacion is null or
     tbl_usuario.perfil_evaluacion='SI')




     order by nombre_completo asc




     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaFinalizadoObjetivosIndividuales($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "
     select * from tbl_objetivos_indviduales_finalizado
     where evaluado='$rut'
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarobjetivoIndividualFinalizado($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_indviduales_finalizado(evaluado, fecha, hora) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function SumaPonderacionesPorRut($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select sum(ponderacion) as suma_ponderaciones from tbl_objetivos_individuales


     where rut='$rut'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaObjetivosIndividuales($id_objetivo, $rut, $dimension, $objetivo, $metrica, $mes, $ano, $ponderacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_objetivos_individuales set dimension='$dimension', descripcion_objetivo='$objetivo',  metrica='$metrica', mes='$mes', ano='$ano', ponderacion='$ponderacion'  where rut='$rut' and id='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeDatosParaSemaforo($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select tbl_usuario.rut,
tbl_objetivos_empresa_finalizado.rut as dato_empresa_finalizado,
tbl_objetivos_area_finalizado.rut as dato_area_finalizado,
tbl_objetivos_indviduales_finalizado.evaluado as dato_individual_finalizado,
tbl_objetivos_ajustes_jefe.evaluado as dato_ajuste_jefatura,
tbl_objetivos_aceptacion.fecha as dato_aceptacion_usuario,
tbl_objetivos_aceptacion_competencias.fecha as dato_aceptacion_competencias,
tbl_sgd_finalizados_evaluado_evaluador.fecha as dato_ev_intermedia,
tbl_objetivos_validaciones.fecha as dato_validacion_validador
from tbl_usuario
left join tbl_objetivos_empresa_finalizado on tbl_objetivos_empresa_finalizado.rut=tbl_usuario.rut
left join tbl_objetivos_area_finalizado on tbl_objetivos_area_finalizado.rut=tbl_usuario.rut
left join tbl_objetivos_indviduales_finalizado on tbl_objetivos_indviduales_finalizado.evaluado=tbl_usuario.rut
left join tbl_objetivos_ajustes_jefe on tbl_objetivos_ajustes_jefe.evaluado=tbl_usuario.rut
left join tbl_objetivos_aceptacion on tbl_objetivos_aceptacion.rut=tbl_usuario.rut
left join tbl_objetivos_aceptacion_competencias on tbl_objetivos_aceptacion_competencias.rut=tbl_usuario.rut
left join tbl_sgd_finalizados_evaluado_evaluador on tbl_sgd_finalizados_evaluado_evaluador.evaluado=.tbl_usuario.rut
left join tbl_objetivos_validaciones on tbl_objetivos_validaciones.evaluado=tbl_usuario.rut
where tbl_usuario.rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaObjetivoIndividual($rut, $dimension, $objetivo, $metrica, $mes, $ano, $ponderacion)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_individuales(rut, dimension, descripcion_objetivo, metrica, mes, ano, fecha, hora, ponderacion, id_empresa) " . "VALUES ('$rut', '$dimension', '$objetivo', '$metrica', '$mes', '$ano', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$ponderacion', '" . $_SESSION["id_empresa"] . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeObjetivosIndividualesDadoIdObjetivo($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select tbl_objetivos_individuales.*, tbl_objetivos_dimension.nombre as nombre_dimension
from tbl_objetivos_individuales
inner join tbl_objetivos_dimension
on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension
where tbl_objetivos_individuales.id='$id'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeObjetivosIndividualesDadoRut($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_objetivos_individuales.*, tbl_objetivos_dimension.nombre as nombre_dimension
from tbl_objetivos_individuales
inner join tbl_objetivos_dimension on tbl_objetivos_dimension.id=tbl_objetivos_individuales.dimension
where rut='$rut' order by tbl_objetivos_individuales.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SelectDistValorPorEmpresa($campo, $tabla, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select distinct($campo) as dato from $tabla where id_empresa='$id_empresa' and $campo<>''";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function SelectDistValor($campo, $tabla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select distinct($campo) as dato from $tabla";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValorSelectDistinctDinaico2PorEmpresa($tabla, $campo_mostrar, $campo_valor, $order, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select $campo_valor as id, $campo_mostrar as nombre from $tabla  where id_empresa='$id_empresa' $order";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValorSelectDinaico2PorEmpresa($tabla, $campo_mostrar, $campo_valor, $order, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select $campo_valor as id, $campo_mostrar as nombre from $tabla


     where id_empresa='$id_empresa' $order";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValorSelectDinaico2($tabla, $campo_mostrar, $campo_valor, $order)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select $campo_valor as id, $campo_mostrar as nombre from $tabla $order";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValorSelectDinaico($tabla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from $tabla";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ValorSelectDinaicoPorEmpresa($tabla, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from $tabla where id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRevisionObjetivoArea($rut, $id_empresa, $id_area)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_area_finalizado(rut, id_empresa, id_area) " . "VALUES ('$rut', '$id_empresa', '$id_area');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaFinalizadoObjetivosArea($rut, $id_area)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_area_finalizado where rut='" . $rut . "'  and id_area=" . $id_area . "";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosObjetivosAreaConNota($id_area, $id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT


     tbl_objetivos_area.*, (select nota from tbl_sgd_notas_area where tbl_sgd_notas_area.id_objetivo=tbl_objetivos_area.id and tbl_sgd_notas_area.id_proceso='$id_proceso' ORDER BY tbl_sgd_notas_area.fecha DESC limit 1) as nota


FROM


     tbl_objetivos_area


WHERE


     tbl_objetivos_area.id_area = '$id_area'


and tbl_objetivos_area.id_empresa = '$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosObjetivosArea($id_area, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_objetivos_area.*


     from tbl_objetivos_area










     where     tbl_objetivos_area.id_area='" . $id_area . "'


     and     tbl_objetivos_area.id_empresa='" . $id_empresa . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaRevisionObjetivoEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_objetivos_empresa_finalizado(rut, id_empresa) " . "VALUES ('$rut', '$id_empresa');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaObjetivoEmpresa($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_empresa_finalizado where rut='" . $rut . "'  and id_empresa=" . $id_empresa . "";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosDeEmpresaConNota($id_empresa, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT


     tbl_objetivos_empresa.*,


     (select nota from tbl_sgd_notas_empresa where tbl_objetivos_empresa.id=tbl_sgd_notas_empresa.id_objetivo and tbl_sgd_notas_empresa.id_proceso='$id_proceso' order by tbl_sgd_notas_empresa.fecha DESC limit 1) as nota


FROM


     tbl_objetivos_empresa






WHERE


     tbl_objetivos_empresa.id_empresa = '$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetivosDeEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetivos_empresa where id_empresa='" . $id_empresa . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeUsuariosDadoCriterio($campo, $valor, $arreglo_post)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_usuario


     where " . $campo . "='$valor' $filtro






";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtenerCargosDadoIdCurso($id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT










r    el_malla.campo,


r    el_malla.valor as cargo






FROM


     tbl_lms_curso


INNER JOIN rel_nivel_curso ON rel_nivel_curso.id_curso = tbl_lms_curso.id


inner join tbl_nivel on tbl_nivel.id=rel_nivel_curso.id_nivel


inner join tbl_programa on tbl_programa.id=tbl_nivel.id_programa


inner join rel_malla_programa on rel_malla_programa.id_programa=tbl_programa.id


inner join rel_malla on rel_malla.id_malla=rel_malla_programa.id_malla


WHERE


     tbl_lms_curso.id = '$id_curso'






group BY campo, cargo


";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObtengoIdMalla($id_empresa, $id_cargo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from rel_malla where id_empresa='" . $id_empresa . "' and valor='" . $id_cargo . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeSliders($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_slider where id_empresa='$id_empresa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VeProgramaFinalizadoPorMalla($id_malla, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_programas_finalizados where id_malla='$id_malla' and rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaProgramaFinalizado($id_programa, $rut, $id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_programas_finalizados(id_programa, rut, fecha, hora, id_malla) " . "VALUES ('$id_programa', '$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$id_malla');";
    $connexion->query($sql);
    $connexion->execute();
}
function VeProgramaFinalizado($id_programa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_programas_finalizados where id_programa='$id_programa' and rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function totalNavegacionDadoProgramaRut($id_programa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo  from tbl_logs_navegacion






inner join tbl_lms_curso


on tbl_lms_curso.id=tbl_logs_navegacion.id_curso


inner join rel_nivel_curso


on rel_nivel_curso.id_curso=tbl_lms_curso.id


inner join tbl_nivel


on tbl_nivel.id=rel_nivel_curso.id_nivel


where tbl_nivel.id_programa='$id_programa' and tbl_logs_navegacion.rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CantidadCursosPorPrograma($id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_lms_curso.*


     from rel_nivel_curso


     inner join tbl_nivel


     on tbl_nivel.id=rel_nivel_curso.id_nivel


     inner JOIN tbl_lms_curso


     on tbl_lms_curso.id=rel_nivel_curso.id_curso


     where tbl_nivel.id_programa='$id_programa'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DuracionCursosPorPrograma($id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select


     SEC_TO_TIME( SUM( TIME_TO_SEC((


     SELECT


     SEC_TO_TIME(


     SUM(


     TIME_TO_SEC(duracion_video)


     )


     ) AS total_tiempo


     FROM


     tbl_objeto


     WHERE


     tbl_objeto.id_curso = tbl_lms_curso.id


     )


)


)


)    AS total_suma_tiempos_objetos


     from rel_nivel_curso


     inner join tbl_nivel


     on tbl_nivel.id=rel_nivel_curso.id_nivel


     inner JOIN tbl_lms_curso


     on tbl_lms_curso.id=rel_nivel_curso.id_curso


     where tbl_nivel.id_programa='$id_programa'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function CantidadCursosPorProgramaFinalizadosPorUsuario($id_programa, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_lms_curso.*


     from rel_nivel_curso






     inner join tbl_nivel


     on tbl_nivel.id=rel_nivel_curso.id_nivel


     inner JOIN tbl_lms_curso


     on tbl_lms_curso.id=rel_nivel_curso.id_curso






     inner join tbl_lms_curso_finalizados


     on tbl_lms_curso_finalizados.id_curso=tbl_lms_curso.id and tbl_lms_curso_finalizados.rut='$rut'






     where tbl_nivel.id_programa='$id_programa'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaNivelFinalizado($id_nivel, $rut, $id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_nivel_finalizado(rut, id_nivel, id_programa, fecha, hora) " . "VALUES ('$rut', '$id_nivel', '$id_programa',  '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaNivelFinalizadoDadoNivelPrograma($id_programa, $id_nivel, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = " select * from tbl_nivel_finalizado where rut='$rut' and id_nivel='$id_nivel' and id_programa='$id_programa' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PromedioDeEvaluacionesDadoCursoYRut($id_curso, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select ROUND(avg(nota),1) as promedio_nota_curso from tbl_objetos_finalizados






inner join tbl_objeto


on tbl_objeto.id=tbl_objetos_finalizados.id_objeto


where tbl_objetos_finalizados.rut='$rut'


AND tbl_objeto.id_curso='$id_curso' and nota>='0'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntasDadoIdObjetoaleatorio($id_objeto, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT


     tbl_evaluaciones_preguntas.*


FROM


     tbl_evaluaciones_asociacion_preguntas_usuario


inner join tbl_evaluaciones_preguntas


on tbl_evaluaciones_preguntas.id=tbl_evaluaciones_asociacion_preguntas_usuario.id_pregunta






INNER JOIN tbl_objeto
on tbl_evaluaciones_preguntas.evaluacion = tbl_objeto.id_evaluacion
AND tbl_objeto.id_empresa='" . $_SESSION["id_empresa"] . "'
AND tbl_objeto.id='$id_objeto'


WHERE


     tbl_evaluaciones_asociacion_preguntas_usuario.id_objeto ='$id_objeto' and tbl_evaluaciones_asociacion_preguntas_usuario.rut ='$rut'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function PreguntaDeEvaluacionAleatorias($id_evaluacion, $numero, $rut, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_evaluaciones_preguntas.*, tbl_evaluaciones_tipo_preguntas.tipo as tipo_pregunta,


     tbl_evaluaciones_tipo_preguntas.template as template_pregunta


     from


     tbl_evaluaciones_asociacion_preguntas_usuario






     inner join tbl_evaluaciones_preguntas


     on tbl_evaluaciones_preguntas.id=tbl_evaluaciones_asociacion_preguntas_usuario.id_pregunta






     INNER JOIN tbl_evaluaciones_tipo_preguntas


     ON tbl_evaluaciones_tipo_preguntas.id = tbl_evaluaciones_preguntas.tipo






     where tbl_evaluaciones_asociacion_preguntas_usuario.id_evaluacion='$id_evaluacion' and


tbl_evaluaciones_asociacion_preguntas_usuario.id_objeto='$id_objeto'


     and tbl_evaluaciones_asociacion_preguntas_usuario.orden='$numero' and tbl_evaluaciones_asociacion_preguntas_usuario.rut='$rut' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoRegistroPreguntasAleatorias($rut, $id_evaluacion, $id_objeto, $orden, $id_pregunta, $id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluaciones_asociacion_preguntas_usuario(rut, id_evaluacion, id_objeto, id_curso, id_pregunta, orden) " . "VALUES ('$rut', '$id_evaluacion', '$id_objeto', '$id_curso', '$id_pregunta', '$orden');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaSiTienePReguntasAsociadasRandomicas($rut, $id_evaluacion, $id_objeto)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_asociacion_preguntas_usuario


     where rut='$rut' and id_evaluacion='$id_evaluacion' and id_objeto='$id_objeto' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosMalla($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_lms_malla where id='$id'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosObjetoDadoRutCursoyOrden($id_curso, $orden)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto


     where id_curso='$id_curso' and orden='$orden'


     ";
     //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosObjetoDadoIdCurso($id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select * from tbl_objeto


     where id_curso='$id_curso'


     ";
     //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaNavegacionesDadoRutYNivel($rut, $id_nivel)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo  from tbl_logs_navegacion






inner join rel_nivel_curso


on rel_nivel_curso.id_curso=tbl_logs_navegacion.id_curso


where rut='$rut' and rel_nivel_curso.id_nivel='$id_nivel'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaNavegacionesDadoRutYObjeto($rut, $id_objeto, $id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo
     from tbl_logs_navegacion where rut='$rut'
     and id_curso='$id_curso' and id_objeto='$id_objeto'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaNavegacionesDadoRutYCurso($rut, $id_curso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo
     from tbl_logs_navegacion where rut='$rut'
     and id_curso='$id_curso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaNavegacionesDadoRut($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo  from tbl_logs_navegacion where rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ObjetoFinalizadoDadoIdYRut($rut, $id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_objetos_finalizados where rut='$rut' and id_objeto='$id'";
    //    echo "<br>ObjetoFinalizadoDadoIdYRut<br>".$sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaDeNotasObjetosFinalizadosYNivel($rut, $id_nivel)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select avg(tbl_objetos_finalizados.nota) as promedio_notas_finales


     from tbl_objetos_finalizados






     inner join rel_nivel_curso


     on rel_nivel_curso.id_curso=tbl_objetos_finalizados.id_curso






     where rut='$rut' and nota<>'' and rel_nivel_curso.id_nivel='$id_nivel'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function SumaDeNotasObjetosFinalizados($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select avg(nota) as promedio_notas_finales from tbl_objetos_finalizados where rut='$rut' and nota<>''";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ComportamientoDadoDimension($id_dimension)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_comportamientos where id_dimension='$id_dimension' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TotalDimensionesDeCumplimientoDnc()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_dimensiones ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertoRegistroFinalzadoEvalConductas($evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluaciones_conducta_finalizado(evaluado, evaluador, fecha, hora) " . "VALUES ('$evaluado', '$evaluador', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function TraeDebilidadAlternativaEvConducta()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_niveles_debilidad ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNivelesAlternativaEvConducta()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_niveles_alternativas ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaNotaEConducta($evaluado, $evaluador, $nota, $id_objetivo, $numero_conducta, $debilidad)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_evaluaciones_conducta_respuestas set nota_c" . $numero_conducta . "='$nota',  debilidad_c" . $numero_conducta . "='$debilidad' where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertoNotaEvConducta($evaluado, $evaluador, $nota, $id_objetivo, $numero_conducta, $debilidad)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_evaluaciones_conducta_respuestas(evaluado, evaluador, id_objetivo, nota_c" . $numero_conducta . ", debilidad_c" . $numero_conducta . ") " . "VALUES ('$evaluado', '$evaluador', '$id_objetivo', '$nota', '$debilidad');";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneRegistroRespuestaEvConduccta($evaluado, $evaluador, $id_objetivo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_conducta_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_objetivo='$id_objetivo' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EvaluacionFinConducta($evaluado, $evaluador)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluaciones_conducta_finalizado where evaluado='$evaluado' and evaluador='$evaluador' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarClaveNueva($rut, $clave)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_clave(rut, clave, cambiado, fecha) " . "VALUES ('$rut', '$clave', '1', '" . date("Y-m-d") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertarClaveDefecto($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_clave(rut, clave, cambiado, fecha) " . "VALUES ('$rut', '123456', '0', '" . date("Y-m-d") . "');";
    $connexion->execute();
}
function InsertarUsuarioNuevoCargoTblUsuario2($rut, $nombre, $apateno, $amaterno, $cargo, $id_empresa, $jefe, $gerencia, $email)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_usuario(rut, nombre, nombre_completo, apaterno, amaterno, cargo, id_empresa, jefe, gerencia, email) " . "VALUES ('$rut', '$nombre', '$nombre', '$apateno', '$amaterno', '$cargo', '$id_empresa', '$jefe', '$gerencia', '$email');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertarUsuarioNuevoCargoTblUsuario3($rut, $nombre, $apateno, $amaterno, $nombre_completo, $cargo, $id_empresa, $jefe, $gerencia, $email, $imagen)
{
    $connexion = new DatabasePDO();
    
    
    if ($imagen == 'undefined') {
        $sql = "INSERT INTO tbl_usuario(rut, nombre, nombre_completo, apaterno, amaterno, cargo, id_empresa, jefe, gerencia, email) " . "VALUES ('$rut', '$nombre', '$nombre_completo', '$apateno', '$amaterno', '$cargo', '$id_empresa', '$jefe', '$gerencia', '$email');";
    } else {
        $sql = "INSERT INTO tbl_usuario(rut, nombre, nombre_completo, apaterno, amaterno, cargo, id_empresa, jefe, gerencia, email, avatar) " . "VALUES ('$rut', '$nombre', '$nombre_completo', '$apateno', '$amaterno', '$cargo', '$id_empresa', '$jefe', '$gerencia', '$email', '$imagen');";
    }
    $connexion->query($sql);
    $connexion->execute();
}
function UpdateUsuarioNuevoCargoBci($rut, $id_empresa, $imagenUrl)
{
    $connexion = new DatabasePDO();
   if ($imagenUrl == 'undefined') {
    } else {
        $sql = "UPDATE tbl_usuario set avatar='$imagenUrl' where rut='$rut' and id_empresa='$id_empresa';";
    }
    $connexion->query($sql);
    $connexion->execute();
}
function InsertarUsuarioNuevoCargoTblUsuario($cargo, $jefe)
{
    $connexion = new DatabasePDO();
    $rut_aleatorio = $prefijo = substr(md5(uniqid(rand())), 0, 6);
    $sql = "INSERT INTO tbl_usuario(rut, nombre, apaterno, amaterno, cargo, id_empresa, jefe) " . "VALUES ('$rut_aleatorio', '$cargo', '$cargo', '$cargo', '$cargo', '4', '$jefe');";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaLogSistema($rut, $ambiente, $id_empresa, $id_detalle, $subcategoria, $id_archivo, $nivel, $id_menu_nivel)
{
    $connexion = new DatabasePDO();
    
    
    if($ambiente=="sdriesgo_TEsT_"){
        $sql = "INSERT INTO tbl_log_sistema(rut, ambiente, fecha, hora, ip, id_empresa, id_detalle, subcategoria, id_archivo, menu_nivel, id_menu_nivel, variables_post, variables_get) " . "VALUES ('$rut','$ambiente', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "', '$id_empresa', '$id_detalle', '$subcategoria', '$id_archivo', '$nivel', '$id_menu_nivel', '" . ($_POST["value"]) . "', '" . json_encode($_GET) . "');";
        $connexion->query($sql);
        $connexion->execute();

        $sql = "INSERT INTO tbl_json_ext(rut, fecha, hora, json_completo) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . ($_POST["value"]) . "');";
        $connexion->query($sql);
        $connexion->execute();


    }else if($ambiente=="sdriesgo"){
        $sql = "INSERT INTO tbl_log_sistema(rut, ambiente, fecha, hora, ip, id_empresa, id_detalle, subcategoria, id_archivo, menu_nivel, id_menu_nivel, variables_post, variables_get) " . "VALUES ('$rut','$ambiente', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "', '$id_empresa', '$id_detalle', '$subcategoria', '$id_archivo', '$nivel', '$id_menu_nivel', '" . ($_POST["value"]) . "', '" . json_encode($_GET) . "');";
        $connexion->query($sql);
        $connexion->execute();
        $sql = "INSERT INTO tbl_json_ext(rut, fecha, hora, json_completo) " . "VALUES ('$rut', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . ($_POST["value"]) . "');";
        $connexion->query($sql);
        $connexion->execute();

    }else{
        $sql = "INSERT INTO tbl_log_sistema(rut, ambiente, fecha, hora, ip, id_empresa, id_detalle, subcategoria, id_archivo, menu_nivel, id_menu_nivel, variables_post, variables_get) " . "VALUES ('$rut','$ambiente', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "', '$id_empresa', '$id_detalle', '$subcategoria', '$id_archivo', '$nivel', '$id_menu_nivel', '" . json_encode($_POST) . "', '" . json_encode($_GET) . "');";
        $connexion->query($sql);
        $connexion->execute();
    }
}
function InsertaComentarioFormulario($nombre, $email, $comentario)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_formulario_contacto(nombre, email, comentario, fecha, hora) " . "VALUES ('$nombre','$email', '$comentario', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function EliminarObjetivo($id)
{
    $connexion = new DatabasePDO();
    if (!isset($pagina)) {
        $pagina = 1;
    }
    
    
    $sql = sprintf("DELETE from tbl_dnc_objetivos WHERE id='" . $id . "'");
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizarObjetivoDNC($objetivo, $conducta1, $conducta2, $conducta3, $id_objetivo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "update tbl_dnc_objetivos set objetivo='$objetivo', conducta1='$conducta1', conducta2='$conducta2', conducta3='$conducta3' where id='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "update tbl_dnc_objetivos_log_jefatura set objetivo='$objetivo', conducta1='$conducta1', conducta2='$conducta2', conducta3='$conducta3' where id='$id_objetivo';";
    $connexion->query($sql);
    $connexion->execute();
}
function ListadoCargosFinalizadosPorJefe($rut)
{
    $connexion = new DatabasePDO();
    $sql = " select * from tbl_dnc_objetivos_finalizado where jefe='$rut' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertaFinalizadoObjetivoDnc($cargo, $jefe)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_dnc_objetivos_finalizado(jefe, cargo, fecha, hora) " . "VALUES ('$jefe', '$cargo', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function DatosObjetivoDncDadoId($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos where id='$id' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosObjetivoDncDadoJefe($jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos where jefe='$jefe' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoObjetivosDncDadoCargo($cargo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos where cargo='$cargo'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoObjetivosDnc2($jefe, $cargo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos where jefe='$jefe' and cargo='$cargo'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarObjetivoDnc($objetivo, $conducta1, $conducta2, $conducta3, $cargo, $jefe)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_dnc_objetivos(jefe, cargo, objetivo, conducta1, conducta2, conducta3, fecha, hora) " . "VALUES ('$jefe', '$cargo' , '$objetivo', '$conducta1', '$conducta2', '$conducta3', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
    $sql = "INSERT INTO tbl_dnc_objetivos_log_jefatura(jefe, cargo, objetivo, conducta1, conducta2, conducta3, fecha, hora) " . "VALUES ('$jefe', '$cargo', '$objetivo', '$conducta1', '$conducta2', '$conducta3', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function VerificaDNCFinalizado($jefe, $cargo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_dnc_objetivos_finalizado where jefe='$jefe' and cargo='$cargo'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizaCargoDadoJefe($nuevo_cargo, $rutjefe, $cargo_antiguo)
{
    $connexion = new DatabasePDO();
    $sql = "update tbl_usuario set cargo='$nuevo_cargo' where jefe='$rutjefe' and cargo='$cargo_antiguo';";
    $connexion->query($sql);
    $connexion->execute();
}
function PruebaActualiza($valor)
{
    $connexion = new DatabasePDO();
    $sql = "update ingreso_db set valor='$valor';  ";
    $connexion->query($sql);
    $connexion->execute();
}
function ListadoCargosDistinct($rut)
{
    $connexion = new DatabasePDO();
    $sql = " select distinct(cargo), count(*) as numero_colaboradores from tbl_usuario where jefe='$rut' group BY cargo ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarLike($voto, $user, $id_noticia)
{
    $connexion = new DatabasePDO();
    $fecha = date('Y-m-d H:i:s');
    $sql   = "INSERT INTO $voto (id_noticia, user, fecha) " . "VALUES ('$id_noticia', '$user', '$fecha');";
    $connexion->query($sql);
    $connexion->execute();
}
function ExisteVoto($voto, $user, $id_noticia)
{
    $connexion = new DatabasePDO();
    $sql = "select * from $voto WHERE user = '$user' and id_noticia= '$id_noticia'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function TraerVotos($voto, $id_noticia)
{
    $connexion = new DatabasePDO();
    $sql = "select * from $voto WHERE  id_noticia= '$id_noticia'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function NoticiaPorId($id)
{
    $connexion = new DatabasePDO();
    $sql = "select * from tbl_noticias where id='" . $id . "'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function NoticiaPorIdConVistas($id, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select
     tbl_noticias.*,
     (select count(*) as total from tbl_noticias_log where tbl_noticias_log.id_empresa='$id_empresa'
     and tbl_noticias_log.id_noticia='$id') as total_visitas,
     tbl_noticias_categorias.categoria as nombre_categoria,
     tbl_empresa.ve_comentarios
     from
     tbl_noticias
     inner join tbl_noticias_categorias on tbl_noticias_categorias.id = tbl_noticias.categoria
     inner join tbl_empresa on tbl_empresa.id=tbl_noticias.id_empresa
     where tbl_noticias.id='" . $id . "'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function NoticiaPorIdConVistasPorCategoria($id_categoria, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = " select tbl_noticias.*, 
            (SELECT count(*) AS total FROM tbl_noticias_log WHERE tbl_noticias_log.id_empresa = '$id_empresa' AND tbl_noticias_log.id_noticia = tbl_noticias.id) AS total_visitas,
            tbl_noticias_categorias.categoria AS nombre_categoria
            FROM tbl_noticias
            INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria
            WHERE tbl_noticias.categoria = '$id_categoria' and tbl_noticias.id_empresa='$id_empresa' limit 3 ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticias($id_empresa, $pagina, $cantidad_por_pagina)
{
    $connexion = new DatabasePDO();
    if (!$pagina) {
        $limit = " limit 0, $cantidad_por_pagina";
    } else {
        $inicio = ($pagina - 1) * $cantidad_por_pagina;
        $limit  = " limit $inicio, $cantidad_por_pagina";
    }
    if ($id_empresa == 22) {
        $datos_usuario_session = UsuarioEnBasePersonas($_SESSION["user_"], $rutcontodo);
        if ($datos_usuario_session[0]->unidad_negocio == "Sucursales") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='2')";
        } else if ($datos_usuario_session[0]->unidad_negocio == "Santiago") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='1')";
        }
    }
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE
     tbl_noticias.estado = '1' and
     tbl_noticias.id_empresa ='$id_empresa'
     $filtro_mundo
order by orden is  null, orden asc, fecha_creacion desc $limit";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasBKBKBK($id_empresa, $pagina, $cantidad_por_pagina)
{
    $connexion = new DatabasePDO();

    if (!$pagina) {
        $limit = " limit 0, $cantidad_por_pagina";
    } else {
        $inicio = ($pagina - 1) * $cantidad_por_pagina;
        $limit  = " limit $inicio, $cantidad_por_pagina";
    }
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa'
     order by tbl_noticias.fecha_creacion
     desc , tbl_noticias.id desc limit 0, $cantidad_por_pagina";
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa'
     order by tbl_noticias.fecha_creacion
     desc , tbl_noticias.id desc $limit";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasTodas($id_empresa, $id_categoria)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_categoria) {
        $filtro_Categoria = " and tbl_noticias.categoria='$id_categoria'";
    }
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa' $filtro_Categoria
     order by tbl_noticias.fecha_creacion
     desc , tbl_noticias.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasTodasBKBK($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa'
     order by tbl_noticias.fecha_creacion
     desc , tbl_noticias.id desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPorCategoriaTodas($id_empresa, $id_categoria, $pagina, $cantidad_por_pagina)
{
    $connexion = new DatabasePDO();
    
    
    if (!$pagina) {
        $limit = " limit 0, $cantidad_por_pagina";
    } else {
        $inicio = ($pagina - 1) * $cantidad_por_pagina;
        $limit  = " limit $inicio, $cantidad_por_pagina";
    }
    if ($id_empresa == 22) {
        $datos_usuario_session = UsuarioEnBasePersonas($_SESSION["user_"], $rutcontodo);
        if ($datos_usuario_session[0]->unidad_negocio == "Sucursales") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='2')";
        } else if ($datos_usuario_session[0]->unidad_negocio == "Santiago") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='1')";
        }
    }
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1'
     and tbl_noticias.id_empresa ='$id_empresa'
     and tbl_noticias.categoria='$id_categoria'


     $filtro_mundo


     order by orden is  null, orden asc, fecha_creacion desc $limit";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPorCategoriaTodasBK($id_empresa, $id_categoria)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa' and tbl_noticias.categoria='$id_categoria' order by tbl_noticias.fecha_Creacion desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPorCategoria($id_empresa, $id_categoria)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
     from tbl_noticias
     inner join tbl_noticias_categorias
     on tbl_noticias_categorias.id=tbl_noticias.categoria
     WHERE tbl_noticias.estado = '1' and tbl_noticias.id_empresa ='$id_empresa' and tbl_noticias.categoria='$id_categoria' order by tbl_noticias.fecha_Creacion desc limit 0, 6";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPrincipales($id_empresa, $variable, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_empresa == 22) {
        $datos_usuario_session = UsuarioEnBasePersonas($_SESSION["user_"], $rutcontodo);
        if ($datos_usuario_session[0]->unidad_negocio == "Sucursales") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='2')";
        } else if ($datos_usuario_session[0]->unidad_negocio == "Santiago") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='1')";
        }
    }
    if ($limit) {
        $limit = " LIMIT 0, $limit";
    } else {
        $limit = " ";
    }
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria, tbl_noticias_principales.prioridad, tbl_noticias_principales.id as id_noticia_principal
FROM
     tbl_noticias
inner JOIN tbl_noticias_principales
on tbl_noticias_principales.idnoticia=tbl_noticias.id
inner join tbl_noticias_categorias
on tbl_noticias_categorias.id=tbl_noticias.categoria
WHERE
     estado = '1' and
     tbl_noticias.id_empresa='$id_empresa' and
     tbl_noticias_principales.idempresa is not NULL
     and slider_activo=0
     and tbl_noticias.id_mundo='0' $filtro_mundo
order BY
     prioridad asc
$limit
     ";
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria AS nombre_categoria
FROM
     tbl_noticias
INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria
WHERE
     estado = '1'AND
     tbl_noticias.id_empresa = '$id_empresa' AND
     tbl_noticias.principal >0
     $filtro_mundo






     order by orden is  null, orden asc, fecha_creacion desc
     $limit
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPrincipalesBK($id_empresa, $variable, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = " LIMIT 0, $limit";
    } else {
        $limit = " ";
    }
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria, tbl_noticias_principales.prioridad, tbl_noticias_principales.id as id_noticia_principal
FROM
     tbl_noticias
inner JOIN tbl_noticias_principales
on tbl_noticias_principales.idnoticia=tbl_noticias.id
inner join tbl_noticias_categorias
on tbl_noticias_categorias.id=tbl_noticias.categoria
WHERE
     estado = '1' and
     tbl_noticias.id_empresa='$id_empresa' and
     tbl_noticias_principales.idempresa is not NULL
     and slider_activo=0
order BY
     prioridad asc
$limit
     ";
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria AS nombre_categoria
FROM
     tbl_noticias
INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria
WHERE
     estado = '1'AND
     tbl_noticias.id_empresa = '$id_empresa' AND
     tbl_noticias.principal >0




order BY
     tbl_noticias.fecha_creacion DESC
     $limit
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPrincipalesCom($id_empresa, $variable, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($limit) {
        $limit = " LIMIT 0, $limit";
    } else {
        $limit = " ";
    }
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria, tbl_noticias_principales.prioridad, tbl_noticias_principales.id as id_noticia_principal
FROM
     tbl_noticias
inner JOIN tbl_noticias_principales
on tbl_noticias_principales.idnoticia=tbl_noticias.id
inner join tbl_noticias_categorias
on tbl_noticias_categorias.id=tbl_noticias.categoria
WHERE
     estado = '1' and tbl_noticias.id_empresa='$id_empresa' and tbl_noticias_principales.idempresa is not NULL and slider_activo=0
order BY
     prioridad asc
$limit
     ";
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria AS nombre_categoria
FROM
     tbl_noticias
INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria
WHERE
     tbl_noticias.estado = '1' and tbl_noticias.categoria = '39' and tbl_noticias.principal ='0'
and tbl_noticias.id_empresa = '$id_empresa'


order BY
     tbl_noticias.fecha_creacion DESC limit 3
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPrincipalesPorComunidad($id_empresa, $id_comunidad)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_comunidad) {
        $variable = " and id_comunidad='$id_comunidad'";
    } else {
        $variable = "";
    }
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
FROM
     tbl_noticias
inner join tbl_noticias_categorias
on tbl_noticias_categorias.id=tbl_noticias.categoria
WHERE
     estado = '1' and tbl_noticias.id_empresa='$id_empresa' $variable
limit 0,
     6
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasPrincipalesPorGerencia($id_empresa, $variable)
{
    $connexion = new DatabasePDO();
    
    
    if ($variable) {
        $variable = " and gerencia='$variable'";
    } else {
        $variable = "";
    }
    $sql = "
     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria as nombre_categoria
FROM
     tbl_noticias
inner join tbl_noticias_categorias
on tbl_noticias_categorias.id=tbl_noticias.categoria
WHERE
     estado = '1' and tbl_noticias.id_empresa='$id_empresa' $variable
limit 0,
     6
     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasSecundarias($id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    if ($id_empresa == 22) {
        $datos_usuario_session = UsuarioEnBasePersonas($_SESSION["user_"], $rutcontodo);
        if ($datos_usuario_session[0]->unidad_negocio == "Sucursales") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='2')";
        } else if ($datos_usuario_session[0]->unidad_negocio == "Santiago") {
            $filtro_mundo = "and (tbl_noticias.id_mundo='0' or tbl_noticias.id_mundo='1')";
        }
    }
    $sql = "


     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria AS nombre_categoria
    FROM
     tbl_noticias
INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria




WHERE
     estado = '1'
AND tbl_noticias.id_empresa = '$id_empresa' and
tbl_noticias.principal=0 and
slider_activo=0


$filtro_mundo
order by orden is  null, orden asc, fecha_creacion desc


$limit


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasSecundariasBK($id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     SELECT
     tbl_noticias.*, tbl_noticias_categorias.categoria AS nombre_categoria
FROM
     tbl_noticias
INNER JOIN tbl_noticias_categorias ON tbl_noticias_categorias.id = tbl_noticias.categoria




WHERE
     estado = '1'
and tbl_noticias.id_empresa = '$id_empresa' and
tbl_noticias.principal=0 and
lider_activo=0
order BY
     fecha_Creacion DESC


$limit






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeNoticiasMiniSlider($id_empresa, $limit)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select *
     from tbl_noticiasminislider


     WHERE
     id_empresa ='$id_empresa'


     order by orden is  null, orden asc, fecha desc $limit";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TodosComentarios($id_noticia)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_noticias_comentarios WHERE estado = '1' AND id_noticia = '$id_noticia' order by fecha desc";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarComentario($id_noticia, $usuario, $comentario, $fecha)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_noticias_comentarios(id_noticia, id_usuario, comentario, fecha) " . "VALUES ('$id_noticia', '$usuario', '$comentario', '$fecha');";
    $connexion->query($sql);
    $connexion->execute();
}
function ObjetosDadoCursoCruceNota($id_curso, $rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "SELECT tbl_objeto.*, tbl_tipo_objeto.nombre AS tipo_objeto,
 tbl_tipo_objeto.icono,
 tbl_tipo_objeto.ambiente,
 (select SEC_TO_TIME( SUM( TIME_TO_SEC( tiempo_navegacion ) ) ) as total_tiempo  from tbl_logs_navegacion where tbl_logs_navegacion.id_objeto=tbl_objeto.id and tbl_logs_navegacion.rut='$rut') as total_tiempo,
 tbl_objetos_finalizados.nota as nota_objeto
 FROM tbl_objeto
INNER JOIN tbl_tipo_objeto ON tbl_tipo_objeto.id = tbl_objeto.tipo_objeto
left join
tbl_objetos_finalizados
on tbl_objetos_finalizados.id_objeto=tbl_objeto.id and tbl_objetos_finalizados.rut='$rut'


WHERE
     tbl_objeto.id_curso = '$id_curso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ActualizoComentarioEvaluacionJefatura($evaluado, $evaluador, $id_programa, $comentario)
{
    $connexion = new DatabasePDO();
    $sql = " UPDATE tbl_evaluacion_jefe_respuestas
    SET comentario= '" . $comentario . "',
    fecha='" . date("Y-m-d") . "',
    hora='" . date("H:i:s") . "'
    where evaluado='$evaluado'
    and evaluador='$evaluador'
    and id_programa='$id_programa'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaComentarioEvaluacionJefe($evaluado, $evaluador, $id_programa, $comentario)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_evaluacion_jefe_comentario(evaluado, evaluador, id_programa, fecha, hora, comentario) " . "VALUES ('$evaluado', '$evaluador', '$id_programa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$comentario');";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneComentarioEvaluacionJefe($evaluado, $evaluador, $id_programa)
{
    $connexion = new DatabasePDO();
    $sql = " select * from tbl_evaluacion_jefe_comentario where evaluado='$evaluado' and evaluador='$evaluador' and id_programa='$id_programa' ";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function TieneRespuestasEvaluacionJefeCrucePRogramas($evaluado, $evaluador, $id_programa)
{
    $connexion = new DatabasePDO();
    $sql = "select tbl_evaluacion_jefe_respuestas.*, tbl_conductas.nombre as nombre_conducta, tbl_conductas.requerido
    from tbl_evaluacion_jefe_respuestas
    inner join tbl_programa on tbl_programa.id=tbl_evaluacion_jefe_respuestas.id_programa
    inner join tbl_conductas on tbl_conductas.id=tbl_evaluacion_jefe_respuestas.id_conducta
    where evaluado='$evaluado' and evaluador='$evaluador'  and tbl_evaluacion_jefe_respuestas.id_programa='$id_programa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaFinalizadoEvaluacionJefe($evaluado, $evaluador, $id_programa)
{
    $connexion = new DatabasePDO();
    $sql = "select * from tbl_evaluacion_jefe_finalizados where evaluado='$evaluado' and evaluador='$evaluador' and id_programa='$id_programa'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function InsertarFinalizadoEvaluacionJefatura($evaluado, $evaluador, $id_programa)
{
    $connexion = new DatabasePDO();
    $sql = "INSERT INTO tbl_evaluacion_jefe_finalizados(evaluado, evaluador, id_programa, fecha, hora) " . "VALUES ('$evaluado', '$evaluador', '$id_programa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "');";
    $connexion->query($sql);
    $connexion->execute();
}
function ActualizaRespuestasEvaluacionJefe($evaluado, $evaluador, $id_conducta, $id_programa, $alternativa, $debilidad)
{
    $connexion = new DatabasePDO();

    $sql = " UPDATE tbl_evaluacion_jefe_respuestas SET respuesta= '" . $alternativa . "', debilidad='" . $debilidad . "',
    fecha='" . date("Y-m-d") . "',
    hora='" . date("H:i:s") . "'
    where evaluado='$evaluado'
    and evaluador='$evaluador'
    and id_programa='$id_programa'
    and id_conducta='$id_conducta'";
    $connexion->query($sql);
    $connexion->execute();
}
function InsertaRegistroEvaluacionJefe($evaluado, $evaluador, $id_conducta, $id_programa, $alternativa, $debilidad)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "INSERT INTO tbl_evaluacion_jefe_respuestas(evaluado, evaluador, id_conducta, id_programa, respuesta, fecha, hora, debilidad) " . "VALUES ('$evaluado', '$evaluador', '$id_conducta', '$id_programa', '$alternativa', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '$debilidad');";
    $connexion->query($sql);
    $connexion->execute();
}
function TieneRespuestasEvaluacionJefe($evaluado, $evaluador, $id_conducta, $id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluacion_jefe_respuestas where evaluado='$evaluado' and evaluador='$evaluador' and id_conducta='$id_conducta' and id_programa='$id_programa'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function AlternativasDadoIdPrograma($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluacion_jefe_alternativas where id_grupo_alternativas='$id'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ProgramasDadoMallaTraeEvaluacionesJefe($id_malla)
{
    $connexion = new DatabasePDO();
    
    
    $sqlBK = "


     select tbl_programa.*, tbl_evaluacion_jefe.nombre as nombre_evaluacion


     from rel_malla_programa


     inner join tbl_programa


     on tbl_programa.id=rel_malla_programa.id_programa


     inner join tbl_evaluacion_jefe


     on tbl_evaluacion_jefe.id_programa=tbl_programa.id


     where rel_malla_programa.id_malla='$id_malla'


     ";
    $sql   = "


     select tbl_programa.*


from tbl_programa


INNER JOIN tbl_conductas


on tbl_conductas.id_programa=tbl_programa.id


inner join rel_malla_programa


on rel_malla_programa.id_programa=tbl_programa.id


where rel_malla_programa.id_malla='$id_malla'


group BY tbl_programa.id


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ConductasParaEvaluacionJefePorMalla($malla)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_evaluacion_jefe_conducta_habilidad where id_malla='$malla' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function ListadoUsuariosLideres($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select


     tbl_usuario.*,


     (select count(*) from tbl_usuario as aux where aux.jefe=tbl_usuario.rut) as total,
     base_jefe.nombre_completo as nombre_jefe,
     base_jefe.rut_completo as rut_jefe


     from tbl_usuario


     left join tbl_usuario as base_jefe
     on base_jefe.rut=tbl_usuario.jefe


     where tbl_usuario.jefe='$rut'






";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function EsJefe($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select


     tbl_usuario.*,


     (select count(*) from tbl_usuario as aux where aux.jefe=tbl_usuario.rut) as total,
     base_jefe.nombre_completo as nombre_jefe,
     base_jefe.rut_completo as rut_jefe


     from tbl_usuario


     left join tbl_usuario as base_jefe
     on base_jefe.rut=tbl_usuario.jefe


     where tbl_usuario.jefe='$rut'


     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_empresa
     where id='$id_empresa' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosPrograma($id)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_programa where id='$id'";
    //echo "$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function NivelesDadoPrograma($id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_nivel.*, tbl_usuario.nombre_completo


     from tbl_nivel


     left join tbl_usuario


     on tbl_usuario.rut=tbl_nivel.tutor


     where tbl_nivel.id_programa='" . $id_programa . "' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function NotaAprobacionDadoMallaPrograma($id_malla, $id_programa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "






     select * from rel_malla_programa where id_malla='$id_malla' and id_programa='$id_programa'






     ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaClaveAcceso($rut, $clave)
{
    $connexion = new DatabasePDO();
    $clave    = ($clave);
    
    
    $sql = "select * from tbl_clave where rut='" . mysql_real_escape_string($rut) . "' and clave='" . mysql_real_escape_string($clave) . "'";
    $sql = "select * from tbl_clave where rut='" . $rut . "' and clave='" . $clave . "'";
    //echo $sql;
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    if ($cod[0]->id == "") {
        $existe_base      = UsuarioEnBasePersonas($rut, $rutcontodo);
        $NoCambiaClaveArr = VerificaNoCambiaClaveAccesoObligatorio($existe_base[0]->id_empresa);
        $NoCambiaClave    = $NoCambiaClaveArr[0]->nocambiaclaveobligatorio;
        if ($NoCambiaClave <> 1) {
            $obligatorio = 0;
        } else {
            $obligatorio = 1;
        }
        $rutcuatroprimeros = substr($rut, 0, 4);
        $sql               = "INSERT INTO tbl_clave(rut, clave, cambiado, fecha, id_empresa) " . "VALUES ('$rut', '$rutcuatroprimeros', '$obligatorio', '" . date("Y-m-d") . "', '" . $existe_base[0]->id_empresa . "');";
        $connexion->query($sql);
        $connexion->execute();
        $sql = "select * from tbl_clave where rut='" . mysql_real_escape_string($rut) . "' and clave='" . mysql_real_escape_string($clave) . "'";
        $sql = "select * from tbl_clave where rut='" . $rut . "' and clave='" . $clave . "'";
        $connexion->query($sql);
        
        $cod = $connexion->resultset();
    }
    return $cod;
}
function VerificaClaveAccesoSoloRut($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_clave where rut='" . mysql_real_escape_string($rut) . "' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBasePersonas($rut, $rut_contodo)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_usuario where rut='" . $rut . "'   and '" . $rut . "'<>'' and vigencia='0'";
    $connexion->query($sql);
    
    $cod    = $connexion->resultset();
        return $cod;
}
function UsuarioAdminEmpresa($id_empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_admin where id_empresa='" . $id_empresa . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function VerificaNoCambiaClaveAccesoObligatorio($empresa)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from tbl_empresa where id='" . $empresa . "'   and '" . $empresa . "'<>''";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBasePersonas2($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select tbl_usuario.perfil_evaluacion, tbl_sgd_perfiles_ponderaciones.descripcion as nombre_perfil


     from tbl_usuario


     inner join tbl_sgd_perfiles_ponderaciones


     on


     tbl_usuario.perfil_evaluacion=tbl_sgd_perfiles_ponderaciones.perfil


     where rut='" . $rut . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBasePersonas2PorProceso($rut, $id_proceso)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "


     select DISTINCT(tbl_sgd_relaciones.perfil_evaluacion_competencias) as perfil_evaluacion,
tbl_sgd_perfiles_ponderaciones.descripcion AS nombre_perfil
from tbl_sgd_relaciones
inner join tbl_sgd_perfiles_ponderaciones on tbl_sgd_relaciones.perfil_evaluacion_competencias=tbl_sgd_perfiles_ponderaciones.perfil
where tbl_sgd_relaciones.evaluado='$rut' and tbl_sgd_relaciones.id_proceso='$id_proceso'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBasePersonasInnerArea($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_usuario.*, tbl_area.area as nombre_area
     from tbl_usuario
     inner join tbl_area
     on tbl_area.id=tbl_usuario.id_area
     where rut='" . $rut . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function UsuarioEnBaseDePersonasInnerEmpresa($rut)
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select tbl_usuario.*, tbl_empresa.campo1, tbl_empresa.campo2, tbl_empresa.campo3
     from tbl_usuario
     inner join tbl_empresa
     on tbl_empresa.id=tbl_usuario.id_empresa
     where rut='" . $rut . "'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function TraeDatos()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from go_proceso";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}
function DatosProceso()
{
    $connexion = new DatabasePDO();
    
    
    $sql = "select * from go_proceso";
    $connexion->query($sql);
    
    $qwerty = $connexion->resultset();
    return $qwerty;
}
function mp_buscaDATOSPERSONAS($rut, $id_empresa)
{

    //echo "<br>mp_buscaDATOSPERSONAS rut $rut, ide $id_empresa";

    $connexion = new DatabasePDO();
    
    
    $sql = "


    select h.*,
(select biografia from tbl_usuario_biografia where rut=h.rut and id_empresa=h.id_empresa limit 1) as biografia,
(select sueno from tbl_usuario_biografia where rut=h.rut and id_empresa=h.id_empresa  limit 1) as sueno,
(select logros from tbl_usuario_biografia where rut=h.rut and id_empresa=h.id_empresa  limit 1) as logros,
(select avatar from tbl_usuario_biografia where rut=h.rut and id_empresa=h.id_empresa  limit 1) as avatarcomunidad,
(select celular from tbl_usuario_biografia where rut=h.rut and id_empresa=h.id_empresa  limit 1) as celular

 from tbl_usuario h where h.id_empresa='$id_empresa' and h.rut='$rut'


    ";

    //echo "<br>$sql";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    //print_r($cod);

    return $cod;
}


?>