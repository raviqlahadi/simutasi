<main class="c-main">
    <div class="container-fluid">
        <div id="ui-view">
            <div>
                <div class="fade-in">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <?php echo $page_title ?>


                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="<?php echo $page_url ?>" method="post">
                                                        <div class="row">
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <?php echo $this->form_template->select('OPD', 'agency_id', $select_agencies, (isset($form_value['agency_id']) ? $form_value['agency_id'] : null)) ?>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="type">Tipe Report</label>
                                                                    <select class="form-control" id="type" name="type">
                                                                        <option value="officer">ASN</option>
                                                                        <option value="asset">BMD</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group">
                                                                    <label for="filter">Filter</label>
                                                                    <select class="form-control" id="filter" name="filter">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <button type="submit" class="btn btn-warning text-white btn-block">Generate Report</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                                            <?php $this->load->view('page/report/table') ?>
                                        </div>
                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
    const typeSelect = document.getElementById('type')
    const filterSelect = document.getElementById('filter')

    var asnOption = ['semua', 'menggunakan', 'bebas']
    var assetOption = ['semua', 'kembali', 'verifikasi', 'digunakan']

    if (filterSelect.options.length == 0) {

        asnOption.forEach((opt) => {
            filterSelect.appendChild(addOption(opt))
        })

    }
    typeSelect.onchange = () => {
        let type_value = typeSelect.options[typeSelect.selectedIndex].value
        console.log(filterSelect.options)
        switch (type_value) {
            case 'officer':
                removeOpt(filterSelect.options.length)

                asnOption.forEach((opt) => {
                    filterSelect.appendChild(addOption(opt))
                })

                break;
            case 'asset':
                removeOpt(filterSelect.options.length)
                assetOption.forEach((opt) => {
                    filterSelect.appendChild(addOption(opt))
                })
                break;
            default:
                break;
        }
    }

    function removeOpt(length) {
        console.log(length)
        if (length > 0) {
            for (let i = 0; i < length; i++) {
                filterSelect.remove(filterSelect.options)

            }
        }
    }

    function addOption(opt) {
        var option = document.createElement('option')
        option.value = opt
        option.text = opt.charAt(0).toUpperCase() + opt.slice(1)
        return option
    }
</script>