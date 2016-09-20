<tr>
    <td><?= $trid?></td>
    <td><?= $username ?></td>
    <td><?= $date?></td>
    <td><?= $end_date ?></td>
    <td><?= ($track_code ? $track_code : '') ?></td>
    <td class="text-center"><?= $status == 0 ? '<i title="In process" class="fa fa-clock-o"></i>' : '<i title="Done" class="fa fa-check"></i>'?></td>
    <td class="text-right"><?= $total_price?></td>
    <td><a href="<?= $action?>" title="Detail info" class="fa fa-eye"></a></td>
</tr>
