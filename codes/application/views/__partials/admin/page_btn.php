<?php if ($current_page > $offset + 1) { ?>
<span class="admin-page-btn product-page-btn" id="1" data-field="<?= $field ?>"><?= "|<<" ?></span>
<?php } ?>

<?php for($i = max([$current_page - $offset,  1]); $i < $current_page; $i++) { ?>
<span class="admin-page-btn product-page-btn" id="<?= $i ?>" data-field="<?= $field ?>"><?= $i ?></span>
<?php } ?>

<span class="admin-page-btn product-page-btn active" id="<?= $current_page ?>" data-field="<?= $field ?>"><?= $current_page ?></span>

<?php for($i = $current_page + 1; $i <= min([$current_page + $offset, $total_pages]); $i++) { ?>
<span class="admin-page-btn product-page-btn" id="<?= $i ?>" data-field="<?= $field ?>"><?= $i ?></span>
<?php } ?>

<?php if ($current_page < $total_pages - $offset) { ?>
<span class="admin-page-btn product-page-btn" id="<?= $total_pages ?>" data-field="<?= $field ?>"><?= ">>|" ?></span>
<?php } ?>
