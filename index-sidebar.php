<h2><?php print($KV["nahodne_dilo"]) ?></h2>

<?php
    if ($PAGE["pocet_del"] == 0) {
        print ($KV["zadne_dilo"]);
    } else {
        $objects = array();
        $searches = 1;

        $i = 1;
        while ($i <= getCountRandomObjects()) {
                $obj = kv_random_object();

                $i++;

            if ($obj == null) {
                continue;
            }
            $objects[] = $obj;
        }

        foreach($objects as $obj) {
                echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';

                if ($obj->img_512 != null) {
                        echo '<a href="/katalog/dilo/'.$obj->id.'/">
                                <img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';
                } else {
                        echo '<a href="/katalog/dilo/'.$obj->id.'/">
                                <img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';
                }

                echo "<br /><br />";
        }

        if (sizeof ($objects) == 0) {
            print ($KV["zadne_dilo"]);
        }
    }
?>

<br /><br /><br /><br />
<h2><?php print($KV["posledni_pridane"]) ?></h2>

<?php
        $obj = kv_last_object();
        if ($obj == null) {
            print ($KV["zadne_dilo"]);
        } else {
            echo '<a href="/katalog/dilo/'.$obj->id.'/"><h3>'.$obj->nazev.'</h3></a>';

            if ($obj->img_512 != null) {
                    echo '<a href="/katalog/dilo/'.$obj->id.'/">
                            <img src="'.$uploadDir['baseurl'].$obj->img_512.'" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';				
            } else {
                    echo '<a href="/katalog/dilo/'.$obj->id.'/">
                            <img src="'.get_template_directory_uri().'-child-krizkyavetrelci/images/foto-neni-512.png" alt="'.$KV["ukazka_dila"].'" id="titulka-random-img" /></a>';	
            }			
        }
?>
