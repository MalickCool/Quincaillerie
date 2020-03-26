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
            <th style="width: 40%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Lieu de Stockage
            </th>
            <th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                Effectué par
            </th>
        </tr>
        </thead>
        <tbody>
        <?php $total = 0 ?>
        <?php foreach ($inventaires as $inventaire):?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo date("d/m/Y", strtotime($inventaire->dateinventaire)); ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo date("H:i:s", strtotime($inventaire->heureinventaire)); ?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($inventaire->designation,ENT_QUOTES,'UTF-8');?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
                    <?php echo htmlspecialchars($this->ion_auth->user($inventaire->iduser)->row()->first_name." ".$this->ion_auth->user($inventaire->iduser)->row()->last_name,ENT_QUOTES,'UTF-8');?>
                </td>

            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <!-- end: page -->
</section>
</div>
</section>
