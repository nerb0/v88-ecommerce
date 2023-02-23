<?php if ($current_page > 2) { ?>
<input class="catalog-page-btn btn bg-transparent" type="button" id="1" value="|<<"/>
<?php } ?>

<?php if ($current_page > 1) { ?>
<input class="catalog-page-btn btn bg-transparent" type="button" id="<?= $current_page - 1 ?>" value="<?= $current_page - 1 ?>"/>
<?php } ?>
<input class="catalog-page-btn btn bg-transparent active" type="button" id="<?= $current_page ?>" value="<?= $current_page ?>"/>
<?php if ($current_page < $total_pages) { ?>
<input class="catalog-page-btn btn bg-transparent" type="button" id="<?= $current_page + 1 ?>" value="<?= $current_page + 1 ?>"/>
<?php } ?>

<?php if ($current_page < $total_pages - 1) { ?>
<input class="catalog-page-btn btn bg-transparent" type="button" id="<?= $total_pages ?>" value=">>|"/>
<?php } ?>
