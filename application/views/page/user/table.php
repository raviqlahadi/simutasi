
<table class="table table-responsive-sm table-striped table-borderless">
    <thead>
        <tr>
            <?php
            echo "<th style='max-width:20px'>No</th>";
            foreach ($table_head as $key => $value) {
                echo "<th>" . ucfirst($value) .  "</th>";
            }
            echo "<th><span class=''>Profil</span></th>";
            echo "<th><span class=''>Password</span></th>";
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
            echo "<td><a href='".site_url()."profile/index/".$value->id. "' class='btn btn-small btn-info text-white'>Profile</a></td>";
            echo "<td><a href='" . site_url() . "user/password/" . $value->id . "' class='btn btn-small btn-warning text-white'>Password</a></td>";
            echo "<td><span class='float-right'>".$this->table_template->action_dropdown($page_url, $value->id)."</span></td>";
            echo "</tr>";
           
        }
        ?>
    </tbody>
</table>