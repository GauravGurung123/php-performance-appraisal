<div class="row"> 
                       <!-- update scale form -->
                       <?php
                        $query = "SELECT * FROM scales";
                        $scales_query = mysqli_query($connection, $query);

                          while($row = mysqli_fetch_assoc($scales_query)) {
                              $id = $row['id'];
                              $minimum = $row['minimum'];
                              $maximum = $row['maximum'];
                          }
                          if(isset($_POST['update_scale'])) {
                            $minimum = trim($_POST['minimum']);
                            $maximum = trim($_POST['maximum']);
                            $query = "UPDATE scales SET ";
                            $query .="minimum = '{$minimum}', maximum = '{$maximum}'";
                            $query .="WHERE id = 1 ";
                            $log_action="Scale range updated";
                            create_log($_SERVER['REMOTE_ADDR'], $_SESSION['username'], $_SERVER['HTTP_USER_AGENT'], $log_action);

                            $update_scales_query = mysqli_query($connection, $query);
                            confirm($update_scales_query);
                            header('Location: '.$_SERVER['PHP_SELF']);
                          }
                      ?>
                      <form action="" method="post" autocomplete="on">
                        <div class="card-body">
                          <div class="form-group">
                            <p>Set new scale range </p>
                            <div class="row">
                              <div class="col-4">
                                <input type="number" class="form-control" id="exampleMinimum" name="minimum" value="<?php echo $minimum;?>" placeholder="min: <?php echo $minimum;?>"> 
                              </div>
                              <div class="col-4">
                                  <input type="number" class="form-control" id="exampleMaximum" name="maximum" value="<?php echo $maximum;?>" placeholder="max: <?php echo $maximum;?>">
                              </div>                              
                              <div class="col-4">
                              <button type="submit" id="submit" name="update_scale" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <!-- /.card-body -->
                      </form>
                  </div>
                  <!-- row ended -->