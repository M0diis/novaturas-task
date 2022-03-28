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
        <div class="col-xl-12 grid-margin">
            <div class="card">
                
                <div class="card-body">


                    <h5 class="card-title">AVIALINIJOS</h5>

                    <input class="form-control" type="text" id="customSearch" onkeyup="filterTable()" placeholder="Įrašykite avialinijos pavadinimą..">

                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-md table-hover" id="filterable-table">
                        <thead>
                            <tr>
                                <th>
                                    PAVADINIMAS
                                </th>
                                <th>
                                    ŠALIES KODAS
                                </th>
                                <th>
                                    ŠALIS
                                </th>
                                <th>
                                    REDAGAVIMAS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							
							$id = 0;

                            $avlines = getAvlines($mysqli, true);

							if(count($avlines) == 0)
							{
								echo "<tr><td colspan=3>Nėra sukurtų avialinijų.</td></tr>";
							}

                            foreach($avlines as $avl)
                            {
                               
                            ?>
                            <tr>
                                <td>
                                    <?= $avl['avline_name'] ?>
                                </td>
                                <td>
                                    <?= $avl['country_iso'] ?>
                                </td>
                                <td>
                                    <?= $avl['country_name'] ?>
                                </td>
                                <td>
                                    <a href="avline_edit.php?id=<?= $avl['avline_id'] ?>" target="_blank">
                                        <button type="button" class="btn btn-sm btn-primary">
                                            Redaguoti
                                        </button>
                                    </a>
                                </td>
                            </tr>

                            <?php
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>

                    <a href="avline_create.php" target="_blank">
                        <button type="button" class="btn btn-sm btn-primary">
                                Kurti naują
                        </button>
                    </a>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">ŠALYS BE AVIALINIJŲ</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-responsive-md table-hover">
                        <thead>
                            <tr>
                                <th>
                                    ISO
                                </th>
                                <th>
                                    PAVADINIMAS
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
							
							$id = 0;

                            $countries = getCountriesWithoutAvialines($mysqli);

							if(count($countries) == 0)
							{
								echo "<tr><td colspan=2>Nėra šalių be avialinijų.</td></tr>";
							}

                            foreach($countries as $c)
                            {
                               
                            ?>
                            <tr>
                                <td>
                                    <?= $c['iso'] ?>
                                </td>
                                <td>
                                    <?= $c['name'] ?>
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Another row start -->

    <!-- Another row end -->

</div>
<?php include(__DIR__."/cms/theme/layout_footer.php"); ?>