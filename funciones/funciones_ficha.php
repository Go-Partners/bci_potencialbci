<?php
function CheckVisualizaMiRxRxCol($miRx,	$miRx_2){

    if($miRx=="")		{$visualiza="NO";}
    if($miRx=="R1")	{$visualiza="SI";}

    if($miRx=="R2" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R2" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R2" and $miRx_2=="R3"){$visualiza="SI";}
    if($miRx=="R2" and $miRx_2=="R4"){$visualiza="SI";}
    if($miRx=="R2" and $miRx_2=="R5"){$visualiza="SI";}
    if($miRx=="R2" and $miRx_2=="R6"){$visualiza="SI";}
    if($miRx=="R2" and $miRx_2=="R7"){$visualiza="SI";}

    if($miRx=="R3" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R3" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R3" and $miRx_2=="R3"){$visualiza="NO";}
    if($miRx=="R3" and $miRx_2=="R4"){$visualiza="SI";}
    if($miRx=="R3" and $miRx_2=="R5"){$visualiza="SI";}
    if($miRx=="R3" and $miRx_2=="R6"){$visualiza="SI";}
    if($miRx=="R3" and $miRx_2=="R7"){$visualiza="SI";}

    if($miRx=="R4" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R4" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R4" and $miRx_2=="R3"){$visualiza="NO";}
    if($miRx=="R4" and $miRx_2=="R4"){$visualiza="NO";}
    if($miRx=="R4" and $miRx_2=="R5"){$visualiza="SI";}
    if($miRx=="R4" and $miRx_2=="R6"){$visualiza="SI";}
    if($miRx=="R4" and $miRx_2=="R7"){$visualiza="SI";}

    if($miRx=="R5" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R5" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R5" and $miRx_2=="R3"){$visualiza="NO";}
    if($miRx=="R5" and $miRx_2=="R4"){$visualiza="NO";}
    if($miRx=="R5" and $miRx_2=="R5"){$visualiza="NO";}
    if($miRx=="R5" and $miRx_2=="R6"){$visualiza="SI";}
    if($miRx=="R5" and $miRx_2=="R7"){$visualiza="SI";}

    if($miRx=="R6" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R3"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R4"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R5"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R6"){$visualiza="NO";}
    if($miRx=="R6" and $miRx_2=="R7"){$visualiza="SI";}

    if($miRx=="R7" and $miRx_2=="R1"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R2"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R3"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R4"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R5"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R6"){$visualiza="NO";}
    if($miRx=="R7" and $miRx_2=="R7"){$visualiza="NO";}

    $perfil_super=Potencial_SoySuper($_SESSION["user_"]);
    
    if($perfil_super>0){
        $visualiza="SI";
    }

    $perfil_sn=Potencial_Es_Socio($_SESSION["user_"]);
    if($perfil_sn>0){
        $visualiza="SI";
    }



    return $visualiza;

}
function CheckValidateSucesionRut_2024($id_comite_save,$rut_colaborador, $r_posicion, $rut_posicion){
    
    $data_col=Sucesion_Colaborador_data_2024($rut_colaborador);
    $data_pos=Sucesion_Colaborador_data_2024($rut_posicion);
    
    // R es menor
    $levels = ["R0", "R1", "R2", "R3", "R4", "R5", "R6", "R7"];
    $CheckOk=0;
    // Example values
    $nivel_r    = $r_posicion;
    $nivel_r2   = $data_col[0]->r;
    //$nivel_r2   =   "R4";
    $index_r = array_search($nivel_r, $levels);
    $index_r2 = array_search($nivel_r2, $levels);

    $result = ($index_r2 > $index_r) ? 1 : 0;
    
    if($data_col[0]->r<>""){
        // validacion R
        if($result>0){
            //validacion no es parte del equipo
            //$jefe = LimpiaRutFront($data_col[0]->jefe);
            $Comparte_Jefe=Sucesion_Check_Comparte_Jefe_data_2024($rut_colaborador, $data_pos[0]->jefe);
            
            if($Comparte_Jefe>0){
                echo "<script>alert('El colaborador no puede ser del mismo equipo del Lider.');</script>";
            } else {
                $CheckOk=1;
            }
            

        } else {
            echo "<script>alert('El colaborador tiene un Nivel ".$data_col[0]->r.". Recuerda que el colaborador para la matriz de sucesion debe estar un nivel R menor.');</script>";
        }

    }





    return $CheckOk;
}
function Ficha_colaborador_Sucesion_fn($PRINCIPAL, $rut, $perfil, $filtro, $id_empresa){

    $Usu=DatosUsuario_($rut, $id_empresa);
    
    $Data=DatosDataBci2021($rut);
    $Perfil=Perfil_Acceso_SN_data($_SESSION["user_"]);
    
    $avatar=$Usu[0]->avatar_usuario;
    $avatar = str_replace("s96-c",      "s180-c",           $avatar);
    
    if($avatar==""){$avatar="https://www.potencialbci.cl/front/img/sinfoto.png";}
    $PRINCIPAL = str_replace("{AVATAR_COLABORADOR}",       $avatar,                    $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR}",       utf8_encode($Usu[0]->nombre_completo),           $PRINCIPAL);

    if($Usu[0]->vigencia=="1"){
        $vigente="<a class='btn btn-sm btn-light-warning fw-bold ms-2 fs-8 py-1 px-3' data-bs-target='#kt_modal_upgrade_plan' data-bs-toggle='modal' href='#'>NO ACTIVO</a>";
    } else {
        $vigente="<a class='btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3' data-bs-target='#kt_modal_upgrade_plan' data-bs-toggle='modal' href='#'>ACTIVO</a>";
    }

    $PRINCIPAL = str_replace("{VIGENTE}",               $vigente,                    $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COMPLETO}",          $Usu[0]->rut_completo,       $PRINCIPAL);
    $PRINCIPAL = str_replace("{CARGO}",                 $Data[0]->d5,              $PRINCIPAL);
    $PRINCIPAL = str_replace("{POSICION}",              $Data[0]->d6,           $PRINCIPAL);
    $edad=calcular_edad_2023($Data[0]->d18);
    $PRINCIPAL = str_replace("{EMAIL}",                 $Data[0]->d17,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_BCI}",        $Data[0]->d13,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_CARGO}",      $Data[0]->d14,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_POSICION}",   Ficha_Traduccion_Fecha_espanol(Ficha_Potencial_Fecha_Posicion_data($rut)),  $PRINCIPAL);
    $PRINCIPAL = str_replace("{FECHA_NACIMIENTO}",      $Data[0]->d18,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_BCI_YEARS}",        calcular_edad_2023($Data[0]->d13),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_CARGO_YEARS}",      calcular_edad_2023($Data[0]->d14),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_POSICION_YEARS}",   calcular_edad_2023(Ficha_Traduccion_Fecha_espanol(Ficha_Potencial_Fecha_Posicion_data($rut))),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{EDAD}",                  $edad,                   $PRINCIPAL);

    $NivelHay=Ficha_NivelHay_data($rut);
    $nivel_HAY_txt="Nivel HAY: ".$NivelHay;
    $PRINCIPAL = str_replace("{GERENCIA}",              $Data[0]->d7,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FONDO}",                 $Data[0]->d8,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DEPENDENCIA}",           $Data[0]->d9,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{NIVEL_HAY}",              $nivel_HAY_txt,         $PRINCIPAL);
    $UsuSSNN=DatosUsuario_(LimpiaRutFront($Data[0]->d11), $id_empresa);
    $UsuJEFE=DatosUsuario_(LimpiaRutFront($Data[0]->d12), $id_empresa);

    

    /*$EsJefe=EsJefetblUsuario($rut, $id_empresa);
        if($EsJefe>0){
            $es_jefe="LIDER";
        } else {
            $es_jefe="NO LIDER";
        }*/
    $PRINCIPAL = str_replace("{NOMBRE_SSNN}",      $UsuSSNN[0]->nombre_completo,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_LIDER}",     $UsuJEFE[0]->nombre_completo,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{TIPO_DE_CARGO}",    "FALTA TIPO CARGO",          $PRINCIPAL);
    $PRINCIPAL = str_replace("{LIDER_NO_LIDER}",   $Data[0]->d10,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{NIVEL_R}",          "Nivel R: ".$Data[0]->d16,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FACILITADOR_ACADEMIA}",  "",          $PRINCIPAL);
    global $periodo_A,$periodo_B,$periodo_C;
    $PRINCIPAL = str_replace("{YEAR_A}",  $periodo_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{YEAR_B}",  $periodo_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{YEAR_C}",  $periodo_C,          $PRINCIPAL);
    $Desempeno_ficha_A            =     Ficha_Desempeno_ficha($periodo_A, $rut);
    $Desempeno_promedios_ficha_A  =     Ficha_Desempeno_promedio_ficha($periodo_A, $rut);

    
    if($Desempeno_ficha_A[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_A[0]->promedio==""){
        
        $Desempeno_promedios_ficha_A=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_A);
        $Desempeno_promedios_ficha_A[0]->promedio=round(($Desempeno_promedios_ficha_A[0]->acd+$Desempeno_promedios_ficha_A[0]->imp+$Desempeno_promedios_ficha_A[0]->sac+$Desempeno_promedios_ficha_A[0]->lob)/4,2);
        
    }
    $PRINCIPAL = str_replace("{DESEMPENO_A}",                   $Desempeno_ficha_A[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_A}",          $Desempeno_promedios_ficha_A[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_A}",        $Desempeno_promedios_ficha_A[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_A}",    $Desempeno_ficha_A[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_A}",    $Desempeno_ficha_A[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_A}",    $Desempeno_ficha_A[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_A}",        $Desempeno_promedios_ficha_A[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_A}",    $Desempeno_ficha_A[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_A}",    $Desempeno_ficha_A[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_A}",    $Desempeno_ficha_A[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_A}",    $Desempeno_ficha_A[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_A}",    $Desempeno_ficha_A[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_A}",        $Desempeno_promedios_ficha_A[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_A}",    $Desempeno_ficha_A[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_A}",    $Desempeno_ficha_A[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_A}",    $Desempeno_ficha_A[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_A}",        $Desempeno_promedios_ficha_A[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_A}",    $Desempeno_ficha_A[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_A}",    $Desempeno_ficha_A[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_A}",    $Desempeno_ficha_A[0]->lob_3_1,          $PRINCIPAL);

    $Desempeno_ficha_B            =     Ficha_Desempeno_ficha($periodo_B, $rut);
    $Desempeno_promedios_ficha_B  =     Ficha_Desempeno_promedio_ficha($periodo_B, $rut);


    
    if($Desempeno_ficha_B[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_B[0]->promedio==""){
        
        $Desempeno_promedios_ficha_B=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_B);
        
        $Desempeno_promedios_ficha_B[0]->promedio=round(($Desempeno_promedios_ficha_B[0]->acd+$Desempeno_promedios_ficha_B[0]->imp+$Desempeno_promedios_ficha_B[0]->sac+$Desempeno_promedios_ficha_B[0]->lob)/4,2);
    }

    $PRINCIPAL = str_replace("{DESEMPENO_B}",                   $Desempeno_ficha_B[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_B}",          $Desempeno_promedios_ficha_B[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_B}",        $Desempeno_promedios_ficha_B[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_B}",    $Desempeno_ficha_B[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_B}",    $Desempeno_ficha_B[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_B}",    $Desempeno_ficha_B[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_B}",        $Desempeno_promedios_ficha_B[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_B}",    $Desempeno_ficha_B[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_B}",    $Desempeno_ficha_B[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_B}",    $Desempeno_ficha_B[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_B}",    $Desempeno_ficha_B[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_B}",    $Desempeno_ficha_B[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_B}",        $Desempeno_promedios_ficha_B[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_B}",    $Desempeno_ficha_B[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_B}",    $Desempeno_ficha_B[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_B}",    $Desempeno_ficha_B[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_B}",        $Desempeno_promedios_ficha_B[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_B}",    $Desempeno_ficha_B[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_B}",    $Desempeno_ficha_B[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_B}",    $Desempeno_ficha_B[0]->lob_3_1,          $PRINCIPAL);

    $Desempeno_ficha_C            =     Ficha_Desempeno_ficha($periodo_C, $rut);
    $Desempeno_promedios_ficha_C  =     Ficha_Desempeno_promedio_ficha($periodo_C, $rut);
    
    if($Desempeno_ficha_C[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_C[0]->promedio==""){
        
        $Desempeno_promedios_ficha_C=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_C);
        
        $Desempeno_promedios_ficha_C[0]->promedio=round(($Desempeno_promedios_ficha_C[0]->acd+$Desempeno_promedios_ficha_C[0]->imp+$Desempeno_promedios_ficha_C[0]->sac+$Desempeno_promedios_ficha_C[0]->lob)/4,2);
    }

    $PRINCIPAL = str_replace("{DESEMPENO_C}",                   $Desempeno_ficha_C[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_C}",          $Desempeno_promedios_ficha_C[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_C}",        $Desempeno_promedios_ficha_C[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_C}",    $Desempeno_ficha_C[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_C}",    $Desempeno_ficha_C[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_C}",    $Desempeno_ficha_C[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_C}",        $Desempeno_promedios_ficha_C[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_C}",    $Desempeno_ficha_C[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_C}",    $Desempeno_ficha_C[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_C}",    $Desempeno_ficha_C[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_C}",    $Desempeno_ficha_C[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_C}",    $Desempeno_ficha_C[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_C}",        $Desempeno_promedios_ficha_C[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_C}",    $Desempeno_ficha_C[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_C}",    $Desempeno_ficha_C[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_C}",    $Desempeno_ficha_C[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_C}",        $Desempeno_promedios_ficha_C[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_C}",    $Desempeno_ficha_C[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_C}",    $Desempeno_ficha_C[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_C}",    $Desempeno_ficha_C[0]->lob_3_1,          $PRINCIPAL);

    if($Desempeno_ficha_C[0]->desempeno<>""){} else {$PRINCIPAL = str_replace("{DESEMPENO_C_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($Desempeno_ficha_B[0]->desempeno<>""){} else {$PRINCIPAL = str_replace("{DESEMPENO_B_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($Desempeno_ficha_A[0]->desempeno<>""){} else {$PRINCIPAL = str_replace("{DESEMPENO_A_DISPLAY}", "display:none!important;",  $PRINCIPAL);}

    //desempeno_metas

    $Meta_A = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_A));
    $Meta_B = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_B));
    $Meta_C = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_C));
    $PRINCIPAL = str_replace("{METAS_A}",  $Meta_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{METAS_B}",  $Meta_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{METAS_C}",  $Meta_C,          $PRINCIPAL);

    if($Meta_C<>""){} else {$PRINCIPAL = str_replace("{METAS_C_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($Meta_B<>""){} else {$PRINCIPAL = str_replace("{METAS_B_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($Meta_A<>""){} else {$PRINCIPAL = str_replace("{METAS_A_DISPLAY}", "display:none!important;",  $PRINCIPAL);}

    $Cuadrante_Vigente = (Ficha_Cuadrantes_2023_data($rut, "vigente"));
    $Cuadrante_Anterior = (Ficha_Cuadrantes_2023_data($rut, "anterior"));
    

    /*if($Perfil=="TALENTO"){

    } else {
        $Cuadrante_Vigente = (Ficha_Cuadrantes_2023_data($rut, "vigente"));
        $Cuadrante_Anterior = (Ficha_Cuadrantes_2023_data($rut, "anterior"));
    }*/

    $PRINCIPAL = str_replace("{CUADRANTE_VIGENTE}",        $Cuadrante_Vigente[0]->cuadrante,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_FECHA_VIGENTE}",  Ficha_Traduccion_Fecha_espanol($Cuadrante_Vigente[0]->fecha),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_VIGENTE_CLASE}",  $Cuadrante_Vigente[0]->clase,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_ANTERIOR}",        $Cuadrante_Anterior[0]->cuadrante,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_FECHA_ANTERIOR}",  Ficha_Traduccion_Fecha_espanol($Cuadrante_Anterior[0]->fecha),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_ANTERIOR_CLASE}",  $Cuadrante_Anterior[0]->clase,          $PRINCIPAL);


    if($Cuadrante_Vigente[0]->cuadrante==""){
        $PRINCIPAL = str_replace("{DISPLAY_POTENCIAL}",      "display:none!important;",          $PRINCIPAL);
    }
    if($Cuadrante_Anterior[0]->cuadrante==""){
        $PRINCIPAL = str_replace("{DISPLAY_POTENCIAL_ANTERIOR}",      "display:none!important;",          $PRINCIPAL);
    }

    $ENGAGEMENT_A   = Ficha_Engagement_2023_data($rut, $periodo_A);
    $ENGAGEMENT_B   = Ficha_Engagement_2023_data($rut, $periodo_B);
    $ENGAGEMENT_C   = Ficha_Engagement_2023_data($rut, $periodo_C);
    $PRINCIPAL = str_replace("{ENGAGEMENT_A}",  $ENGAGEMENT_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ENGAGEMENT_B}",  $ENGAGEMENT_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ENGAGEMENT_C}",  $ENGAGEMENT_C,          $PRINCIPAL);

    if($ENGAGEMENT_C<>""){} else {$PRINCIPAL = str_replace("{ENGAGEMENT_C_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($ENGAGEMENT_B<>""){} else {$PRINCIPAL = str_replace("{ENGAGEMENT_B_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($ENGAGEMENT_A<>""){} else {$PRINCIPAL = str_replace("{ENGAGEMENT_A_DISPLAY}", "display:none!important;",  $PRINCIPAL);}

    $CLIMA_A   = Ficha_Clima_2023_data($rut, $periodo_A);
    $CLIMA_B   = Ficha_Clima_2023_data($rut, $periodo_B);
    $CLIMA_C   = Ficha_Clima_2023_data($rut, $periodo_C);
    $PRINCIPAL = str_replace("{CLIMA_A}",  $CLIMA_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CLIMA_B}",  $CLIMA_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CLIMA_C}",  $CLIMA_C,          $PRINCIPAL);

    if($CLIMA_C<>""){} else {$PRINCIPAL = str_replace("{CLIMA_C_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($CLIMA_B<>""){} else {$PRINCIPAL = str_replace("{CLIMA_B_DISPLAY}", "display:none!important;",  $PRINCIPAL);}
    if($CLIMA_A<>""){} else {$PRINCIPAL = str_replace("{CLIMA_A_DISPLAY}", "display:none!important;",  $PRINCIPAL);}

    if($ENGAGEMENT_A=="" and $ENGAGEMENT_B==""  and $ENGAGEMENT_B=="" and $CLIMA_A=="" and $CLIMA_B=="" and $CLIMA_C==""){
        $PRINCIPAL = str_replace("{DISPLAY_ENGAGEMENT_CLIMA}",  "display:none!important",          $PRINCIPAL);
    }

    $SkillChallenge=Ficha_SkillChallenge_2023_data($rut);
    foreach ($SkillChallenge as $sk){
        $cuenta_skillchallenges++;
        IF($sk->estado_skill_cursos=="EXIMIDA_AUTO"){
            $sk->estado_skill_cursos="Skill Eximida";
        }
        $row_skill_challenge.="  <tr><td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($sk->skill)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href=''>".utf8_encode($sk->nom_nivel_skill)."</a></td>
                                        <td>".utf8_encode($sk->estado_skill_cursos)."</td>
                                    </tr>";
        $cargo_oficial_sk=$sk->cargo;
    }
    $PRINCIPAL = str_replace("{CARGO_OFICIAL_SKILLCHALLENGE}",              utf8_decode($cargo_oficial_sk),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FICHA_COLABORADOR_ROW_SKILL_CHALLENGE}",     utf8_decode($row_skill_challenge),          $PRINCIPAL);

    if($cuenta_skillchallenges>0){
        $display_none_skillchallenge=" ";
    } else {
        $display_none_skillchallenge=" display:none !important; ";
    }
    $PRINCIPAL = str_replace("{DISPLAY_NONE_SKILL_CHALLENGE}",  $display_none_skillchallenge,          $PRINCIPAL);

    $Premiaciones=Ficha_Premiaciones_2023_data($rut);
    foreach ($Premiaciones as $pr){
        $cuenta_premiaciones++;
        $row_premiaciones.="        <tr>
                                        <td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($pr->tipo)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href='' style='padding-left: 10px;'>".utf8_encode($pr->periodo)."</a></td>
                                    </tr>";
    }

    if($cuenta_premiaciones>0){
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_PREMIACIONES_2023}",  utf8_decode($row_premiaciones),          $PRINCIPAL);
    } else {
        $PRINCIPAL = str_replace("{DISPLAY_NONE_PREMIACIONES_2023}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_PREMIACIONES}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_PREMIACIONES_2023}",  "<div style='padding-left: 30px;'>Sin Premiaciones</div>",          $PRINCIPAL);
    }

    $AccionesDesarrollo=Ficha_AccionesDesarrollo_2023_data($rut);
    
    foreach ($AccionesDesarrollo as $ad){
        $cuenta_accionesdesarrollo++;
        $row_acciones_desarrollo.="  <tr><td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($ad->tipo)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href=''  style='padding-left: 10px;'>".utf8_encode($ad->periodo)."</a></td>
                                    </tr>";
    }
    if($cuenta_accionesdesarrollo>0){
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_ACCIONES_DESARROLLO_2023}",  utf8_decode($row_acciones_desarrollo),          $PRINCIPAL);
    } else {
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_ACCIONES_DESARROLLO_2023}",  "<div style='padding-left: 30px;'>Sin Acciones de Desarrollo</div>",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_NONE_ACCIONES_DESARROLLO_2023}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_ACCIONES}",  "display:none!important;",          $PRINCIPAL);
    }
    return ($PRINCIPAL);
}
function FuncionesTransversales($html)
{
    
    $environment_sw               = $_GET["sw"];
    $rut                          = $_SESSION["user_"];
    $rut_sesion                   = $_SESSION["user_"];
    $id_empresa                   = $_SESSION["id_empresa"];
    
    $datos_usuario                = UsuarioEnBasePersonas($rut_sesion, "");
    $html                         = str_replace("{FECHAHOY}", formatearFechaCompleta(date("Y-m-d")), $html);
    $html                         = str_replace("{NOMBRE_USUARIO}", $datos_usuario[0]->nombre_completo, $html);
    $html                         = str_replace("{RUT_USUARIO_LOGUEADO}", $datos_usuario[0]->rut, $html);
    $rand                         = rand(1, 4);
    $html = str_replace("{RANDOM}", $rand , $html);
    $ahora=date("Ymdhi");
    $html = str_replace("{AHORA}", $ahora , $html);
    $html = str_replace("{HEAD}", file_get_contents("views/head.html"), $html);
    $html = str_replace("{HEAD_DINAMICO}",     file_get_contents("views/head/" . $id_empresa . "_head.html"), $html);
    $html = str_replace("{MENU_DINAMICO}",     file_get_contents("views/menu/" . $id_empresa . "_menu_principal.html"), $html);
    $html = str_replace("{FOOTER_DINAMICO}",file_get_contents("views/head/" . $id_empresa . "_footer.html"), $html);
    $html   = str_replace("{LOGO_EMPRESA}", '', $html);
    return ($html);
}
function ValidarSesion($ambiente, $id_empresas, $url_front)
{
    
    if ($_SESSION["user_"]) {
        //Tiene session
        //Veo si el usuario esta en la base
        $existe_usuario_en_la_base = $datos_usuario = UsuarioEnBasePersonas($_SESSION["user_"],$_SESSION["user_"]);
        if (!$existe_usuario_en_la_base) {
                exit("FN_#9991");
        } else {
            if ($existe_usuario_en_la_base[0]->vigencia == "1") {
                exit("FN_#9992");
            }
        }
            InsertaLogSistema($_SESSION["user_"], $ambiente, $id_empresas, "", "", "", "", "");

    } else {
        if ($ambiente <> "checkUserBci") {

                
                session_start();
                $_SESSION = array();
                if (isset($_COOKIE[session_name()])) {
                    setcookie(session_name(), '', time() - 42000, '/');
                }
                session_destroy();
                $PRINCIPAL        = FuncionesTransversales(file_get_contents("" . $url_front . "/front/views/home/login.html"));
                $token_fecha_hora = Encodear3(date("Y-m-d") . " " . date("H:i:s"));
                $PRINCIPAL        = str_replace("{TOKEN_FECHA_HORA}", $token_fecha_hora, $PRINCIPAL);
                session_start();
                $_SESSION["token"] = $token_fecha_hora;
                echo $PRINCIPAL;
                exit;

        } else {
        }
        
    }
}
function ColocaDatosPerfil($PRINCIPAL, $rut)
{
    $PRINCIPAL             = str_replace("{FOTO_PERSONA}", VerificaFotoPersonal($rut), $PRINCIPAL);
    $datos_usuario         = DatosUsuarioLeftJefeDeTblUsuario($rut);
    $PRINCIPAL             = str_replace("{NOMBRE}", ($datos_usuario[0]->nombre . " " . $datos_usuario[0]->apaterno . " " . $datos_usuario[0]->amaterno), $PRINCIPAL);
    $PRINCIPAL             = str_replace("{CARGO}", ($datos_usuario[0]->cargo), $PRINCIPAL);
    $PRINCIPAL             = str_replace("{GERENCIA}", ($datos_usuario[0]->gerencia), $PRINCIPAL);
    $PRINCIPAL             = str_replace("{DIVISION}", ($datos_usuario[0]->division), $PRINCIPAL);
    $PRINCIPAL             = str_replace("{CORREO}", $datos_usuario[0]->email, $PRINCIPAL);
    $PRINCIPAL             = str_replace("{RUT_ENCODEADO}", Encodear3($rut), $PRINCIPAL);
    return ($PRINCIPAL);
}
Function VerificaFotoPersonal($rut)
{
    $imagen = "img/sinfoto.png";
    $avatar=DatosAvatarTblUsuario2022($rut);
    
    if($avatar<>""){
        $imagen=$avatar;
    }

    return ($imagen);
}
function LMS_ConsultaRutSegunEmail($email, $id_empresa)
{
    $arrayKey = LMS_ConsultaRutSegunEmail_data($email, $id_empresa);
    
    $key      = $arrayKey[0]->rut;

    return $key;
}
function formatearFechaCompleta($valor_fecha)
{
    $dia = date("d", strtotime($valor_fecha));
    $mes = devuelveNombreMes(date("m", strtotime($valor_fecha)));
    $ano = date("Y", strtotime($valor_fecha));
    //return($fecha2=date("d-m-Y",strtotime($valor_fecha)));
    return ($dia . " de " . $mes . " de " . $ano);
}
function Decodear3($valor)
{
    //$valor=Decodear(Decodear(Decodear($valor)));
    
    $valor = my_simple_crypt_decodear($valor, 'd');
    return ($valor);
}
function Encodear3($valor)
{
    //$valor=Encodear(Encodear(Encodear($valor)));
    $valor = my_simple_crypt_encodear($valor, 'e');
    return ($valor);
}
function my_simple_crypt_encodear($string)
{
    // you may change these values to your own
    $secret_key     = getenv('SECRET_KEY1');
    $secret_iv      = getenv('SECRET_IV1');
    $output         = false;
    $encrypt_method = "AES-256-CBC";
    $key            = hash('sha256', $secret_key);
    $iv             = substr(hash('sha256', $secret_iv), 0, 16);
    $output         = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    return $output;
}
function my_simple_crypt_decodear($string)
{
    // you may change these values to your own
    $secret_key     = getenv('SECRET_KEY1');
    $secret_iv      = getenv('SECRET_IV1');
    $output         = false;
    $encrypt_method = "AES-256-CBC";
    $key            = hash('sha256', $secret_key);
    $iv             = substr(hash('sha256', $secret_iv), 0, 16);
    $output         = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    return $output;
}
function devuelveNombreMes($numero_mes)
{
    if ($numero_mes == "1") {
        return ("Enero");
    } else if ($numero_mes == "2") {
        return ("Febrero");
    } else if ($numero_mes == "3") {
        return ("Marzo");
    } else if ($numero_mes == "4") {
        return ("Abril");
    } else if ($numero_mes == "5") {
        return ("Mayo");
    } else if ($numero_mes == "6") {
        return ("Junio");
    } else if ($numero_mes == "7") {
        return ("Julio");
    } else if ($numero_mes == "8") {
        return ("Agosto");
    } else if ($numero_mes == "9") {
        return ("Septiembre");
    } else if ($numero_mes == "10") {
        return ("Octubre");
    } else if ($numero_mes == "11") {
        return ("Noviembre");
    } else if ($numero_mes == "12") {
        return ("Diciembre");
    }
}
function VerificaArregloSQLInjectionV2_BK($arreglo)
{
    $total_arreglo = count($arreglo);

    foreach ($arreglo as $clave => $valor) {

        if (strtoupper(trim($valor)) == "") {
            continue;
        }

        $valor = str_replace("'", "", $valor);
        $valor = str_replace('"', "", $valor);
        $valor = str_replace("+'", "", $valor);
        $valor = str_replace('--', "", $valor);
        $valor = str_replace('--', "", $valor);
        $valor = str_replace('--', "", $valor);
        //$valor = str_replace('', "", $valor);
        $valor = str_replace('.php', "", $valor);
        $valor = str_replace('.js', "", $valor);
        $valor = str_replace('.vbs', "", $valor);
        $valor = str_replace('%', "", $valor);
        //valor = str_replace('&', "", $valor);
        $valor = str_replace('&amp;', "", $valor);
        $valor = str_replace('&#38;', "", $valor);
        $valor = str_replace('<', "", $valor);
        $valor = str_replace('&lt;', "", $valor);
        $valor = str_replace('&#60;', "", $valor);
        $valor = str_replace('>', "", $valor);
        $valor = str_replace('&gt;', "", $valor);
        $valor = str_replace('&#62;', "", $valor);
        $valor = str_replace('&quot;', "", $valor);
        $valor = str_replace('&#34;', "", $valor);
        $valor = str_replace('&#39;', "", $valor);
        $valor = str_replace('select', "", $valor);
        $valor = str_replace('tables', "", $valor);
        $valor = str_replace('union', "", $valor);
        $valor = str_replace('information_schema', "", $valor);
        //$valor = str_replace('', "", $valor);
        $valor = str_replace('delete', "", $valor);
        $valor = str_replace('update', "", $valor);
        $valor = str_replace('show', "", $valor);
        $valor = str_replace('|', "", $valor);
        $arreglo[$clave]= $valor;
    }
    return ($arreglo);
}
function VerificaArregloSQLInjectionV2($arreglo) {
    // Define dangerous patterns to remove
    $dangerousPatterns = [
        "/('|\"|\+|'|\`|;|\||--|\.php|\.js|\.vbs|%|<|>|&amp;|&#38;|&lt;|&#60;|&gt;|&#62;|&quot;|&#34;|&#39;)/i", // Common dangerous characters
        "/(select|tables|union|information_schema|delete|update|show)/i", // SQL injection keywords
    ];

    foreach ($arreglo as $clave => $valor) {
        // Skip empty or null values
        if (trim($valor) === "") {
            continue;
        }

        // Remove dangerous patterns
        foreach ($dangerousPatterns as $pattern) {
            $valor = preg_replace($pattern, '', $valor);
        }

        // Additional sanitization based on context
        if (strpos($clave, 'url') !== false || strpos($clave, 'href') !== false) {
            // Sanitize URLs
            $valor = filter_var($valor, FILTER_SANITIZE_URL);
        }

        // Reassign the sanitized value back to the array
        $arreglo[$clave] = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8'); // Prevent XSS
    }

    return $arreglo;
}

function Ficha_Traduccion_Fecha_espanol($date){
    try {
        $date2 = new DateTime($date);
        return $date2->format('d-m-Y');
    } catch (Exception $e) {
        // Handle the exception if the input date is not valid
        return false;
    }
}
function LimpiaRutFront($rut)
{
    
    $rut         = str_replace(".", "", $rut);
    $rut         = str_replace(",", "", $rut);
    $arreglo_rut = explode("-", $rut);
    

    $rut         = intval(preg_replace('/[^0-9]+/', '', $arreglo_rut[0]), 10);
    
    return ($rut);
}

function Potencial_Sucesion_Mis_Comites_estado_activo_2024($PRINCIPAL, $rut, $perfil, $id_empresa, $comite_cierre)
{
    $lista = Potencial_Sucesion_Mis_Comites_data_2024($id_empresa, $rut, $perfil);
    
    $nomuestracabeceras="";
    if($perfil=="VISUALIZADOR"){$nomuestracabeceras="1";}
    if($nomuestracabeceras=="1"){$lider="";$colab="";} else {$lider1="LIDER";$colab="COLAB.";}
    $num_comites    =   count($lista);
    if($num_comites>0){$potencial_titulo="";}   else   {
        $potencial_titulo="<div class='row'><div class='col-sm-12 txt_title_pot'><br><br><center>[ No hay comit&eacute;s de sucesi�n creados ]</center></div></div>";
    }
	$pot_sucesion_badge_ok_cerrado="";
    foreach($lista as $unico) {
        $cuenta_lista++;
        $num_colaboradores=0;
        $array_comite=Potencial_Comites_Suc_data_2024($unico->id_comite,$id_empresa);
        $id_comite_cerrado = $array_comite[0]->comite_cerrado;
        $perfil="YO";
        $g2="";
        $array_g2=Potencial_Busca_Colaboradores_Comite_2024($unico->id_comite, $id_empresa);
        foreach ($array_g2 as $unlid){
	        $estado_tarea_comite="";
            $g2.="<i class='bi bi-arrow-right-short'></i><strong>".$unlid->posicion."</strong>".$pot_sucesion_badge_ok_cerrado."
                        <br><br><i class='bi bi-person'></i> ".$unlid->nombre_completo."
                        <br><i class='bi bi-arrow-right-short'></i>Cargo: ".$unlid->d5." 
                        <br><i class='bi bi-bookmark'></i> Nivel R: ".$unlid->d16."
                        <br> <hr>";
        }
        $row_lista.= file_get_contents("views/sucesion/row_comites_sucesion.html");
        $row_lista = str_replace("{ID_COMITE}", ($unico->id_comite), $row_lista);
        $row_lista = str_replace("{COMITE}", ($unico->nombre), $row_lista);
        $row_lista = str_replace("{CARGO_LIDER_COMITE}", ($unico->cargo_lider), $row_lista);
        $row_lista = str_replace("{POSICION_LIDER_COMITE}", ($unico->posicion_lider), $row_lista);
        $row_lista = str_replace("{NIVEL_R_LIDER_COMITE}", ($unico->nivelr_lider), $row_lista);

        if(trim($estado_tarea_comite) == "<span class='badge badge-danger'>Finalizado</span><br>") {
            
            $row_button_eliminar_editar="";
        } else {
            
            $row_button_eliminar_editar = "
                <br>
                <a href='?sw=sucesion&id_comite=".Encodear3($unico->id_comite)."&edit=1&previsualizar=1'>
                    <i class='bi bi-pencil'></i>
                </a> 
                <a href='?sw=sucesion&id_comite=".Encodear3($unico->id_comite)."&id_del=".Encodear3($unico->id_comite)."&del=1' 
                   onclick='return confirm(\"Esta seguro de eliminar el comite?\")'>
                    <i class='bi bi-trash'></i>
                </a>
            ";

        }
        $row_lista = str_replace("{BOTON_EDITAR_ELIMINAR_COMITE}", $row_button_eliminar_editar, $row_lista);


        $estado_tarea_comite=SucesionEstadoTareaComite($unico->id_comite,"comite","",$unico->fecha,$unico->fecha_comite,"");
        $row_lista = str_replace("{ESTADO_TAREA_COMITE}", ($estado_tarea_comite), $row_lista);

        $row_lista = str_replace("{COMITE}", ($unico->nombre), $row_lista);

        $fechas_comite  =   "   Desde: ".DDYYMMM($unico->fecha)."<br> T&eacute;rmino: ".DDYYMMM($unico->fecha_comite);

        $row_lista = str_replace("{FECHA}", $fechas_comite, $row_lista);
        $row_lista = str_replace("{GERENTES_R2}", ($g2), $row_lista);
        $row_lista = str_replace("{COLABORADORES}", $num_colaboradores, $row_lista);
        //$UsuaCreadorComite=DatosUsuario_($unico->rut, $id_empresa);
        $row_lista = str_replace("{NOMBRE_CREADOR_COMITE}",     $unico->nombre_creador, $row_lista);
        $row_lista = str_replace("{NOMBRE_LIDER_COMITE}",       $unico->nombre_lider, $row_lista);
        $row_lista = str_replace("{BOTON_VER_COMITE}", "<a href='?sw=sucesion_comite&id_comite=".Encodear3($unico->id_comite)."' class='btn btn-info'><span class='blanco'>Ingresar</span></a>", $row_lista);

        if($perfil=="SOCIO DE NEGOCIO" OR $perfil=="SUPER USER")    {
            $row_lista = str_replace("{BOTON_ELIMINAR_COMITE}", "<a href='?sw=sucesion&id_del=".Encodear3($unico->id_comite)."' class='btn btn-link'>
        	<span class='azul_comite'><i class='fas fa-trash-alt'></i></span></a>", $row_lista);
        }else {
            $row_lista = str_replace("{BOTON_ELIMINAR_COMITE}", "", $row_lista);
        }
    }
    $PRINCIPAL = str_replace("{MIS_COMITES_SUCESION}",         $row_lista,         $PRINCIPAL);
    $PRINCIPAL = str_replace("{MIS_COMITES_POTENCIAL_TITULO}",  $potencial_titulo,  $PRINCIPAL);


    if($cuenta_lista>0){
        $display_none_mi_sucesion="";
    } else {
        $display_none_mi_sucesion="display:none!important";
    }
    $PRINCIPAL = str_replace("{MIS_COMITES_SUCESION_DISPLAY_NONE}",  $display_none_mi_sucesion,  $PRINCIPAL);

    return ($PRINCIPAL);
}
function SucesionEstadoTareaComite($id_comite,$tipo_estado,$rut_tarea, $fecha_inicio, $fecha_cierre, $posicion){

    $hoy=date("Y-m-d");
    

    if($tipo_estado=="comite"){
        $cuenta_colaboradores=Sucesion_EstadoComite_Cuenta_colaboradores_propuestos($id_comite);
        // "<br>-> cuenta_colaboradores $cuenta_colaboradores $id_comite";
        $estado_comite_tarea="<span class='badge badge-warning'>No Iniciado</span><br>";
        if($fecha_cierre<$hoy){
            $estado_comite_tarea="<span class='badge badge-danger'>Finalizado</span><br>";
        }
        if($cuenta_colaboradores>0){
            $estado_comite_tarea="<span class='badge badge-primary'>En Proceso</span><br>";
        }
    }
    if($tipo_estado=="tarea") {
        
        $Inmediato = PotencialSucesion_Vista_Colaboradores_Tarea_Posicion_2024($id_comite, "", "", "1", $posicion);
        $Mediano = PotencialSucesion_Vista_Colaboradores_Tarea_Posicion_2024($id_comite, "", "", "2", $posicion);
        $Largo = PotencialSucesion_Vista_Colaboradores_Tarea_Posicion_2024($id_comite, "", "", "3", $posicion);
        
        $estado_comite_tarea="<span class='badge badge-warning'>No Iniciado</span><br>";
        if($Inmediato>0 or $Mediano>0 or $Largo>0){
            $estado_comite_tarea="<span class='badge badge-danger'>Incompleto</span><br>";
        }
        if($Inmediato>0 and $Mediano>0 and $Largo>0){
            $estado_comite_tarea="<span class='badge badge-primary'>En Proceso</span><br>";
        }


    }
    return $estado_comite_tarea;
}
function Potencial_Sucesion_Colaboradores_Comites_Ficha_2024($PRINCIPAL, $id_comite, $rut, $perfil, $posicion, $id_empresa)
{
    $MiRx=MiRx($_SESSION["user_"]);
    
    if($perfil=="LIDER"){
        $display_acciones_desarrollo = " display:none; ";
    } else {
        $display_acciones_desarrollo = "  ";
    }
    $array_comite=Potencial_Comites_Suc_data($id_comite,$id_empresa);
    
    $comite_cerrado_esta=$array_comite[0]->comite_cerrado;

    //todo0s agregan acciones desarrollo
    $display_acciones_desarrollo = "  ";
    //Rx $MiRx";

    if($perfil=="LIDER"){
        $display_acciones_desarrollo = " display:none; ";
    } else {
        $display_acciones_desarrollo = "  ";
    }

    $array_comite=Potencial_Comites_Suc_data($id_comite,$id_empresa);
    

    $comite_cerrado_esta=$array_comite[0]->comite_cerrado;

    //todo0s agregan acciones desarrollo
    $display_acciones_desarrollo = "  ";
    $row_inmediato="";
    $row_lista1="";
    $inmediato=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite,$rut, $id_empresa, "1", $posicion);
    
    foreach ($inmediato as $uni1){
	    $filtro="";
        if($comite_cerrado_esta=="SI" and $uni1->estado=="No es sucesor"){
            // continue;
        }
        $Usua1=DatosUsuario_($uni1->rut_col, $id_empresa);
        
        if($Usua1[0]->vigencia_descripcion=="Externo"){
            $row_lista1.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar_externos.html");
        } else {
            $row_lista1.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar.html");
            $row_lista1=Ficha_colaborador_Sucesion_fn($row_lista1, $uni1->rut_col, $perfil, $filtro, $id_empresa);
        }
        $row_lista1 = str_replace("{CARGO_EXTERNO}", 			$Usua1[0]->cargo, $row_lista1);

        $row_lista1 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni1->rut_col), $row_lista1);
        $RxCol=MiRx($uni1->rut_col);
        $visualiza1=CheckVisualizaMiRxRxCol($MiRx, $RxCol);

        $es_posicion_clave=Pot_CheckPosicion_Clave($uni1->rut_col);
        if($es_posicion_clave>0){
            $posicion_clave	=" <div class='badge badge-gray' style='    background-color: transparent !important;padding-left: 0px!important;'><center></center></div><br>";
        } else {
            $posicion_clave="";
        }
        $row_lista1 = str_replace("{POSICION_CLAVE}", 			$posicion_clave, $row_lista1);
        $Num_Sucesion=Potencial_Sucesion_Num_Sucesores_2024($uni1->rut_col);
	    $Cuad_2020="";
        if($Cuad_2020<>""){
            if($Cuad_2020=="10"){$Cuad_2020="5+";}
            $cuadrante_2020="Cuadrante Actual: $Cuad_2020";
        } else {
            $cuadrante_2020="Sin cuadrante actual";
        }
        if($Num_Sucesion>0){
            $num_sucesion_2020="Veces como sucesor: $Num_Sucesion";
        } else {
            $num_sucesion_2020="1 vez como sucesor";
        }
        /*$Usua=DatosUsuario_($uni1->rut_col, $id_empresa);
        if($Usua[0]->gerencia=="GERENCIA CORPORATIVA GESTION PERSONAS"){
            $cuadrante_2020="";
        }*/
        if($visualiza1=="NO"){$num_sucesion_2020="";}
        if($visualiza1=="NO"){$cuadrante_2020="";}
        $row_lista1 = str_replace("{CARGO_CUDRANTE_SUCESORES}",   $cuadrante_2020, $row_lista1);
        $row_lista1 = str_replace("{CARGO_VECES_SUCESOR}",     		$num_sucesion_2020, $row_lista1);
        $estado_badge_avatar="";
        if($uni1->estado=="No es sucesor"){
            if($uni1->rutlider==""){
                $estado_badge_avatar="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span>";
            } else {
                $estado_badge_avatar="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span> <span style='font-size: 12px;display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($uni1->estado=="Es Sucesor"){
            if($uni1->rutlider==""){
                $estado_badge_avatar="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span> - <span style='font-size: 12px;'>Propuesta de Sucesi&oacute;n</span>";
            } else {
                $estado_badge_avatar="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span> <span style='font-size: 12px;display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($comite_cerrado_esta=="SI" and $uni1->estado=="Es Sucesor"){
            $estado_badge_avatar="";
        }
        $row_lista1 = str_replace("{NO_ES_SUCESOR_ESTADO_BADGE}",     		$estado_badge_avatar, $row_lista1);
        $row_lista1 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua1[0]->nombre_completo), $row_lista1);
        $posicion1=Potencial_Sucesion_d6_d5($uni1->rut_col);
        $row_lista1 = str_replace("{POSICION_SUCESORES}",        ($posicion1[0]->d6), $row_lista1);
        $row_lista1 = str_replace("{CARGO_SUCESORES}",           ($posicion1[0]->d5), $row_lista1);
        $row_lista1 = str_replace("{RUT_SUCESORES}",           	 ($uni1->rut_col), $row_lista1);
        $row_lista1 = str_replace("{RUT_SUCESORES_ENC}",         Encodear3($uni1->rut_col), $row_lista1);
        $row_lista1 = str_replace("{ID_SUCESORES}",           	 Encodear3($uni1->id), $row_lista1);
        $row_lista1 = str_replace("{ID_POSICION_ENC}",           Encodear3($posicion), $row_lista1);
        $row_lista1 = str_replace("{ID_COMITE_ENC}",           	 Encodear3($id_comite), $row_lista1);
        $row_lista1 = str_replace("{ID_COL}",           				 Encodear3($uni1->id), $row_lista1);
        $row_lista1 = str_replace("{PERFIL_ENC}",           		Encodear3($perfil), $row_lista1);
        $row_lista1 = str_replace("{ACTUAL_TEMPORALIDAD}",      "Inmediato", $row_lista1);
        $row_lista1 = str_replace("{ID_ACTUAL_TEMPORALIDAD}",      "1", $row_lista1);
        $sucesion_display_none="";
        if($visualiza1=="NO"){$sucesion_display_none=" display:none; ";}
        $row_lista1 = str_replace("{sucesion_display_none}",      $sucesion_display_none, $row_lista1);
        $row_lista1 = str_replace("{RUT}",              ($uni1->rut), $row_lista1);
        $row_lista1 = str_replace("{COLABORADOR}",   	($uni1->nombre_completo), $row_lista1);
        $row_lista1 = str_replace("{CARGO_COL}",   		($uni1->cargo_col), $row_lista1);
        if($visualiza1=="NO"){
            $row_lista1 = str_replace("{BOTON_VER_FICHA}","", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_A_inicial}","", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_B_final}","", $row_lista1);
        } else {
            $row_lista1 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_fichaxxx&rut_col=".Encodear3($uni1->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."' class='btn btn-link' >
			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni1->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;'>", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista1);
        }
        $row_lista1 = str_replace("{STYLO_AGREGAR_ACCIONES_DESARROLLO}", $display_acciones_desarrollo, $row_lista1);
        $row_lista1_acciones="";

        $row_bitacora1="";
        $Bitacora1=SucesionBitacora_2024($uni1->rut_col, $id_comite);
        foreach ($Bitacora1 as $b1){
            $row_bitacora1.="<br> <i class='bi bi-arrow-right-short'></i> ".$b1->comentario;
        }
        $row_lista1 = str_replace("{BITACORA}",$row_bitacora1, $row_lista1);

        /*$Potencial_Acciones_Desarrollo	=	Potencial_Busca_Acciones_Desarrollo($uni1->rut_col);
        if(count($Potencial_Acciones_Desarrollo)>0){
            foreach ($Potencial_Acciones_Desarrollo as $un1){
                $row_lista1_acciones.="

						  		<i class='far fa-file-alt'></i>
						  				".$un1->plan."
						  				<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un1->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>
						  		<br>
						  		<i class='fas fa-chevron-right' style='padding-left: 20px;'></i>
						  				".$un1->fundamento."
						  	<br>";
            }
            $row_lista1 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample2_".$uni1->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample2'>Acciones de Desarrollo</div>", $row_lista1);
            $row_lista1 = str_replace("{ACCIONES_DE_DESARROLLO}", $row_lista1_acciones, $row_lista1);
        } else {
            $row_lista1 = str_replace("{ACCIONES_DE_DESARROLLO}", "", $row_lista1);
            $row_lista1 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "", $row_lista1);
        }
        $Potencial_Bitacora_Desarrollo	=	Potencial_Busca_Bitacora_Desarrollo($uni1->rut_col);
        $row_lista1_bitacora="";
        if(count($Potencial_Bitacora_Desarrollo)>0){
            foreach ($Potencial_Bitacora_Desarrollo as $un1){
                $row_lista1_bitacora.="

						  		".$un1->comite." - Sucesi&oacute;n - ".$un1->fecha."
						  				 <br> ".$un1->nombre_completo." <br>  ".$un1->accion." ".$un1->comentario."
						  				<!--<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un1->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>-->
						  	<br><br>";
            }
            $row_lista1 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample1_".$uni1->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample'>Bit&aacute;cora de Sucesi&oacute;n</div>", $row_lista1);
            $row_lista1 = str_replace("{BITACORA_DE_DESARROLLO}", $row_lista1_bitacora, $row_lista1);
        } else {
            $row_lista1 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "", $row_lista1);
            $row_lista1 = str_replace("{BITACORA_DE_DESARROLLO}", "", $row_lista1);
        }*/
    }

    $row_mediano="";
    $row_lista2="";
    $Mediano=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, $uni1->rut_col, $id_empresa, "2", $posicion);
    
    foreach ($Mediano as $uni2){
        if($comite_cerrado_esta=="SI" and $uni2->estado=="No es sucesor"){
            // continue;
        }
        $Usua2=DatosUsuario_($uni2->rut_col, $id_empresa);
        if($Usua2[0]->vigencia_descripcion=="Externo"){
            
            $row_lista2.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar_externos.html");
        } else {
            
            $row_lista2.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar.html");
            $row_lista2=Ficha_colaborador_Sucesion_fn($row_lista2, $uni2->rut_col, $perfil, $filtro, $id_empresa);
        }
        $row_lista2 = str_replace("{RUT}",           ($uni2->rut), $row_lista2);
        $RxCol=MiRx($uni2->rut_col);
        $visualiza2=CheckVisualizaMiRxRxCol($MiRx,	$RxCol);
        $row_lista2 = str_replace("{COLABORADOR}",   	($uni2->nombre_completo), $row_lista2);
        $row_lista2 = str_replace("{CARGO_COL}",   		($uni2->cargo_col), $row_lista2);
        $row_lista2 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni2->rut_col), $row_lista2);
        $row_lista2 = str_replace("{RUT_SUCESORES}",           ($uni2->rut_col), $row_lista2);
        $row_lista2 = str_replace("{RUT_SUCESORES_ENC}",           Encodear3($uni2->rut_col), $row_lista2);
        $row_lista2 = str_replace("{ID_POSICION_ENC}",           	Encodear3($posicion), $row_lista2);
        $row_lista2 = str_replace("{ID_COMITE_ENC}",           		Encodear3($id_comite), $row_lista2);
        $row_lista2 = str_replace("{ID_COL}",           					Encodear3($uni2->id), $row_lista2);
        $row_lista2 = str_replace("{PERFIL_ENC}",           		Encodear3($perfil), $row_lista2);
        $row_lista2 = str_replace("{ID_ACTUAL_TEMPORALIDAD}",      "2", $row_lista2);


        $es_posicion_clave=Pot_CheckPosicion_Clave($uni2->rut_col);
        if($es_posicion_clave>0){
            $posicion_clave	="<div class='badge badge-gray'  style='    background-color: transparent !important;padding-left: 0px!important;'><strong>Posici&oacute;n Clave</strong></div><br>";
        } else {
            $posicion_clave="";
        }
        $row_lista2 = str_replace("{POSICION_CLAVE}", 			$posicion_clave, $row_lista2);
        $row_lista2 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua2[0]->nombre_completo), $row_lista2);
        $posicion2=Potencial_Sucesion_d6_d5($uni2->rut_col);
        $row_lista2 = str_replace("{POSICION_SUCESORES}",        ($posicion2[0]->d6), $row_lista2);
        $row_lista2 = str_replace("{CARGO_SUCESORES}",           ($posicion2[0]->d5), $row_lista2);
        $row_lista2 = str_replace("{ID_SUCESORES}",           		Encodear3($uni2->id), $row_lista2);
        $row_lista2 = str_replace("{STYLO_AGREGAR_ACCIONES_DESARROLLO}", $display_acciones_desarrollo, $row_lista2);
        $row_lista2 = str_replace("{ACTUAL_TEMPORALIDAD}",      "Mediano", $row_lista2);
        $sucesion_display_none="";
        if($visualiza2=="NO"){$sucesion_display_none=" display:none; ";}
        $row_lista2 = str_replace("{sucesion_display_none}",      $sucesion_display_none, $row_lista2);
        $Num_Sucesion=Potencial_Sucesion_Num_Sucesores_2024($uni2->rut_col);
        if($Cuad_2020<>""){
            if($Cuad_2020=="10"){$Cuad_2020="5+";}
            $cuadrante_2020="Cuadrante Actual: $Cuad_2020";
        } else {
            $cuadrante_2020="Sin cuadrante actual";
        }
        if($Num_Sucesion>0){
            $num_sucesion_2020="Veces como sucesor: $Num_Sucesion";
        } else {
            $num_sucesion_2020="1 vez como sucesor";
        }
        /*$Usua=DatosUsuario_($uni2->rut_col, $id_empresa);
        if($Usua[0]->gerencia=="GERENCIA CORPORATIVA GESTION PERSONAS"){
            $cuadrante_2020="";
        }*/
        if($visualiza2=="NO"){$num_sucesion_2020="";}
        if($visualiza2=="NO"){$cuadrante_2020="";}
        $estado_badge_avatar2="";
        $row_lista2 = str_replace("{CARGO_CUDRANTE_SUCESORES}",   $cuadrante_2020, $row_lista2);
        $row_lista2 = str_replace("{CARGO_VECES_SUCESOR}",     		$num_sucesion_2020, $row_lista2);
        if($uni2->estado=="No es sucesor"){
            if($uni2->rutlider==""){
                $estado_badge_avatar2="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span>";
            } else {
                $estado_badge_avatar2="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span> <span style='font-size: 12px;display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($uni2->estado=="Es Sucesor"){
            if($uni2->rutlider==""){
                $estado_badge_avatar2="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span> - <span style='font-size: 12px;'>Propuesta de Sucesi&oacute;n</span>";
            } else {
                $estado_badge_avatar2="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span>  <span style='font-size: 12px; display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($comite_cerrado_esta=="SI" and $uni2->estado=="Es Sucesor"){
            $estado_badge_avatar2="";
        }
        $row_lista2 = str_replace("{NO_ES_SUCESOR_ESTADO_BADGE}",     		$estado_badge_avatar2, $row_lista2);
        if($visualiza2=="NO"){
            $row_lista2 = str_replace("{BOTON_VER_FICHA}","", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_A_inicial}","", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_B_final}","", $row_lista2);
        } else {
            $row_lista2 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni2->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."' class='btn btn-link' >			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni2->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;'>", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista2);
        }

        $row_bitacora2="";
        $Bitacora2=SucesionBitacora_2024($uni2->rut_col, $id_comite);
        foreach ($Bitacora2 as $b2){
            $row_bitacora2.="<br> <i class='bi bi-arrow-right-short'></i> ".$b2->comentario;
        }
        $row_lista2 = str_replace("{BITACORA}",$row_bitacora2, $row_lista2);

        $row_lista2_acciones="";
        /*$Potencial_Acciones_Desarrollo	=	Potencial_Busca_Acciones_Desarrollo($uni2->rut_col);
        if(count($Potencial_Acciones_Desarrollo)>0){
            foreach ($Potencial_Acciones_Desarrollo as $un2){
                $row_lista2_acciones.=" <i class='far fa-file-alt'></i> ".$un2->plan."
									  		<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un2->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>
									  		<br>
									  		<i class='fas fa-chevron-right' style='padding-left: 20px;'></i> ".$un2->fundamento."<br>";
            }
            $row_lista2 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample2_".$uni2->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample'>Acciones de Desarrollo</div>", $row_lista2);
            $row_lista2 = str_replace("{ACCIONES_DE_DESARROLLO}", $row_lista2_acciones, $row_lista2);
        } else {
            $row_lista2 = str_replace("{ACCIONES_DE_DESARROLLO}", "", $row_lista2);
            $row_lista2 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "", $row_lista2);
        }*/
        /*$Potencial_Bitacora_Desarrollo	=	Potencial_Busca_Bitacora_Desarrollo($uni2->rut_col);
        if(count($Potencial_Bitacora_Desarrollo)>0){
            $row_lista1_bitacora="";
            foreach ($Potencial_Bitacora_Desarrollo as $un1){
                $row_lista1_bitacora.="

						  		".$un1->comite." - Sucesi&oacute;n - ".$un1->fecha."
						  				 <br> ".$un1->nombre_completo." <br>  ".$un1->accion." ".$un1->comentario."
						  				<!--<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un1->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>-->
						  	<br><br>";
            }
            $row_lista2 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample1_".$uni2->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample'>Bit&aacute;cora de Sucesi&oacute;n</div>", $row_lista2);
            $row_lista2 = str_replace("{BITACORA_DE_DESARROLLO}", $row_lista1_bitacora, $row_lista2);
        } else {
            $row_lista2 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "", $row_lista2);
            $row_lista2 = str_replace("{BITACORA_DE_DESARROLLO}", "", $row_lista2);
        }*/
    }

    

    $row_largo="";
    $row_lista3="";
    $Largo=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, $uni2->rut_col, $id_empresa, "3", $posicion);
    
    foreach ($Largo as $uni3){
        if($comite_cerrado_esta=="SI" and $uni3->estado=="No es sucesor"){
            //  continue;
        }

        $Usua3=DatosUsuario_($uni3->rut_col, $id_empresa);
        if($Usua3[0]->vigencia_descripcion=="Externo"){
            $row_lista3.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar_externos.html");
        } else {
            $row_lista3.= file_get_contents("views/sucesion/sucesion_row_colaboradores_comites_sucesion_avatar.html");
            $row_lista3=Ficha_colaborador_Sucesion_fn($row_lista3, $uni3->rut_col, $perfil, $filtro, $id_empresa);
        }
        $row_lista3 = str_replace("{RUT}",           ($uni3->rut_col), $row_lista3);
        $RxCol=MiRx($uni3->rut_col);
        $visualiza3=CheckVisualizaMiRxRxCol($MiRx,	$RxCol);
        $row_lista3 = str_replace("{COLABORADOR}",   	($uni3->nombre_completo), $row_lista3);
        $row_lista3 = str_replace("{CARGO_COL}",   		($uni3->cargo_col), $row_lista3);
        $row_lista3 = str_replace("{RUT_SUCESORES_ENC}",           Encodear3($uni3->rut_col), $row_lista3);
        $row_lista3 = str_replace("{ID_POSICION_ENC}",           	Encodear3($posicion), $row_lista3);
        $row_lista3 = str_replace("{ID_COMITE_ENC}",           		Encodear3($id_comite), $row_lista3);
        $row_lista3 = str_replace("{ID_COL}",           					Encodear3($uni3->id), $row_lista3);
        $row_lista3 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni3->rut_col), $row_lista3);
        $row_lista3 = str_replace("{PERFIL_ENC}",           		Encodear3($perfil), $row_lista3);
        $row_lista3 = str_replace("{ACTUAL_TEMPORALIDAD}",      "Largo", $row_lista3);
        $row_lista3 = str_replace("{ID_ACTUAL_TEMPORALIDAD}",      "3", $row_lista3);
        $sucesion_display_none="";
        if($visualiza3=="NO"){$sucesion_display_none=" display:none; ";}
        $row_lista3 = str_replace("{sucesion_display_none}",      $sucesion_display_none, $row_lista3);
        $es_posicion_clave=Pot_CheckPosicion_Clave($uni3->rut_col);
        if($es_posicion_clave>0){
            $posicion_clave	="<div class='badge badge-gray'  style='    background-color: transparent !important;padding-left: 0px!important;'><strong>Posici&oacute;n Clave</strong></div><br>";
        } else {
            $posicion_clave="";
        }
        $row_lista3 = str_replace("{POSICION_CLAVE}", 			$posicion_clave, $row_lista3);
        $row_lista3 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua3[0]->nombre_completo), $row_lista3);
        $posicion3=Potencial_Sucesion_d6_d5($uni3->rut_col);
        $row_lista3 = str_replace("{POSICION_SUCESORES}",        ($posicion3[0]->d6), $row_lista3);
        $row_lista3 = str_replace("{CARGO_SUCESORES}",           ($posicion3[0]->d5), $row_lista3);
        $row_lista3 = str_replace("{RUT_SUCESORES}",           		($uni3->rut_col), $row_lista3);
        $row_lista3 = str_replace("{STYLO_AGREGAR_ACCIONES_DESARROLLO}", $display_acciones_desarrollo, $row_lista3);
        $row_lista3 = str_replace("{ID_SUCESORES}",           		Encodear3($uni3->id), $row_lista3);
        $Num_Sucesion=Potencial_Sucesion_Num_Sucesores_2024($uni3->rut_col);
        if($Cuad_2020<>""){
            if($Cuad_2020=="10"){$Cuad_2020="5+";}
            $cuadrante_2020="Cuadrante Actual: $Cuad_2020";
        } else {
            $cuadrante_2020="Sin cuadrante actual";
        }
        if($Num_Sucesion>0){
            $num_sucesion_2020="Veces como sucesor: $Num_Sucesion";
        } else {
            $num_sucesion_2020="1 vez como sucesor";
        }
        /*$Usua=DatosUsuario_($uni3->rut_col, $id_empresa);
        if($Usua[0]->gerencia=="GERENCIA CORPORATIVA GESTION PERSONAS"){
            $cuadrante_2020="";
        }*/
        if($visualiza3=="NO"){$num_sucesion_2020="";}
        if($visualiza3=="NO"){$cuadrante_2020="";}
        $row_lista3 = str_replace("{CARGO_CUDRANTE_SUCESORES}",   $cuadrante_2020, $row_lista3);
        $row_lista3 = str_replace("{CARGO_VECES_SUCESOR}",     		$num_sucesion_2020, $row_lista3);
        $estado_badge_avatar3="";
        if($uni3->estado=="No es sucesor"){
            if($uni3->rutlider==""){
                $estado_badge_avatar3="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span>";
            } else {
                $estado_badge_avatar3="<span class='badge badge-danger' style='color:#fff'>No es Sucesor</span>  <span style='font-size: 12px;display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($uni3->estado=="Es Sucesor"){
            if($uni3->rutlider==""){
                $estado_badge_avatar3="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span> - <span style='font-size: 12px;'>Propuesta de Sucesi&oacute;n</span>";
            } else {
                $estado_badge_avatar3="<span class='badge badge-info' style='color:#fff'>Es Sucesor</span>  <span style='font-size: 12px;display:none;'>Sugerido por L&iacute;der</span>";
            }
        }
        if($comite_cerrado_esta=="SI" and $uni3->estado=="Es Sucesor"){
            $estado_badge_avatar3="";
        }
        $row_lista3 = str_replace("{NO_ES_SUCESOR_ESTADO_BADGE}",     		$estado_badge_avatar3, $row_lista3);
        $row_lista3 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."' class='btn btn-link' >
			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista3);
        $row_lista3 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;'>", $row_lista3);
        $row_lista3 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista3);
        if($visualiza3=="NO"){
            $row_lista3 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."' class='btn btn-link' >
			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut_col)."&id_comite=".Encodear3($id_comite)."&sucesion=1&sucesion=1&id_posicion_enc=".Encodear3($posicion)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;'>", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista3);
        } else {
            $row_lista3 = str_replace("{BOTON_VER_FICHA}","", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_A_inicial}","", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_B_final}","", $row_lista3);
        }
        $row_lista3_acciones="";
        $row_bitacora2="";
        $Bitacora3=SucesionBitacora_2024($uni3->rut_col, $id_comite);
        foreach ($Bitacora3 as $b3){
            $row_bitacora3.="<br> <i class='bi bi-arrow-right-short'></i> ".$b3->comentario;
        }
        $row_lista3 = str_replace("{BITACORA}",$row_bitacora3, $row_lista3);
        /*$Potencial_Acciones_Desarrollo	=	Potencial_Busca_Acciones_Desarrollo($uni3->rut_col);
        if(count($Potencial_Acciones_Desarrollo)>0){
            foreach ($Potencial_Acciones_Desarrollo as $un3){
                $row_lista3_acciones.=" <i class='far fa-file-alt'></i> ".$un3->plan."
									  		<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un3->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>
									  		<br>
									  		<i class='fas fa-chevron-right' style='padding-left: 20px;'></i> ".$un3->fundamento."<br>";
            }
            $row_lista3 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample2_".$uni3->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample'>Acciones de Desarrollo</div>", $row_lista3);
            $row_lista3 = str_replace("{ACCIONES_DE_DESARROLLO}", $row_lista3_acciones, $row_lista3);
        } else {
            $row_lista3 = str_replace("{ACCIONES_DE_DESARROLLO}", "", $row_lista3);
            $row_lista3 = str_replace("{ACCIONES_DE_DESARROLLO_TITULO1}", "", $row_lista3);
        }
        $Potencial_Bitacora_Desarrollo	=	Potencial_Busca_Bitacora_Desarrollo($uni3->rut_col);
        if(count($Potencial_Bitacora_Desarrollo)>0){
            $row_lista1_bitacora="";
            foreach ($Potencial_Bitacora_Desarrollo as $un1){
                $row_lista1_bitacora.="

						  		".$un1->comite." - Sucesi&oacute;n - ".$un1->fecha."
						  				 <br> ".$un1->nombre_completo." <br>  ".$un1->accion." ".$un1->comentario."
						  				<!--<span class='pull-right'><a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."&delad=".Encodear3($un1->id)."'><i class='far fa-trash-alt' style='color: #337ab7;'></i></a></span>-->
						  	<br><br>";
            }
            $row_lista3 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "<div class='txt_2020' data-toggle='collapse' href='#collapseExample1_".$uni3->rut_col."' role='button' aria-expanded='false' aria-controls='collapseExample'>Bit&aacute;cora de Sucesi&oacute;n</div>", $row_lista3);
            $row_lista3 = str_replace("{BITACORA_DE_DESARROLLO}", $row_lista1_bitacora, $row_lista3);
        } else {
            $row_lista3 = str_replace("{BITACORA_DE_DESARROLLO_TITULO1}", "", $row_lista3);
            $row_lista3 = str_replace("{BITACORA_DE_DESARROLLO}", "", $row_lista3);
        }*/
    }
	$row_lista="";
	$potencial_titulo="";
    $PRINCIPAL = str_replace("{INMEDIATO}", ($row_lista1), $PRINCIPAL);
    $PRINCIPAL = str_replace("{MEDIANO}",   ($row_lista2), $PRINCIPAL);
    $PRINCIPAL = str_replace("{LARGO}",   	($row_lista3), $PRINCIPAL);
    $PRINCIPAL = str_replace("{MIS_COLABORADORES_COMITES_POTENCIAL}",         $row_lista,         $PRINCIPAL);
    $PRINCIPAL = str_replace("{COLABORADORES_COMITE_POTENCIAL_TITULO}",  $potencial_titulo,  $PRINCIPAL);

    return ($PRINCIPAL);
}
function Potencial_Sucesion_Colaboradores_Comites_2024($PRINCIPAL, $id_comite, $rut, $perfil, $id_empresa)
{
    $lista = Potencial_Sucesion_Colaboradores_Comites_2024_data($id_comite, $rut, $perfil, $id_empresa);
    
    $num_comites    =   count($lista);
    
    if($num_comites>0){
        $potencial_titulo="
					<div class=''>

					</div>";
    }   else   {
        $potencial_titulo="
					<div class=''><br>
					    <div class='col-sm-12 txt_title_pot_hohay'><center>[ No hay cargos a suceder ]</center></div>
					    					<br>
					</div>";
    }

    $cuenta_inmediato=0; $cuenta_mediano=0; $cuenta_largo=0;

    foreach($lista as $unico) {
        $row_lista.= file_get_contents("views/sucesion/row_colaboradores_comite.html");
        
        
        $row_lista = str_replace("{RUT}",           ($unico->rut), $row_lista);
        $row_lista = str_replace("{NIVEL_R_COL}",           ($unico->r), $row_lista);


        $Potencial_Mapeado=Potencial_Check_Mapeado($unico->rut);
        if($Potencial_Mapeado<>""){
            $row_lista = str_replace("{MAPEADO}",           "<span class='badge badge-success' style='font-size: 10px;'><span class='blanco'>Mapeado</span></span>", $row_lista);
        } else {
            $row_lista = str_replace("{MAPEADO}",         	"", $row_lista);
        }

        $Estado_Tarea=SucesionEstadoTareaComite($id_comite,"tarea","", "", "",$unico->posicion);
        $row_lista = str_replace("{ESTADO_TAREA}",           ($Estado_Tarea), $row_lista);

        $pos_validada=Sucesion_Check_Posicion_validada($unico->cargo_col);
        if($pos_validada>0){
            $pot_sucesion_badge_ok_cerrado="<div class='badge badge-success'><i class='fas fa-check' style='color: #fff;'></i></div>";
        } else {
            $pot_sucesion_badge_ok_cerrado="";
        }
        $row_lista = str_replace("{CARGO_SUCEDER_LIDER_CERRADO}",         	$pot_sucesion_badge_ok_cerrado, $row_lista);
        $modal_row_rutc_col	 = "
						<a href='?sw=sucesion_ficha_sucesion&id_posicion_enc=".Encodear3($unico->posicion)."&id_comite=".Encodear3($id_comite)."&perfil=".Encodear3($perfil)."' 
						        class='btn btn-info'> 
								Ver Matriz de Sucesi&oacute;n 
						</a>
				";



        $sucesores_cuadrantes_2_3=0;
        $sucesores_cuadrantes_6=0;
        $sucesores_cuadrantes_1_9_4_8_7=0;
        $cuenta_femenino=0;
        $cuenta_total=0;
        //
        $row_inmediato="";
        $row_lista1="";
        $cuenta_inmediato="";
        $Inmediato=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, $unico->rut, $id_empresa, "Inmediato", $unico->posicion);

        foreach ($Inmediato as $uni1){

            if($uni1->estado=="No es sucesor"){continue;}

            $cuenta_inmediato++;
            $row_lista1.= file_get_contents("views/sucesion/row_colaboradores_comites_sucesion.html");
            $row_lista1 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni1->rut_col), $row_lista1);

            $Usua1=DatosUsuario_($uni1->rut_col, $id_empresa);
            $row_lista1 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua1[0]->nombre_completo), $row_lista1);
            $row_lista1 = str_replace("{CARGO_SUCESORES}",           ($Usua1[0]->cargo), $row_lista1);
            $row_lista1 = str_replace("{TEMPORALIDAD}",           	"Inmediato / Hoy", $row_lista1);

            $cuadrante1=Potencial_Mi_Cuadrante_Actual($uni1->rut_col);
            

            $genero1=Potencial_Genero($uni1->rut_col);

            if($cuadrante1=="2" or $cuadrante1=="3")	{$sucesores_cuadrantes_2_3++;}
            if($cuadrante1=="6")	{$sucesores_cuadrantes_6++;}
            if($cuadrante1=="1" or $cuadrante1=="9" or $cuadrante1=="4" or $cuadrante1=="8" or $cuadrante1=="7")	{$sucesores_cuadrantes_1_9_4_8_7++;}
            if($genero1=="Femenino")																			{$cuenta_femenino++;}
            $cuenta_total++;
            $row_lista1 = str_replace("{RUT}",           ($uni1->rut_col), $row_lista1);
            $row_lista1 = str_replace("{COLABORADOR}",   	($uni1->nombre_completo), $row_lista1);
            $row_lista1 = str_replace("{CARGO_COL}",   		($uni1->cargo_col), $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni1->rut)."&id_comite=".Encodear3($id_comite)."' class='btn btn-link' >
			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni1->rut_col)."&id_comite=".Encodear3($id_comite)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;padding: 0px;'>", $row_lista1);
            $row_lista1 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista1);
        }

        $row_mediano="";
        $row_lista2="";
        $cuenta_mediano="";
        $Mediano=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, 	$unico->rut, $id_empresa, "Mediano", $unico->posicion);

        //$Largo=PotencialSucesion_Vista_Colaboradores_Posicion($id_comite, 		$unico->rut, $id_empresa, "Largo", $unico->cargo_col);
        foreach ($Mediano as $uni2){
            $cuenta_mediano++;

            if($uni2->estado=="No es sucesor"){continue;}

            $row_lista2.= file_get_contents("views/sucesion/row_colaboradores_comites_sucesion.html");
            $row_lista2 = str_replace("{RUT}",           ($uni2->rut_col), $row_lista2);
            $row_lista2 = str_replace("{COLABORADOR}",   	($uni2->nombre_completo), $row_lista2);

            $row_lista2 = str_replace("{CARGO_COL}",   		($uni2->cargo_col), $row_lista2);
            $row_lista2 = str_replace("{TEMPORALIDAD}",           	"Mediano / 1 a 2 a&ntilde;os", $row_lista2);
            $row_lista2 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni2->rut_col), $row_lista2);
            $cuenta_total++;


            $Usua2=DatosUsuario_($uni2->rut_col, $id_empresa);
            $row_lista2 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua2[0]->nombre_completo), $row_lista2);
            $row_lista2 = str_replace("{CARGO_SUCESORES}",           ($Usua2[0]->cargo), $row_lista2);

            $cuadrante2=Potencial_Mi_Cuadrante_Actual($uni2->rut_col);
            

            $genero2=Potencial_Genero($uni2->rut_col);

            if($cuadrante2=="2" or $cuadrante2=="3")	{$sucesores_cuadrantes_2_3++;}
            if($cuadrante2=="6")	{$sucesores_cuadrantes_6++;}
            if($cuadrante2=="1" or $cuadrante2=="9" or $cuadrante2=="4" or $cuadrante2=="8" or $cuadrante2=="7")	{$sucesores_cuadrantes_1_9_4_8_7++;}
            if($genero2=="Femenino")																			{$cuenta_femenino++;}

            $row_lista2 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni2->rut)."&id_comite=".Encodear3($id_comite)."' class='btn btn-link' >			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni2->rut_col)."&id_comite=".Encodear3($id_comite)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px; padding: 0px;'>", $row_lista2);
            $row_lista2 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista2);									}

        $row_largo="";
        $row_lista3="";
        $cuenta_largo="";
        $Largo=PotencialSucesion_Vista_Colaboradores_Posicion_2024($id_comite, 		$unico->rut, $id_empresa, "Largo", $unico->posicion);
        foreach ($Largo as $uni3){
            $cuenta_largo++;

            if($uni3->estado=="No es sucesor"){continue;}

            $row_lista3.= file_get_contents("views/sucesion/row_colaboradores_comites_sucesion.html");
            $row_lista3 = str_replace("{RUT}",           ($uni3->rut_col), $row_lista3);
            $row_lista3 = str_replace("{COLABORADOR}",   	($uni3->nombre_completo), $row_lista3);
            $row_lista3 = str_replace("{CARGO_COL}",   		($uni3->cargo_col), $row_lista3);
            $row_lista3 = str_replace("{TEMPORALIDAD}",           	"Largo  / 3 a 5 a&ntilde;os", $row_lista3);
            $row_lista3 = str_replace("{AVATAR_RUT_SUCESORES}",   				VerificaFotoPersonal($uni3->rut_col), $row_lista3);

            $Usua3=DatosUsuario_($uni3->rut_col, $id_empresa);
            $row_lista3 = str_replace("{COLABORADOR_SUCESORES}",     ($Usua3[0]->nombre_completo), $row_lista3);
            $row_lista3 = str_replace("{CARGO_SUCESORES}",           ($Usua3[0]->cargo), $row_lista3);

            $cuadrante3=Potencial_Mi_Cuadrante_Actual($uni3->rut_col);
            
            $genero3=Potencial_Genero($uni3->rut_col);
            

            if($cuadrante3=="6")	                    {$sucesores_cuadrantes_2_3++;}
            if($cuadrante3=="2" or $cuadrante3=="3")	{$sucesores_cuadrantes_6++;}
            if($cuadrante3=="1" or $cuadrante3=="9" or $cuadrante3=="4" or $cuadrante3=="8" or $cuadrante3=="7")	{$sucesores_cuadrantes_1_9_4_8_7++;}
            if($genero3=="Femenino")																			{$cuenta_femenino++;}
            $cuenta_total++;

            $row_lista3 = str_replace("{BOTON_VER_FICHA}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut)."&id_comite=".Encodear3($id_comite)."' class='btn btn-link'>
			        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_A_inicial}","<a href='?sw=potencial_ficha&rut_col=".Encodear3($uni3->rut_col)."&id_comite=".Encodear3($id_comite)."'
						   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding: 0px;'>", $row_lista3);
            $row_lista3 = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista3);




        }


        
        
        $Porcentaje_Cargo	=	Potencial_CalculoPorcentaje($cuenta_inmediato,$cuenta_mediano,$cuenta_largo);
        $cuenta_porcentaje_cargo++;
        $suma_porcentaje_cargo		= $suma_porcentaje_cargo + $Porcentaje_Cargo	;
        

        $row_lista = str_replace("{INMEDIATO}", ($row_lista1), $row_lista);
        $row_lista = str_replace("{MEDIANO}",   ($row_lista2), $row_lista);
        $row_lista = str_replace("{LARGO}",   	($row_lista3), $row_lista);

        $cuenta_masculino=$cuenta_total-$cuenta_femenino;


        $porc_2_3=round(100*$sucesores_cuadrantes_2_3/$cuenta_total);
        $porc_6=round(100*$sucesores_cuadrantes_6/$cuenta_total);
        $porc_1_9_4_8_6=round(100*$sucesores_cuadrantes_1_9_4_8_7/$cuenta_total);
        $porc_fem=round(100*$cuenta_femenino/$cuenta_total);
        $porc_mas=round(100*$cuenta_masculino/$cuenta_total);

        $row_lista = str_replace("{Sucesores_Cuadrantes_23}",  		"Cuadrantes 2-3: <div class='badge badge-info'>			<span style='color:#fff'>".$porc_2_3."%</span></div>", $row_lista);
        $row_lista = str_replace("{Sucesores_Cuadrantes_6}",  		"Cuadrantes 6: <div class='badge badge-info'>			<span style='color:#fff'>".$porc_6."%</span></div>", $row_lista);
        $row_lista = str_replace("{Sucesores_Cuadrantes_19487}",  	"Cuadrantes 1-9-4-8-7: <div class='badge badge-info'>			<span style='color:#fff'>".$porc_1_9_4_8_6."%</span></div>", $row_lista);
        $row_lista = str_replace("{Sucesores_Mujeres}",  			"Mujeres: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_fem)."%</span></div>", $row_lista);
        $row_lista = str_replace("{Sucesores_Hombre}",  			"Hombres: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_mas)."%</span></div>", $row_lista);

        //if($cuenta_mediano>0){ $titulo_inmediato="<div class='txt_title_pot'>Inmediato</div>"; } else { $titulo_inmediato=""; }
        //if($cuenta_mediano>0){ $titulo_mediano="<div class='txt_title_pot'>Mediano</div>"; } else { $titulo_mediano=""; }
        //if($cuenta_mediano>0){ $titulo_largo="<div class='txt_title_pot'>Largo</div>"; } else { $titulo_largo=""; }
	    $titulo_inmediato="";
	    $titulo_mediano="";
	    $titulo_largo="";

        $row_lista = str_replace("{LARGO}",   	($row_lista3), $row_lista);

        $row_lista = str_replace("{TITULO_INMEDIATO}", 	$titulo_inmediato, $row_lista);
        $row_lista = str_replace("{TITULO_MEDIANO}",   	$titulo_mediano, $row_lista);
        $row_lista = str_replace("{TITULO_LARGO}",   		$titulo_largo, $row_lista);


        $row_lista = str_replace("{NOMBRE_COL}",   	($unico->nombre_completo), $row_lista);
        $row_lista = str_replace("{POSICION_COL}",  ($unico->posicion), $row_lista);
        $row_lista = str_replace("{CARGO_COL}",   	($unico->cargo), $row_lista);
        $row_lista = str_replace("{NOMBRE_LIDER}",  ($unico->nombre_lider), $row_lista);
        $row_lista = str_replace("{AVATAR}",   		VerificaFotoPersonal($unico->rut), $row_lista);
        $row_lista = str_replace("{BOTON_MODAL}",  	($modal_row_rutc_col), $row_lista);

        $row_lista = str_replace("{BOTON_VER_FICHA}",							"<a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($unico->cargo_col)."&id_comite=".Encodear3($id_comite)."' class='btn btn-link' >
        <span class='azul_comite'><i class='fas fa-user'></i> <span class='mt-comment-authorSM'> Ficha</span></span></a>", $row_lista);

        $row_lista = str_replace("{BOTON_VER_FICHA_A_inicial}",	"<a href='?sw=potencial_ficha_sucesion&id_posicion_enc=".Encodear3($unico->cargo_col)."&id_comite=".Encodear3($id_comite)."'
			   class='btn btn-link' style='padding-left: 0px;    padding-left: 0px;text-align: left;padding-right: 0px;'>", $row_lista);

        $row_lista = str_replace("{BOTON_VER_FICHA_B_final}","</a>", $row_lista);


        $SUMA_sucesores_cuadrantes_2_3=	$sucesores_cuadrantes_2_3 + $SUMA_sucesores_cuadrantes_2_3;
        $SUMA_sucesores_cuadrantes_6=	$sucesores_cuadrantes_6 + $SUMA_sucesores_cuadrantes_6;

        $SUMA_sucesores_cuadrantes_1_9_4_8_7=	$sucesores_cuadrantes_1_9_4_8_7 + $SUMA_sucesores_cuadrantes_1_9_4_8_7;

        $SUMA_cuenta_femenino		=	$cuenta_femenino + $SUMA_cuenta_femenino;
        $SUMA_cuenta_masculino	=	$cuenta_masculino + $SUMA_cuenta_masculino;
        $SUMA_cuenta_total			=	$cuenta_total + $SUMA_cuenta_total;


    }



    $PRINCIPAL = str_replace("{MIS_COLABORADORES_COMITES_POTENCIAL}",         $row_lista,         $PRINCIPAL);
    $PRINCIPAL = str_replace("{COLABORADORES_COMITE_POTENCIAL_TITULO}",  $potencial_titulo,  $PRINCIPAL);
    $PRINCIPAL = str_replace("{PORCENTAJE_AREA_PONDERADO}", "�rea Total: <div class='badge badge-info'>			<span style='color:#fff'>".round($suma_porcentaje_cargo/$cuenta_porcentaje_cargo)."%</span></div>",  $PRINCIPAL);


    $porc_total_2_3=round(100*$SUMA_sucesores_cuadrantes_2_3/$SUMA_cuenta_total);

    $porc_total_6=round(100*$SUMA_sucesores_cuadrantes_6/$SUMA_cuenta_total);

    $porc_total_1_9_4_8_6=round(100*$SUMA_sucesores_cuadrantes_1_9_4_8_7/$SUMA_cuenta_total);
    $porc_total_fem=round(100*$SUMA_cuenta_femenino/$SUMA_cuenta_total);
    $porc_total_mas=round(100*$SUMA_cuenta_masculino/$SUMA_cuenta_total);


    $PRINCIPAL = str_replace("{MASCULINO_PONDERADO}", "Sucesores Hombres: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_total_mas)."%</span></div>",  $PRINCIPAL);
    $PRINCIPAL = str_replace("{FEMENINO_PONDERADO}", 	"Sucesores Mujeres: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_total_fem)."%</span></div>",  $PRINCIPAL);

    $PRINCIPAL = str_replace("{CUADRANTE_23}", 			"Sucesores en Cuadrantes 2-3: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_total_2_3)."%</span></div>",  $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_6}", 			"Sucesores en Cuadrantes 6: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_total_6)."%</span></div>",  $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_19487}", 		"Sucesores en Cuadrantes 1-9-4-8-7: <div class='badge badge-info'>			<span style='color:#fff'>".($porc_total_1_9_4_8_6)."%</span></div>",  $PRINCIPAL);



    return ($PRINCIPAL);
}
function DDYYMMM($date) {
    // Check if the date is in the format yyyy-mm-dd
    if (DateTime::createFromFormat('Y-m-d', $date) !== false) {
        // Create a DateTime object from the given date
        $dateTime = DateTime::createFromFormat('Y-m-d', $date);
        // Return the date in the format dd-mm-yyyy
        return $dateTime->format('d-m-Y');
    } else {
        // Return an error message if the date is not in the correct format
        return "Invalid date format. Please use yyyy-mm-dd.";
    }
}
function Potencial_CalculoPorcentaje($cuenta_inmediato,$cuenta_mediano,$cuenta_largo){
   /* $porcentaje=0;
    if($cuenta_largo>0)					{ $porcentaje=50;}
    if($cuenta_mediano>0)					{ $porcentaje=70;}
    if($cuenta_inmediato>0)					{ $porcentaje=100;}

    return $porcentaje;*/
}
function Potencial_Sucesion_Mi_Sucesion_estado_activo_2024($PRINCIPAL, $rut, $perfil, $id_empresa, $comite_cierre)
{
    $lista = Potencial_Sucesion_Mi_Sucesion_data_2024($id_empresa, $rut, $perfil);
    
    $nomuestracabeceras="";
    if($perfil=="VISUALIZADOR"){$nomuestracabeceras="1";}
    if($nomuestracabeceras=="1"){$lider="";$colab="";} else {$lider1="LIDER";$colab="COLAB.";}

    $num_comites    =   count($lista);
    if($num_comites>0){$potencial_titulo="";}   else   {
        $potencial_titulo="<div class='row'><div class='col-sm-12 txt_title_pot'><br><br><center>[ No hay comit&eacute;s de sucesi�n creados ]</center></div></div>";
    }
    foreach($lista as $unico) {
        $cuenta_lista++;
        $Usu=UsuaData2021_mini($rut);
        $num_colaboradores=0;
        $array_comite=Potencial_Comites_Suc_data_2024($unico->id_comite,$id_empresa);
        $id_comite_cerrado = $array_comite[0]->comite_cerrado;
        $row_lista.= file_get_contents("views/sucesion/row_mi_sucesion.html");
        
        $row_lista = str_replace("{ID_COMITE}", ($unico->id_comite), $row_lista);
        $row_lista = str_replace("{COMITE}", ($unico->nombre), $row_lista);
        $row_lista = str_replace("{FECHA}", $unico->fecha_comite, $row_lista);
        $row_lista = str_replace("{CARGO}", $Usu[0]->d6, $row_lista);
        $row_lista = str_replace("{COLABORADORES}", $num_colaboradores, $row_lista);
        //$UsuaCreadorComite=DatosUsuario_($unico->rut, $id_empresa);
        $row_lista = str_replace("{NOMBRE_CREADOR_COMITE}",     $unico->nombre_creador, $row_lista);
        $row_lista = str_replace("{NOMBRE_LIDER_COMITE}",       $unico->nombre_lider, $row_lista);
        $row_lista = str_replace("{BOTON_VER_COMITE}", "<a href='?sw=sucesion_comite&id_comite=".Encodear3($unico->id_comite)."' class='btn btn-info'><span class='blanco'>Ingresar</span></a>", $row_lista);

        if($perfil=="SOCIO DE NEGOCIO" OR $perfil=="SUPER USER")    {
            $row_lista = str_replace("{BOTON_ELIMINAR_COMITE}", "<a href='?sw=sucesion&id_del=".Encodear3($unico->id_comite)."' class='btn btn-link'>
        	<span class='azul_comite'><i class='fas fa-trash-alt'></i></span></a>", $row_lista);
        }else {
            $row_lista = str_replace("{BOTON_ELIMINAR_COMITE}", "", $row_lista);
        }
    }
    $PRINCIPAL = str_replace("{MI_SUCESION}",         $row_lista,         $PRINCIPAL);
    $PRINCIPAL = str_replace("{MIS_COMITES_POTENCIAL_TITULO}",  $potencial_titulo,  $PRINCIPAL);


    if($cuenta_lista>0){
        $display_none_mi_sucesion="";
    } else {
        $display_none_mi_sucesion="display:none!important";
    }
    $PRINCIPAL = str_replace("{MI_SUCESION_DISPLAY_NONE}",  $display_none_mi_sucesion,  $PRINCIPAL);

    return ($PRINCIPAL);
}
function Ficha_colaborador_fn($PRINCIPAL, $rut, $perfil, $filtro, $id_empresa){

    $Usu=DatosUsuario_($rut, $id_empresa);
    $Data=DatosDataBci2021($rut);
    $Perfil=Perfil_Acceso_SN_data($_SESSION["user_"]);
    
    $avatar=$Usu[0]->avatar_usuario;
    $avatar = str_replace("s96-c",      "s180-c",           $avatar);
    
    if($avatar==""){$avatar="https://www.potencialbci.cl/front/img/sinfoto.png";}
    $PRINCIPAL = str_replace("{AVATAR_COLABORADOR}",       $avatar,                    $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR}",       utf8_encode($Usu[0]->nombre_completo),           $PRINCIPAL);

        if($Usu[0]->vigencia=="1"){
            $vigente="<a class='btn btn-sm btn-light-warning fw-bold ms-2 fs-8 py-1 px-3' data-bs-target='#kt_modal_upgrade_plan' data-bs-toggle='modal' href='#'>NO ACTIVO</a>";
        } else {
            $vigente="<a class='btn btn-sm btn-light-success fw-bold ms-2 fs-8 py-1 px-3' data-bs-target='#kt_modal_upgrade_plan' data-bs-toggle='modal' href='#'>ACTIVO</a>";
        }

    $PRINCIPAL = str_replace("{VIGENTE}",               $vigente,                    $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COMPLETO}",          $Usu[0]->rut_completo,       $PRINCIPAL);
    $PRINCIPAL = str_replace("{CARGO}",                 $Data[0]->d5,              $PRINCIPAL);
    $PRINCIPAL = str_replace("{POSICION}",              $Data[0]->d6,           $PRINCIPAL);
    $edad=calcular_edad_2023($Data[0]->d18);
    $PRINCIPAL = str_replace("{EMAIL}",                 $Data[0]->d17,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_BCI}",        $Data[0]->d13,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_CARGO}",      $Data[0]->d14,           $PRINCIPAL);
    //$PRINCIPAL = str_replace("{ANTIGUEDAD_POSICION}",   Ficha_Traduccion_Fecha_espanol(Ficha_Potencial_Fecha_Posicion_data($rut)),  $PRINCIPAL);
    $PRINCIPAL = str_replace("{FECHA_NACIMIENTO}",      $Data[0]->d18,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_BCI_YEARS}",        calcular_edad_2023($Data[0]->d13),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ANTIGUEDAD_CARGO_YEARS}",      calcular_edad_2023($Data[0]->d14),          $PRINCIPAL);
    //$PRINCIPAL = str_replace("{ANTIGUEDAD_POSICION_YEARS}",   calcular_edad_2023(Ficha_Traduccion_Fecha_espanol(Ficha_Potencial_Fecha_Posicion_data($rut))),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{EDAD}",                  $edad,                   $PRINCIPAL);

    //$NivelHay=Ficha_NivelHay_data($rut);
    //$nivel_HAY_txt="Nivel HAY: ".$NivelHay;
	$nivel_HAY_txt="";
    $PRINCIPAL = str_replace("{GERENCIA}",              $Data[0]->d7,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FONDO}",                 $Data[0]->d8,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DEPENDENCIA}",           $Data[0]->d9,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{NIVEL_HAY}",              $nivel_HAY_txt,         $PRINCIPAL);
    $UsuSSNN=DatosUsuario_(LimpiaRutFront($Data[0]->d11), $id_empresa);
    $UsuJEFE=DatosUsuario_(LimpiaRutFront($Data[0]->d12), $id_empresa);

    

    /*$EsJefe=EsJefetblUsuario($rut, $id_empresa);
        if($EsJefe>0){
            $es_jefe="LIDER";
        } else {
            $es_jefe="NO LIDER";
        }*/
    $PRINCIPAL = str_replace("{NOMBRE_SSNN}",      $UsuSSNN[0]->nombre_completo,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_LIDER}",     $UsuJEFE[0]->nombre_completo,           $PRINCIPAL);
    $PRINCIPAL = str_replace("{TIPO_DE_CARGO}",    "FALTA TIPO CARGO",          $PRINCIPAL);
    $PRINCIPAL = str_replace("{LIDER_NO_LIDER}",   $Data[0]->d10,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{NIVEL_R}",          "Nivel R: ".$Data[0]->d16,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FACILITADOR_ACADEMIA}",  "",          $PRINCIPAL);
    global $periodo_A,$periodo_B,$periodo_C;
    $PRINCIPAL = str_replace("{YEAR_A}",  $periodo_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{YEAR_B}",  $periodo_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{YEAR_C}",  $periodo_C,          $PRINCIPAL);
    $Desempeno_ficha_A            =     Ficha_Desempeno_ficha($periodo_A, $rut);
    $Desempeno_promedios_ficha_A  =     Ficha_Desempeno_promedio_ficha($periodo_A, $rut);

    
    if($Desempeno_ficha_A[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_A[0]->promedio==""){
        
        $Desempeno_promedios_ficha_A=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_A);
        $Desempeno_promedios_ficha_A[0]->promedio=round(($Desempeno_promedios_ficha_A[0]->acd+$Desempeno_promedios_ficha_A[0]->imp+$Desempeno_promedios_ficha_A[0]->sac+$Desempeno_promedios_ficha_A[0]->lob)/4,2);
        
    }
    $PRINCIPAL = str_replace("{DESEMPENO_A}",                   $Desempeno_ficha_A[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_A}",          $Desempeno_promedios_ficha_A[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_A}",        $Desempeno_promedios_ficha_A[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_A}",    $Desempeno_ficha_A[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_A}",    $Desempeno_ficha_A[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_A}",    $Desempeno_ficha_A[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_A}",        $Desempeno_promedios_ficha_A[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_A}",    $Desempeno_ficha_A[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_A}",    $Desempeno_ficha_A[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_A}",    $Desempeno_ficha_A[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_A}",    $Desempeno_ficha_A[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_A}",    $Desempeno_ficha_A[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_A}",        $Desempeno_promedios_ficha_A[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_A}",    $Desempeno_ficha_A[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_A}",    $Desempeno_ficha_A[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_A}",    $Desempeno_ficha_A[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_A}",        $Desempeno_promedios_ficha_A[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_A}",    $Desempeno_ficha_A[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_A}",    $Desempeno_ficha_A[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_A}",    $Desempeno_ficha_A[0]->lob_3_1,          $PRINCIPAL);

    $Desempeno_ficha_B            =     Ficha_Desempeno_ficha($periodo_B, $rut);
    $Desempeno_promedios_ficha_B  =     Ficha_Desempeno_promedio_ficha($periodo_B, $rut);


    
    if($Desempeno_ficha_B[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_B[0]->promedio==""){
        
        $Desempeno_promedios_ficha_B=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_B);
        
        $Desempeno_promedios_ficha_B[0]->promedio=round(($Desempeno_promedios_ficha_B[0]->acd+$Desempeno_promedios_ficha_B[0]->imp+$Desempeno_promedios_ficha_B[0]->sac+$Desempeno_promedios_ficha_B[0]->lob)/4,2);
    }

    $PRINCIPAL = str_replace("{DESEMPENO_B}",                   $Desempeno_ficha_B[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_B}",          $Desempeno_promedios_ficha_B[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_B}",        $Desempeno_promedios_ficha_B[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_B}",    $Desempeno_ficha_B[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_B}",    $Desempeno_ficha_B[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_B}",    $Desempeno_ficha_B[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_B}",        $Desempeno_promedios_ficha_B[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_B}",    $Desempeno_ficha_B[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_B}",    $Desempeno_ficha_B[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_B}",    $Desempeno_ficha_B[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_B}",    $Desempeno_ficha_B[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_B}",    $Desempeno_ficha_B[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_B}",        $Desempeno_promedios_ficha_B[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_B}",    $Desempeno_ficha_B[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_B}",    $Desempeno_ficha_B[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_B}",    $Desempeno_ficha_B[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_B}",        $Desempeno_promedios_ficha_B[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_B}",    $Desempeno_ficha_B[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_B}",    $Desempeno_ficha_B[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_B}",    $Desempeno_ficha_B[0]->lob_3_1,          $PRINCIPAL);

    $Desempeno_ficha_C            =     Ficha_Desempeno_ficha($periodo_C, $rut);
    $Desempeno_promedios_ficha_C  =     Ficha_Desempeno_promedio_ficha($periodo_C, $rut);
    
    if($Desempeno_ficha_C[0]->acd_1_1<>"" and $Desempeno_promedios_ficha_C[0]->promedio==""){
        
        $Desempeno_promedios_ficha_C=Ficha_Calculo_Promedio_Competencias_2023_data($rut, $periodo_C);
        
        $Desempeno_promedios_ficha_C[0]->promedio=round(($Desempeno_promedios_ficha_C[0]->acd+$Desempeno_promedios_ficha_C[0]->imp+$Desempeno_promedios_ficha_C[0]->sac+$Desempeno_promedios_ficha_C[0]->lob)/4,2);
    }

    $PRINCIPAL = str_replace("{DESEMPENO_C}",                   $Desempeno_ficha_C[0]->desempeno,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_PROMEDIO_C}",          $Desempeno_promedios_ficha_C[0]->promedio,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA1_C}",        $Desempeno_promedios_ficha_C[0]->acd,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA11_C}",    $Desempeno_ficha_C[0]->acd_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA12_C}",    $Desempeno_ficha_C[0]->acd_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA13_C}",    $Desempeno_ficha_C[0]->acd_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA2_C}",        $Desempeno_promedios_ficha_C[0]->imp,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA21_C}",    $Desempeno_ficha_C[0]->imp_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA22_C}",    $Desempeno_ficha_C[0]->imp_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA23_C}",    $Desempeno_ficha_C[0]->imp_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA24_C}",    $Desempeno_ficha_C[0]->imp_4_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA25_C}",    $Desempeno_ficha_C[0]->imp_5_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA3_C}",        $Desempeno_promedios_ficha_C[0]->sac,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA31_C}",    $Desempeno_ficha_C[0]->sac_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA32_C}",    $Desempeno_ficha_C[0]->sac_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA33_C}",    $Desempeno_ficha_C[0]->sac_3_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_CATEGORIA4_C}",        $Desempeno_promedios_ficha_C[0]->lob,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA41_C}",    $Desempeno_ficha_C[0]->lob_1_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA42_C}",    $Desempeno_ficha_C[0]->lob_2_1,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{DESEMPENO_SUBCATEGORIA43_C}",    $Desempeno_ficha_C[0]->lob_3_1,          $PRINCIPAL);
    //desempeno_metas

    $Meta_A = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_A));
    $Meta_B = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_B));
    $Meta_C = utf8_decode(Ficha_Desempeno_Metas_2023_data($rut, $periodo_C));
    $PRINCIPAL = str_replace("{METAS_A}",  $Meta_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{METAS_B}",  $Meta_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{METAS_C}",  $Meta_C,          $PRINCIPAL);

    $Cuadrante_Vigente = (Ficha_Cuadrantes_2023_data($rut, "vigente"));
    $Cuadrante_Anterior = (Ficha_Cuadrantes_2023_data($rut, "anterior"));
    

    /*if($Perfil=="TALENTO"){

    } else {
        $Cuadrante_Vigente = (Ficha_Cuadrantes_2023_data($rut, "vigente"));
        $Cuadrante_Anterior = (Ficha_Cuadrantes_2023_data($rut, "anterior"));
    }*/

    $PRINCIPAL = str_replace("{CUADRANTE_VIGENTE}",        $Cuadrante_Vigente[0]->cuadrante,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_FECHA_VIGENTE}",  Ficha_Traduccion_Fecha_espanol($Cuadrante_Vigente[0]->fecha),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_VIGENTE_CLASE}",  $Cuadrante_Vigente[0]->clase,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_ANTERIOR}",        $Cuadrante_Anterior[0]->cuadrante,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_FECHA_ANTERIOR}",  Ficha_Traduccion_Fecha_espanol($Cuadrante_Anterior[0]->fecha),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CUADRANTE_ANTERIOR_CLASE}",  $Cuadrante_Anterior[0]->clase,          $PRINCIPAL);


    if($Cuadrante_Vigente[0]->cuadrante==""){
        $PRINCIPAL = str_replace("{DISPLAY_POTENCIAL}",      "display:none!important;",          $PRINCIPAL);
    }
    if($Cuadrante_Anterior[0]->cuadrante==""){
        $PRINCIPAL = str_replace("{DISPLAY_POTENCIAL_ANTERIOR}",      "display:none!important;",          $PRINCIPAL);
    }

    $ENGAGEMENT_A   = Ficha_Engagement_2023_data($rut, $periodo_A);
    $ENGAGEMENT_B   = Ficha_Engagement_2023_data($rut, $periodo_B);
    $ENGAGEMENT_C   = Ficha_Engagement_2023_data($rut, $periodo_C);
    $PRINCIPAL = str_replace("{ENGAGEMENT_A}",  $ENGAGEMENT_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ENGAGEMENT_B}",  $ENGAGEMENT_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{ENGAGEMENT_C}",  $ENGAGEMENT_C,          $PRINCIPAL);

    $CLIMA_A   = Ficha_Clima_2023_data($rut, $periodo_A);
    $CLIMA_B   = Ficha_Clima_2023_data($rut, $periodo_B);
    $CLIMA_C   = Ficha_Clima_2023_data($rut, $periodo_C);
    $PRINCIPAL = str_replace("{CLIMA_A}",  $CLIMA_A,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CLIMA_B}",  $CLIMA_B,          $PRINCIPAL);
    $PRINCIPAL = str_replace("{CLIMA_C}",  $CLIMA_C,          $PRINCIPAL);

    if($ENGAGEMENT_A=="" and $ENGAGEMENT_B==""  and $ENGAGEMENT_B=="" and $CLIMA_A=="" and $CLIMA_B=="" and $CLIMA_C==""){
        $PRINCIPAL = str_replace("{DISPLAY_ENGAGEMENT_CLIMA}",  "display:none!important",          $PRINCIPAL);
    }

    $SkillChallenge=Ficha_SkillChallenge_2023_data($rut);
        foreach ($SkillChallenge as $sk){
            $cuenta_skillchallenges++;
            IF($sk->estado_skill_cursos=="EXIMIDA_AUTO"){
                $sk->estado_skill_cursos="Skill Eximida";
            }
            $row_skill_challenge.="  <tr><td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($sk->skill)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href=''>".utf8_encode($sk->nom_nivel_skill)."</a></td>
                                        <td>".utf8_encode($sk->estado_skill_cursos)."</td>
                                    </tr>";
            $cargo_oficial_sk=$sk->cargo;
        }
    $PRINCIPAL = str_replace("{CARGO_OFICIAL_SKILLCHALLENGE}",              utf8_decode($cargo_oficial_sk),          $PRINCIPAL);
    $PRINCIPAL = str_replace("{FICHA_COLABORADOR_ROW_SKILL_CHALLENGE}",     utf8_decode($row_skill_challenge),          $PRINCIPAL);

    if($cuenta_skillchallenges>0){
        $display_none_skillchallenge=" ";
    } else {
        $display_none_skillchallenge=" display:none !important; ";
    }
    $PRINCIPAL = str_replace("{DISPLAY_NONE_SKILL_CHALLENGE}",  $display_none_skillchallenge,          $PRINCIPAL);

    $Premiaciones=Ficha_Premiaciones_2023_data($rut);
    foreach ($Premiaciones as $pr){
        $cuenta_premiaciones++;
        $row_premiaciones.="        <tr>
                                        <td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($pr->tipo)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href='' style='padding-left: 10px;'>".utf8_encode($pr->periodo)."</a></td>
                                    </tr>";
    }

    if($cuenta_premiaciones>0){
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_PREMIACIONES_2023}",  utf8_decode($row_premiaciones),          $PRINCIPAL);
    } else {
        $PRINCIPAL = str_replace("{DISPLAY_NONE_PREMIACIONES_2023}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_PREMIACIONES}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_PREMIACIONES_2023}",  "<div style='padding-left: 30px;'>Sin Premiaciones</div>",          $PRINCIPAL);
    }

    $AccionesDesarrollo=Ficha_AccionesDesarrollo_2023_data($rut);
    
    foreach ($AccionesDesarrollo as $ad){
        $cuenta_accionesdesarrollo++;
        $row_acciones_desarrollo.="  <tr><td class='ps-9'><span class='badge badge-light-primary fs-7 fw-bold'>".utf8_encode($ad->tipo)."</span></td>
                                        <td class='ps-0'><a class='text-hover-primary text-gray-600' href=''  style='padding-left: 10px;'>".utf8_encode($ad->periodo)."</a></td>
                                    </tr>";
    }
    if($cuenta_accionesdesarrollo>0){
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_ACCIONES_DESARROLLO_2023}",  utf8_decode($row_acciones_desarrollo),          $PRINCIPAL);
    } else {
        $PRINCIPAL = str_replace("{ROW_FICHA_COLABORADOR_ACCIONES_DESARROLLO_2023}",  "<div style='padding-left: 30px;'>Sin Acciones de Desarrollo</div>",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_NONE_ACCIONES_DESARROLLO_2023}",  "display:none!important;",          $PRINCIPAL);
        $PRINCIPAL = str_replace("{DISPLAY_ACCIONES}",  "display:none!important;",          $PRINCIPAL);
    }
    return ($PRINCIPAL);
}
function Ficha_Desempeno_Meta($tabla, $rut){

    $Datos=Ficha_Desempeno_Meta_data($tabla, $rut);
    return $Datos;
}

function calcular_edad_2023($fecha_nacimiento_sp){

    list($day, $month, $year) = explode("-", $fecha_nacimiento_sp);

    // Calculate the current date
    $currentDate = date("d-m-Y");
    list($currentDay, $currentMonth, $currentYear) = explode("-", $currentDate);

    // Calculate the age in years
    $ageYears = $currentYear - $year;

    // Calculate the age in months
    if ($currentMonth >= $month) {
        $ageMonths = $currentMonth - $month;
        if ($currentDay < $day) {
            $ageMonths--;
            if ($ageMonths < 0) {
                $ageMonths += 12;
                $ageYears--;
            }
        }
    } else {
        $ageMonths = 12 - ($month - $currentMonth);
        $ageYears--;
    }

    // Return the age in the format "X years and Y months"
    return $ageYears . "a " . $ageMonths . "m";
}