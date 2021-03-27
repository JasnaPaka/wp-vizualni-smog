<h2>Mapa</h2>

<p id="titulka-mapa">
    Aktuálně je zmapováno umístění <strong><?php echo $PAGE["pocet_del"] ?> <?php print (getObjectPluralStr(kv_ObjektPocet())) ?></strong>.
</p>

<p id="titulka-mapa-img"><a href="/mapa/" title="Přejít na mapu">
        <img src="<?php bloginfo('template_url'); ?>-child-protileteckaobrana/images/kv-mapa.jpg" alt="Mapa" />
    </a></p>

<div id="titulka-mapa-button">
    <a href="/mapa/" class="button">Přejít na mapu</a>
</div>