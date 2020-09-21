<div class="table-responsive">
    <table class="table table-striped table-borderless">
        <thead>
            <tr>
                <?php
                echo "<th>No</th>";

                foreach ($table_head as $key => $value) {
                    echo "<th>" . ucfirst($value) .  "</th>";
                }
                echo "<th>Aksi</th>";

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
                foreach ($table_head as $key_head => $value_head) {
                    echo "<td>" . $value->{$key_head} .  "</td>";
                }
                echo "<td><a class='btn btn-warning text-white' href='".site_url('asset/deletion/').$value->id."'>Cek Pengajuan</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>