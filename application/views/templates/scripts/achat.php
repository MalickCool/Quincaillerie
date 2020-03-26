<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 25/02/2019
 * Time: 10:57
 */
?>
<script>

    $('#qte').keyup(function () {
        pu = $('#pu').val();

        if(pu > 0){
            $('#total').val(parseInt(pu) * $(this).val())
        }
    });

    $('#pu').keyup(function () {
        qte = $('#qte').val();

        if(qte > 0){
            $('#total').val(parseInt(qte) * $(this).val())
        }
    });

    $('#addToTable').click(function(){

        intrant = $('#intrant').select2('data')[0];

        qte = $('#qte').val();

        pu = $('#pu').val();

        valActuelle = $('.total').text();

        if(intrant.text !== '' && qte > 0 && pu > 0){

            tempInput = $('#int_'+ intrant.id).length;

            if(tempInput <= 0){

                tempValActuelle = parseInt(valActuelle) + ( parseInt(qte) * parseInt(pu) );

                $('.total').text(tempValActuelle);

                td = "<td id='name_"+intrant.id+"'>"+intrant.text+"</td>";
                inputs = "<input name='product[]' type='hidden' value='"+intrant.id+"' />";

                td += "<td>"+qte+"</td>";
                inputs += "<input name='qte[]' type='hidden' value='"+qte+"' />";

                td += "<td>"+pu+"</td>";
                inputs += "<input name='pu[]' type='hidden' value='"+pu+"' />";



                td += "<td class='tot'>"+parseInt(pu * qte)+"</td>";

                td += "<td><button type='button' class='btn btn-danger removeBtn' id='"+intrant.id+"'> Retirer</button></td>";

                tr = "<tr id='tr_"+intrant.id+"'>"+td+"</tr>";
                elem = "<div id='elem_"+intrant.id+"'>"+ inputs +"</div>";

                $('#tbody').append(tr);
                $('#formulaire').append(elem);

                $('#qte').val("");
                $('#pu').val("");
                $('#total').val("");
            }else{
                alert("Cet intrant à déjà été ajouter à ce lieux de stockage");
            }

            $('#intrant option[value='+intrant.id+']').remove();
            $('#intrant').trigger('change');
        }else{
            alert('Champs vide');
        }
    });

    $(document).on("click",".removeBtn",function() {
        id = $(this).attr('id');

        theName = $('#name_'+id).text();

        $('#intrant').append("<option value='"+ id +"'>"+ theName +"</option>");
        $('#intrant').trigger('change');

        valActuelle = $('.total').text();

        tempValActuelle = parseInt(valActuelle) - parseInt($('#tr_'+id+' .tot').text());

        $('.total').text(tempValActuelle);

        $('#tr_'+id).remove().fadeOut();
        $('#elem_'+id).remove().fadeOut();
    });
</script>
