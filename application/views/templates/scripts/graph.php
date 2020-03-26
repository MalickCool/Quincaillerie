<?php
/**
 * Created by PhpStorm.
 * User: GLORIA TECHNOLOGY
 * Date: 29/07/2019
 * Time: 14:50
 */
?>
<script>
    data = <?= $return ?>;

    var dates = [];
    var productionss = [];

    for(i in data) {
        dates.push(data[i].Jour);

        productionss.push(parseInt(data[i].Productions));

        /*if(data[i].Production == null){
            productionss.push(0);
        }else{

        }*/
    }

    console.log(productionss);

    var chartdata2 = {
        labels: dates,
        datasets: [
            {
                label: "Coût de Production Moyen",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "#fff",
                borderColor: "red",
                pointHoverBackgroundColor: "red",
                pointHoverBorderColor: "red",
                data: productionss
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

</script>
