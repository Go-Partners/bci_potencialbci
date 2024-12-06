function handleCredentialResponse(response) {
    var id_token = response.credential;

    grecaptcha.ready(function () {
        grecaptcha.execute('6LequgweAAAAAEr1BAG3nBxnrx56yFZXE9RlctBN', {action: 'login'}).then(function (token) {
            // Envía el token de Google y el token de reCAPTCHA al backend
            $.ajax({
                url: '?sw=checkUserBci',
                method: 'POST',
                data: {
                    id_token: id_token,
                    recaptcha_token: token
                },
                success: function (response) {
                    let datos = JSON.parse(response);
                    if(datos.success){
                        window.location.href = "https://www.potencialbci.cl/front/?sw=logext&rut_enc=" + datos.rut_enc;
                    }else{
                        alert(datos.message);
                    }
                }
            });
        });
    });
}
