<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">
        <h2 class="panel-title" style="color: #000000; text-align: center; border: solid; border-bottom-color: #0a001f; padding: 10px; border-radius: 15px">
            <?= $message ?>
        </h2>
    </header>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
        <tr style="width: 100%; border: solid; border-color: #000;">
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Date
            </th>
            <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                N° Commande
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Client
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant HT
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant TTC
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Status
            </th>
            <th style="width: 16%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Reste à Payer
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $montant = 0 ?>
        <?php foreach ($commandes as $commande):?>
            <?php
            $montant += $commande['Reste'];
            ?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= date('d/m/Y', strtotime($commande['Commande']->datecommande)) ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $commande['Commande']->idcommande ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $commande['Client']->nom ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($commande['Commande']->montant) ?> FCFA
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($commande['MontTTC']) ?> FCFA
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php
                    if($commande['Commande']->etat == 1){
                        if($commande['Reste'] > 0){
                            echo "Non Soldée";
                        }else{
                            echo "Soldée";
                        }
                    }else{
                        echo "Non Validée";
                    }
                    ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($commande['Reste']) ?> FCFA
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="6" style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 16px">Total Reste à Payer</td>
            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold; font-size: 16px">
                <?= $this->commande_m->formatNumber($montant) ?> FCFA
            </td>
        </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
