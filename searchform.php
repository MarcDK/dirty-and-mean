<?php
$searchvalue = get_search_query();

if ($searchvalue == '') {
  $searchvalue = "Suchbegriff";
}
?>

<div class="searchbox">
  <form method="get" class="searchform" action="<?php echo esc_url(home_url('/')); ?>searcher.php">
    <input type="text" class="suchfeld" name="s" placeholder="<?php echo $searchvalue; ?>" />
  </form>
</div>