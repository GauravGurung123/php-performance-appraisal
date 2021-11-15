<div class="card card-info m-2">
                            <div class="card-header">
                                <h3 class="card-title">Self Appraisal Form</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="" method="post">
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
                                        <input type="text" name="evaluatorname" class="form-control" 
                                        id="exampleEvaluateename" value="self" disabled>
                                        </div>
                                    </div>            
                                    <span class="validity"><p>rating must be in range of 1 to 10.</p></span>

                                    <?php
                                    $query = "SELECT * from appraisal_criterias";
                                    $sel_criterias = mysqli_query($connection, $query);
                                    confirm($sel_criterias);
                                    while($row = mysqli_fetch_assoc($sel_criterias)) {
                                        $input_name = $row['name'];
                                        $input_name = strtok($input_name, " ");
                                        $name = ucwords($row['name']);
                                        $query = "SELECT * FROM scales";
                                        $sel_scl = mysqli_query($connection, $query);
                                        if($row = mysqli_fetch_assoc($sel_scl)) {
                                            $min = $row['minimum'];
                                            $max = $row['maximum'];
                                        }
    
                                        echo "<div class='form-group row'>
                                        <label for='example{$name}' class='col-sm-6 col-form-label'>{$name}</label>
                                            <div class='col-sm-2'>
                                            <input type='number' name='{$input_name}' onblur='handleValue(this, {$min}, {$max})' 
                                            class='form-control' onfocus='handleFocus(this)' min='{$min}' max='{$max}'
                                            id='example{$name}' placeholder='{$min} to {$max}'>
                                            </div>
                                            <label for='examplefbk{$name}' class='col-sm-6 col-form-label'>Remarks</label>
                                            <div class='col-sm-6'>
                                            <input type='text' name='comment{$input_name}' class='form-control' 
                                            id='examplefbk{$name}' placeholder='your remarks'>
                                            
                                            </div>
                                            </div><hr>";

                                    }
                                    ?>  
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                <button type="submit" name="self_report" class="btn btn-info">Submit</button>
                                </div>
                                <!-- /.card-footer -->
                            </form>
                        </div>
                        <!-- ./card -->