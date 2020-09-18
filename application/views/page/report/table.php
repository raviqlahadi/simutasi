<?php 
if ($table_content != false) { ?>
    <table id="table" class="table table-responsive-sm table-striped table-borderless">
        <thead>
            <tr>
                <?php
                echo "<th>No</th>";
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
                foreach ($table_head as $key_head => $value_head) {
                    echo "<td>" . $value->{$key_head} .  "</td>";
                }

                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php } ?>