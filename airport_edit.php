<?php
// Path: airports.php

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

?>
<div class="content-wrapper">
    <div class="row">
    <div id="map" style="height: 50vh;"></div>
    <script type="text/javascript">
        (async() =>
        {
            var map = await getMap(<?= $airport['lat'] ?>, <?= $airport['lng'] ?>, 13, 19);
            var popup = L.popup();

            async function onMapClick(e)
            {
                let result = await reverse(e.latlng);

                popup.setLatLng(e.latlng)
                    .setContent("<b>Pasirinkote adresą:</b> <br> " + result.address.LongLabel)
                    .openOn(map);

                    
                document.getElementById("address").value = result.address.LongLabel;
                
                document.getElementById("lat").value = e.latlng.lat;
                document.getElementById("lng").value = e.latlng.lng;
            }

            var marker = L.marker([<?= $airport['lat'] ?>, <?= $airport['lng'] ?>]).addTo(map);

            async function onMarkerClick(e)
            {
                document.getElementById("lat").value = e.latlng.lat;
                document.getElementById("lng").value = e.latlng.lng;

                let result = await reverse(e.latlng);
                document.getElementById("address").value = result.address.LongLabel;
            }

            marker.on('click', onMarkerClick);
            
            map.on('click', onMapClick);
        })();

        (async() =>
        {
            let result = await reverse(new L.LatLng(<?= $airport['lat'] ?>, <?= $airport['lng'] ?>));
            document.getElementById("address").value = result.address.LongLabel;
        })();
    </script>
        <div class="col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ORO UOSTAI</h5>
                    <form action="/avialinija/airport_handler.php" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-control-sm">
                                <label class="field" for="country_iso">Šalies kodas</label>
                                <input type="text" id="country_iso" name="country_iso" class="form-control" value=<?= $airport['country_iso'] ?>>
                            </div>
                        
                            <div class="form-control-sm">
                                <label class="field" for="lat">Ilguma</label>
                                <input type="text" id="lat" name="lat" class="form-control" value=<?= $airport['lat'] ?>>
                            </div>	
                            
                            <div class="form-control-sm">
                                <label class="field" for="lng">Platuma</label>
                                <input type="text" id="lng" name="lng" class="form-control" value="<?= $airport['lng'] ?>">
                            </div>			

                            <div class="form-control-sm">
                                <label class="field" for="address">Adresas</label>
                                <input disabled type="text" id="address" name="address" class="form-control">
                            </div>
                            
                            <input type="hidden" name="id" value="<?= $id ?>">

                            <div class="form-control-sm">
                                <button type="submit" name="update" class="btn btn-sm btn-success">Redaguoti</button>

                                <button type="submit" name="delete" class="btn btn-sm btn-danger">Ištrinti</button>

                                <button class="btn btn-sm btn-dark" type="button" data-bs-toggle="collapse" 
                                data-bs-target="#newAvialineCollapse" aria-expanded="false" aria-controls="newAvialineCollapse">Pridėti avialiniją</button>
                            </div>
                        </fieldset>
                    </form>

                    <hr>
                    <?php
                    $airportAvlines = getAvialines($mysqli, $id, true);

                    $excludes = [];

                    foreach($airportAvlines as $airavl)
                    {
                        $excludes[] = $airavl['avline_id'];

                        ?>
                        <form action="/avialinija/airport_handler.php" method="post" autocomplete="off">
                        <fieldset>
                            <div class="form-control-sm">
                                <label class="field" for="avline_name">Avialinijos pavadinimas</label>
                                <input disabled type="text" id="avline_name" name="avline_name" class="form-control" value=<?= $airavl['avline_name'] ?>>
                            </div>

                            <div class="form-control-sm">
                                <label class="field" for="country_iso">Šalies kodas</label>
                                <input disabled type="text" id="country_iso" name="country_iso" class="form-control" value=<?= $airavl['country_iso'] ?>>
                            </div>

                            <div class="form-control-sm">
                                <label class="field" for="country_name">Šalis</label>
                                <input disabled type="text" id="country_name" name="country_name" class="form-control" value=<?= $airavl['country_name'] ?>>
                            </div>
                            
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name="avline_id" value="<?= $airavl['avline_id'] ?>">

                            <div class="form-control-sm">
                                <button type="submit" name="remove_avline" class="btn btn-sm btn-danger">Ištrinti</button>
                            </div>
                        </fieldset>
                    </form>
                    <?php
                    }
                    ?>
                    
                    <div class="collapse" id="newAvialineCollapse">
                        <br>
                        <form action="/avialinija/airport_handler.php" method="post" autocomplete="off">
                            <fieldset>
                                <div class="form-control-sm">
                                    <label class="avline_id" for="address">Avialinija</label>
                                    <select id="avline_id" name="avline_id" class="form-control">
                                    <?php 
                                        $avlines = getAvlines($mysqli);
                            
                                        foreach($avlines as $avl)
                                        {
                                            if(!in_array($avl['id'], $excludes))
                                            {
                                                ?>
                                                <option value="<?= $avl['id'] ?>"><?= $avl['name'] ?></option>
                                                <?php
                                            }
                                        }
                                    ?>
                                    </select>
                                </div>

                                <input type="hidden" name="id" value="<?= $id ?>">

                                <div class="form-control-sm">
                                    <button type="submit" name="add_avline" class="btn btn-sm btn-success">Pridėti</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>	
                </div>
            </div>
        </div>
    </div>
    <!-- Another row start -->

    <!-- Another row end -->

</div>
<?php include(__DIR__."/cms/theme/layout_footer.php"); ?>