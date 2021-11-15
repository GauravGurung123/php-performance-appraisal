<div class="row mt-2">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Show 
                <select name="page_no" id="">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select> Entries
                </h3> 
                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Department</th>
                        <th>Staff</th>
                        <?php if (checkPermission()): ?>
                        <th>Action</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="getTableData">
                <?php
                    while($row = mysqli_fetch_assoc($sel_depts)) {
                        global $ide;
                        ++$ide;
                        $id = $row['id'];
                        $name = ucwords($row['name']);
                        $number = $row['number'];

                        echo"<tr>";
                        echo"<td>{$ide}</td>";
                        echo"<td data-id='{$id}' onClick='showDetails(this)'>{$name}</td>";
                        echo"<td>{$number}</td>";
                        if (is_superadmin($_SESSION['role_id']) || is_admin($_SESSION['role_id'])){
                            
                            echo "<td><a class='bg-primary p-1' href='departments.php?source=edit_department&edit_department={$id}'>Edit</a>";
                            echo"<a rel='$id' class='del_link bg-danger p-1' href='javascript:void(0)'>Delete</a></small></td>";
                        }
                            echo"</tr>";
                    }?>
                    </tbody>
                    </table>
                    <div class="row mt-3">
                        <div class="col-sm-12 col-md-5">
                            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                                Showing 1 to 4 of 15 entries
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                                <ul class="pagination">
                                <?php
                                    for ($i=1; $i<=$count; $i++) {
                                        if ($i == $page ){
                                        echo "<li class='paginate_button page-item active'><a class='page-link active' href='staffs.php?page={$i}'>{$i}</a>";
                                        } else {
                                        echo "<li class='paginate_button page-item'><a class='page-link' href='staffs.php?page={$i}'>{$i}</a>";
                                    
                                        }
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div> 
                    <!-- ./row mt-3 -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- col-md-12 ended -->
</div>
<!-- /.row mt-2 ended -->
<div class="modal fade" id="modal-lg">

</div>
<!-- /.modal -->


<script>
function showDetails(el) {
    var showIds = el.getAttribute("data-id");
    // var url = "includes/modal_department_staff.php?"+$showIds,
    // $("#modal-lg").modal('show');
    // $("#idkl").html(showIds);

    $.ajax
        ({
            type: "GET",
            url: "includes/modal_department_staff.php/",
            data: "showIds="+showIds,
            success: function(data)
            {
                $("#modal-lg").html(data);
                $("#modal-lg").modal('show');
                console.log(data);
            }
        }); 
    }
</script>