<tr>
    <td class="text-left" style="max-width: 360px;"><span class="cut-text-in-one-line"><?= $trid?></span></td>
    <td class="text-center"><?= $username ?></td>
    <td><?= date("m/d/Y", $date)?></td>
    <td><?= isset($end_date) && !empty($end_date) ? date("m/d/Y", $end_date) : 'Not specified yet' ?></td>
    <td class="text-center"><?= ($track_code ? $track_code : 'Missing') ?></td>
    <td class="text-center"><?= $status == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>'?></td>
    <td class="text-center"><?= $total_price?></td>
    <td><a href="<?= $action?>" title="Detail info" class="fa fa-eye"></a></td>
</tr>
