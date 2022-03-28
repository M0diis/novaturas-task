<?php
// Path: airport_create.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__."/cms/theme/layout_header.php");
include(__DIR__."/cms/theme/navigation.php");

$id = -1;

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}

$airport = getAirport($mysqli, $id);
$countries = getCountries($mysqli);

?>
<div class="content-wrapper">
    <div class="row">    
        <div class="col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">NAUJA ORO LINIJA</h5>
                    <form action="/avialinija/avline_handler.php" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-control-sm">
                                <label class="field" for="country_iso" style="font-weight: bold">Šalis</label>
                                <br>
                                <p>Pasirinkite naujos oro linijos šalį.</p>
                                <select id="country_iso" name="country_iso" class="form-control">
                                <?php 
                                    foreach($countries as $c)
                                    {
                                        echo '<option value="'.$c['iso'].'">'.$c['name'].' ('.$c['iso'].')</option>';
                                    }
                                ?>
                                </select>
                            </div>
                        
                            <div class="form-control-sm">
                                <label class="field" for="name" style="font-weight: bold">Pavadinimas</label>
                                <p>Nurodykite naujos oro linijos pavadinimą.</p>
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                            
                            <div class="form-control-sm">
                                <button type="submit" name="create" class="btn btn-sm btn-success">Sukurti</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Another row start -->

    <!-- Another row end -->

</div>
<?php include(__DIR__."/cms/theme/layout_footer.php"); ?>