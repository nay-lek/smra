
                <?php  $vidoeo_err = $_GET['err']; ?>
 
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                           <h4 class="modal-title" id="myModalLabel">แสดงวิธีแก้ไข Code := <?=$vidoeo_err;?></h4>
                        </div>
                            <div class="modal-body">
                                <div align="center">
                                    <div align="center" class="embed-responsive embed-responsive-16by9">
                                        <video width="860" height="480" controls >
                                            <source src="video/<?=trim($vidoeo_err);?>.mp4" type="video/mp4" />
                                        </video>
                                    </div>
                                </div>
                            </div>
                                 

                    </div>
                  </div>
                </div>