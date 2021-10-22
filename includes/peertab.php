<div class="card card-info m-2">
                            <div class="card-header">
                                <h3 class="card-title">Peer Evaluation Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="peer_appraisal.php" method="post" class="col-10">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="exampleEvaluatorname" class="col-sm-6 col-form-label">Evaluator Name</label>
                                    <div class="col-sm-6">
                                    <input type="text" name="evaluatorname" class="form-control" 
                                    id="exampleEvaluatorname" value="<?php echo $_SESSION['name']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="exampleEvaluateename" class="col-sm-6 col-form-label">Evaluatee Name</label>
                                    <div class="col-sm-6">
                                    <select name="evaluateename" class="form-control select2" style="width: 100%;">
                                    <?php

                                        $query = "SELECT * from staffs";
                                        $sel_staffs = mysqli_query($connection, $query);
                                        confirm($sel_staffs);
                                        while($row = mysqli_fetch_assoc($sel_staffs)) {
                                            $id = $row['id'];
                                            $name = $row['name'];
                                            $username = $row['username'];

                                            echo '<option value="'. $name .'" ' . ($_SESSION['username']=='' . $username . ''  ? 'disabled="disabled"' : ''). '>' . $name .'</option>';

                                        }

                                        ?>
                                        
                                    </select>
                                    </div>
                                </div>
                                <span class="validity"><p>rating must be in range of 1 to 10.</p></span>
                                <?php

                                $query = "SELECT * from appraisal_criterias";
                                $sel_criterias = mysqli_query($connection, $query);
                                confirm($sel_criterias);
                                while($row = mysqli_fetch_assoc($sel_criterias)) {
                                    // $id = $row['id'];
                                    $name = ucwords($row['name']);
                                    $minimum = $row['minimum'];
                                    $maximum = $row['maximum'];

                                    echo "<div class='form-group row'>
                                <label for='example{$name}' class='col-sm-6 col-form-label'>{$name}</label>
                                    <div class='col-sm-2'>
                                    <input type='number' name='{$name}' class='form-control' 
                                    id='example{$name}' placeholder='1 to 10' min='{$minimum}' max='{$maximum}'  required>
                                    
                                    </div>
                                    <label for='examplefbk{$name}' class='col-sm-6 col-form-label'>Remarks</label>
                                    <div class='col-sm-6'>
                                    <input type='text' name='comment{$name}' class='form-control' 
                                    id='examplefbk{$name}' placeholder='your remarks' required>
                                    
                                    </div>
                                    </div><hr>";

                                }
                                ?>
                                </div>
                                <!-- /.card body-->
                                <div class="card-footer">
                                    <button type="submit" name="create_report" class="btn btn-info" data-toggle="modal" data-target="#modal-lg">Submit</button>
                                </div>
                                <!-- /.card-footer -->            
                            
                            </form>
                        </div>
                        <!-- ./card -->