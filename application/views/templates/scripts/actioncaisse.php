<script>

    $('#openCaisse').click(function (event) {
        event.preventDefault();

        const login = $("#utilisateur").val();
        const password = $("#password").val();
        const token = $("#token").val();

        if(login.length > 5 && password.length > 5){

            params = new FormData();

            params.append( 'identity', login);
            params.append( 'password', password);
            params.append( 'token', token);

            var config = {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            };
            axios.post('<?= site_url('auth/ajaxLogin');?>', params, config)
                .then(function (response) {
                    alert("Ouverture de Caisse effectuée");

                    window.location.href = $('#link').val();
                })
                .catch(function (error) {
                    console.log(error);
                });
		}
    });

    $('#password').keyup(function () {
        const login = $("#utilisateur").val();
        const password = $("#password").val();
        $('#changeName').html('');

        if(login.length > 5 && password.length > 5){

            params = new FormData();

            params.append( 'identity', login);
            params.append( 'password', password);

            var config = {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            };
            axios.post('<?= site_url('auth/ajaxLoginGetOnlyInfo');?>', params, config)
                .then(function (response) {
                    const data = response.data;

                    //console.table(response.data);

					if(data.length !== 0){
                        console.log(data.username);
                        $('#changeName').append(data.first_name+" "+data.last_name);

					}

                })
                .catch(function (error) {
                    console.log(error);
                });
		}

    });


    $('#reOpenCaisse').click(function (event) {
        event.preventDefault();

        const login = $("#utilisateur").val();
        const password = $("#password").val();

        if(login.length > 5 && password.length > 5){

            params = new FormData();

            params.append( 'identity', login);
            params.append( 'password', password);
            params.append( 'token', token);

            var config = {
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
            };
            axios.post('<?= site_url('auth/ajaxLogin2');?>', params, config)
                .then(function (response) {
                    alert("Réouverture de Caisse effectuée");

                    window.location.href = $('#link').val();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    });

    $('.nombreBillet').keyup(function () {
        const soldeTheorique = parseInt($('#soldeTheorique').val());
        let valeur = 0;
        $('.nombreBillet').each(function () {
            const temp1 = $(this).val();
            const temp2 = $(this).parent().prev().attr('lang');
            valeur += (temp1 * temp2);
        });
        $('#montantEncaisser').val(accounting.formatNumber(valeur, 0, " "));
        $('#montPh').val(valeur);
        if(valeur !== soldeTheorique){
            $('#putRemarque').attr('required', 'required');
        }else{
            $('#putRemarque').removeAttr('required');
        }
    });
</script>
