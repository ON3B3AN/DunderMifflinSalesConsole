<?php
require('../model/databaseConnect.php');
require('../model/paperQueries.php');
require('../model/Paper.php');

/*********************************************
 * Get request from user
 **********************************************/

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {
        $action = 'selectall';
    }
}

/**********************************************
 * Build and execute requested query
 **********************************************/
switch ($action) {
    case 'selectall':
        // get all rows
        $result = get_all();
        $message = '';

        // display results
        include('../view/papers.php');
        break;
    case 'insert':
        // insert one new row

        $pprCode = NULL;
        $venID = filter_input(INPUT_POST, 'venID');
        $pprType = filter_input(INPUT_POST, 'pprType');
        $pprSize = filter_input(INPUT_POST, 'pprSize');
        $pprColor = filter_input(INPUT_POST, 'pprColor');
        $pprWeight = filter_input(INPUT_POST, 'pprWeight');
        $pprImg = filter_input(INPUT_POST, 'pprImg');
        $pprQOH = filter_input(INPUT_POST, 'pprQOH');
        $pprPrice = filter_input(INPUT_POST, 'pprPrice');
        $pprLstMod = date("Y-m-d");

        $paper = new Paper($pprCode,$venID,$pprType,$pprSize,$pprColor,$pprWeight,$pprImg,$pprQOH,$pprPrice,$pprLstMod);

        $rows = insert($paper);

        if ($rows == NULL){
            $message = 'Row not inserted';
        }
        else {
            $result = get_all();
            $message = 'Row inserted';
        }
        // display results
        include('../view/papers.php');
        break;
    case 'delete':
        // delete selected row
        $pprCode = filter_input(INPUT_POST, 'pprCode');
        $rows = delete($pprCode);

        if ($rows == NULL){
            $message = 'Row not deleted';
        }
        else {
            $result = get_all();
            $message = 'Row deleted';
        }
        // display paper list
        include('../view/papers.php');
        break;
    case 'update':
        // update selected row
        $pprType = filter_input(INPUT_POST, 'pprType');
        $pprSize = filter_input(INPUT_POST, 'pprSize');
        $pprColor = filter_input(INPUT_POST, 'pprColor');
        $pprWeight = filter_input(INPUT_POST, 'pprWeight');
        $pprImg = filter_input(INPUT_POST, 'pprImg');
        $pprQOH = filter_input(INPUT_POST, 'pprQOH');
        $pprPrice = filter_input(INPUT_POST, 'pprPrice');

        $paper = new Paper($pprCode,$pprType,$pprSize,$pprColor,$pprWeight,$pprImg,$pprQOH,$pprPrice);

        $rows = insert($paper);

        if ($rows == NULL){
            $message = 'Row not updated';
        }
        else {
            $result = get_all();
            $message = 'Row updated';
        }
        // display results
        include('../view/papers.php');
        break;
}
?>