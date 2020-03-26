<section role="main" class="content-body">
    <span style="font-size: 10px; text-align: right">
        <?= date('d/m/Y') ?>
    </span>
    <header class="panel-heading">
        <h2 class="panel-title" style="color: #000000; text-align: center; border: solid; border-bottom-color: #0a001f; padding: 10px; border-radius: 15px">
            Liste des Services
        </h2>
    </header>

    <!-- start: page -->

    <table style="width: 100%;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 30%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Nom du Service
                </th>
                <th style="width: 70%; border: solid; border-color: #000; border-width: 0.5px; padding: 10px; background-color: #CCCCCC">
                    Description
                </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($groups as $group):?>
            <tr>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px">
                    <?php echo ucfirst(htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'));?>
                </td>
                <td style="border: solid; border-color: #000; border-width: 0.5px; padding: 5px">
                    <?php echo htmlspecialchars($group->description,ENT_QUOTES,'UTF-8');?>
                </td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
