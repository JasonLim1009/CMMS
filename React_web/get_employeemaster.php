<?php
// get these values from your DB.

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header(
    "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"
);

require_once('config.php');
require_once ('functions.php');

$error_message;
$valid = true;


$site_cd = $_REQUEST['site_cd'];



$key[0] = "site_cd";
$key[1] = "emp_mst_empl_id";
$key[2] = "emp_mst_login_id";
$key[3] = "emp_mst_usr_grp";
$key[4] = "emp_mst_privilege_template";
$key[5] = "emp_mst_name";
$key[6] = "emp_mst_title";
$key[7] = "emp_mst_status";
$key[8] = "emp_det_supervisor_id";
$key[9] = "emp_supervisor_name";
$key[10] = "emp_mst_homephone";

$key[11] = "emp_mst_emg_name";
$key[12] = "emp_mst_emg_phone";
$key[13] = "emp_mst_dateofhire";
$key[14] = "emp_mst_sex";
$key[15] = "emp_mst_date_of_birth";
$key[16] = "emp_mst_marital_status";
$key[17] = "emp_mst_payrate";
$key[18] = "emp_mst_pay_period";
$key[19] = "emp_mst_remarks";
$key[20] = "emp_mst_create_by";

$key[21] = "emp_mst_create_date";
$key[22] = "emp_det_mr_approver";
$key[23] = "emp_det_mr_limit";
$key[24] = "emp_det_wo_budget_approver";
$key[25] = "emp_det_wo_approval_limit";
$key[26] = "emp_det_pr_approver";
$key[27] = "emp_det_pr_approval_limit";
$key[28] = "emp_det_wr_approver";
$key[29] = "emp_det_planner";
$key[30]= "emp_det_wo_gen_mr_pr";


$key[31] = "emp_det_time_card_enter";
$key[32] = "emp_det_time_card_void";
$key[33] = "emp_det_wo_sched";
$key[34] = "emp_det_po_buyer";
$key[35] = "emp_det_supervisor";
$key[36] = "emp_det_foreman";
$key[37] = "emp_det_asset_tag_flag";
$key[38] = "emp_det_msetup_mobile_user";
$key[39] = "emp_det_email_id";
$key[40] = "emp_det_craft";

$key[41] = "emp_det_work_area";
$key[42] = "emp_det_work_grp";
$key[43] = "emp_det_shift";
$key[44] = "emp_det_varchar1";
$key[45] = "emp_det_varchar2";
$key[46] = "emp_det_varchar3";
$key[47] = "emp_det_varchar4";
$key[48] = "emp_det_varchar5";
$key[49] = "emp_det_varchar6";
$key[50] = "emp_det_varchar7";

$key[51] = "emp_det_varchar8";
$key[52] = "emp_det_varchar9";
$key[53] = "emp_det_varchar10";
$key[54] = "emp_det_varchar11";
$key[55] = "emp_det_varchar12";
$key[56] = "emp_det_varchar13";
$key[57] = "emp_det_varchar14";
$key[58] = "emp_det_varchar15";
$key[59] = "emp_det_varchar16";
$key[60] = "emp_det_varchar17";

$key[61] = "emp_det_varchar18";
$key[62] = "emp_det_varchar19";
$key[63] = "emp_det_varchar20";
$key[64] = "emp_det_numeric1";
$key[65] = "emp_det_numeric2";
$key[66] = "emp_det_numeric3";
$key[67] = "emp_det_numeric4";
$key[68] = "emp_det_numeric5";
$key[69] = "emp_det_numeric6";
$key[70] = "emp_det_numeric7";

$key[71] = "emp_det_numeric8";
$key[72] = "emp_det_numeric9";
$key[73] = "emp_det_numeric10";
$key[74] = "emp_det_datetime1";
$key[75] = "emp_det_datetime2";
$key[76] = "emp_det_datetime3";
$key[77] = "emp_det_datetime4";

$key[78] = "emp_det_datetime5";
$key[79] = "emp_det_datetime6";
$key[80] = "emp_det_datetime7";
$key[81] = "emp_det_datetime8";
$key[82] = "emp_det_datetime9";
$key[83] = "emp_det_datetime10";

$key[84] = "emp_det_pm_generator";


$page 		= $_REQUEST['page'];
$pageSize 	= $_REQUEST['pageSize'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	
	$sql= "select totalPages = Count(*)/ '".$pageSize."' from emp_mst (NOLOCK)";

	$stmt = sqlsrv_query( $conn, $sql);

	if( !$stmt ) {
		 $error_message = "Error selecting table (Total Pages SQL)";
		 returnError($error_message);
		 die( print_r( sqlsrv_errors(), true));
	}

	do {
		 while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
		 $totalPages = $row['totalPages'];
		 }
	} while ( sqlsrv_next_result($stmt) );
		
	

	
    $sql ="	SELECT  *,emp_supervisor_name	 = 	(	SELECT 	a.emp_mst_name  FROM 	emp_mst a,  emp_det  														
						WHERE 	( emp_det.site_cd = a.site_cd )
						AND		( emp_det.emp_det_supervisor_id = a.emp_mst_empl_id ) 
						AND		( emp_det.site_cd = emp_mst.site_cd )  	
						AND     ( emp_det.mst_Rowid = emp_mst.RowID ) )
			FROM 		emp_mst,  emp_det   
			WHERE	( emp_mst.site_cd = emp_det.site_cd ) 
			AND  	( emp_mst.rowid = emp_det.mst_rowid ) 
			AND 	(emp_mst.site_cd = '".$site_cd."')
			AND 	emp_mst_status IS NOT NULL ORDER BY emp_mst_empl_id OFFSET ".($page  -1)*$pageSize." ROWS FETCH NEXT ".$pageSize." ROWS ONLY";

    $stmt = sqlsrv_query($conn, $sql);

    if (!$stmt) {
        $error_message = "Error selecting table (emp_mst)";
        returnError($error_message);
        die(print_r(sqlsrv_errors(), true));
    }

    $row_end = [];
    $header_end = [];
	 $header_result=[];

    do {
        while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
           /*  $row_result[$key[0]] = $row[$key[0]];
            $row_result[$key[1]] = $row[$key[1]];
            $row_result[$key[2]] = $row[$key[2]];
			$row_result[$key[3]] = $row[$key[3]];
			$row_result[$key[4]] = $row[$key[4]];
			$row_result[$key[5]] = $row[$key[5]];
			$row_result[$key[6]] = $row[$key[6]];
			$row_result[$key[7]] = $row[$key[7]];
			$row_result[$key[8]] = $row[$key[8]];
			$row_result[$key[9]] = $row[$key[9]];
			$row_result[$key[10]] =  validate_date($row[$key[10]]);
			
			$row_result[$key[11]] = $row[$key[11]];
            $row_result[$key[12]] = validate_date($row[$key[12]]);
            $row_result[$key[13]] = $row[$key[13]];
			$row_result[$key[14]] = $row[$key[14]];
			$row_result[$key[15]] = $row[$key[15]];
			$row_result[$key[16]] = $row[$key[16]];
			$row_result[$key[17]] = $row[$key[17]];
			$row_result[$key[18]] = $row[$key[18]]; */
			
			
			
			  $row_end[] = $row;
			

           // array_push($row_end, $row_result);

//            $result = [];
        }
    } while (sqlsrv_next_result($stmt));

    $final_result["result"] = $row_end;

    for ($x = 0; $x < count($key); $x++) {
        $sql =
            "select customize_header  from cf_label (NOLOCK) where column_name ='" .
            $key[$x] .
            "' and language_cd ='DEFAULT'";

        $stmt = sqlsrv_query($conn, $sql);

        if (!$stmt) {
            $error_message = "Error selecting table (emp_mst)";
            returnError($error_message);
            die(print_r(sqlsrv_errors(), true));
        }

        do {
            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                $header_result[ $row["customize_header"]] = $row["customize_header"];
			   //$header_result[  $key[$x]] = $row["customize_header"];
               // $header_result["accessor"] = "col" . ($x + 1);

                //array_push($header_end, $header_result);
            }
        } while (sqlsrv_next_result($stmt));

        $final_headername["header"] = $header_result;
    }
}

returnData($final_headername, $final_result,$key,$totalPages);

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

function returnData($final_headername, $final_result,$key,$totalPages)
{
    $returnData = [
        "status" => "SUCCESS",
        "message" => "Successfully",
		"header_count"=>sizeof($key),
		"totalPages"=>$totalPages,
    ];

    $returnData["data"] = array_merge($final_headername, $final_result);

    echo json_encode($returnData);
}

function returnError($error_message)
{
    $json = [];

    $returnData = [
        "status" => "ERROR",
        "message" => $error_message,
        "data" => $json,
    ];

    echo json_encode($returnData);
    exit();
}




 
?>