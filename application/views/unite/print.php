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
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Désignation
            </th>

            <th style="width: 35%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Symbole
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Type
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Nbre Bout.
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Format
            </th>
        </tr>
        </thead>
        <tbody>

            <?php
                foreach ($unites as $item) {
                    $status = "Activer";
                    if($item->etat  > 0)
                        $status = "Désactiver";
                    ?>
                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->designation ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->symbole ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= ucfirst($item->type) ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->nbrebout ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?= $item->valeur ?> cl
                        </td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
