<?php
include('dbconfig.php');
 
if(isset($_POST["date_from"], $_POST["date_to"])) {
    $createdDate = "";
    $query = "SELECT * FROM reports WHERE created_at BETWEEN '".$_POST["date_from"]."' AND '".$_POST["date_to"]."' GROUP BY report_id";
    $result = mysqli_query($connection, $query);
 
    $createdDate .='
    <table id="myTable" class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Report ID</th>
        <th>Created At</th>
        <th>Evaluator</th>
        <th>Evaluatee</th>'.
        <?php
        $query = "SELECT DISTINCT(criteria_id) as crit_id from reports";
        $criterias = mysqli_query($connection, $query);
        while($row = mysqli_fetch_assoc($criterias)) {
            $critId = $row['crit_id'];

            $query = "SELECT * from appraisal_criterias WHERE id = '$critId'";
            $col_crit = mysqli_query($connection, $query);
            if($row = mysqli_fetch_assoc($col_crit)) {
                $names = ucwords($row['name']);
                echo "<th>{$names}</th>";
            }
        }
?>. '
        <th>Total Score</th>
        <th>Average Score</th>
        <th>Remarks</th>
        
    </tr>
    </thead>';
 
    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            $reportId = $row['report_id'];
            $a1 = $row['evaluator_id'];
            $a2 = $row['evaluatee_id'];
            $created_at = $row['created_at'];
            $created_at = date("Y M j", strtotime($created_at));
            $createdDate .='
            <?php                   
                echo"<tr>";
                echo"<td class='text-center'>{$reportId}<br><small>
                <a class='bg-danger p-1' href='reports.php?delete={$reportId}'>del</a></small></td>";
                echo"<td>{$created_at}</td>";
                for($i=1;$i<3;$i++){
                    $var = "a".$i;
                    $q3 ="select username, name from staffs where id='".${$var}."'";
                    $results = mysqli_query($connection,$q3);
                    while($rows1=mysqli_fetch_assoc($results)){
                        $name1 = ucwords($rows1['name']);   
                        echo"<td>{$name1}<br> <small>({$rows1['username']})</small></td>";

                    }
                }
                $addCol = "SELECT COUNT(DISTINCT(criteria_id)) AS count FROM reports";
                $res = mysqli_query($connection,$addCol);
                while($rows=mysqli_fetch_assoc($res)){
                    $tc =  $rows['count'];
                    $tc1= $tc;
                    while($tc>=1){
                
                        $q2 = "SELECT criteria_id, remark,score FROM reports WHERE report_id = '$reportId'";
                        $val= mysqli_query($connection,$q2);
                        $c1=0;
                        $c2=0;
                            while($rows=mysqli_fetch_assoc($val)){
                                $c1=$c1+1; 
                                $q= $rows['score'];
                                $r = $rows['remark'];
                                global $g;
                                if($g){ break; }
                                $c2=$c2+1;
                                
                                echo"<td>{$q}<br>(<small>{$r}</small> )</td>";
                                
                            }
                                
                            $g=true;
                            $tc = $tc - 1 - $c2;
                            if(!($tc1==$c1)){
                            echo "<td>N/A</td>";
                            }
                    }
                    $g=false;
                      
                }
                $q3 = "SELECT SUM(score) AS total, AVG(score) AS avg, SUM(max_scale) AS scaleScore FROM reports WHERE report_id = '$reportId'";
                $val2= mysqli_query($connection,$q3);
                
                if ($rows = mysqli_fetch_assoc($val2)) {
                    $total  = $rows['total'];
                    $avg  = round($rows['avg']);
                    $scaleScore = $rows['scaleScore'];

                    $percentage = ($total/$scaleScore)*100;
                    echo"<td>{$total}</td>";
                    echo"<td>{$avg}</td>";
                    
                    $remarK_query = "SELECT * FROM remarks";    
                    $val3= mysqli_query($connection,$remarK_query);
                    if ($rows = mysqli_fetch_assoc($val3)) {
                        $twenty  = $rows['twenty'];
                        $fourty  = $rows['fourty'];
                        $sixty  = $rows['sixty'];   
                        $eighty  = $rows['eighty'];
                        $hundred  = $rows['hundred'];
                        
                        switch($percentage) {
                            case ($percentage<20):
                                echo"<td>{$twenty}</td>";
                                break;
                            case ($percentage>=20 && $percentage <40 ):
                                echo"<td>{$fourty}</td>";
                                break;
                            case ($percentage>=40 && $percentage <60 ):
                                echo"<td>{$sixty}</td>";
                                break;
                            case ($percentage>=60 && $percentage <80 ):
                                echo"<td>{$eighty}</td>";
                                break;
                            default:
                                echo"<td>{$hundred}</td>";
                                break;

                        }   
                        
                    }
                }
            }
                echo"</tr>";
        ?>






        }
    }
    else
    {
        $createdDate .= '
        <tr>
        <td colspan="5">No report Found</td>
        </tr>';
    }
    $createdDate .= '</table>';
    echo $createdDate;
}
?>