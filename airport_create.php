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

?>
<div class="content-wrapper">
    <div class="row">
    <div id="map" style="height: 50vh;"></div>
    <script type="text/javascript">
        (async() =>
        {
            var map = await getMap(54.635968, 25.2815694, 13);
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
            
            map.on('click', onMapClick);
        })();
    </script>

    
        <div class="col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">NAUJAS ORO UOSTAS</h5>

						<form action="/avialinija/airport_handler.php" method="post" autocomplete="off">
							<fieldset>
                                <div class="form-control-sm">
									<label class="field" for="country_iso" style="font-weight: bold">Šalis</label>
                                    <br>
                                    <p>Pasirinkite naujo oro uosto šalį.</p>
                                    <select id="country_iso" name="country_iso" class="form-control">
                                    <?php 
                                        $res = $mysqli->query("SELECT * FROM `countries`");
                            
                                        while($row = $res->fetch_assoc())
                                        {
                                            echo '<option value="'.$row['iso'].'">'.$row['name'].'</option>';
                                        }
                                    ?>
                                    </select>
                                </div>
							
								<div class="form-control-sm">
									<label class="field" for="lat" style="font-weight: bold">Ilguma</label>
                                    <p>Nurodykite ilgumą spausdami ant žemėlapio arba įrašydami į laukelį.</p>
									<input type="text" id="lat" name="lat" class="form-control">
                                </div>
								
								<div class="form-control-sm">
									<label class="field" for="lng" style="font-weight: bold">Platuma</label>
                                    <p>Nurodykite platumą spausdami ant žemėlapio arba įrašydami į laukelį.</p>
									<input type="text" id="lng" name="lng" class="form-control">
                                </div>			

								<div class="form-control-sm">
									<label class="field" for="address" style="font-weight: bold">Adresas</label>
                                    <p>Nurodykite adresą spausdami ant žemėlapio.</p>
									<input disabled type="text" id="address" name="address" class="form-control">
                                </div>
								
							</fieldset>

                            <button type="submit" name="create" class="btn btn-sm btn-success">Sukurti</button>
						</form>

                </div>
            </div>
        </div>
    </div>
    <!-- Another row start -->

    <!-- Another row end -->

</div>
<?php include(__DIR__."/cms/theme/layout_footer.php"); ?>