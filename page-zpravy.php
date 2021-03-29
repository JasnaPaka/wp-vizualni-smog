<?php
  get_header();
  $filter = (isset($_GET['filtr']) and $_GET['filtr']) ? $_GET['filtr'] : false;
  $hidetags = isset($_GET['hidetags']) ? true : false;
  $filters = array('tema' => 'Tématu', 'autor' => 'Autora');

  if (get_current_blog_id() == 1)
  {
    $posts = get_all_posts();
    $filters['projekt'] = 'Projektu';
  }
  else
    $posts = get_posts(array('posts_per_page' => -1));
?>

<div id="page" class="index zpravy">

    

<div class="padding title">

    <div class="rightMenu">


		   <div id="searchdatabase" class="searchnews">
              <form method="get" action="<?php bloginfo('siteurl') ?>">
                <input type="hidden" name="typ" value="podnet">
                <input type="text" name="s" placeholder="Hledat ve zprávách...">
                <input type="submit" value="Hledat">
              </form>
            </div>

    </div>

	<div class="clear"></div>


</div>


    <div class="inner">



        <div class="tags">    

          <div class="tagsblock autor"<?php echo ((strpos($filter, 'autor') !== false) && $hidetags == false ) ? ' style="display: block"' : '' ?>>

            <?php

              $autori = array();

              foreach ($posts as $post)
              {
                switch_to_blog($post->blog_id);
                
                $autori[$post->post_author] = get_the_author_meta('first_name', $post->post_author) . ' ' . get_the_author_meta('last_name', $post->post_author);
                
                $authors = get_post_meta($post->ID, 'authors', true);
                if ($authors)
                foreach ($authors as $author_id)
                {                                 
                  $autori[$author_id] = getAuthorNickname($author_id);
                }
                
                restore_current_blog();
              }

              foreach ($autori as $id => $name) printf('<span name="autor_%s" class="%s">%s</span>&nbsp;', $id, ($filter == sprintf('autor_%s', $id)) ? 'active' : '', $name);

            ?>  

          </div>


          <div class="tagsblock tema"<?php echo ((strpos($filter, 'tema') !== false) && $hidetags == false) ? ' style="display: block"' : '' ?>>

            <?php            

              $temata = array();

              foreach ($posts as $post)
              {
                switch_to_blog($post->blog_id);
              
                $tags = wp_get_post_tags($post->ID);
              
                foreach ($tags as $tag)
                {
                  $temata[$tag->term_id] = $tag;
                }
              
                restore_current_blog();
              }
              
              if ($temata) foreach ($temata as $tema) printf('<span name="tema_%s" class="%s">%s</span>&nbsp;', $tema->term_id, ($filter == sprintf('tema_%s', $tema->term_id)) ? 'active' : '', $tema->name);
            ?>  

          </div> 

        </div>



        <?php

         

          foreach ( $posts as $post )
          {
            switch_to_blog($post->blog_id);
            setup_postdata($post); 

            $color = get_option('project_color', '#000');
            $classes = sprintf(' projekt_%s autor_%s ', $post->blog_id, $post->post_author);
            $authors = get_post_meta(get_the_ID(), 'authors', true);

            if ($authors)

            foreach ($authors as $author_id) $classes .= sprintf('autor_%s ', $author_id);   


            $tags = '';

            $posttags = get_the_tags();

            if ($posttags)

            {

              foreach ($posttags as $posttag)
              {
                $tags .= sprintf('<a href="%s/zpravy/?filtr=tema_%s">%s</a>, ',  get_bloginfo('url'), $posttag->term_id, $posttag->name);
                $classes .= sprintf(' tema_%s', $posttag->term_id);
              }
              $tags = trim($tags, ', ');

            }
            $itemhidden = ($filter and !strpos($classes, $filter) !== false);

            ?><div class="post postitem <?php echo $classes ?>"<?php echo ($itemhidden) ? ' style="display: none"' : '' ?>>

            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('post-index-recent'); ?></a>

            <div class="padding">
              <a href="<?php the_permalink() ?>"><h3 style="color:black"><?php the_title(); ?></h3></a>
              
              <p><span>#</span><?php echo ($tags) ? trim($tags, ', ') : 'Příspěvek bez tagů'; ?></p>
              <p><span>Vloženo</span><?php the_date('d. m. Y'); ?></p>
              <p><span>Autor</span>
                  Vizuální smog v Plzni
              </p>
            </div>

        </div><?php
              wp_reset_postdata();
              restore_current_blog();
          }                                           
        ?>

        

        <div class="clear"></div>

        

        <div class="padding tcenter">

          <a href="#"><img src="<?php bloginfo('template_url') ?>/i/arrow-more.png"></a>

        </div>

        

    </div>

  </div>

           		

<?php get_footer(); ?>



