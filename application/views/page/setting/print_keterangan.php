    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
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

            #header2 {
                font-weight: bold;
                font-size: <?php echo (strlen($agency->name) <= 15) ? '1.4em'  : '1em'; ?>;
                text-transform: uppercase;
            }

            img {
                max-height: 60px;
            }

            #tebusan {
                font-size: 0.8em;
            }
        </style>
    </head>

    <body>
        <?php
        function get64($logo_path)
        {
            $path = $logo_path;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            return $base64;
        }

        function check_if_img_exist($url)
        {
            if (file_exists($url)) {
                return get64($url);
            } else {
                return get64(base_url(LOGO_PATH) . '/blank.png');
            }
        }

        //HEADER
        $agency_name = $agency->name;
        
        $agency_address = $agency->address;
        $logo_kota = get64(base_url(LOGO_PATH) . '/kota_kendari.png');

        $logo_opd = check_if_img_exist(base_url(LOGO_PATH) . '/' . $agency->code . '.png');


        $pemerintah_kota = '<span id="header1">PEMERINTAH KOTA KENDARI<span>';
        $nama_opd = '<span id="header2">' . $agency_name . '<span>';
        $alamat_opd = '<span id="header3">' . $agency_address . '<span>';
        $code_opd = $agency->code;

        $print = str_replace('PEMERINTAH_KOTA', $pemerintah_kota, $print);
        $print = str_replace('NAMA_OPD', $nama_opd, $print);
        $print = str_replace('ALAMAT_OPD', $alamat_opd, $print);
        $print = str_replace('CODE_OPD', $code_opd, $print);
        $print = str_replace('LOGO_PATH', $logo_kota, $print);
        $print = str_replace('LOGO_OPD', $logo_opd, $print);

        //Kadis
        $print = str_replace('NAMA_KADIS', $agency->nama_kadis, $print);
        $print = str_replace('NIP_KADIS', $agency->nip_kadis, $print);
        $print = str_replace('PANGKAT_KADIS', $agency->pangkat_kadis, $print);
        $print = str_replace('JABATAN_KADIS', $agency->jabatan_kadis, $print);

       

        //PENGURUS BARANG
        $print = str_replace('PENGURUS_BARANG', $agency->pengurus_barang, $print);
        $print = str_replace('NIP_PEBAR', $agency->nip_pebar, $print);

        //PERIHAL
        if ($perihal != '') $perihal = $perihal . ' dan ';
        $print = str_replace('PERIHAL', $perihal, $print);

        //TANGGAL
        function get_tanggal($tanggal)
        {
            $bulan = array(
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $split = explode('-', $tanggal);
            return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
        }
        $tanggal = get_tanggal(date('Y-m-d'));
        $print = str_replace('TANGGAL', $tanggal, $print);

        //TEBUSAN
        $tebusan_item = "<div id='tebusan'>
        1. Walikota Kota Kendari (sebagai laporan) di Kendari <br>
        2. Kepala Inspektorat Kota Kendari di Kendari<br>
        3. Kepala BKPSDM Kota Kendari di Kendari<br>
        4. Kepala BPKAD Kota Kendari di Kendari<br>
        5. Yang bersangkutan untuk diketahui<br>
        6. Arsip</tebusan>";
        $print = str_replace('TEBUSAN_ITEM', $tebusan_item, $print);

        echo $print;
        ?>
    </body>

    </html>