	
		
		<div class="aaa">
	  
        <?php
          $args = array( 'posts_per_page' => 2 );
		  $allposts = get_posts($args);
          foreach ($allposts as $post)
          {
            switch_to_blog($post->blog_id);
            setup_postdata($post);
             
            $color = get_option('project_color', '#000');

            $tags = '';
            $posttags = get_the_tags();
            if ($posttags)
              foreach ($posttags as $posttag)
              {
                $tags .= sprintf('<a href="%s/zpravy/?filtr=tema_%s">%s</a>, ',  get_bloginfo('url'), $posttag->term_id, $posttag->name);
              }

            ?><div class="post" style="height: 360px">
              <?php the_post_thumbnail('post-index-recent'); ?>
              <div class="padding">
                <a href="<?php the_permalink() ?>" style="<?php printf('color: %s', $color) ?>"><h3><?php the_title(); ?></h3></a>
                <p><span>#</span><?php echo ($tags) ? trim($tags, ', ') : 'Příspěvek bez tagů'; ?></p>
                <p><span>Vloženo</span><?php the_date('d. m. Y'); ?></p>
                <p><span>Text</span>
                  <?php
                    $authors = get_post_meta(get_the_ID(), 'authors', true);
                    if ($authors)
                    {
                      $users = '';
                      foreach ($authors as $author_id)
                      {       
                        $user = get_userdata($author_id);
                        $users .= sprintf('<a href="%s%s/zpravy/?filtr=autor_%s">%s %s</a>, ', get_bloginfo('url'), ($project_menu) ? sprintf('/projekt/%s', $project_menu->slug): '', $author_id, $user->first_name, $user->last_name);
                      }
                      echo trim($users, ', ');
                    }
                    else
                    {
                      $user = get_userdata($post->post_author);
                      printf('<a href="%s%s/zpravy/?filtr=autor_%s">%s %s</a>', get_bloginfo('url'), ($project_menu) ? sprintf('/projekt/%s', $project_menu->slug): '', $post->post_author, $user->first_name, $user->last_name);
                    }
                  ?>
                </p>
              </div>
            </div><?php
            wp_reset_postdata();
            restore_current_blog();
          }
        ?>
		
		<div class="clear"></div>
		
	</div>
		
       <div id="titulka-zpravy-button">
        <a href="/zpravy/" class="button">Všechny aktuality</a>
       </div>	