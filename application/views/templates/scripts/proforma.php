<script>
    $('#ajouter').click(function (event) {
        event.preventDefault();
        var input = $('#add').html();
        $('#add2').append(input);
    });


    $(document).on("change", '.theSelect', function (){
        var x = $(this).find('option:selected').attr('lang');
        $(this).parent().parent().find('.theQte').val(0);
        console.log(x);
    });

    $(document).on('keyup', '.theQte', function () {
        var x = $(this).parent().parent().parent().find('option:selected').attr('lang');

        var remise = $(this).parent().parent().parent().find('.theRemise').val();


        if(remise !== ''){
            x = parseInt(x) - parseInt(remise);
        }


        if(x >= 0){
            var result = parseInt(x) * parseInt($(this).val());
            console.log(result);

            $(this).parent().parent().parent().find('.theTotal').val(result);

            var transport = 0;


            var mht = 0;
            $("#fieldset .theTotal").each(function() {
                mht += parseInt($( this ).val());
            });

            let remiseFacture = $('#remiseMtnt').val();

            if(remiseFacture === ''){
                remiseFacture = 0;
            }

            var mhtAvecTransport = mht + parseInt(transport);

            mhtAvecTransport -= remiseFacture;

            $('#mht').val(mhtAvecTransport);
            $('#htWithoutTransport').val(mht);

            var tauxTVA = $("#tva").find('option:selected').attr('lang');

            var mttc = parseInt(mht) + (parseInt(mht) * parseInt(tauxTVA) / 100);


            var mttcAvecTransport = mttc + parseInt(transport);


            mttcAvecTransport -= parseInt(remiseFacture);
            //mttc -= parseInt(remiseFacture);

            $('#mttc').val(mttcAvecTransport);
            $('#rap').val(mttcAvecTransport);
            $('#montP').val(0);

            $('#ttcWithoutTransport').val(mttc);
        }
    });

    $("#filedset0 .theTVA").change(function () {
        var tauxTVA = $("#filedset0 .theTVA").find('option:selected').attr('lang');

        var mht = $('#mht').val();

        var transport = 0;

        mht -= transport;

        if(mht > 0){
            var mttc = parseInt(mht) + (parseInt(mht) * parseInt(tauxTVA) / 100);

            var mttcAvecTransport = mttc + parseInt(transport);

            $('#mttc').val(mttcAvecTransport);
            $('#rap').val(mttcAvecTransport);
            $('#montP').val(0);

            $('#ttcWithoutTransport').val(mttc);

            alert(mttc);
        }
    });

    $('#add2').on("click","#suppr", function (event) {
        event.preventDefault();
        var totalHT = $(this).parent().parent().parent().find('.theTotal').val();

        //let remise = $('#remiseMtnt').val();
        let remise = 0;

        //console.log(totalHT);

        var tauxTVA = $("#filedset0 .theTVA").find('option:selected').attr('lang');

        var mht = $('#mht').val() - parseInt(totalHT) - parseInt(remise);

        console.table(mht);

        //var transport = $('#transport_id option:selected').attr('lang');

        //var mhtSansTransport = mht - parseInt(transport);

        $('#mht').val(mht);
        $('#htWithoutTransport').val(mht);

        if(mht > 0){
            var mttc = parseInt(mht) + (parseInt(mht) * parseInt(tauxTVA) / 100);

            $('#mttc').val(mttc);
            $('#rap').val(mttc);
            $('#montP').val(0);

            $('#ttcWithoutTransport').val(mttc);
        }

        $(this).parent().parent().parent().remove();
    });

    $('#remiseMtnt').keyup(function () {
        var transport = 0;

        let ttc = $('#ttcWithoutTransport').val();
        let ht = $('#htWithoutTransport').val();
        let remise = $('#remiseMtnt').val();

        console.log(ht);

        if(remise === "")
            remise = 0;

        let mht = parseInt(ht) + parseInt(transport) - parseInt(remise);

        let mttc = parseInt(ttc) + parseInt(transport) - parseInt(remise);



        $('#mttc').val(mttc);
        $('#rap').val(mttc);
        $('#montP').val(0);

        $('#mht').val(mht);
    });

    $('#montP').focusin(function () {
        if($(this).val() == 0){
            $(this).val('');
		}
    });

    $('#montP').keyup(function () {

        let ttc = $('#mttc').val();

        let rap = ttc - $(this).val();

        if(rap < 0)
            rap = 0;

        $('#rap').val(rap);

        if(rap > 0){
            $('#echeanceDiv').removeClass("d-none");
            $('#echeance').attr("required", "required");
        }else{
            $('#echeanceDiv').addClass("d-none");
            $('#echeance').removeAttr("required");
        }

    });

    $(document).on('keyup', '.theRemise', function () {
        console.log("gh");
        var theQte = $(this).parent().parent().parent().find('.theQte');

        theQte.trigger('keyup');
        $(this).focus();
    });

    $('#montV').keyup(function () {
        var montVerse = $(this).val();
        var montTTC = $('#totalTTC').val();

        var reste = parseInt(montTTC) - parseInt(montVerse);

        if(reste < 0)
            reste = 0;

        $('#reste').val(reste+" FCFA")
    });
</script>
