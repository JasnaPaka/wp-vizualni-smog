<?php 
	get_header();
    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }
	
	$collection = kv_collection_info();
	$objekty = kv_collection_objects();
?>

<?php if (!isset($collection->id) || $collection->deleted) { ?>
	
	<div id="page" class="static">
	
	  <div class="inner">
	
	    <div class="padding">
	
			<h2>Soubor děl nebyl nalezen</h2>
			
			<p>Vámi hledaný soubor děl nebyl bohužel v katalogu nalezen.</p>
		</div>
	   </div>
	</div>	
	
<?php } else { ?>

<div id="page" class="katalog author index">

  <div class="inner">

    <div class="padding">

      <h2><?php printf ($collection->nazev) ?></h2>         
	</div>
	
	<?php if (is_user_logged_in()) { ?>
		<div class="buttonsGreen">			
			<a class="buttonGreen" href="/wp-admin/admin.php?page=collection&action=view&id=<?php echo $collection->id ?>">UPRAVIT</a>
		</div>
    <?php } ?>	
    
	<div id="obsah-container">
			 
	<?php if ($collection->zpracovano) { ?>
	 	<div id="obsah-perex">
	 		<?php echo stripslashes($collection->popis) ?>
	 	</div>
	 	<div id="obsah">
	 		<?php
	 			if ($collection->zpracovano) { 
	 				echo stripslashes($collection->obsah);
				}
	 		?>
	 	</div>
	 <?php } ?>
	 
	 </div>    
	 
<div id="dila"> 
<hr />
<h3>Přehled děl</h3>
	
<p id="pocet-del">Celkový počet děl: <?php echo $collection->pocet ?></p>
	
<?php	
	$objCount = 0;
	foreach ($objekty as $objekt) {
		$objCount++;
		
		if ($objekt->img_512 != null) {
			$img = $uploadDir['baseurl'].$objekt->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if ($objCount % 3 == 1) echo '<div>';
?>

<div class="post postitem postitemauthor">
	<a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle">
		<img src="<?php echo $img ?>" alt="Ukázka díla" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding">
		<h3><a href="/katalog/dilo/<?php echo $objekt->id ?>/" title="Zobrazení informací o díle"><?php echo $objekt->nazev ?></a></h3>
	</div>
</div>

<?php
		if ($objCount % 3 == 0) echo '</div>';

	}
?>	

<div class="clear"></div>	    
    
<?php		
} 
?>    
   
   </div> 
   </div>
</div>	 


<?php get_footer(); ?>