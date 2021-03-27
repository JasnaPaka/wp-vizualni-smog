<?php get_header(); ?>



<div id="page" class="static">

  <div class="inner">



    <div class="content">

    <?php

      $current_post_id = $post->ID;

    

      $content = apply_filters('the_content', $post->post_content);

      echo preg_replace('/<p([^>]+)?>/', '<p$1 class="textMiddleBlack">', $content);

    ?>

    </div>

  </div>

</div>

<?php get_footer(); ?>



