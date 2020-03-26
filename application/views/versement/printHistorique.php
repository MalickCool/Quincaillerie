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
            <th style="width: 45%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Description
            </th>
            <th style="width: 25%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Montant
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Utilisateur
            </th>

        </tr>
        </thead>
        <tbody>
            <?php
                $total = 0;
                foreach ($details as $item) {
                    $total += $item->montant;
                    ?>
                    <tr>
                        <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= date('d/m/Y', strtotime($item->dateversement)) ?>
                        </td>
                        <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->motifversement ?>
                        </td>
                        <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->versement_m->formatNumber($item->montant) ?> FCFA
                        </td>
                        <td  style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $this->ion_auth->user($item->iduser)->row()->first_name." ".$this->ion_auth->user($item->iduser)->row()->last_name ?>
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold" colspan="2">Total Versement: </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center; font-weight: bold">
                    <?= $this->versement_m->formatNumber($total) ?> FCFA
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; font-weight: bold"></td>
            </tr>
        </tfoot>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
