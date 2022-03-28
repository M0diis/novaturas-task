<?php
// Path: airports.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__."/cms/theme/layout_header.php");
include(__DIR__."/cms/theme/navigation.php");
?>
<div class="content-wrapper">
    <div class="row">
    <div id="map" style="height: 50vh;"></div>
    <script type="text/javascript">
        (async() =>
        {
            const map = await getMap(54.96779482, 24.07233345, 11);

            <?php
            $airports = getAirports($mysqli, true);

            foreach($airports as $airport)
            {
                ?>
                var marker = L.marker([<?= $airport['lat'] ?>, <?= $airport['lng'] ?>]).addTo(map);
                <?php
            }
            ?>           

           map.on('click', (e) => {
                locationPopup(e, map, L.popup());
            });
        })();
    </script>
        <div class="col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ORO UOSTAI</h5>

                    <input class="form-control" type="text" id="customSearch" onkeyup="filterTable(2)" placeholder="Įrašykite šalies pavadinimą..">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-md table-hover" id="filterable-table">
                        <thead>
                            <tr>
                                <th>
                                    ILGUMA
                                </th>
                                <th>
                                    PLATUMA
                                </th>
                                <th>
                                    ŠALIS
                                </th>
                                <th>
                                    AVIALINIJOS
                                </th>
                                <th>
                                    REDAGAVIMAS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							
							$id = 0;

							if(count($airports) == 0)
							{
								echo "<tr><td colspan=5>Nėra sukurtų oro uostų.</td></tr>";
							}

                            foreach($airports as $ap)
                            {
                               
                            ?>
                            <tr>
                                <td>
                                    <?= $ap['lat'] ?>
                                </td>
                                <td>
                                    <?= $ap['lng'] ?>
                                </td>
                                <td>
                                    <?= $ap['country_name'] ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#avialines_<?= $ap['id'] ?>">
                                        Peržiūrėti avialinijas
                                    </button>
                                </td>
                                <td>
                                    <a href="airport_edit.php?id=<?= $ap['id'] ?>" target="_blank">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Redaguoti
                                        </button>
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="avialines_<?= $ap['id'] ?>" tabindex="-1" aria-labelledby="label_<?= $ap['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="label_<?= $ap['id'] ?>">Avialinijų peržiūra</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                    <?php
                                                    
                                                    $id = 0;

                                                    $avlines = getAvialines($mysqli, $ap['id'], true);

                                                    if(count($avlines) == 0)
                                                    {
                                                        echo "Nėra avialinijų pagal šį oro uostą.";
                                                    }

                                                    foreach($avlines as $avl)
                                                    {

                                                        echo $avl['avline_name'];
                                                        echo '<br>';
                                                    }
                                                    ?>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Uždaryti</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <?php
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>

                    <a href="airport_create.php" target="_blank">
                        <button type="button" class="btn btn-sm btn-primary">
                                Kurti naują
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Another row start -->

    <!-- Another row end -->

</div>
<?php include(__DIR__."/cms/theme/layout_footer.php"); ?>