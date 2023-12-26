<?php 
function create_refno($index_assigned){
    switch(strlen($index_assigned))
    {
        case 1:
            $new_index_assigned = "000".$index_assigned;
            break;
        case 2:
            $new_index_assigned = "00".$index_assigned;
        break;
        case 3:
            $new_index_assigned = "0".$index_assigned;
            break;
        default:
            $new_index_assigned = $index_assigned;
    }
    $date=date("Y");
    $month=date("m");
    $format=$date.$month.$new_index_assigned;
    return $format;
}
?>