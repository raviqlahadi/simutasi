
<table class="table table-responsive-sm table-striped table-borderless">
    <thead>
        <tr>
            <?php
            echo "<th>No</th>";
            foreach ($table_head as $key => $value) {
                echo "<th>" . ucfirst($value) .  "</th>";
            }
            echo "<th>Action</th>";

            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = $table_start_number;
        foreach ($table_content as $key => $value) {
            $no++;
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            foreach ($table_head as $key_head => $value_head) {
                echo "<td>" . $value->{$key_head} .  "</td>";
            }
            echo "<td>".$this->table_template->action_dropdown($page_url, $value->id,$page_url."?edit=true&id=".$value->id)."</td>";
            echo "</tr>";
           
        }
        ?>
    </tbody>
</table>