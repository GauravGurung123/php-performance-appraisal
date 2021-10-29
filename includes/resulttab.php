<div class="row"> 
                    <div class="col col-5 border-right">
                      <?php
                      $query = "SELECT * FROM remarks";
                      $remarks_query = mysqli_query($connection, $query);

                      while($row = mysqli_fetch_assoc($remarks_query)) {
                          $id = $row['id'];
                          $twenty = $row['twenty'];
                          $fourty = $row['fourty'];
                          $sixty = $row['sixty'];
                          $eighty= $row['eighty'];
                          $hundred= $row['hundred'];
                      }

                      if(isset($_POST['edit_remark'])) {
                        $twenty = trim($_POST['twenty']);
                        $fourty = trim($_POST['fourty']);
                        $sixty = trim($_POST['sixty']);
                        $eighty = trim($_POST['eighty']);
                        $hundred = trim($_POST['hundred']);

                        $query = "UPDATE remarks SET ";
                        $query .="twenty = '{$twenty}', fourty = '{$fourty}',sixty = '{$sixty}',eighty = '{$eighty}', hundred = '{$hundred}' ";
                        $query .="WHERE id = 1 ";
                        $log_action="remarks updated";
                        create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

                        $update_remarks_query = mysqli_query($connection, $query);
                        confirm($update_remarks_query);
                        header('Location: '.$_SERVER['PHP_SELF']);
                        die;
                      }
                      ?>  
                      <form action="" class="col" method="post" autocomplete="on">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="extwenty">0% - 20%</label>
                                <input type="text" class="form-control" id="extwenty" name="twenty" value="<?php echo $twenty ?>">
                                <label for="exfourty">20% - 40%</label>
                                <input type="text" class="form-control" id="exfourty" name="fourty" value="<?php echo $fourty ?>">
                                <label for="exsixty">40% - 60%</label>
                                <input type="text" class="form-control" id="exsixty" name="sixty" value="<?php echo $sixty ?>">
                                <label for="exeighty">60% - 80%</label>
                                <input type="text" class="form-control" id="exeighty" name="eighty" value="<?php echo $eighty ?>">
                                <label for="exhundred">80% - 100%</label>
                                <input type="text" class="form-control" id="exhundred" name="hundred" value="<?php echo $hundred ?>">
                                
                            </div>
                            <button type="submit" id="submit" name="edit_remark" class="btn btn-primary">Save</button>
                            
                        </div>
                        <!-- /.card-body -->
                      </form>
                    </div>
                    <!-- col-5 border-right  ended -->
                              
                    <div class="col col-7 pl-2">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                          <th>0% - 20%</th>
                          <th>20% - 40%</th>
                          <th>40% - 60%</th>
                            <th>60% - 80%</th>
                            <th>80% - 100%</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM remarks";
                            $sel_remarks = mysqli_query($connection, $query);
                
                            if($row = mysqli_fetch_assoc($sel_remarks)) {
                                $id = $row['id'];
                                $twenty = ucwords($row['twenty']);
                                $fourty = ucwords($row['fourty']);
                                $sixty = ucwords($row['sixty']);
                                $eighty = ucwords($row['eighty']);
                                $hundred = ucwords($row['hundred']);
                            
                          echo"<tr>";
                            echo"<td>{$twenty}</td>";
                            echo"<td>{$fourty}</td>";
                            echo"<td>{$sixty}</td>";
                            echo"<td>{$eighty}</td>";
                            echo"<td>{$hundred}</td>";
                            "</tr>";
                
                          }?>         
                        </tbody>
                      </table>
                    </div>
                    <!-- col-7 ended -->
                  </div>
                  <!-- row ended -->