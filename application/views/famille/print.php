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
            <th style="width: 60%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Désignation
            </th>
            <th style="width: 40%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Etat
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        <?php foreach ($familles as $famille):?>
            <?php
                $status = "Activer";
                if($famille->etat  > 0)
                    $status = "Désactiver";
                ?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($famille->libelle,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($status,ENT_QUOTES,'UTF-8');?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
