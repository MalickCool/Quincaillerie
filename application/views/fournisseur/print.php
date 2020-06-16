<section role="main" class="content-body">
    <!-- start: page -->
	<h2 class="panel-title" style="color: #000000; text-align: center; padding-bottom: 25px">
		<?= $message ?>
	</h2>

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
        <tr style="width: 100%; border: solid; border-color: #000;">
            <th style="width: 25%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Structure
            </th>
            <th style="width: 12%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Contact
            </th>
            <th style="width: 12%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Email
            </th>

			<th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Représentant
			</th>
			<th style="width: 12%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Fonction
			</th>
			<th style="width: 10%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Contact Professionnel
			</th>
			<th style="width: 12%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
				Contact Personnel
			</th>

        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        <?php foreach ($fournisseurs as $item):?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->designation,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->contact,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->email,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($item->nomRep,ENT_QUOTES,'UTF-8');?>
                </td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
					<?php echo htmlspecialchars($item->fonction,ENT_QUOTES,'UTF-8');?>
				</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
					<?php echo htmlspecialchars($item->contactProfessionnel,ENT_QUOTES,'UTF-8');?>
				</td>
				<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
					<?php echo htmlspecialchars($item->contactPersonnel,ENT_QUOTES,'UTF-8');?>
				</td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
