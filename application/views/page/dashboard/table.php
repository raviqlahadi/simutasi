<div class="table-responsive">
    <table class="table table-striped table-borderless">
        <thead>
            <tr>
                <?php
                echo "<th>No</th>";
                echo "<th><span class=''>Status</span></th>";
                echo "<th><span class=''>Alasan</span></th>";
                echo "<th><span class=''>Gambar</span></th>";

                foreach ($table_head as $key => $value) {
                    echo "<th>" . ucfirst($value) .  "</th>";
                }

                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;

            foreach ($table_content as $key => $value) {
                $no++;
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td><span class='badge badge-primary'>" . $value->status . "</span></td>";
                echo "<td class='text-warning'>" . ucwords($value->reason) . "</td>";
                if ($value->image != null) {
                    $image = '<img src="' . base_url('uploads/dokumentasi/') . $value->image . '" style="max-height:100px">';
                } else {
                    $image = "<a href='" . $page_url . "/deletion_image/" . $value->status_id . "'><i class='fa fa-image'> Upload </i></a>";
                }
                echo "<td>" . $image . "</td>";
                foreach ($table_head as $key_head => $value_head) {
                    echo "<td>" . $value->{$key_head} .  "</td>";
                }
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>