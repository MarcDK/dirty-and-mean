<?php /*
  Example template for use with post thumbnails
  Requires a theme which supports post thumbnails
  Author: mitcho (Michael Yoshitaka Erlewine)
 */ ?>




<?php if (have_posts()): ?>
<div class="relatedbox fullwidth">
    <div class="site">
        <div class="section">

  <?php

  $mostcom = '<h2 class="supertitle">Mehr zum Thema</h2>';
  $mostcom .= '<ul class="container">';
  $key = 1;
  ?>
  <?php while (have_posts()) : the_post(); ?> 
    <?php

    if ($key % 3 === 0) {
      $mostcom .= '<li class="box last">';
    }
    else if ($key === 1) {
      $mostcom .= '<li class="box first">';
    }
    else {
      $mostcom .= '<li class="box">';
    }
    $key++;
    $mostcom .= get_marctv_teaser(get_the_ID(), true, '', 'medium', true, '', false, false);
    $mostcom .= '</li>';
    ?>
  <?php endwhile; ?>
  <?php

  $mostcom .= '</ul>';
  echo $mostcom;
  ?>
        </div>
    </div>
</div>
<?php else: ?>

<?php endif; ?>


