 <main class="c-main">
     <div class="container-fluid">
         <div id="ui-view">
             <div>
                 <div class="fade-in">
                     <div class="row">
                         <div class="col-12">
                            <div class="fade-in">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6 col-lg-3">
                                                    <div class="card text-white bg-gradient-primary">
                                                        <div
                                                            class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div class="text-value-lg"><?php echo $assets_count?></div>
                                                                <div> Aset BMD</div>
                                                            </div>
                                                            <div class="btn-group">
                                                                <button class="btn btn-transparent dropdown-toggle p-0" type="button"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                        href="#">Action</a><a class="dropdown-item" href="#">Another
                                                                        action</a><a class="dropdown-item" href="#">Something else
                                                                        here</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:50px;">
                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-lg-3">
                                                    <div class="card text-white bg-gradient-info">
                                                        <div
                                                            class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                            <div>
                                                                 <div class="text-value-lg"><?php echo $officers_count?></div>
                                                                <div> ASN</div>
                                                            </div>
                                                            <div class="btn-group">
                                                                <button class="btn btn-transparent dropdown-toggle p-0" type="button"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                        href="#">Action</a><a class="dropdown-item" href="#">Another
                                                                        action</a><a class="dropdown-item" href="#">Something else
                                                                        here</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:50px;">
                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-lg-3">
                                                    <div class="card text-white bg-gradient-warning">
                                                        <div
                                                            class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div class="text-value-lg"><?php echo $assets_bebas_count?></div>
                                                                <div> Aset Dikuasai</div>
                                                            </div>
                                                            <div class="btn-group">
                                                                <button class="btn btn-transparent dropdown-toggle p-0" type="button"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                        href="#">Action</a><a class="dropdown-item" href="#">Another
                                                                        action</a><a class="dropdown-item" href="#">Something else
                                                                        here</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="c-chart-wrapper mt-3" style="height:50px;">
                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-lg-3">
                                                    <div class="card text-white bg-gradient-danger">
                                                        <div
                                                            class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                                            <div>
                                                                <div class="text-value-lg"><?php echo $assets_dikuasai_count?></div>
                                                                <div> Tidak Dikuasai</div>
                                                            </div>
                                                            <div class="btn-group">
                                                                <button class="btn btn-transparent dropdown-toggle p-0" type="button"
                                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <i class="fa fa-cog"></i>
                                                                </button>
                                                                <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                        href="#">Action</a><a class="dropdown-item" href="#">Another
                                                                        action</a><a class="dropdown-item" href="#">Something else
                                                                        here</a></div>
                                                            </div>
                                                        </div>
                                                        <div class="c-chart-wrapper mt-3 mx-3" style="height:50px;">
                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <?php if ($this->session->flashdata('alert') !== null) echo $this->session->flashdata('alert') ?>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

     </div>
 </main>