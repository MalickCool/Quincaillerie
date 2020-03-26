<section role="main" class="content-body">
    <span style="font-size: 10px; text-align: right">
        <?= date('d/m/Y') ?>
    </span>
    <header class="panel-heading">
        <h2 class="panel-title" style="color: #000000; text-align: center; border: solid; border-bottom-color: #0a001f; padding: 10px; border-radius: 15px">Liste du Personnel</h2>
    </header>
    <!-- start: page -->

    <table style="width: 100%; border: none; border-color: #000;" cellspacing="0">
        <thead style="width: 100%; border: solid; border-color: #000;">
            <tr style="width: 100%; border: solid; border-color: #000;">
                <th style="width: 20%; border: solid; border-color: #000; border-width: 1px; padding: 10px; background-color: #CCCCCC">
                    <?php echo lang('index_lname_th');?>
                </th>
                <th style="width: 30%; border: solid; border-color: #000; border-width: 1px; padding: 10px; background-color: #CCCCCC">
                    <?php echo lang('index_fname_th');?>

                </th>
                <th style="width: 20%; border: solid; border-color: #000; border-width: 1px; padding: 10px; background-color: #CCCCCC">
                    <?php echo lang('index_email_th');?>
                </th>
                <th style="width: 20%; border: solid; border-color: #000; border-width: 1px; padding: 10px; background-color: #CCCCCC">
                    <?php echo lang('index_groups_th');?>

                </th>
                <th style="width: 10%; border: solid; border-color: #000; border-width: 1px; padding: 10px; background-color: #CCCCCC">
                    <?php echo lang('index_status_th');?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user):?>
                <tr>
                    <td style="border: solid; border-color: #000; border-width: 1px; padding-right: 5px; padding-left: 5px">
                        <?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?>
                    </td>
                    <td style="border: solid; border-color: #000; border-width: 1px; padding-right: 5px; padding-left: 5px">
                        <?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?>
                    </td>
                    <td style="border: solid; border-color: #000; border-width: 1px; padding-right: 5px; padding-left: 5px">
                        <?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?>

                    </td>
                    <td style="border: solid; border-color: #000; border-width: 1px; text-align: center; padding-right: 5px; padding-left: 5px">
                        <?php foreach ($user->groups as $group):?>
                            <?php if($group->name != "members"): ?>
                                <span class="btn btn-primary fcwhite">
                                <?= $group->name ;?>
                            </span>
                            <?php endif?>
                        <?php endforeach?>
                    </td>
                    <td style="border: solid; border-color: #000; border-width: 1px; text-align: center; padding-right: 5px; padding-left: 5px">
                        <?php
                            if ($user->active){
                                echo "Activer";
                            }else{
                                echo "Désactiver";
                            }
                        ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <!-- end: page -->
</section>
</div>
</section>

