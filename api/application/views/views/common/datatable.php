<div class="table-responsive">
    <table class="table mb-0 text-nowrap text-md-nowrap" id="<?php echo $module;?>List">
        <thead>
            <tr>
                <th nowrap>Sr. No.</th>
                <?php 
                    $columnSettings = [];
                    $columnDefs = [];
                    $export = [];
                    $cnt = 0;
                    $expandableColumns = isset($expandableColumns) ? $expandableColumns : [];
                    foreach($columnsHeading as $row) { 		
                        $columnDefsCnt = count($columnDefs);	
                        
                        $setColumnDefs = false;
                        $columnSettings[$cnt]['data'] = $row['data'];
                        if(isset($row['renderClass'])){
                            $columnSettings[$cnt]['renderClass'] = $row['renderClass'];
                        }
                        if(isset($row['export']) && $row['export'] == 'Yes'){
                            $export[count($export)] =  $cnt+1;//because 1st column is serial no. 
                        }   
                        //set columnDefs : starts    
                        if(isset($row['visible'])){
                            $columnSettings[$cnt]['visible'] = $row['visible'];
                        }

                        if(isset($row['className']) && !empty($row['className'])){
                            $columnDefs[$columnDefsCnt]['className'] =  $row['className'];
                            $setColumnDefs = true;
                        }
                        if(isset($row['width']) && !empty($row['width'])){
                            $columnDefs[$columnDefsCnt]['width'] =  $row['width'];
                            $setColumnDefs = true;
                        }
                        if($setColumnDefs){
                            $columnDefs[$columnDefsCnt]['targets'] =  $cnt+1;//because 1st column is serial no. 
                        }
                        //set columnDefs : ends
                ?>
                    <th nowrap><?php echo $row['langLabel'];?></th>
                <?php $cnt++; } //foreach ?>

                <?php /*if ((isset($actionsSettings) && is_array($actionsSettings) && !empty($actionsSettings)) || (isset($extraActionButtons) && is_array($extraActionButtons) && !empty($extraActionButtons))) {*/
                if ((isset($actionsSettings) && is_array($actionsSettings) && !empty($actionsSettings) && ( isset($actionsSettings['edit']) || isset($actionsSettings['delete'])) ) || (isset($extraActionButtons) && is_array($extraActionButtons) && !empty($extraActionButtons))) {
                    $columnDefsCnt = count($columnDefs);
                    $columnDefs[$columnDefsCnt]['targets'] =  $cnt+1;
                    $columnDefs[$columnDefsCnt]['className'] =  'text-center'; ?>
                    <th nowrap>Action</th>
                <?php } ?>
            </tr>
        </thead>					
        <tbody>	</tbody>
        <?php if(isset($footerSettings['isFooter']) == 1){ ?>
        <tfoot>
            <tr>
                <th colspan="<?php echo $footerSettings['colColSPan1']; ?>" class="text-end" ><?php echo $footerSettings['colTitle']; ?></th>
                <th colspan="<?php echo $footerSettings['colColSPan2']; ?>" class="text-start"></th>
            </tr>
        </tfoot>
        <?php }  ?>
    </table>

</div>

<style>
	table.dataTable tfoot th.text-start{
		text-align: left !important;
	}
</style>
<?php
$query_params="";
if(isset($_GET['status'])){
    $status=$_GET['status'];
    $query_params.="?status=".$status;
}
//include any custom view if required like Model
if(isset($includeView) && is_array($includeView)){
    foreach($includeView as $vw){
        $this->load->view($vw);
    }   
}


$jsonColumnSettings = isset($columnSettings) && is_array($columnSettings) && !empty($columnSettings) ? json_encode($columnSettings) : json_encode([]);
$jsonExportSettings = isset($export) && is_array($export) && !empty($export) ? json_encode($export) : json_encode([]);

//$params['actionsSettings'] = ['add' => 'newpage', 'edit' => 'newpage', 'delete' => ''];  
$actionsSettings = isset($actionsSettings) && is_array($actionsSettings) && !empty($actionsSettings) ? json_encode($actionsSettings) : json_encode([]);

$editUrl = isset($customEditUrl) && $customEditUrl != '' ? $customEditUrl : '';
$delUrl = isset($customDelUrl) && $customDelUrl != '' ? $customDelUrl : '';
//to pass extra params to Lits page pass array from controller 
$listTopButtons = isset($listTopButtons) && $listTopButtons != '' ? $listTopButtons : [];

/* To pass extra Action buttons:
$params['extraActionButtons'][] = ["text" => "Fetch","faicon" => "fa fa-upload","className" => "btn btn-primary","id" => "fetchid","title"=> "Fetch data","href" => ""];
*/
$listActionButtons = isset($extraActionButtons) && $extraActionButtons != '' ? $extraActionButtons : [];

/* $params['listExtraParams'] = ['id' => $id]; */
$listExtraParams = isset($listExtraParams) && $listExtraParams != '' ? $listExtraParams : [];

/* extra params to send on add page. Ex. $params['addExtraParams'] ='pending/1/11'
so in controller method we can access this parameters as manage($id,$param1,$param2,$param3) 
*/
$addExtraParams = isset($addExtraParams) && $addExtraParams != '' ? '/0/'.ltrim($addExtraParams, '/') : '';

/* extra params to send on edit page : same as Add Parames */
$editExtraParams = isset($editExtraParams) && $editExtraParams != '' ? '/'.ltrim($editExtraParams, '/') : '';

/* each column level settings  */
$colSettings = isset($colSettings) && is_array($colSettings) && !empty($colSettings) ? $colSettings : [];
$rowSettings = isset($rowSettings) && is_array($rowSettings) && !empty($rowSettings) ? $rowSettings : [];
$footerSettings = isset($footerSettings) && is_array($footerSettings) && !empty($footerSettings) ? $footerSettings : [];
if (!empty($delUrl)) {  ?>
<script>let delExtraParams = {mode: 3}; </script>
<?php } ?>

<script>
let statusRecord = '<?= isset($status)?$status:''?>';
let listTopButtons = listExtraButtons = listActionButtons = listExtraParams = {};
let baseModule = '<?php echo $module;?>';

let configuredColumns = $.parseJSON('<?php echo $jsonColumnSettings;?>');
let exportSettings = $.parseJSON('<?php echo $jsonExportSettings;?>');
let actionsSettings = $.parseJSON('<?php echo $actionsSettings;?>');
let customEditUrl = '<?php echo $editUrl;?>';
const customDelUrl =  '<?php echo $delUrl;?>';

const addExtraParams =  '<?php echo $addExtraParams;?>';
const editExtraParams =  '<?php echo $editExtraParams;?>';
let orderListSetting = [[1, "<?= ($sortOrder)?$sortOrder:'desc'; ?>"]];//default =
let columnDefsSettings = [];
let expandableColumns = [];
let columnsHeading = [];

const queryParams =  '<?php echo $query_params;?>'; //getmethod data for getRecords()

/*  colsettings: where 1 : column number where we want to provide edit url
Ex1: [1 => ['url' => $params['module'].'manage/#ID#','search' => 'ID', 'replace' => 'AutoID', 'colValue' => 'Name','class'=>'']];
Ex2: [1 => ['default_edit' => 1, 'colValue' => 'Name','class'=>'']];
Ex3: [1 => ['default_view' => 1, 'colValue' => 'Name','class'=>'']];
Ex4: [1 => ['html_tag' => 'span','colValue' => 'Name','class'=>'primary']]; */
let colSettings = $.parseJSON('<?php echo json_encode($colSettings);?>');
let rowSettings = $.parseJSON('<?php echo json_encode($rowSettings);?>');
const footerParams = $.parseJSON('<?php echo json_encode($footerSettings);?>'); //{isFooter:false,columnNo:8,colTitle:"Total : ", colColSPan1:8,colColSPan2:2}; //footer

</script>
<?php if (!empty($listTopButtons)) { ?>
    <script>listTopButtons = $.parseJSON('<?php echo json_encode($listTopButtons);?>'); </script>
<?php }
if (!empty($listExtraButtons)) { ?>
     <script>listExtraButtons = $.parseJSON('<?php echo json_encode($listTopButtons);?>'); </script>
<?php } 
 if (!empty($listActionButtons)) { ?>
     <script>listActionButtons = $.parseJSON('<?php echo json_encode($listActionButtons);?>'); </script>
<?php } ?>

<?php if (!empty($listExtraParams)) { ?>
     <script>listExtraParams = $.parseJSON('<?php echo json_encode($listExtraParams);?>'); </script>
<?php } 
if (!empty($order) && !empty($order)) { ?>
    <script>orderListSetting = $.parseJSON('<?php echo json_encode($order);?>'); </script>
<?php }
if (!empty($columnDefs)) {?>
    <script>columnDefsSettings = $.parseJSON('<?php echo json_encode($columnDefs);?>');</script>
<?php } if (!empty($expandableColumns)) {?>
    <script>expandableColumns = $.parseJSON('<?php echo json_encode($expandableColumns);?>'); </script>
<?php } if (!empty($columnsHeading)) {?>
    <script>columnsHeading = $.parseJSON('<?php echo json_encode($columnsHeading);?>'); </script>
<?php } ?>

<script>
$(document).on("click", ".delete", function() { 
	$('#danger-alert-modal').modal('show');
	$('#updateid').val($(this).attr("data-id"));
	$('#danger-alert-modal').modal({backdrop: true, keyboard:false}, 'show');
});


$(document).on("click", "#danger-alert-modal", function() { 
	$('#danger-alert-modal').modal('hide');
});
</script>
