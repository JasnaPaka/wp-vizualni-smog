<?php 
	get_header();
    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }
	$objekty = kv_object_seznam();
	$oc = kv_object_controller();
	
	$page = (int) $_GET["stranka"];
	if ($page == null) {
		$page = 0;	
	} 
?>

<div id="page" class="katalog index">
<div class="inner">
<div class="padding">

<div class="rightMenu">
	<div id="viewdatabase">
        <a href="?zobrazeni=grid"><span id="vdgrid" class="<?php if (!$oc->getIsZobrazeniList()) { print("active"); } ?>"></span></a>
        <a href="?zobrazeni=list"><span id="vdlist" class="<?php if ($oc->getIsZobrazeniList()) { print("active"); } ?>">"></span></a>
    </div>
    <div class="separator"></div>
	<div id="searchdatabase">
		<form method="post" action="/katalog/<?php print($oc->getZobrazeniStr(false)) ?>">
	        <input name="typ" value="dilo" type="hidden">
	        <input id="s" name="s" placeholder="<?php print($KV["hledat_v_dilech"]) ?>" type="text">
	        <input value="Hledat" type="submit">
		</form>
	</div>  
</div>


<h2>
	<?php if ($oc->getIsShowedTag()) { ?>
		<?php print($KV["dila_se_stitkem"]) ?> '<?php print ($oc->getCurrentTag()->nazev) ?>'
	<?php } else if ($oc->getIsShowedCategory()) { ?>		
		<?php print($KV["katalog_del"]) ?> '<?php print ($oc->getCurrentCategory()->nazev) ?>'
		<?php if ($oc->getIShowedBezAutora()) { ?>(bez autora)<?php } ?>
	<?php } else if ($oc->getSearchValue() == null) { ?>
		<?php print($KV["katalog_del"]) ?>
	<?php } else { ?>
		<?php print($KV["vysledek_hledani_dila"]) ?> '<?php print($oc->getSearchValue()) ?>'
	<?php }?>
</h2>

<?php if ($page == 0 && count($oc->getAllTags()) > 0 && !$oc->getIsShowedCategory()) { ?>	
	<div id="kat-tags">	
<?php foreach ($oc->getAllTags() as $tag) { ?>

<a href="/katalog/stitek/<?php printf ($tag->id) ?>/" class="kat-tag"><?php print ($tag->nazev) ?></a>

<?php } ?>
	</div>
	<div class="clear"></div>	
<?php } ?>

</div>

</div>

<hr />

<div class="inner">

<?php if (count($objekty) == 0) { ?>

<p><?php print($KV["dilo_nenalezeno"]) ?></p>

<?php 

} else {
	if ($oc->getIsShowedTag()) {
		$popis = $oc->getCurrentTag()->popis;
		
		if (strlen(trim($popis)) > 0) {
			printf("<p>%s</p>", $popis);
		}
		printf("<p>%s: %d</p><br />", $KV["dila_se_stitkem"], sizeof($objekty));	
	}
	
	$objCount = 0;
	foreach ($objekty as $objekt) {
		$objCount++;
		
		if ($objekt->img_512 != null) {
			$img = $uploadDir['baseurl'].$objekt->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if (!$oc->getIsZobrazeniList()) {		
                        if ($objCount % 3 == 1) { print('<div>'); };
?>

<div class="post postitem">
	<a href="/katalog/dilo/<?php print($objekt->id) ?>/" title="<?php print ($KV["zobrazeni_informaci"]) ?>">
		<img src="<?php print($img) ?>" alt="Ukázka díla" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding">
		<h3><a href="/katalog/dilo/<?php printf($objekt->id) ?>/" title="<?php print ($KV["zobrazeni_informaci"]) ?>"><?php printf($objekt->nazev) ?></a></h3>
		<?php include "page-katalog-dilo-grid.php" ?>
	</div>
</div>

<?php
			if ($objCount % 3 == 0) printf('</div>');			
		} // konec zobrazení "grid" 
		else {
			
?>	

<ul class="line_list">
<li class="postitem rocnik_2015-2016 autor_231 kategorie_mam-napad ">
	<article class="inner">

                  <a href="/katalog/dilo/<?php printf ($objekt->id) ?>/" title="Zobrazení informací o díle"><div class="img_block">
                  
                  <img src="<?php printf($img)?>" class="attachment-initiative-recent wp-post-image" alt="Náhled" height="212" width="340">                  
                  <span class="line_list_icon green"></span></div></a>

                  <div class="center_block">

                    <h3><a href="/katalog/dilo/<?php printf ($objekt->id) ?>/" title="Zobrazení informací o díle"><?php printf ($objekt->nazev)?></a></h3>

					<?php if (strlen($objekt->popis) > 0) { ?>
                    	<p><?php printf ($objekt->popis)?></p>
                    <?php } ?>
                    					
                  </div>

                  <div class="right_block">

                    <h4>Kategorie</h4>

                    <p><a href="/katalog/kategorie/<?php printf ($objekt->kategorie)?>/" 
                    	title="Zobrazí seznam děl v kategorii"><?php printf ($objekt->katnazev)?></a></p>
                    
                    <?php include "page-katalog-dilo-list.php" ?>
                   

                  </div>

		</article>
	</li>
</ul>	
	
<?php		
		} 
	}
?>	

<div class="clear"></div>		
	
<?php		
} 
?>

</div>

<hr />

<div class="padding">
<div class="inner">
<div class="katalog-strankovani">

<?php
	if (count($objekty) > 0) {
		$countPages = kv_object_pages_count();
		
		$subcat = "";
		$category = $oc->getCurrentCategory();
		if ($category != null) {
			$subcat = "kategorie/".$category->id."/";	
		}				
		
		if ($countPages > 0) {
			// První
			if ($page > 0) {
				printf('<a href="/katalog/'.$subcat.$oc->getZobrazeniStr(false).'" class="strankovani-prvni">První</a>');		
			}		
		
			// Předchozí
			if ($page-1 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-1).$oc->getZobrazeniStr(true).'" class="strankovani-predchozi">Předchozí</a>');		
			}
		
			// před aktuální stránkou
			if ($page-2 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-2).$oc->getZobrazeniStr(true).'" class="strankovani-polozka">'.($page-1)."</a>");		
			}
			if ($page-1 >= 0) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page-1).$oc->getZobrazeniStr(true).'" class="strankovani-polozka">'.($page)."</a>");		
			}
			
			// aktuální
			printf('<span class="strankovani-polozka-akt">'.($page+1).'</span>');
			
			// po aktuálním
			if ($page+1 <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+1).$oc->getZobrazeniStr(true).'" class="strankovani-polozka">'.($page+2)."</a>");		
			}
			if ($page+2 <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+2).$oc->getZobrazeniStr(true).'" class="strankovani-polozka">'.($page+3)."</a>");		
			}
			
			// další
			if ($page+1 <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($page+1).$oc->getZobrazeniStr(true).'" class="strankovani-dalsi">Další</a>');		
			}	
			
			// Poslední
			if ($page+1 <= $countPages) {
				printf('<a href="/katalog/'.$subcat.'?stranka='.($countPages).$oc->getZobrazeniStr(true).'" class="strankovani-posledni">Poslední</a>');		
			}
		}	
	}
		
?>

</div>
</div>
</div>


<div class="clear"></div>

</div>

</div>
	

<?php get_footer(); ?>
