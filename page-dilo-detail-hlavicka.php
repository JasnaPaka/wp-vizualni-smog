<div class="topMenu">
		<div>
			<h1>Kategorie</h1>
			<h2><?php print ($kategorie->nazev) ?></h2> 
			<div class="space"></div>
		</div>
		<div>
			<h1>Přístupnost</h1>
			<h2>
				<?php
					if (strlen($objekt->pristupnost) > 2) {
						printf($objekt->pristupnost);	
					} else {
						printf('<em class="neevidovano">(není uvedena)</em>');	
					}
				?>
			</h2>
                        <div class="space"></div>
		</div>
		<div>
			<h1>GPS</h1>
			<h2><?php printf(round($objekt->latitude, 6).",".round($objekt->longitude, 6)) ?></h2>
                        <div class="space"></div>
		</div>
		<div>
			<h1>Památková ochrana</h1>
			<h2>
				<?php
					if (strlen($objekt->pamatkova_ochrana) > 2) {
						printf('<a href="http://monumnet.npu.cz/pamfond/list.php?CiRejst='.$objekt->pamatkova_ochrana.'">'.$objekt->pamatkova_ochrana.'</a>');	
					} else {
						printf("ne");	
					}
				?>			
			</h2>
                        <div class="space"></div>
		</div>
	</div>