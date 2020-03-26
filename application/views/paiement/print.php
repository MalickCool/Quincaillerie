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
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Date
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                N° Commande
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Payer Par
            </th>

            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Moyen de Paiement
            </th>

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Encaissé par
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant
            </th>
        </tr>
        </thead>
        <tbody>
            <?php
                $montant = 0;
                foreach ($paiements as $paiement){
                    $montant += $paiement->montant;
                    ?>
                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= date('d/m/Y', strtotime($paiement->datepaiement)) ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= date('Y/m/', strtotime($paiement->token))."_".$paiement->commande_id;  ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= ucwords($paiement->nompayeur) ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= ucfirst($paiement->typepaiement) ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->ion_auth->user($paiement->userid)->row()->first_name." ".$this->ion_auth->user($paiement->userid)->row()->last_name ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->commande_m->formatNumber($paiement->montant) ?> FCFA
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left; font-weight: bold; font-size: 18px" colspan="5">Total Encaissé:</td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold; font-size: 18px"><?= $this->commande_m->formatNumber($montant) ?> FCFA</td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
