<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">

    </header>

    <h2 class="panel-title" style="color: #000000; text-align: center; padding-top: 60px; padding-bottom: 25px">
        <?= $message ?>
    </h2>

    <div style="padding-bottom: 0px">
        <b>N° Commande: </b><?= date("Y/m/", strtotime($commande->datecommande))."_".$commande->idcommande ?>
    </div>

    <div style="padding-bottom: 0px">
        <b>N° Client: </b>C<?= str_pad($returnArray['Client']->idclient, 5, "0", STR_PAD_LEFT); ?>
    </div>

    <div style="padding-bottom: 0px">
        <b>Client: </b><?= $returnArray['Client']->nom ?>
    </div>

    <div style="padding-bottom: 20px">
        <b>Mode de Paiement: </b><?= ucwords($paiement->typepaiement) ?>
    </div>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Date
                </th>
                <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Montant Commande
                </th>
                <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Montant Réglé
                </th>
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Montant Versement
                </th>
                <th style="width: 14%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Reste
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= date('d/m/Y', strtotime($paiement->datepaiement)) ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($returnArray['TotalTTC']) ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($oldPaiement) ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($paiement->montant) ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?= $this->commande_m->formatNumber($returnArray['TotalTTC'] - ($oldPaiement + $paiement->montant)) ?>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
