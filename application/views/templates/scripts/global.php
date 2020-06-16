<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 25/02/2019
 * Time: 10:57
 */
?>
<script>

    $('#montV').keyup(function () {

        let montVerse = $(this).val();
        if(montVerse === '')
            montVerse = 0;

        var montTTC = $('#totalTTC').val();

        var reste = parseInt(montTTC) - parseInt(montVerse);

        console.log(montVerse);

        if(reste <= 0){
            reste = 0;
            $('.echeanceDiv').addClass('d-none');
        }else{
            $('.echeanceDiv').removeClass('d-none');
        }

        reste = formatNumber(reste, 0, " ");
        $('#reste').val(reste+" FCFA")
    });


    $('#chbRDV').change(function() {
        if ($(this).is(':checked')) {
            $('#dateRDVDiv').removeClass('d-none');
        }else{
            $('#dateRDVDiv').addClass('d-none');
        }
    });



    $('#moyen').change(function () {
        if($(this).val() === 'cheque'){
            $('.chequeDiv').removeClass('d-none');
            $('#numCheque').attr('required', 'required');
            $('#banque').attr('required', 'required');
        }else{
            $('.chequeDiv').addClass('d-none');
            $('#numCheque').removeAttr('required', 'required');
            $('#banque').removeAttr('required', 'required');
        }
    });

    $('#typeDepense').change(function () {
        let id = $(this).val();

        if(id == 2){
            $('.depBenef').addClass('d-none');
            $('.founisseurDiv').addClass('d-none');
        }else{
            $('.depBenef').removeClass('d-none');
            $('.founisseurDiv').removeClass('d-none');
        }
    });

    $('#type_client').change(function () {
        let type = $(this).val();

        if(type == 'revendeur'){
            $('#form-ncc').removeClass('d-none');
        }else{
            $('#form-ncc').addClass('d-none');
            $('#ncc').val('');
        }
    });

    $('.modalClick').click(function () {
		let id = $(this).attr('id');

		$('#achat').val(id);

        $('#modal-default').modal('show');
    });


</script>
