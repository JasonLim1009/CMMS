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
$error_message;
$valid = true;


$site_cd = $_REQUEST['site_cd'];
$RowID = $_REQUEST['RowID'];




$sql= "	SELECT 	 itm_loc.site_cd,   

				 itm_loc.itm_loc_order_pt,
				 itm_loc.itm_loc_lockout4count,
				 itm_loc.itm_loc_prim_locn_flg,
				 itm_loc.itm_loc_stk_loc,
				 itm_loc.itm_loc_inc_ttloh,
			 	 itm_loc.itm_loc_stock_cost_flag,
			 	 itm_loc.itm_loc_oh_qty,
				 itm_loc.itm_loc_order_pt,
				 itm_loc.itm_loc_minimum,
				 itm_loc.itm_loc_hard_resrv,
				 itm_loc.itm_loc_short_qty,
				 itm_loc.itm_loc_create_date,
				 itm_loc.itm_loc_lastactdate,
			 	 itm_loc.itm_loc_lastcntdate,
				 itm_loc.itm_loc_next_cnt_date,
  
				 itm_loc.RowID 
				 
		FROM 	itm_loc (NOLOCK)
		WHERE 	itm_loc.site_cd = '".$site_cd."'
		and 	itm_loc.RowID='".$RowID."'ORDER BY itm_loc_stk_loc";

	$stmt_itm_loc = sqlsrv_query( $conn, $sql);

	if( !$stmt_itm_loc ) {
		 $error_message = "Error selecting table (itm_loc Drop Down)";
		 returnError($error_message);
		 die( print_r( sqlsrv_errors(), true));
		 
	}

	 $AssetLocation = array();

	do {
		 while ($row = sqlsrv_fetch_array($stmt_itm_loc, SQLSRV_FETCH_ASSOC)) {	
		 
			   $AssetLocation[] = $row;
		
		 }
	} while ( sqlsrv_next_result($stmt_itm_loc) );
	
	
returnData($AssetLocation);

sqlsrv_free_stmt($stmt_itm_loc);
sqlsrv_close($conn);

function returnData($AssetLocation)
{
    $returnData = [
        "status" => "SUCCESS",
        "message" => "Successfully",
		"data"=>$AssetLocation
    ];

   

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