<?php
function CheckUser_2024_perfil($rut){
    
    
    
    
}
function Potencial_SoySuper($rut){
    $connexion = new DatabasePDO();



    $SQL_SU="select id from tbl_potencial_perfil_super where rut='$rut'";
    $connexion->query($SQL_SU);

    $COD_SU = $connexion->resultset();

    return $COD_SU[0]->id;

}
function Potencial_Data_Bci_2021_groupby($field){
    /* $connexion = new DatabasePDO();
     $sql=" 	select $field as dato from tbl_data_bci_2021 group by $field order by $field ";
     $connexion->query($sql);
     echo $sql;exit();
     $cod = $connexion->resultset();
     return ($cod);*/
}
function Potencial_Es_Socio($rut) {
    $connexion = new DatabasePDO();


    $sql=" 	select id from tbl_potencial_perfil where rut='$rut' ";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod[0]->id);
}
function UsuarioEnBasePersonas($rut, $rut_contodo)
{
    $connexion = new DatabasePDO();
    
    $sql = "select * from tbl_usuario where rut='" . $rut . "'   and '" . $rut . "'<>'' and vigencia='0'";
    $connexion->query($sql);
    $cod    = $connexion->resultset();
    return $cod;
}
function Potencial_Sucesion_d6_d5($rut){
    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $sql="select d5,d6 from tbl_data_bci_2021 where rut='$rut'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
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
function InsertaLogSistema($rut, $ambiente, $id_empresa, $id_detalle, $subcategoria, $id_archivo, $nivel, $id_menu_nivel)
{
    $connexion = new DatabasePDO();

        $sql = "INSERT INTO tbl_log_sistema(rut, ambiente, fecha, hora, ip, id_empresa, id_detalle, subcategoria, id_archivo, menu_nivel, id_menu_nivel, variables_post, variables_get) " . "VALUES ('$rut','$ambiente', '" . date("Y-m-d") . "', '" . date("H:i:s") . "', '" . $_SERVER['REMOTE_ADDR'] . "', '$id_empresa', '$id_detalle', '$subcategoria', '$id_archivo', '$nivel', '$id_menu_nivel', '" . json_encode($_POST) . "', '" . json_encode($_GET) . "');";
        $connexion->query($sql);
        $connexion->execute();

}
function DatosUsuarioLeftJefeDeTblUsuario($rut)
{
    $connexion = new DatabasePDO();
    $sql = " SELECT tbl_usuario.* FROM tbl_usuario WHERE tbl_usuario.rut = '$rut'";
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function DatosAvatarTblUsuario2022($rut){
    $connexion = new DatabasePDO();


    $fecha      = date("Y-m-d");
    $sql        = "select h.avatar from tbl_avatar h where h.rut='$rut'";
    
    $connexion->query($sql);

    $cod        = $connexion->resultset();

    return ($cod[0]->avatar);
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
function LMS_ConsultaRutSegunEmail_data($email, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select h.* from tbl_usuario h where h.email='$email' and h.id_empresa='$id_empresa' and h.vigencia='0' and h.rut<>''";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Fichas_Personas_Sucesion_Vigentes($search){
    $connexion = new DatabasePDO();
    //print_r($_SESSION);
    $soySSNN=0;
    $soySSNN=SoySocioSSNN_2023($_SESSION["user_"]);
    
    $Perfil=Perfil_Acceso_SN_data($_SESSION["user_"]);
    //print_r($Perfil);
    if(($soySSNN>0 or $Perfil=="LIDER") and $Perfil<>"SUPERUSUARIO"){
        $sql="  
               SELECT
    tbl_usuario.*,
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '$search' ) AS relevance,
    'vigente' AS vigente ,
    tbl_data_bci_2021.d16
FROM
    tbl_usuario 
    left JOIN tbl_data_bci_2021 on tbl_usuario.rut = tbl_data_bci_2021.rut
WHERE
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) 
    AND MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) > 0.01 
    AND tbl_usuario.vigencia_descripcion IS NULL 
ORDER BY
    vigente DESC,
    relevance DESC     ";
    } else {
        $sql="
               SELECT
    tbl_usuario.*,
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '$search' ) AS relevance,
    'vigente' AS vigente,
    tbl_data_bci_2021.d16 
FROM
    tbl_usuario
    LEFT JOIN tbl_data_bci_2021 ON tbl_usuario.rut = tbl_data_bci_2021.rut 
WHERE
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) 
    AND MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) > 0.01 
    AND tbl_usuario.vigencia_descripcion IS NULL 
and '$miRX' < tbl_data_bci_2021.d16
ORDER BY
    vigente DESC,
    relevance DESC     ";
    }

    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo){
    $connexion = new DatabasePDO();
    
    
    $sql="
    SELECT
        ROUND((AVG(acd_1_1) + AVG(acd_2_1) + AVG(acd_3_1)) / 3, 2) AS acd,
        ROUND((AVG(imp_1_1) + AVG(imp_2_1) + AVG(imp_3_1) + AVG(imp_4_1) + AVG(imp_5_1)) / 5, 2) AS imp,
        ROUND((AVG(sac_1_1) + AVG(sac_2_1) + AVG(sac_3_1)) / 3, 2) AS sac,
        ROUND((AVG(lob_1_1) + AVG(lob_2_1) + AVG(lob_3_1)) / 3, 2) AS lob
    FROM
        tbl_potencial_ficha_desempeno
    WHERE
        rut = '$rut'
        AND periodo = '$periodo';";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}

function Perfil_Acceso_SN_data($rut){
    $connexion = new DatabasePDO();
    
    
    $sql="select perfil from tbl_ficha_accesos  where rut='$rut' limit 1";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    //print_r($cod);exit();
    return $cod[0]->perfil;
}

function Ficha_Acceso_SN_data($rut){

    $connexion = new DatabasePDO();
    $acceso=0;
    // ACCESO ADMIN //
    $sql="select id from tbl_ficha_accesos  where rut='$rut' limit 1";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    if($cod[0]->id>0){
        $acceso=1;
    } else {
        $sql2="select rut_completo from tbl_usuario  where rut='$rut' and vigencia='0'";
        
        $connexion->query($sql2);
        $cod2 = $connexion->resultset();
        // ACCESSO SSNN //
        $sql3="select id from tbl_usuario  where operador='".$cod2[0]->rut_completo."' limit 1";
        
        $connexion->query($sql3);
        $cod3 = $connexion->resultset();

        if( $cod3[0]->id>0){
            $acceso=1;
        }  else {
            //ACCESO LIDER SUCESION
            $Check_Sucesion=Sucesion_CheckUserLiderPosiciones_data($rut);
            
            if($Check_Sucesion>0){
                echo "    <script>         location.href='?sw=sucesion';     </script>"; exit;
            }
                   // exit("lider sucesion");
        }
    }
    if($acceso>0){

    } else {

        exit("Sin permisos para visualizar este modulo");
    }
}
function Ficha_Acceso_SN_Sucesion_data($rut){

    $connexion = new DatabasePDO();
    $acceso=0;
    // ACCESO ADMIN //
    $sql="select id from tbl_ficha_accesos  where rut='$rut' limit 1";
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    if($cod[0]->id>0){
        $acceso=1;
    } else {
        $sql2="select rut_completo from tbl_usuario  where rut='$rut'";
       
        $cod2 = $connexion->resultset();
        // ACCESSO SSNN //
        $sql3="select id from tbl_usuario  where operador='".$cod2[0]->rut_completo."' and operador<>'' limit 1";
        
        $connexion->query($sql3);

        $cod3 = $connexion->resultset();

        if( $cod3[0]->id>0){
            $acceso=1;
        }  else {
            //ACCESO LIDER SUCESION
            $Check_Sucesion=Sucesion_CheckUserLiderPosiciones_data($rut);
            
            if($Check_Sucesion>0){
                $acceso=1;
            }
            // exit("lider sucesion");
        }
    }
    
    if($acceso>0){

    } else {

        exit("Sin permisos para visualizar este modulo");
    }
}

function Ficha_Acceso_SN_Sucesion_CheckCrear_data($rut){
    $connexion = new DatabasePDO();
    $acceso=0;
    // ACCESO ADMIN //
    $sql="select id from tbl_ficha_accesos  where rut='$rut' limit 1";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    if($cod[0]->id>0){
        $acceso=1;
    } else {
        $sql2="select rut_completo from tbl_usuario  where rut='$rut'";
        
        $connexion->query($sql2);
        $cod2 = $connexion->resultset();
        // ACCESSO SSNN //
        $sql3="select id from tbl_usuario  where operador='".$cod2[0]->rut_completo."' limit 1";
        
        $connexion->query($sql3);
        $cod3 = $connexion->resultset();
        if( $cod3[0]->id>0){
            $acceso=1;
        }  else {

        }
    }
    if($acceso>0){
    } else {
    }
    return $acceso;
}

function SoySocioSSNN_2023($rut){
    $connexion = new DatabasePDO();
    $acceso=0;
    
    
    $soySSNN=0;
    $sql2="select rut_completo from tbl_usuario  where rut='$rut'";
    
    $connexion->query($sql2);
    
    $cod2 = $connexion->resultset();

    $sql3="select id from tbl_usuario  where operador='".$cod2[0]->rut_completo."' limit 1";
    
    $connexion->query($sql3);
    
    $cod3 = $connexion->resultset();
    if( $cod3[0]->id>0){
        $soySSNN=1;
    }

    return $soySSNN;
}

function Ficha_Premiaciones_2023_data($rut){
  /*  $connexion = new DatabasePDO();
    
    
    $sql=" select * from tbl_ficha_premiaciones where rut='$rut' order by periodo DESC, tipo ASC";

    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;*/
}
function Fichas_Personas_Vigentes($search){
    $connexion = new DatabasePDO();
    //print_r($_SESSION);
    $soySSNN=0;
    $soySSNN=SoySocioSSNN_2023($_SESSION["user_"]);
    
    $Perfil=Perfil_Acceso_SN_data($_SESSION["user_"]);
    //print_r($Perfil);

    if(($soySSNN>0 or $Perfil=="TALENTO") and $Perfil<>"ADMIN"){
        $sql="	
               SELECT
    tbl_usuario.*,
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '$search' ) AS relevance,
    'vigente' AS vigente ,
    tbl_data_bci_2021.d16
FROM
    tbl_usuario 
    left JOIN tbl_data_bci_2021 on tbl_usuario.rut = tbl_data_bci_2021.rut
WHERE
    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) 
    AND MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) > 0.01 
    AND tbl_usuario.vigencia_descripcion IS NULL
    AND tbl_usuario.vigencia='0'
    AND (tbl_usuario.gerencia <> 'GERENCIA CORPORATIVA GESTION PERSONAS' and tbl_data_bci_2021.d16<>'R1')
ORDER BY
    vigente DESC,
    relevance DESC     ";
    } else {
        $sql="
                SELECT
                    tbl_usuario.*,
                    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '$search' ) AS relevance,
                    'vigente' AS vigente
                FROM
                    tbl_usuario
                WHERE
                    MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' )
                    AND MATCH ( tbl_usuario.nombre_completo ) AGAINST ( '+ $search' ) > 0.01
                    AND tbl_usuario.vigencia_descripcion is null
                AND tbl_usuario.vigencia='0'
                ORDER BY
                    vigente DESC,
                    relevance DESC";
    }
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Ficha_AccionesDesarrollo_2023_data($rut){
    /*$connexion = new DatabasePDO();
    $sql=" select * from tbl_ficha_acciones_desarrollo  where rut='$rut' order by periodo DESC, tipo ASC";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;*/
}
function Ficha_SkillChallenge_2023_data($rut){
   /* $connexion = new DatabasePDO();
    
    
    $sql=" select h.skill, h.nom_nivel_skill, h.estado_skill_cursos, j.cargo from tbl_checklist_consolidado h 
                     INNER JOIN tbl_checklist_matriz_cursos j   ON h.id_cargo = j.id_cargo
                                                          
                                                          where h. rut='$rut' and 
                                                                h.tipo_cargo ='OFICIAL' and
                                                                
                         (  h.estado_skill_cursos='EXIMIDA_AUTO' or   
                            h.estado_skill_cursos='Skill Convalidada' or   
                            h.estado_skill_cursos='Skill Eximida' or   
                            h.estado_skill_cursos='Skill Obtenida'
                            ) group by h.id_skill order by h.skill
                                                ";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;*/
}
function Ficha_Cuadrantes_2023_data($rut, $tipo){
    /*$connexion = new DatabasePDO();
    $sql=" select cuadrante, fecha, clase from tbl_ficha_cuadrantes where rut='$rut' and tipo='$tipo' ";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();*/
    return $cod;
}
function Ficha_Engagement_2023_data($rut, $periodo){
    $connexion = new DatabasePDO();
    $sql=" select engagement from tbl_ficha_potencial_eng where rut='$rut' and periodo='$periodo' ";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod[0]->engagement;
}
function Ficha_Clima_2023_data($rut, $periodo){
    $connexion = new DatabasePDO();
    
    
    $sql=" select clima from tbl_ficha_potencial_clima where rut='$rut' and periodo='$periodo' ";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->clima;
}

function Ficha_Desempeno_Metas_2023_data($rut, $periodo){
    $connexion = new DatabasePDO();
    
    
    $sql=" select meta from tbl_ficha_potencial_metas where rut='$rut' and periodo='$periodo' ";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->meta;
}

function Ficha_Desempeno_Meta_data($tabla, $rut){
    $connexion = new DatabasePDO();
    
    
    $sql="select * from $tabla  where rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}

function Ficha_NivelHay_data($rut){
    /*$connexion = new DatabasePDO();
    
    
    $sql="select nivel_hay from tbl_potencial_nivel_hay   where rut='$rut'";
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->nivel_hay;*/
}
function Ficha_Potencial_Fecha_Posicion_data($rut){
    /*$connexion = new DatabasePDO();
    
    
    $sql="select fecha_posicion from tbl_potencial_usuario_posicion  where rut='$rut'";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod[0]->fecha_posicion;*/
}
function Ficha_Desempeno_ficha($periodo, $rut){
    $connexion = new DatabasePDO();
    
    
    $sql="select * from tbl_potencial_ficha_desempeno where rut ='$rut' and periodo='$periodo';";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;
}

function Ficha_Desempeno_promedio_ficha($periodo, $rut){
    $connexion = new DatabasePDO();
    
    
    $sql="select * from tbl_potencial_ficha_desempeno_promedios where rut ='$rut' and periodo='$periodo';";
    
    $connexion->query($sql);
    
    $cod = $connexion->resultset();
    return $cod;

}

function DatosUsuario_($rut, $id_empresa)
{
    $connexion = new DatabasePDO();
    $sql = "select h.*, a.avatar as avatar_usuario
    from tbl_usuario h left join tbl_avatar a on a.rut=h.rut
    where h.rut='$rut' and h.id_empresa='$id_empresa'
    ";
   
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod);
}
function DatosDataBci2021($rut){
    $connexion = new DatabasePDO();
    $sql="select * from tbl_data_bci_2021  where rut='$rut'";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function UsuaData2021_mini($rut){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    /*$sql=" 	select h.d153 as rx from tbl_data_bci_2021 h where rut='$rut'";*/
    $sql=" 	select h.d5, h.d6, h.d16  from tbl_data_bci_2021 h where rut='$rut'";
    
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
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Sucesion_Num_Sucesores_2024($rut){
    $connexion = new DatabasePDO();


    $sql=" 	select count(id) as cuenta from tbl_potencial_sucesion_colaboradores_propuestos_2024 where rut_col='$rut' and estado='Es Sucesor' ";
    
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
    
    $connexion->query($sql);
    $connexion->execute();
    $datos = $connexion->resultset();
    return $datos;


}
function Potencial_trae_rut_col_fromId_Sucesion_2024($id_sucesor){
    $connexion = new DatabasePDO();
    $sql   = "select rut_col from tbl_potencial_sucesion_colaboradores_propuestos_2024 where id='$id_sucesor' ";
    
    $connexion->query($sql);
    $cod = $connexion->resultset();


    return $cod[0]->rut_col;


}
function Potencial_Actualiza_tbl_potencial_sucesion_colaboradores_propuestos_r2_2024($id_sucesor, $tipo_sucesion_ficha){

    $connexion = new DatabasePDO();


    $hoy   = date('Y-m-d');
    $sql="update tbl_potencial_sucesion_colaboradores_propuestos_2024 set tipo_sucesion='$tipo_sucesion_ficha' where id='$id_sucesor' ";
    
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

    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    if($cod[0]->id>0){
        $owner_comite="owner";
    } else {
        $sql="select id from tbl_potencial_sucesion_comites_colaboradores_2024 where id_comite='$id_comite' and rut='$rut'";
        
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
    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod[0]->cuenta);
}
function Potencial_Sucesion_Colaboradores_Comites_2024_data($id_comite, $rut, $perfil, $id_empresa){

    $connexion = new DatabasePDO();
    $fecha = date("Y-m-d");
    $query="";
    
    if($perfil=="SOCIO DE NEGOCIO" OR $perfil=="SUPER USER")    {

        
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
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

}
function Potencial_Mis_Comites_insert_Nuevo_Comite_Sucesion_data_2024($nombre, $rut_g1, $rut, $fecha_comite, $id_empresa, $id_comite_edit)
{
    
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

    array_multisort($aux, SORT_DESC, $cod);

    
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
    
    if($perfil=="SUPER USER"){
        

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
        


        $sql=" SELECT 
    h.*, 
    j.d1 AS rut_completo,
    k.d1 AS rut_completo_r1,
    l.rut AS rut_dependiente,
    COUNT(m.rut) AS dep,
    n.d12 AS jefe_creador,
    o.d12 AS mi_jefe,
            k.d5 as cargo_lider,
        k.d6 as posicion_lider,
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

    
    foreach ($cod as $key => $row) {
        $aux[$key] = $row->fecha_comite;
    }

    array_multisort($aux, SORT_DESC, $cod);

    
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
                       (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1')) as dep, 
                       U.nombre_completo from tbl_data_bci_2021 h 
                       left join tbl_usuario U on h.rut=U.rut where h.d12=(select d1 from tbl_data_bci_2021 where rut='$rut_R1') 
                        and (select count(rut) from tbl_data_bci_2021 where d12=(select d1 from tbl_data_bci_2021 where rut=h.d1)) >0 
                                    group by h.d6
     		
     		";

    
    $connexion->query($sql);
    $cod = $connexion->resultset();
    return $cod;
}
function Potencial_Check_Mapeado($rut){
    /*$connexion = new DatabasePDO();


    $periodo=date("Y");
    $sql=" 	select cuadrante_2020 from tbl_potencial_cuadrantes where rut='$rut' and cerrado='1' order by id DESC limit 1";
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return $cod[0]->cuadrante_2020;*/
}
function Sucesion_Check_Posicion_validada($id_posicion){
/*
    $connexion = new DatabasePDO();



    $SQL_SU="select count(id) as cuenta from tbl_potencial_sucesion_colaboradores_propuestos_r2
				where posicion='$id_posicion' and validado_lider='SI'";
    
    $connexion->query($SQL_SU);

    $COD_SU = $connexion->resultset();

    return $COD_SU[0]->cuenta;*/

}
function Sucesion_Rut_Nombre_lider_posicion($id_posicion){

    $connexion = new DatabasePDO();



    //$SQL_SU="select rut, d7, d8, d9 from tbl_data_bci_2021 where d6='$id_posicion'";
    $SQL_SU="select rut, d7, d8, d9 from tbl_data_bci_2021 where d6='$id_posicion'";
    
    $connexion->query($SQL_SU);

    $COD_SU = $connexion->resultset();

    return $COD_SU;
}
function Potencial_Colaboradores_Matriz_tbl_data_bci_data($id_empresa, $rut){

    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql   = "

     				select h.* from tbl_data_bci_2021 h where h.rut='$rut' 

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
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod[0]->rx);

}
function Potencial_Bitacora_Comites_FullRut_data($rut_col,  $id_empresa){
   /* $connexion = new DatabasePDO();

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
    return ($cod);*/
}
function Potencial_Busca_Nombre_Lider($rut_col,$id_comite_enc){
/*
    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");
    $id_comite=Decodear3($id_comite_enc);
    
    $sql="

        select h.rut_lider, (select d7 from tbl_data_bci_2021 where rut=h.rut_lider) as nombre, (select d8 from tbl_data_bci where rut=h.rut_lider) as apellido
 from tbl_potencial_comites_colaboradores h where h.rut='$rut_col' and h.id_comite='$id_comite'


        ";

    $connexion->query($sql);

    $cod = $connexion->resultset();
    $nombre=$cod[0]->nombre." ".$cod[0]->apellido;
    return ($nombre);
*/
}
function Pot_CheckPosicion_Clave($rut) {
/*
    $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql=" select h.id, h.posicion_clave, (select d6 from tbl_data_bci_2021 where rut='$rut') from tbl_potencial_posicion_clave h   where
            (select d6 from tbl_data_bci_2021 where rut='$rut') = h.posicion_clave ";
    $sql=" select h.id, h.posicion_clave, (select d6 from tbl_data_bci_2021 where rut='$rut') from tbl_potencial_posicion_clave h where
				(select d6 from tbl_data_bci_2021 where rut='$rut') = h.posicion_clave ";

    $connexion->query($sql);
    $cod = $connexion->resultset();
    return ($cod[0]->id);
*/
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
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod);

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
    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod[0]->cuenta);
}
/*
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
*/
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
function Potencial_EliminaComite_Sucesion_2024($id_comite) {

    $connexion = new DatabasePDO();

    $sql="update tbl_potencial_comites_sucesion_2024 set id_empresa='99' where id_comite='$id_comite' ";
    
    $connexion->query($sql);
    $connexion->execute();
    $cod = $connexion->resultset();
    return $cod;

}
function Potencial_Sucesion_Select_Insert_comites_colaboradores_CheckSave_2024($rut,$posicion,$id_comite,$nombre_completo,$id_empresa)
{
    
    $connexion = new DatabasePDO();
    $sql_check="select id from tbl_potencial_sucesion_comites_colaboradores_2024 where id_comite='$id_comite' and rut='$rut' and posicion ='$posicion'";
    $connexion->query($sql_check);
    
    $cod = $connexion->resultset();
    if($cod[0]->id>0){

    } else{
        if($posicion<>""){
            $sql   = "insert into tbl_potencial_sucesion_comites_colaboradores_2024 (id_comite, posicion, rut, nombre_completo, id_empresa) VALUES ('$id_comite','$posicion', '$rut', '$nombre_completo','$id_empresa');";

            $connexion->query($sql);
            $connexion->execute();
        }
    }
}

function Potencial_Es_SuperUsers($rut){
    $connexion = new DatabasePDO();


    $sql=" 	select id from tbl_potencial_perfil_super where rut='$rut' and rut<>'17810781' ";


    
    $connexion->query($sql);

    $cod = $connexion->resultset();
    return ($cod[0]->id);
}
function Potencial_Perfil_Sucesion_Usuarios($rut, $id_empresa){
  /*  $connexion = new DatabasePDO();

    $fecha = date("Y-m-d");

    $sql   = " select h.id from tbl_potencial_perfil h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
    
    $connexion->query($sql);

    $cod = $connexion->resultset();

    $sql1   = " select h.id from tbl_potencial_sucesion_comites_colaboradores h where h.rut='$rut' and h.id_empresa='$id_empresa'  limit 1";
    
    $connexion->query($sql1);

    $cod1 = $connexion->resultset();


    $sql2   = " select h.id from tbl_potencial_sucesion_comites_colaboradores h where 
     		(h.rut_jefe_socio='$rut' or h.rut_jefe_jefe_socio='$rut' or h.rut_jefe_lider='$rut' or h.rut_jefe_jefe_lider='$rut')
     		 and h.id_empresa='$id_empresa'  limit 1";
    
    //exit();
    $connexion->query($sql2);

    $cod2 = $connexion->resultset();

    

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
    
    $connexion->query($sqlSU);

    $codSU = $connexion->resultset();
    if($codSU[0]->id > 0){
        $perfil="SUPER USER";
    }

    //}

    

    //vista socio 2 y 3
    if($perfil==""){

        $sqlSOc_2_3   = " select h.id from tbl_potencial_comites_sucesion h where (h.rut='$rut' or h.gerenciaR1='$rut' or h.rut_socio_2='$rut' or h.rut_socio_3='$rut' or h.rut_socio_4='$rut') 
        and h.id_empresa='$id_empresa'  limit 1";
        
        $connexion->query($sqlSOc_2_3);

        $codSOc_2_3 = $connexion->resultset();
        if($codSOc_2_3[0]->id > 0){
            $perfil="SOCIO DE NEGOCIO";
        }


    }

    return $perfil;*/
}