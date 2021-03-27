<?php 
	get_header();
    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }
	$autori = kv_autor_seznam();
	$ac = kv_autor_controller();
?>


<div id="page" class="katalog author index">
<div class="inner">
<div class="padding">

<div id="rightMenu">

	<div id="searchdatabase">
		<form method="post" action="/katalog/autori/">
	        <input name="typ" value="autor" type="hidden">
	        <input id="s" name="s" placeholder="Hledat v autorech..." type="text">
	        <input value="Hledat" type="submit">
		</form>
	</div>
</div>


<h2>
	<?php 
		if ($ac->getFirstCharFromURL() != null) {
			printf("Autoři začínající na '%s'", $ac->getFirstCharFromURL()); 
		} else if ($ac->getSearchValue() == null) { ?>
			Autoři
	<?php 			
		} else { ?>
		Výsledek hledání v autorech pro "<?php printf($ac->getSearchValue()) ?>"
	<?php }	
	if ($ac->getFirstCharFromURL() != null || $ac->getSearchValue() == null) {
			printf("<hr />");
			printf("<div class=\"katalog-strankovani\">");	
			foreach($ac->getUniqueFirstCharSurname() as $ch) {
				printf ("<a href=\"/katalog/autori/?znak=%s\" class=\"strankovani-polozka\">%s</a>", urlencode($ch->znak), $ch->znak); 	
			}
			printf("</div>");			
	}
	
	?>
</h2>


</div>
</div>

<hr />

<div class="inner">
<?php if (count($autori) == 0) { ?>
	<p>Nebyl nalezen žádný autor.</p>
<?php } else { ?>
<?php
	$autCount = 0;
	foreach ($autori as $autor) {
		$autCount++;
		
		if ($autor->img_512 != null) {
			$img = $uploadDir['baseurl'].$autor->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if ($autCount % 3 == 1) printf('<div>');
?>

<div class="post postitem">
	<a href="/katalog/autor/<?php printf($autor->id) ?>/" title="Zobrazení informací o autorovi">
		<img src="<?php printf($img) ?>" alt="Ukázka díla autora" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding paddingaut">
		<h3><a href="/katalog/autor/<?php printf($autor->id) ?>/" title="Zobrazení informací o autorovi">
			<?php printf(trim($autor->titul_pred." ".$autor->jmeno." ".$autor->prijmeni." ".$autor->titul_za)) ?>
		</a></h3>	
	</div>
</div>

<?php
		if ($autCount % 3 == 0) echo '</div>';

	}
}
?>	

<div class="clear"></div>

</div>

<hr />

<div class="padding">
<div class="inner">
<div class="katalog-strankovani">

<?php
	if (count($autori) > 0) {
		$page = (int) $_GET["stranka"];
		$countPages = kv_autor_pages_count();
		
		if ($countPages > 0) {
			
			// První
			if ($page > 0) {
				echo '<a href="/katalog/autori/" class="strankovani-prvni">První</a>';		
			}		
		
			// Předchozí
			if ($page-1 >= 0) {
				echo '<a href="/katalog/autori/?stranka='.($page-1).'" class="strankovani-predchozi">Předchozí</a>';		
			}
		
			// před aktuální stránkou
			if ($page-2 >= 0) {
				echo '<a href="/katalog/autori/?stranka='.($page-2).'" class="strankovani-polozka">'.($page-1)."</a>";		
			}
			if ($page-1 >= 0) {
				echo '<a href="/katalog/autori/?stranka='.($page-1).'" class="strankovani-polozka">'.($page)."</a>";		
			}
			
			// aktuální
			echo '<span class="strankovani-polozka-akt">'.($page+1).'</span>';
			
			// po aktuálním
			if ($page <= $countPages) {
				echo '<a href="/katalog/autori/?stranka='.($page+1).'" class="strankovani-polozka">'.($page+2)."</a>";		
			}
			if ($page+1 <= $countPages) {
				echo '<a href="/katalog/autori/?stranka='.($page+2).'" class="strankovani-polozka">'.($page+3)."</a>";		
			}
			
			// další
			if ($page <= $countPages) {
				echo '<a href="/katalog/autori/?stranka='.($page+1).'" class="strankovani-dalsi">Další</a>';		
			}	
			
			// Poslední
			if ($page <= $countPages) {
				echo '<a href="/katalog/autori/?stranka='.($countPages+1).'" class="strankovani-posledni">Poslední</a>';		
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