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
                Date
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Heure
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Point de Vente
            </th>
            <th style="width: 40%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Produit
            </th>
            <th style="width: 15%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Quantité Perdue
            </th>
        </tr>
        </thead>
        <tbody>
        <?php
            if(isset($details) AND !empty($details)){
                foreach ($details as $detail) {
                    ?>
                    <tr>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?php echo htmlspecialchars($detail['date'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?php echo htmlspecialchars($detail['heure'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?php echo htmlspecialchars($detail['Point'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?php echo htmlspecialchars($detail['Produit'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                        <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                            <?php echo htmlspecialchars($detail['quantite'], ENT_QUOTES, 'UTF-8'); ?>
                        </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
