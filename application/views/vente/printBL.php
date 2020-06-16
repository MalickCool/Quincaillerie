<section role="main" class="content-body">
    <!-- start: page -->
    <header class="panel-heading">

    </header>

    <h2 class="panel-title" style="color: #000000; text-align: center; padding-top: 60px; padding-bottom: 25px">
        <?= $message ?>
    </h2>

    <div style="padding-bottom: 0px">
        <b>N° Client: </b>C<?= str_pad($returnArray['Client']->idclient, 5, "0", STR_PAD_LEFT); ?>
    </div>
    <div style="padding-bottom: 0px">
        <b>Client: </b><?= $returnArray['Client']->nom ?>
    </div>
	<div style="padding-bottom: 0px">
		<b>Contact Client: </b><?= $returnArray['Client']->phone ?>
	</div>

    <div style="padding-bottom: 0px">
        <b>Date de la vente: </b><?= date("d/m/Y", strtotime($returnArray['Vente']->datevente)) ?>
    </div>

	<div style="padding-bottom: 0px">
		<b>Date de livraison: </b><?= date("d/m/Y", strtotime($returnArray['Vente']->datelivraison)) ?>
	</div>
	<div style="padding-bottom: 25px">
		<b>Magasin de Desctockage: </b><?= $this->entrepot_m->get($returnArray['Vente']->entrepotlivraison)->designation ?>
	</div>



    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 20%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Quantité
                </th>

				<th style="width: 80%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
					Désignation
				</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($returnArray['Produits'] as $produitItem) {
                    if($produitItem['Etat'] == 0){
                        ?>
                        <tr>
							<td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: center">
								<?= $produitItem['Qte'] ?>
							</td>
                            <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px; text-align: left">
                                <?= $produitItem['Produit'] ?>
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
