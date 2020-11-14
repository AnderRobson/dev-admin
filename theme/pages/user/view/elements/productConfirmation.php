<tr>
    <td>
        <img src="<?= urlFile('upload/product/' . $productImages->image, true); ?>" class="img-fluid img-thumbnail" alt="<?= $product->product->title; ?>" style="width: 100px; height: 80px;">
    </td>
    <th><?= $stock->code; ?></th>
    <td class="text-left"><?= $product->product->title; ?></td>
    <td><?= $product->quantity ?></td>
    <td><?= currencyFormatter($product->value); ?></td>
</tr>