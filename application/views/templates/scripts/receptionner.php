<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 25/02/2019
 * Time: 10:57
 */
?>
<script>

    $('.qte').keyup(function () {


        let qte = $(this).val();

        let pu = $(this).parent().parent().find('.pu').text();

        pu = pu.split(' ').join('');

        let oldTotalHT = $(this).parent().parent().find('.total').text();

        let totalHT = qte * parseInt(pu);

        let tva = $('#tva').text();

        let ttc = totalHT;

        if(tva === "Oui"){
            ttc = totalHT + (0.18 * totalHT);
		}

        $(this).parent().parent().find('.total').text(formatNumber(ttc));

        calculateTotal();
        $('#montantPayer').val(0);
        $('#reste').val(0);
        //console.log(formatNumber(ttc));
        //alert(ttc);

    });

    $('.entrepot').keyup(function(){
        let hisParent = $(this).parent().parent();

        let totalQte = hisParent.find('.qte').val();

        let allEntrepotsElement = $(this).parent().parent().find('.entrepot');

        let total = 0;

        allEntrepotsElement.each(function () {
            qte = $(this).val();
            if(qte !== '' && qte > 0){
                total += parseInt(qte);
			}
        });
        if(total > totalQte){
            $(this).val(0);
		}
	});

    function calculateTotal(){
        let total = 0;

        $('.total').each(function () {
			pu = $(this).text();
            pu = pu.split(' ').join('');

            total += parseInt(pu);
        });

        $('#theTotal').text(formatNumber(total));
	}

    $('#montantPayer').keyup(function () {

        var savaleur = $(this).val();

        let total = $('#theTotal').text();

        total = total.split(' ').join('');

        reste = total - savaleur;

        if(reste < 0)
            reste = 0;
        console.log(reste);

		$('#reste').val(formatNumber(reste));

		if(reste > 0){
            $('#echeanceDiv').removeClass("d-none");
            $('#echeance').attr("required", "required");
		}else{
            $('#echeanceDiv').addClass("d-none");
            $('#echeance').removeAttr("required");
		}

    });
</script>
