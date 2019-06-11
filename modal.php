
<?php //madal login ?>
<div class="modal fade" id="loginmodal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h2>เข้าสู่ระบบ</h2>
            </div>
            <div class="modal-body">
                <form role="form" action="f_login.php" method="post">
                    <div class="form-group">
                        <label for="username">UserName</label>
                        <input type="text" class="form-control" id="username" name ="username"
                        placeholder="ชื่อผู้ใช้">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name ="password"
                        placeholder="รหัสผ่าน">
                    </div>

                    <button type="submit" class="btn btn-success" > เข้าสู่ระบบ </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                </form>
            </div>
            <div class="modal-footer">
                ใช้ระบบ login เดียวกันกับ hosxp
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="logoutmodal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h2>ออกจากระบบ</h2>
            </div>
            <div class="modal-body">
                <form role="form" action="f_logout.php" method="post">
                    <button type="submit" class="btn btn-primary"> ออกจากระบบ </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ใช้รหัสเดิม</button>
                </form>
            </div>
            <div class="modal-footer">
                ระบบนี้ถูกพัฒนาเพื่อตรวจสอบความถูกต้องของการลงบันทึกการให้บริการ
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="connectmodal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h2>เชื่อมต่อฐานข้อมูล</h2>
            </div>
            <div class="modal-body">
                <form role="form" action="conn/connect.php" method="post">
                    <div class="form-group">
                       <input type="text" class="form-control" id="hostname" name ="hostname"
                        placeholder="Host Name">
                       <input type="text" class="form-control" id="dbname" name ="dbname"
                        placeholder="DB Name">
                       <input type="text" class="form-control" id="dbusername" name ="dbusername"
                        placeholder="DB User Name">
                       <input type="password" class="form-control" id="dbpassword" name ="dbpassword"
                        placeholder="DB Password">
                    </div>

                    <button type="submit" class="btn btn-success" > เข้าสู่ระบบ </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                </form>
            </div>
            <div class="modal-footer">
                กรุณาใช้เชื่อต่อระบบ HIS โรงพยาบาลของท่าน
            </div>
        </div>
    </div>
</div>




<?php //madal create pklog_sys ?>
<div class="modal fade" id="pklogmodal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <h2>ยืนยันการสร้างตาราง pklog_sys</h2>
            </div>
            <div class="modal-body">
                <form role="form" action="db/pklog.php" method="post">
                    <button type="submit" class="btn btn-success" > สร้าง </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">ปิด</button>
                </form>
            </div>
        </div>
    </div>
</div>