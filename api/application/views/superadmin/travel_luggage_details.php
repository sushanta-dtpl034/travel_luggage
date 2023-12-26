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
			
                if(isset($luggage_details)){
					
                    $scan_history_data=getQRScanHistory($luggage_details->AutoID);
                    $new_address =$luggage_details->Address ." ," .$luggage_details->Address2;
					 $type=1;
					$travel_details=[
						'HotelName'     =>($luggage_details->HotelName)?$luggage_details->HotelName:'-',
						'RoomNo'        =>($luggage_details->RoomNo)?$luggage_details->RoomNo:'-',
						'CheckInDate'   =>date('d-m-Y', strtotime($luggage_details->CheckInDate)),
						'CheckOutDate'  =>date('d-m-Y', strtotime($luggage_details->CheckOutDate)),
						'TraavelType'   =>$luggage_details->TraavelType,
						'TraavelFrom'   =>$luggage_details->TraavelFrom,
						'TraavelTo'     =>$luggage_details->TraavelTo,
						'AirlineName'   =>$luggage_details->AirlineName,
						'PnrNo'         =>$luggage_details->PnrNo,
						'TravelDate'    =>date('d-m-Y', strtotime($luggage_details->TravelDate)),
					];
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
					*/
                }else{
                    $type=0; 
                }

            ?>
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <?php if($type == 0) { ?>
                        <div class="row row-sm mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10">No Travel Details Added.</p>
                            </div>
                        </div>

                    <?php }else{  ?>
                    
                    <div class="panel profile-cover">
                        <div class="profile-cover__img mb-5">
                            <img src="<?= base_url().'/'.$luggage_details->ProfilePicture;?>"alt="img" class="profile-pic"> 
                            <h3 class="h3"><?= ($luggage_details)?$luggage_details->TitlePrefix:"";?> <?= ($luggage_details)?$luggage_details->Name:"";?></h3>
                            <p><b><?= ($luggage_details->QrCodeNo)?$luggage_details->QrCodeNo:"";?></b></p>
                        </div>
                        <div class="profile-cover__action2 bg-img"></div>
                    </div>

                    <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                    <h4 class="tx-15 text-uppercase mb-3 mt-3">User Details</h4>
                    <div class="row row-sm mt-4">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Contact Number</p>
                                <p><b><?= ($luggage_details)?$luggage_details->PhoneCountryCode:"";?> <?= ($luggage_details)?$luggage_details->PhoneNumber:" - ";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Whatsapp Number</p>
                                <p><b><?= ($luggage_details)?$luggage_details->WhatsAppCountryCode:"";?> <?= ($luggage_details)?!empty(trim($luggage_details->AltPhoneNumber))?$luggage_details->AltPhoneNumber:'-':" -";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10">Address </p>
                                <p><b><?=($luggage_details)?$luggage_details->Address:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Address2 </p>
                                <p><b><?= ($luggage_details)?$luggage_details->Address2:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Landmark </p>
                                <p><b><?= ($luggage_details)?$luggage_details->Landmark:"";?></b></p>
                            </div>
                        </div>
                    </div>


                    <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                    <h4 class="tx-15 text-uppercase mb-3 mt-3">Travel Details</h4>
                    
                    <div class="row row-sm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Travel Type </p>
                                <p><b><?= ($travel_details)?$travel_details['TraavelType']:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Airline</p>
                                <p><b><?= ($travel_details['TraavelType'] == 'Airline')?$travel_details['AirlineName']:"-";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> PNR No </p>
                                <p><b><?= ($travel_details['TraavelType'] == 'Airline')?$travel_details['PnrNo']:"-";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> From </p>
                                <p><b><?= ($travel_details)?$travel_details['TraavelFrom']:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> To </p>
                                <p><b><?= ($travel_details)?$travel_details['TraavelTo']:"";?></b></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10">Date  </p>
                                <p><b><?= ($travel_details)?$travel_details['TravelDate']:"";?></b></p>
                            </div>
                        </div>
						
                    </div>
                    <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                    <h4 class="tx-15 text-uppercase mb-3  mt-3">Hotel Details</h4>
                   
                    <div class="row row-sm">
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Hotel Name </p>
                                <p><b><?= ($travel_details)?$travel_details['HotelName']:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10"> Room No </p>
                                <p><b><?= ($travel_details)?$travel_details['RoomNo']:"";?></b></p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10">Check in Date  </p>
                                <p><b><?= ($travel_details)?$travel_details['CheckInDate']:"";?></b></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <p class="mg-b-10">Check Out Date  </p>
                                <p><b><?= ($travel_details)?$travel_details['CheckOutDate']:"";?></b></p>
                            </div>
                        </div>
						<div class="col-md-12">
                            <div class="form-group">
                                <?php
									if($this->session->userdata("userdata")){
									if($this->session->userdata('userdata')['UserRole'] == 3){ //&& empty($travel_details['RoomNo'])
									?>
									 <button class="btn btn-success updateRoomNo" data-id="<?= $luggage_details->AutoID;?>">Alert Room No</button>
								<?php } } ?>
                            </div>
                        </div>
                    </div>  
					
                    <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                    <h4 class="tx-15 text-uppercase mb-3  mt-3">Scan History</h4>
                   
                    <div class="row row-sm">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="" class="table table-bordered text-nowrap w-100">
                                    <thead>
                                        <tr role="row">
                                            <th>Address</th>
                                            <th>By</th>
                                            <th>Date & Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($scan_history_data as $history_data){?>
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
                    
                    <?php } ?>
						

                </div>
            </div>
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
<script>
sessionStorage.removeItem('returnurl');
sessionStorage.setItem("returnurl",window.location.href);
</script>