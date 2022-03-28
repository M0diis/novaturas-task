<?php
// Path: cms\layout_header.php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include(__DIR__."/../autoload.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Avialinijos</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Load Bootstrap5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Load Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <!-- Load Esri Leaflet -->
    <script src="https://unpkg.com/esri-leaflet@3.0.4/dist/esri-leaflet.js"></script>
    <script src="https://unpkg.com/esri-leaflet-vector@3.0.0/dist/esri-leaflet-vector.js"></script>

    <!-- Load Esri Leaflet Geocoder -->
    <script src="https://unpkg.com/esri-leaflet-geocoder@3.0.0/dist/esri-leaflet-geocoder.js"></script>

    <!-- Load Leaflet Control Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            osmAttrib = 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">2022 OpenStreetMap contributors</a>';

        var geocodeService = L.esri.Geocoding.geocodeService({
            apikey: "AAPKfa869c04abca4be7b67082007f71bd03dIOoH9wMrdc1IacMrk1yAWkHTNv9euC84dgU3abrG8E4VDxQdBnz8r_ZN7j8c8Zu"
        });

        const reverse = (latlng) =>
        {
            return new Promise((resolve, reject) =>
            {
                geocodeService.reverse().latlng(latlng).run((err, result) =>
                {
                    if (err) return reject(err);

                    return resolve(result);
                });
            });
        }

        const getMap = (lat, lng, zoom) =>
        {
            return new Promise((resolve, reject) =>
            {
                var map = new L.map('map', {
                    center: [lat, lng],
                    zoom: zoom,
                    layers: [
                        L.tileLayer(osmUrl, {
                            attribution: osmAttrib
                        })
                    ]
                });

                L.Control.geocoder().addTo(map);

                return resolve(map);
            });
        }

        const locationPopup = async (e, map, popup) =>
        {
            let result = await reverse(e.latlng);

            popup.setLatLng(e.latlng)
                .setContent("<b>Pasirinkote adresą:</b> <br> " + result.address.LongLabel)
                .openOn(map);
        }

        const filterTable = (col = 0) => 
        {
            var input, filter, table, tr, td, i, txtValue;

            input = document.getElementById("customSearch");
            filter = input.value.toUpperCase();

            table = document.getElementById("filterable-table");
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) 
            {
                td = tr[i].getElementsByTagName("td")[col];

                if (td) 
                {
                    txtValue = td.textContent || td.innerText;

                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } 
                    else 
                    {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div class="container-scroller">