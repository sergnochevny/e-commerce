<tr>
    <td class="text-left" style="max-width: 360px;"><?= $trid?></td>
    <td><?= $username ?></td>
    <td><?= date("m/d/Y", $date)?></td>
    <td><?= isset($end_date) && !empty($end_date) ? date("m/d/Y", $end_date) : 'Not specified yet' ?></td>
    <td><?= ($track_code ? $track_code : 'Missing') ?></td>
    <td class="text-center"><?= $status == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>'?></td>
    <td class="text-right"><?= $total_price?></td>
    <td><a href="<?= $action?>" title="Detail info" class="fa fa-eye"></a></td>
</tr>
