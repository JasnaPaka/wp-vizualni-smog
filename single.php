<?php get_header(); ?>

<div id="page" class="index detail">

  <div class="inner">

	  <div class="postContent">

    <h3 class="titleBigGreen" style="color:black"><?php the_title(); ?></h3>
    <p class="textBlack"><span class="smallGrey">#</span>
    <?php
      $posttags = get_the_tags();
      
      $tags = '';
      if ($posttags)
      foreach ($posttags as $posttag)
      {
        $tags .= sprintf('<a href="%s/zpravy/?filtr=tema_%s">%s</a>, ',  get_bloginfo('url'), $posttag->term_id, $posttag->name);
      }
      
      echo ($tags) ? trim($tags, ', ') : 'Příspěvek bez tagů'; 
    ?>
    </p>

    <p class="textBlack"><span class="smallGrey">Vloženo</span><?php echo date('d. m. Y', strtotime($post->post_date)); ?></p>
    <p class="textBlack"><span class="smallGrey">Autor</span>
        Vizuální smog v Plzni

    <?php 
      $gallery = get_post_meta(get_the_ID(), 'gallery', true);    
      the_post_thumbnail('initiative', array('class' => 'titleImg')); ?>
    <?php

      $current_post_id = $post->ID;
      
      $project_color = "black";
      $excerpt = apply_filters('the_content', $post->post_excerpt);

      echo preg_replace('/<p([^>]+)?>/', '<p$1 class="textMiddleBlack" style="color: black">', $excerpt);


      $content = apply_filters('the_content', $post->post_content);

      echo preg_replace('/<p([^>]+)?>/', '<p$1 class="textMiddleBlack">', $content);

    ?>

    <?php

      $i = 0;

      if ($gallery)

      {

        echo '<div class="gallery">';

        foreach ($gallery as $index => $id)

        {

          $img = wp_get_attachment_image_src($id, 'post-gallery'); 

          $img_href = wp_get_attachment_image_src($id, 'full'); 

          printf('<a href="%s" rel="lightbox[gallery-%s]"><img src="%s" class="%s"></a>', $img_href[0], $post->ID, $img[0], (++$i % 3 == 0) ? 'last' : '');

        }

        echo '</div>';

      }

    ?>
	
	</div>

    <div id="actualprojects" class="recentposts">

        <h2>Sdílet článek</h2>
        
        <div class="socials">                    
            <iframe src="//www.facebook.com/plugins/like.php?href=<?php echo getActualURL() ?>&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>        

            <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo getActualURL() ?>">Tweet</a><br>

            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>        

            <script src="https://apis.google.com/js/platform.js" async defer>{lang: 'cs'}</script>

            <div class="g-plusone" data-size="medium" data-href="<?php echo getActualURL() ?>"></div>
        </div>

        <h2><a href="<?php echo get_permalink(get_page_by_path('zpravy')) ?>">Související články</a></h2>

        <?php

        /*  $args = array( 'posts_per_page' => 4, 'exclude' => $current_post_id);
          $relatedposts = get_posts($args);   */

          $relatedposts = get_all_posts('post', 4, $current_post_id);

          foreach ($relatedposts as $post)
          {
            switch_to_blog($post->blog_id);
            setup_postdata( $post );
            
            $color = get_option('project_color', '#000');
            ?>

            <div class="box">

                <h3 class="titleGreen"><a style="<?php printf('color: %s', 'black') ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>

                <p class="textBlack"><span class="smallGrey">#</span>Veřejný prostor, Architektura, Řeky, Náměstí</p>

                <h4 class="datum"><?php the_date('d. m. Y'); ?></h4>

            </div>

            <?php

           
            if ($post != end($relatedposts))
              echo '<hr class="standart">';

            restore_current_blog();
          }

        ?>

        <a href="<?php echo get_permalink(get_page_by_path('zpravy')) ?>" class="button">VŠECHNY ČLÁNKY</a>
                                                                                        
    </div>
    
        <div class="clear"></div>


</div>

<?php get_footer(); ?>