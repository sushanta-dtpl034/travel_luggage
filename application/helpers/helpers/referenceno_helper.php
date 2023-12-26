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

function  get_previous_qrcode_sequence($last_insert_id,$current_year_month){
    $ci=& get_instance();
    $ci->load->database();
    //get sequence no
    $sql="SELECT ISNULL(SUM(NoofQRCode),0) AS TOTAL FROM QRCodeHeadMst WHERE  FORMAT (CreatedDate, 'yyyyMM')='$current_year_month' AND AutoID <>$last_insert_id";
    $query=$ci->db->query($sql);
    $row=$query->row();
    if($row){
        return $row->TOTAL;
    }else{
        return $row->TOTAL;
    }
}

function pre_generate_qrcode_sequence($company_id,$current_year_month){
    $ci=& get_instance();
    $ci->load->database();
    //get sequence no
    $sql="SELECT ISNULL(SUM(NoofQRCode),0) AS TOTAL FROM [dbo].[QRCodeHeadMst] WHERE  CompanyID=$company_id AND FORMAT (CreatedDate, 'yyyyMM')='$current_year_month'";
    $query=$ci->db->query($sql);
    $row=$query->row();
    if($row){
        return $row->TOTAL;
    }else{
        return $row->TOTAL;
    }
}

function string_ucword($value){
    $value=strtolower($value);
    return strtoupper($value);
}

function limit_text($text, $limit) {
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words); 
        $text  = substr($text, 0, $pos[$limit]) ;
    }
    return $text;
}

?>