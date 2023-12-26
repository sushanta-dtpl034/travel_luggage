<!-- Main Content-->
<style>
    .sp-container.sp-hidden{z-index: 20000 !important;}
    .profile-cover__action2{
        display: flex;
        padding: 216px 30px 10px 185px;
        border-radius: 5px 5px 0 0;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-pack: end;
        -webkit-box-pack: end;
        justify-content: flex-end;
        overflow: hidden;
        background-size: cover;
    }
	.profile-cover__img {
		top: 30px !important;
		bottom: 80px !important;
		height: 100px !important;
	}
</style>
<div class="main-content side-content pt-0">

    <div class="container-fluid">
        <div class="inner-body">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-5">Travel Luggage details</h2>
                </div>
            </div>
            <?php
               /*
                    if(!empty($luggage_details->HotelName) && !empty($luggage_details->RoomNo)){
                        $type=2;//Hotel Details
                        $travel_details=[
                            'HotelName'     =>$luggage_details->HotelName,
                            'RoomNo'        =>$luggage_details->RoomNo,
                            'CheckInDate'   =>date('d-m-Y', strtotime($luggage_details->CheckInDate)),
                            'CheckOutDate'  =>date('d-m-Y', strtotime($luggage_details->CheckOutDate)),
                            'TraavelFrom'   =>'-',
                            'TraavelTo'     =>'-',
                            'TravelDate'    =>'-',
                            'TraavelType'   =>'-',
                            'AirlineName'   =>'-',
                            'PnrNo'         =>'-',
                        ];
                    }else{
                        $type=1; //Travel Details
                        $travel_details=[
						'HotelName'     =>$luggage_details->HotelName,
                            'RoomNo'        =>$luggage_details->RoomNo,
                            'CheckInDate'   =>date('d-m-Y', strtotime($luggage_details->CheckInDate)),
                            'CheckOutDate'  =>date('d-m-Y', strtotime($luggage_details->CheckOutDate)),
                            'TraavelType'   =>$luggage_details->TraavelType,
                            'TraavelFrom'   =>$luggage_details->TraavelFrom,
                            'TraavelTo'     =>$luggage_details->TraavelTo,
                            'AirlineName'   =>$luggage_details->AirlineName,
                            'PnrNo'         =>$luggage_details->PnrNo,
                            'TravelDate'    =>date('d-m-Y', strtotime($luggage_details->TravelDate)),
                            'HotelName'     =>'-',
                            'RoomNo'        =>'-',
                            'CheckInDate'   =>'-',
                            'CheckOutDate'  =>'-',
                        ];
                    }
					
                }else{
                    $type=0; 
                }
                */
                // print_r($luggage_details);
                // exit;
                //t ( [regId] => 1515 [Name] => Mr.Sushanta Kumar Patra [Mobile] => +917208419657 [Address] => Bhubaneswar [City] => nexus exsplanade mall, Rasulgarh,Bhubaneswar,Odisha [State] => Near Rasulgarh Square [ProfileIMG] => [QrCodeNo] => 2023120001 )
            ?>
            <?php if(!$luggage_details){  ?>
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <div class="row row-sm mt-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p class="mg-b-10">No Travel Details Added.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <?php if($luggage_details){    ?>
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="panel profile-cover">
                                <div class="profile-cover__img mb-5">
                                    <?php if(empty($luggage_details->ProfileIMG) ){ ?> 
                                        <img src="<?= base_url()?>/assets/img/users/avatar-2.jpg"alt="img" class="profile-pic" height="80" width="80"> 
                                    <?php }else{  ?>
                                    <img src="<?= base_url().'/'.$luggage_details->ProfileIMG;?>"alt="img" class="profile-pic" height="80" width="80">
                                    <?php } ?> 
                                    <h3 class="h3"><?= ($luggage_details)?$luggage_details->Name:"";?></h3>
                                    <p><b><?= $luggage_details->QrCodeNo;?></b></p>
                                </div>
                                <div class="profile-cover__action2 bg-img"></div>
                            </div>


                            <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                            <h4 class="tx-15 text-uppercase mb-3 mt-3">User Details</h4>
                            <div class="row row-sm mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Contact Number</p>
                                        <p><b><?= ($luggage_details)?$luggage_details->Mobile:"";?></b></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Whatsapp  Number</p> 
                                        <p><a aria-label="Chat on WhatsApp" href="https://wa.me/<?= str_replace('+', '',  $luggage_details->CompanyCode)?><?= $luggage_details->ContactPersonMobile ?>" target="_blank"> <img alt="Chat on WhatsApp" src="https://static.xx.fbcdn.net/assets/?revision=197739703408370&name=platform-agnostic-green-medium-en-us&density=1" height="30" /> </a></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Address </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->Address:"";?></b></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Address2 </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->City:"";?></b></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Landmark </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->State:"";?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <div class="card custom-card overflow-hidden">
                    <div class="card-body">

                        <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                        <h4 class="tx-15 text-uppercase mb-3 mt-3">Travel Details</h4>
                        <div class="row row-sm">
                            <div class="table-responsive">
                                <table id="qrcode_show_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>Travel Type</th>
                                            <th>Airline</th>
                                            <th>PNR No</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                      
                                            $travelsDataObj=getTravelsData($luggage_details->TravelHeadId,'Air Travel'); 
                                            foreach($travelsDataObj as $travelsData){ 
                                        ?>
                                        <tr>
                                            <td><?= ($travelsData)?$travelsData->TravelType:"";?></td>
                                            <td><?= ($travelsData)?$travelsData->AirlineName:"";?></td>
                                            <td><?= ($travelsData)?$travelsData->PnrNo:"";?></td>
                                            <td><?= ($travelsData)?$travelsData->TravelFrom:"";?></td>
                                            <td><?= ($travelsData)?$travelsData->TravelTo:"";?></td>
                                            <td><?= ($travelsData)?date('d-m-Y', strtotime($travelsData->TravelDate)):"";?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                           

                      
                        <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                        <h4 class="tx-15 text-uppercase mb-3  mt-3">Hotel Details</h4>
                        <div class="row row-sm">
                            <div class="table-responsive">
                                <table id="qrcode_show_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Hotel Name</th>
                                            <th>Room No</th>
                                            <th>Check in Date</th>
                                            <th>Check Out Date</th>
                                            <th>To</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $HotelsDataObj=getTravelsData($luggage_details->TravelHeadId,'Hotel Stay'); 
                                            foreach($HotelsDataObj as $HotelData){ 
                                        ?>
                                        <tr>
                                            <td>
                                                <button class="btn btn-success updateRoomNo" data-id="<?= $HotelData->AutoID;?>">Alert Room No</button>
                                                <?php
                                                    if($this->session->userdata("userdata")){
                                                    if($this->session->userdata('userdata')['UserRole'] == 3){ //&& empty($travel_details['RoomNo'])
                                                    ?>
                                                    <button class="btn btn-success updateRoomNo" data-id="<?= $HotelData->AutoID;?>">Alert Room No</button>
                                                <?php } } ?>
                                            </td>
                                            <td><?= ($HotelData)?$HotelData->HotelName:"";?></td>
                                            <td><?= ($HotelData)?$HotelData->RoomNo:"";?></td>
                                            <td><?= ($HotelData)?date('d-m-Y', strtotime($HotelData->CheckInDate)):"";?></td>
                                            <td><?= ($HotelData)?date('d-m-Y', strtotime($HotelData->CheckOutDate)):"";?></td>
                                            <td><?= ($travelsData)?$travelsData->TravelTo:"";?></td>
                                            <td><?= ($travelsData)?date('d-m-Y', strtotime($travelsData->TravelDate)):"";?></td>
                                           
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                        <h4 class="tx-15 text-uppercase mb-3  mt-3">Land Transport Details</h4>
                        <div class="row row-sm">
                            <div class="table-responsive">
                                <table id="qrcode_show_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>Action</th>
                                            <th>Land Transfer Type</th>
                                            <th>Start Date/Time</th>
                                            <th>End Date/Time</th>
                                            <th>Vehicle No</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $landDataObj=getTravelsData($luggage_details->TravelHeadId,'Land Transport'); 
                                            foreach($landDataObj as $landData){ 
                                        ?>
                                        <tr>
                                            <td>
                                                <?php
                                                    if($this->session->userdata("userdata")){
                                                    if($this->session->userdata('userdata')['UserRole'] == 3){ //&& empty($travel_details['RoomNo'])
                                                    ?>
                                                    <button class="btn btn-success updateRoomNo" data-id="<?= $landData->AutoID;?>">Alert Room No</button>
                                                <?php } } ?>
                                            </td>
                                            <td><?= ($landData)?$landData->LandTransferType:"";?></td>
                                            <td><?= ($landData)?date('d-m-Y H:i', strtotime($landData->startDateTime)):"";?></td>
                                            <td><?= ($landData)?date('d-m-Y H:i', strtotime($landData->EndDateTime)):"";?></td>
                                            <td><?= ($landData)?$landData->VehicleNo:"";?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                        <h4 class="tx-15 text-uppercase mb-3  mt-3">Railway Travel Details</h4>
                        <div class="row row-sm">
                            <div class="table-responsive">
                                <table id="qrcode_show_table" class="table table-bordered border-t0 key-buttons text-nowrap w-100" >
                                    <thead>
                                        <tr>
                                            <th>Train Name</th>
                                            <th>Train Number</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $HotelsDataObj=getTravelsData($luggage_details->TravelHeadId,'Railway Travel'); 
                                            foreach($HotelsDataObj as $HotelData){ 
                                        ?>
                                        <tr>
                                            <td><?= ($HotelData)?$HotelData->TrainName:"";?></td>
                                            <td><?= ($HotelData)?$HotelData->TrainNumber:"";?></td>
                                            <td><?= ($HotelData)?date('d-m-Y', strtotime($HotelData->StartDate)):"";?></td>
                                            <td><?= ($HotelData)?date('d-m-Y', strtotime($HotelData->EndDate)):"";?></td>                                           
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                </div>
            
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">

                        <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                        <h4 class="tx-15 text-uppercase mb-3  mt-3">Scan History</h4>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table id="scanHistory" class="table table-bordered text-nowrap w-100">
                                        <thead>
                                            <tr role="row">
                                                <th>Address</th>
                                                <th>By</th>
                                                <th>Date & Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                           
                                            $scan_history_data=getQRScanHistory($luggage_details->TravelHeadId);
                                            foreach($scan_history_data as $history_data){?>
                                            <tr>
                                                <td><?= $history_data->Address; ?></td>
                                                <td><?= $history_data->ScanedByName; ?></td>
                                                <td><?= date('d-m-Y H:i a', strtotime($history_data->CreatedDate)) ;?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>     
                        </div>						

                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
</div>

<!-- Single QR Code Print-->
<div class="modal fade" id="UpdateTravelModal" tabindex="-1" role="dialog" aria-labelledby="UpdateTravelModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="UpdateTravelModal">Alert Room</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#UpdateTravelModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>           
                <div class="modal-body">
                    <div class="row row-sm">
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">Room No :</p>
                                <input type="text" name="RoomNo" id="RoomNo" class="form-control" required>
                            </div>
                            <input type="hidden" name="travel_id" id="travel_id" value="">
                        </div> 
                    </div>                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#UpdateTravelModal')">Close</button>
                    <button type="submit" class="btn btn-primary updateRoom">Update</button>
                </div>
           
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
sessionStorage.removeItem('returnurl');
sessionStorage.setItem("returnurl",window.location.href);

function getLocation() {
    return new Promise((resolve, reject) => {
        if ('geolocation' in navigator) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
            // Resolve the promise with the coordinates
            resolve({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude
            });
            },
            (error) => {
            // Reject the promise with an error message
            reject(`Error getting location: ${error.message}`);
            }
        );
        } else {
        // Geolocation is not supported
        reject('Geolocation is not supported by this browser.');
        }
    });
}

(function (){ 
    getLocation()
    .then((coordinates) => {
        // Use coordinates.latitude and coordinates.longitude as needed
       // console.log(`Latitude: ${coordinates.latitude}, Longitude: ${coordinates.longitude}`);
        const curLocation =window.location.href;
        // Get the current URL
        var url = new URL(curLocation);
        // Use URLSearchParams to get the value of 'ref_no'
        var refNo = url.searchParams.get("ref_no");
        $.ajax({
			url: "<?= base_url('Qrcode/update_scan_history');?>",
			type: 'post',
			data: {
                refNo:refNo,
				Lattitude: `${coordinates.latitude}`, 
                Longitude: `${coordinates.longitude}`
			},
			dataType: 'json',
			success: function(response){
                console.log(response);
				// if(response.status == 200){
				// 	$('#UpdateTravelModal').modal('hide'); 
				// 	alert('Room no alerted Successfully.')  
				// }else{
				// 	alert("Invalid ID.");
				// }
			}
		})
    })
    .catch((error) => {
        console.error(error);
    });
})();

</script>