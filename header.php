<?php
  if (is_front_page() && is_home()) {
	$objectId = $_GET["objekt"];
	if (strlen($objectId) > 0) {
		wp_redirect("/katalog/dilo/".$objectId."/");	
	}
  }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
  <title><?php wp_title(); ?></title>

  <?php wp_head(); ?>

  <link rel="icon" href="<?php bloginfo('template_url') ?>-child-vizualnismog/favicon.png" type="image/png" />
 
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/content.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/line_list_style.css" media="screen" />
	<link rel='stylesheet' id='vpp-css'  href='<?php bloginfo('url') ?>/wp-content/themes/vpp/style.css?ver=4.0.1' type='text/css' media='all' />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="screen, print" />
        <link rel="stylesheet"  type="text/css" href="<?php bloginfo('template_url') ?>-child-vizualnismog/print.css" media="print" />
  
  <link href="//fonts.googleapis.com/css?family=Roboto:400,500,700&subset=latin,cyrillic-ext,latin-ext" rel="stylesheet" type="text/css">

  <script>
    TEMPLATE_URL = "<?php bloginfo('template_url') ?>";
    BID = <?php echo get_current_blog_id() ?>;
  </script>
  
  <script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/jquery.MultiFile.pack.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/jquery.unveil.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/sprintf.js"></script>
  <script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/vpp.js"></script>


  <?php
    if (isProjectPage())
    {
      $project_color = get_blog_option($project->blog_id, 'project_color', '#000');
      $project_background = wp_get_attachment_url(get_blog_option($project->blog_id, 'project_background'));
      ?>
      <style>
        #page.index .post h3 {color: <?php echo $project_color ?>}
        h3.titleBigGreen {color: <?php echo $project_color ?>}   
        #mappage h2 {color: <?php echo $project_color ?>} 
      </style>
      <?php
    }
  ?>
  
</head>                                                                     
<body> 
  <div id="header" <?php if (isProjectPage()) printf('style="background-color: %s; background-image: url(\'%s\')"', "white", $project_background) ?>>
    <div id="header-top"> 
      <div id="blacked">
        <div class="inner">       
			<div id="logos">
			  <a href="<?php echo get_blog_option(2, 'siteurl' ); ?>" id="logo_project">
			  <?php if( get_option('header_logo') == '' ) { ?>
			  <img src="<?php bloginfo('template_url') ?>/i/logotype-pestuj-prostor.png" alt="Logo>">
				<?php } else { ?>
			  <img src="<?php echo wp_get_attachment_url( get_option('header_logo')) ?>" alt="Logo>">
				<?php } ?>
			  </a><span id="logo_separator"></span>
			  <a target="_blank" href="http://www.plzen2015.cz" id="logo"><img src="<?php bloginfo('template_url') ?>/i/logo.png" alt="Logo"></a>
			</div>
          <div id="header-top-right">
            
            <div id="search">
				<form id="searchbox_000059552786512968692:p8jcxifgzhu" action="https://www.google.com/cse">
				    <input name="cx" value="000059552786512968692:p8jcxifgzhu" type="hidden">
				    <input name="cof" value="FORID:0" type="hidden">
				    <input name="ie" value="utf-8" type="hidden">
				    <input type="text" name="q" placeholder="Hledat...">
				    <input type="submit" value="Hledat">
				</form>
            </div>
            
            <div class="separator"></div>
  
            <div id="socials">
              <a id="social_rss" href="<?php printf('%s/feed', get_bloginfo('url')); ?>"></a><a id="social_fb" target="_blank" href="https://www.facebook.com/vizualnismogvPlzni/"></a>

					
			      </div>
            
            <div id="login">
              <?php global $current_user; echo (is_user_logged_in()) ? sprintf('<a class="showpopup" href="#">%s</a>', getAuthorNickname($current_user->ID)) :  '<a class="showpopup" href="#">Přihlásit se</a>'; ?>

					    <div id="loginpopup" class="menupopup">
              <?php if (is_user_logged_in()) { ?>
                <form>
                  <div class="row">
                     <a href="<?php echo get_edit_profile_url(); ?>">Upravit profil</a>
                  </div>
                  <div class="row">
                     <a href="<?php echo wp_logout_url(get_bloginfo('url')); ?>">Odhlásit se</a>
                  </div>
                </form>
              <?php } else { ?>
               <form method="post" action="<?php switch_to_blog(1); echo get_the_permalink(653); restore_current_blog(); ?>">
                 <input type="hidden" name="initiative_author_alreadyregistered" value="1">
                 <div class="row">
                   <label>E-mail</label>
                   <input type="text" name="initiative_exists_author_email">
                 </div>
                 <div class="row">
                   <label>Heslo</label>
                   <input type="password" name="initiative_exists_author_password">
                 </div>
                 <div class="row">
                  <!-- <a href="<?php echo switch_to_blog(1); get_permalink(get_page_by_path('registrace-uzivatele')); restore_current_blog(); ?>" class="button gray small">Registrovat se</a> -->
                  
                  <a href="http://plzne.cz/registrace-uzivatele/" class="button gray small">Registrovat se</a>
                   
                   <input class="button orange small" type="submit" name="initiative_submit" value="Přihlásit se">
                 </div>
               </form>
               <?php } ?>
              </div> 

		        </div>
  

  
          </div>
  
          </div>

          <div class="clear"></div>

        </div>
        
        <div class="inner">

        <label for="show-menu" class="show-menu">Zobrazit menu</label>
        <input type="checkbox" id="show-menu" role="button">

        <?php   
          $projects_items = $maps_items = '';
        
          $projects = wp_get_sites(array('public' => true));
          foreach ($projects as $project)
          {
            if ($project['blog_id'] == 1) continue;
            
            switch_to_blog($project['blog_id']);
                        
            $color = get_option('project_color', '#000');              
          
            $projects_items .= sprintf('<li><a href="%s" style="color: %s">%s</a></li>', get_bloginfo('siteurl'), $color, get_bloginfo('name'));
            
            if (get_page_by_path('mapa')) {
              $maps_items .= sprintf('<li><a href="%s/mapa" style="color: %s">%s</a></li>', get_bloginfo('siteurl'), $color, get_bloginfo('name'));
            }
          
            restore_current_blog();
          }
        
          switch_to_blog(1);
          
          $menu = wp_nav_menu( array('menu' => 'main_menu', 'container_class' => 'menu', 'menu_class' => 'menu w25', 'echo' => false )); 
          $menu = str_replace('Projekty</a>', sprintf('Projekty</a><ul class="sub-menu">%s</ul>', $projects_items), $menu);
          
          echo str_replace('Mapy</a>', sprintf('Mapy</a><ul class="sub-menu">%s</ul>', $maps_items), $menu);
          
          restore_current_blog();
        ?>
      </div>   
    </div>
         
    <div id="header-content">
      <div class="inner">
      <?php if (isProjectPage()) { ?>
        <div id="header_project">
          
          <?php /*<a href="<?php bloginfo('url') ?>"> */ ?>
          <div id="header_project_left" <?php printf('style="background-image: url(%s)"', wp_get_attachment_url( get_option('project_logo')) ) ?>>
          	
          		<a href="<?php bloginfo('url'); ?>" class="logo_link"></a>
          
            <div id="header_project_left_middle">
              <h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name') ?></a></h1>
              <p><?php echo get_option('project_subtitle') ?></p>
            </div>
          </div>  
          <?php /* </a> */ ?>

          <div id="header_project_right">
            <p><?php echo get_option('project_description') ?></p>
          </div>
          <div class="clear"></div>                 
        </div>
        <?php wp_nav_menu( array('menu' => 'main_menu', 'container' => '', 'menu_id' => 'project-menu', 'depth' => 1)); ?>
      <?php } else { ?>
        <h1>Portál pro<br>veřejný<br>prostor.plzne.cz</h1>
        <span>
          <p>Portál tvoří široká škála projektů a organizací,<br>které nespojuje pouze téma veřejného prostoru, ale zejména<br>společný cíl činit veřejný prostor demokratičtější.</p>
          <a href="<?php echo get_the_permalink(17) ?>" class="button white">Více o portálu</a>        
        </span>
      <?php } ?> 
      </div> 
    </div>  
  </div>