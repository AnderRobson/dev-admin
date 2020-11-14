<?= $order->getStatus('class'); ?>
<tr>
    <td><?= $order->id; ?></td>
    <td class="bg-<?= $order->getStatus('getClass'); ?> text-black"><?= $order->getStatus('getStatus') ?></td>
    <td><?= currencyFormatter($order->sub_total); ?></td>
    <td><?= currencyFormatter($order->total); ?></td>
</tr>