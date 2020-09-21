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



            img {
                max-height: 100px;
            }

            tr {
                min-height: 110px;
                padding:10px;
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
        $image_placeholder = "";
        $no = 1;
        foreach ($table_content as $key => $value) {
            $image_placeholder = $image_placeholder . "<tr>";
            $image_placeholder = $image_placeholder . "<td style='text-align:center'>" . $no . "</td>";
            $image_placeholder = $image_placeholder . "<td style='text-align:center'>" . $value->asset_code . "</td>";
            $image_placeholder = $image_placeholder . "<td style='text-align:center'>" . $value->type."<br>".$value->brand . "</td>";
            $image_placeholder = $image_placeholder . "<td style='text-align:center'>" . $value->register_number . "</td>";
            $img = get64(base_url('uploads/dokumentasi/') . $value->image);

            //$img = check_if_img_exist(base_url('uploads/dokumentasi/') . $value->image);
            $image_placeholder = $image_placeholder . "<td style='min-height:200px'><p><img src='" . $img . "' max-height:'100px'></p></td>";
            $image_placeholder = $image_placeholder . "</tr>";
            $no++;
        }

        //var_dump($image_placeholder);
        $print = str_replace('<tr>
					</tr>', $image_placeholder, $print);
        echo $print;
        ?>
    </body>

    </html>