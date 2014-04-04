<?php
$searchvalue = get_search_query();
?>

<div class="searchbox">
  <form method="get" class="searchform" action="<?php echo esc_url(home_url('/')); ?>searcher.php">
    <input type="text" class="suchfeld" name="s" placeholder="Suchen" value="<?php echo $searchvalue; ?>" />
  </form>
</div>