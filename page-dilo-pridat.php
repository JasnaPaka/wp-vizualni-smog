<?php 
    $ROOT = plugin_dir_path( __FILE__ )."../../plugins/wpcity/";
    include_once $ROOT."controllers/ObjectController.php";

    $controller = new ObjectController();

    if (isset($_POST["dilo_submit"])) {
            $objekt = $controller->addPublic();
    } else {
            $objekt = $controller->getInitPublicForm();
    }

    get_header();
?>

<div id="page" class="index podnet pridat-dilo">
<div class="inner">
<div class="padding">

<?php include_once $ROOT."fw/templates/messages.php"; ?>
    
<p><?php print ($KV["pridat_dilo_info1"]) ?></p>

<p><?php print ($KV["pridat_dilo_info2"]) ?></p>

<form class="rows" method="post" enctype="multipart/form-data">

<h3><?php print ($KV["pridat_dilo_o_dile"]) ?></h3>

<div class="row">
    <label for="nazev"><?php print ($KV["pridat_dilo_nazev"]) ?></label>
    <input name="nazev" id="nazev" class="regular-text" type="text" value="<?php print ($objekt->nazev); ?>" maxlength="250" />
</div>

<div class="row">
    <label for="info"><?php print ($KV["pridat_dilo_informace"]) ?></label>
    <textarea id="info" name="info"><?php print ($objekt->info); ?></textarea>
    <p class="gray"><?php print ($KV["pridat_dilo_informace_det"]) ?></p>
</div>

<div class="row">
    <label>Fotografie:</label>
    <input type="file" id="photo" name="photo[]" multiple="multiple" /><br />
    <p class="gray"><?php print ($KV["pridat_dilo_informace_fot"]) ?></p>
</div>

<h3>Umístění</h3>

<p><?php print ($KV["pridat_dilo_mapa"]) ?></p>

<div class="row" style="padding-left: 0px">
    <div id="map-canvas" style="height: 500px"></div>
    <?php echo $controller->getGoogleMapPointEditContent($objekt->latitude, $objekt->longitude); ?>
</div>	

<div class="row" style="display:none">
    <label for="latitude">Latitude:</label>
    <input name="latitude" id="latitude" class="regular-text" type="text" value="<?php if ($objekt->latitude != 0) { print ($objekt->latitude); } ?>" maxlength="20" />
</div>
<div class="row" style="display:none">
    <label for="longitude">Longitude:</label>
    <input name="longitude" id="longitude" class="regular-text" type="text" value="<?php if ($objekt->longitude != 0) { print ($objekt->longitude); } ?>" maxlength="20" />
</div>

<?php if (!is_user_logged_in()) { ?> 

<h3>O vás</h3>

<p>Pokud chcete, můžete vyplnit své jméno a být u fotek uvedeni jako autoři.</p>

<div class="row">
    <label for="author">Autor:</label>
    <input name="author" id="author" class="regular-text" type="text" value="<?php print ($objekt->author) ?>" maxlength="250" />
</div>

<?php } ?>

<div id="pridat-button-div">
    <input class="button orange" name="dilo_submit" value="<?php print ($KV["pridat_dilo_submit"]) ?>" type="submit">
</div>


</form>
    
    
</div>
</div>
</div>

<?php 
    get_footer();
