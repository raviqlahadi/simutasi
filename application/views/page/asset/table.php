
<table class="table table-responsive-sm table-striped table-borderless">
    <thead>
        <tr>
            <?php
            echo "<th>No</th>";
            foreach ($table_head as $key => $value) {
                echo "<th>" . ucfirst($value) .  "</th>";
            }
            echo "<th><span class='float-right'>Action</span></th>";

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
            $admin_root = ($this->session->level==1) ? true : false;
            echo "<td><span class='float-right'>".$this->table_template->action_dropdown_asset($page_url, $value->id, $admin_root)."</span></td>";
            echo "</tr>";
           
        }
        ?>
    </tbody>
</table>