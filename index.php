<?php 
    get_header();

    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }
    $PAGE["pocet_del"] = kv_ObjektPocet();
    $PAGE["pocet_kategorii"] = kv_category_count();
?>

  <div id="page" class="index bleft titulni">

   	<div class="inner contentheight" style="min-height: auto">

        <img src="<?php echo get_template_directory_uri() ?>-child-vizualnismog/images/vizualni-smog-small.jpg"
             alt="Vizuální smog" style="max-width:100%"/>

    </div>

  </div>
    <div class="clear"></div>

<?php 
    get_footer();
