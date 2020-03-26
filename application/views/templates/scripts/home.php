<?php
/**
 * Created by PhpStorm.
 * User: Malick Coulibaly
 * Date: 18/07/2019
 * Time: 10:57
 */
?>
<script>
    setInterval(function(){

        var config = {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        };
        axios.post('<?= site_url('accueil/statVente');?>', 'hh', config)
            .then(function (response) {
                data = response.data;

                var dates = [];
                var ventes = [];
                var depenses = [];

                for(i in data) {
                    dates.push(data[i].Jour);

                    if(data[i].Vente == null){
                        ventes.push(0);
                    }else{
                        ventes.push(parseInt(data[i].Vente));
                    }

                    if(data[i].Depense == null){
                        depenses.push(0);
                    }else{
                        depenses.push(parseInt(data[i].Depense));
                    }
                }

                var chartdata = {
                    labels: dates,
                    datasets: [
                        {
                            label: "Dépenses",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#fff",
                            borderColor: "red",
                            pointHoverBackgroundColor: "red",
                            pointHoverBorderColor: "red",
                            data: depenses
                        },
                        {
                            label: "Ventes",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#fff",
                            borderColor: "#2ecc71",
                            pointHoverBackgroundColor: "#2ecc71",
                            pointHoverBorderColor: "#2ecc71",
                            data: ventes
                        }
                    ]
                };

                var ctx = $("#line-chart");

                var LineGraph = new Chart(ctx, {
                    type: 'line',
                    options: {
                        animation: {
                            duration: 0
                        }
                    },
                    data: chartdata
                });
            })
            .catch(function (error) {
                //console.log(error);
            });
    }, 1000);

    setInterval(function(){

        var config = {
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
        };
        axios.post('<?= site_url('accueil/statCoutProd');?>', 'hh', config)
            .then(function (response) {
                data = response.data;

                var dates = [];
                var ventes = [];
                var productions = [];

                for(i in data) {
                    dates.push(data[i].Jour);

                    if(data[i].Vente == null){
                        ventes.push(0);
                    }else{
                        ventes.push(parseInt(data[i].Vente));
                    }

                    if(data[i].Production == null){
                        productions.push(0);
                    }else{
                        productions.push(parseInt(data[i].Production));
                    }
                }

                var chartdata2 = {
                    labels: dates,
                    datasets: [
                        {
                            label: "Coût de Production Total",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#fff",
                            borderColor: "red",
                            pointHoverBackgroundColor: "red",
                            pointHoverBorderColor: "red",
                            data: productions
                        },
                        {
                            label: "Total des Ventes",
                            fill: false,
                            lineTension: 0.1,
                            backgroundColor: "#fff",
                            borderColor: "#2ecc71",
                            pointHoverBackgroundColor: "#2ecc71",
                            pointHoverBorderColor: "#2ecc71",
                            data: ventes
                        }
                    ]
                };

                var ctx2 = $("#line-chart2");

                var LineGraph2 = new Chart(ctx2, {
                    type: 'line',
                    options: {
                        animation: {
                            duration: 0
                        }
                    },
                    data: chartdata2
                });
            })
            .catch(function (error) {
                //console.log(error);
            });
    }, 10000);


    function scrollTo( target ) {
        if( target.length ) {
            $("html, body").stop().animate( { scrollTop: target.offset().top }, 1500);
        }
    }

    $('#outOfStock').click(function(){
        scrollTo( $("#outOfStockAnchor") );
    });




</script>