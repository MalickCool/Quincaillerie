<section role="main" class="content-body">
    <!-- start: page -->
	<header class="panel-heading">
		<h2 class="panel-title" style="color: #000000; text-align: center; padding: 10px">
			<?= $message ?>
		</h2>
	</header>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
        <tr style="width: 100%; border: solid; border-color: #000;">
            <th style="width: 40%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Nom & Prénom
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Adresse
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Email
            </th>
            <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Contact
            </th>
            <th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Etat
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        <?php foreach ($clients as $item):?>
            <?php
            $status = "Activer";
            if($item->etat  > 0)
                $status = "Désactiver";
            ?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->nom,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->adresse,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->email,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->phone,ENT_QUOTES,'UTF-8');?>
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
