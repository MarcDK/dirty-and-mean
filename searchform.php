<?php
$searchvalue = get_search_query();
?>

<div class="searchbox">
  <form method="get" results="5" class="search" action="<?php echo esc_url(home_url('/')); ?>searcher.php">
    <span class="dashicons dashicons-search"></span>
    <input type="search" name="s" placeholder="Suchen" value="<?php echo $searchvalue; ?>" />
  </form>
</div>