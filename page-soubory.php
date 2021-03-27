<?php 
	get_header();
    $uploadDir = wp_upload_dir();
    if (is_ssl()) {
        $uploadDir = str_replace("http://", "https://", $uploadDir);
    }
	$soubory = kv_soubor_seznam();
	$ac = kv_soubor_controller();
?>


<div id="page" class="katalog collection index">
<div class="inner">
<div class="padding">

<h2>
	Soubory děl
</h2>


</div>
</div>

<hr />


<div class="inner">
<?php if (count($soubory) == 0) { ?>
	<p>Nebyl nalezen žádný soubor děl.</p>
<?php } else { ?>
<?php
	$autCount = 0;
	foreach ($soubory as $soubor) {
		$autCount++;
		
		if ($soubor->img_512 != null) {
			$img = $uploadDir['baseurl'].$soubor->img_512;
		} else {
			$img = get_template_directory_uri()."-child-krizkyavetrelci/images/foto-neni-340.png";
		}
		
		if ($autCount % 3 == 1) echo '<div>';
?>

<div class="post postitem">
	<a href="/katalog/soubor/<?php echo $soubor->id ?>/" title="Zobrazení informací o souboru děl">
		<img src="<?php echo $img ?>" alt="Ukázka" class="katalog-dilo-obr" />
	</a>
	
	<div class="padding paddingaut">
		<h3><a href="/katalog/soubor/<?php echo $soubor->id ?>/" title="Zobrazení informací o souboru děl">
			<?php echo $soubor->nazev ?>
		</a></h3>	
	</div>
</div>

<?php
		if ($autCount % 3 == 0) echo '</div>';

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