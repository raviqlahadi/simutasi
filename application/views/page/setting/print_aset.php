    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DATA USULAN PEMUSNAHAN ASET - <?php echo strtoupper($agency_data->name) ?></title>
        <style>
            @page {
                margin: 0;
            }

            body {
                padding: 0.8in;
                padding-top: 0.6in;
                padding-bottom: 0in;
            }

            #header1 {
                font-weight: bold;
                font-size: 1.2em;
            }



            img {
                max-height: 100px;
            }

            tr {
                min-height: 110px;
                padding: 10px;
            }

            #tebusan {
                font-size: 0.8em;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() . '/assets/' ?>DataTables/datatables.min.css" />
        <link href="<?php echo base_url() .  COREUI_PATH  ?>css/coreui.min.css" rel="stylesheet">
        <link href="<?php echo base_url() .  FONTAWESOME_PATH  ?>css/all.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered" id="table_aset">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>No. Registrasi</th>
                            <th>Merk/Type</th>
                            <th>Ukuran/CC</th>
                            <th>Bahan</th>
                            <th>Tahun Pembelian</th>
                            <th>Asal Usul</th>
                            <th>Unit</th>
                            <th>Harga</th>
                            <th>Akumulasi Penyusutan</th>
                            <th>Nilai Buku</th>
                            <th>Ket</th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <th><strong>1</strong></th>
                            <th><strong>2</strong></th>
                            <th><strong>3</strong></th>
                            <th><strong>4</strong></th>
                            <th><strong>5</strong></th>
                            <th><strong>6</strong></th>
                            <th><strong>7</strong></th>
                            <th><strong>8</strong></th>
                            <th><strong>9</strong></th>
                            <th><strong>10</strong></th>
                            <th><strong>11</strong></th>
                            <th><strong>12</strong></th>
                            <th><strong>13</strong></th>
                            <th><strong>14</strong></th>
                        </tr>
                        <?php
                        $no = 1;
                        foreach ($table_content as $key => $value) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $value->asset_code . "</td>";
                            echo "<td>" . $value->type . "</td>";
                            echo "<td>" . $value->register_number . "</td>";
                            echo "<td>" . $value->brand . "</td>";
                            echo "<td>" . $value->size . "</td>";
                            echo "<td>" . $value->material . "</td>";
                            echo "<td>" . $value->year_purchased . "</td>";
                            echo "<td>" . $value->origin . "</td>";
                            echo "<td>" . '' . "</td>";
                            echo "<td>" . $value->price . "</td>";
                            echo "<td>" . $value->depreciation . "</td>";
                            echo "<td>" . '' . "</td>";
                            echo "<td>" . '' . "</td>";
                            echo "</tr>";


                            $no++;
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        //var_dump($table_content);
        ?>
    </body>

    <script src=" <?php echo base_url() .  COREUI_PATH  ?>js/coreui.bundle.min.js"> </script>
    <script type="text/javascript" src="<?php echo base_url() . '/assets/' ?>js/jquery-3.5.1.min.js">
    </script>
    <script type="text/javascript" src="<?php echo base_url() . '/assets/' ?>DataTables/datatables.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>

    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_aset').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel',
                ],
                "lengthChange": true
            });
        });
    </script>

    </html>