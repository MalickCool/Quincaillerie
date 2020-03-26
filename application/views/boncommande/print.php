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
            <th style="width: 40%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Intrant
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Quantité Physique
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Poids Total
            </th>

            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Seuil d'alerte
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        <?php foreach ($stocks as $item):?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item['designation'],ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item['Qte'],ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($this->stock_m->formatNumber($item['Poids'])." ".$item['unite'],ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item['seuil'],ENT_QUOTES,'UTF-8');?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
