<?php error_reporting(0);?>
<!-- Main Content-->
<style>
    .sp-container.sp-hidden{z-index: 20000 !important;}
    .profile-cover__action2{
        display: flex;
        padding: 160px 30px 10px 185px;
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
    .mobile-no{
        height:30px;
        border-radius:4px;
        font-weight: 500;
        width:145px;
        line-height: 22px;
    }
    .whatsapp-no-div{
        height:30px;
        width:165px 
    }
    .whatsapp-no{
        height:30px;
        width:165px;
        object-fit:cover;
    }
    .email{
        height:30px;
        border-radius:4px;
        font-weight: 500;
        width:165px;
        line-height: 22px;
    }
    .btn-success {
        color: #ffffff;
        background-color: #14d565;
        border-color: #14d565;
    }
    /* Media query for devices with a maximum width of 768 pixels (typical for tablets and mobiles) */
    @media screen and (max-width: 768px) {
        body{
            font-size:16px;
        }
        .mobile-no{
            height:40px;
            border-radius:4px;
            font-weight: 500;
            width:65%;
            line-height: 30px;
            text-align: left;
            padding-left: 14px;
            font-size: 15px;
        }

        .whatsapp-no{
            height: 40px;
            width: 65%;
            object-fit: cover;
        }
        .email{
            height:40px;
            border-radius:4px;
            font-weight: 500;
            width:65%;
            line-height: 30px;
            text-align: left;
            padding-left: 14px;
            font-size: 15px;
        }

    }

    .preloader-bg { 
        background: rgba(22, 22, 22, 0.3); 
    /*  display: none;  */
        position: absolute; 
        top: 0; 
        right: 0; 
        bottom: 0; 
        left: 0; 
        z-index: 10; 
    }

    #preloader { 
        background-image: url(https://cdn.pixabay.com/animation/2022/11/04/09/42/09-42-03-510_512.gif); 
        background-repeat: no-repeat;
        background-position: center;
        background-size: 300px 300px;
        position: fixed; 
        display: block;
        left: 0;
        right:0;
        top:0;
        bottom: 0;
        background-color: #808080e8;
    }
    #preloader p{
        position: absolute;
        left: 0;
        right: 0;
        bottom: 58%;
        /* top:215px; */
        display: inline-block;
        text-align: center;
        margin-bottom: -5em;
        font-size:19px;
        color:brown;
    }

</style>

<div class="preloader-bg" style="display:none">
    <div id="preloader">
		<p>Waiting for owner response...</p>
    </div>
</div>


<div class="main-content side-content pt-0">
    <div class="container-fluid">
        <div class="inner-body">

            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <!-- <h2 class="main-content-title tx-24 mg-b-5">Travel Luggage details</h2> -->
                </div>
            </div>

            <?php if(empty($luggage_details->alertedUserId)){  ?>
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
                <?php if($luggage_details){ ?>
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <div class="panel profile-cover">
                                <div class="profile-cover__img mb-5">
                                    <?php if(empty($luggage_details->ProfileIMG) ){ ?> 
                                        <img src="<?= base_url()?>/assets/img/users/avatar-2.jpg"alt="img" class="profile-pic" height="80" width="80"> 
                                    <?php }else{  ?>
                                    <img src="<?= base_url().'/'.$luggage_details->ProfileIMG;?>"alt="img" class="profile-pic" height="80" width="80">
                                    <?php } ?> 
                                    <h3 class="h3"> <?= $luggage_details->Suffix;?>  <?= ($luggage_details)?masking($luggage_details->Name,5):"";?></h3>
                                    <!-- <p><b><?= $luggage_details->QRCodeText;?></b></p> -->
                                </div>
                                <div class="profile-cover__action2 bg-img"></div>
                            </div>


                            <div style="height:0.5px; width:100%; border:1px solid #dfdfdf;"></div>
                            <h4 class="tx-15 text-uppercase mb-3 mt-3">Contact Details</h4>
                            <div class="row row-sm mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <!-- <p class="mg-b-10"> Contact Number </p> -->
                                        <!-- <p><b><?= ($luggage_details)?$luggage_details->CountryCode.' '.$luggage_details->Mobile:"";?></b></p> -->
                                        <!-- <p><a class="btn btn-sm btn-success mobile-no" href="tel:<?= ($luggage_details)?$luggage_details->CountryCode.' '.$luggage_details->Mobile:"";?>">
                                        <i class="fa fa-phone fa-lg" aria-hidden="true" style="transform: rotate(90deg);"></i>&nbsp; &nbsp;Call on Phone
                                        </a></p> -->

                                        <p >
                                            <a class="btn btn-sm btn-success mobile-no callMobileModal" href="#" data-qrcode="<?= $luggage_details->QRCodeText;?>" data-alertuserid="<?= $luggage_details->alertedUserId;?>" >
                                                <i class="fa fa-phone fa-lg" aria-hidden="true" style="transform: rotate(90deg);"></i>&nbsp; &nbsp;Call the Owner
                                            </a>
                                        </p>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <!-- <p class="mg-b-10"> Whatsapp  Number</p>  -->
                                        <!-- <p >
                                            <a class="whatsapp-no-div" aria-label="Chat on WhatsApp" href="https://wa.me/<?= str_replace('+', '',  $luggage_details->WhatsAppCountryCode)?><?= $luggage_details->WhatsappNumber ?>" target="_blank">
                                                <img alt="Chat on WhatsApp" src="https://static.xx.fbcdn.net/assets/?revision=197739703408370&name=platform-agnostic-green-medium-en-us&density=1"  class="whatsapp-no"/> 
                                            </a>
                                        </p> -->
                                        <p >
                                            <a class="whatsapp-no-div callMobileWhatsappModal" href="#" data-qrcode="<?= $luggage_details->QRCodeText;?>" data-alertuserid="<?= $luggage_details->alertedUserId;?>">
                                                <img alt="Chat on WhatsApp" src="https://static.xx.fbcdn.net/assets/?revision=197739703408370&name=platform-agnostic-green-medium-en-us&density=1"  class="whatsapp-no"/> 
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <!-- <p class="mg-b-10">Email </p> -->
                                        <p >
                                            <a class="btn btn-sm btn-success email" href = "mailto: <?= $luggage_details->MaskEmail;?>?subject=Hi I found your luggage - My Bag Tag&body=
                                            I found your luggage. Please feel free to contact me by replying  this mail."
                                            >
                                                <i class="fa fa-envelope fa-lg" aria-hidden="true" style="transform: rotate(0deg);"></i>&nbsp; &nbsp;Send Email to Owner
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10">Address </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->Address:"";?></b>  <a href="http://maps.google.com/?q=<?= $luggage_details->Address;?>" >
                                        <img src="https://www.pngmart.com/files/23/Google-Maps-Logo-PNG-Photos.png" alt="" height="25">
                                        <span class="badge bg-success">Clik to open in Map</span> 
                                    </a>      
                                    </p>
                                       
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Address2 </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->AdressTwo:"";?></b></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <p class="mg-b-10"> Landmark </p>
                                        <p><b><?= ($luggage_details)?$luggage_details->Landmark:"";?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                
                <!-- Scan History -->
                <?php /* if($luggage_details){    ?>
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body">
                            <h4 class="tx-15 text-uppercase mb-3 mt-3">Scan History</h4>
                            <div class="row row-sm mt-4">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table id="scanHistory" class="table table-bordered border-t0 key-buttons text-nowrap w-100 table-responsive">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>Contact Person Name</th>
                                                    <th>Contact Person Mobile No</th>
                                                    <th>Location</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Sushanta Patra</td>
                                                    <td>1236549870</td>
                                                    <td>Bhubaneswar</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } */ ?>

            <?php } ?>
        </div>
    </div>
</div>
<input type="hidden" name="client_ip" id="clientIP" value="">
<!-- Register Mobile no  -->
<div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="callModal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="callModal">Enter Your Details to Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal('#callModal')">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>      
            <form id="myForm" method="POST">     
                <div class="modal-body">
               
                    <div class="row row-sm">
                        <div class="col-md-5">
                            <div class="form-group">
                                <p class="mg-b-10">Country Code <span class="text-danger">*</span></p>
                                <div class="parsley-select" id="uCountryCode">
                                    <select class="form-control select2 uCountryCode" required=""  name="CountryCode" data-parsley-class-handler="#uCountryCode" data-parsley-errors-container="#uCountryCodeErrorContainer"  data-parsley-required
                                    data-parsley-required-message="Select Country Code">
                                    <option value="">Select Country Code</option>
                                        <?php foreach($country_codes as $country_code){ ?>
                                        <option value="+<?= $country_code['Dialing'];?>">+ <?= $country_code['Dialing'];?> - <?= $country_code['Name'];?></option>
                                        <?php } ?>
                                    </select>

                                    <div id="uCountryCodeErrorContainer"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                <p class="mg-b-10">Mobile No <span class="text-danger">*</span></p>
                                <input type="tel" name="mobileNo" id="mobileNo" class="form-control" placeholder="Mobile no" required>
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <p class="mg-b-10">Name </p>
                                <input type="text" name="name" id="name"  placeholder="Name" class="form-control">
                            </div>
                        </div> 
                    </div>  
                    <input type="hidden" name="status" id="status" value="">   
                    <input type="hidden" name="qrcode" id="qrcode" value="">                   
                    <input type="hidden" name="regid" id="regid" value="">   
                    <input type="hidden" name="latitude" id="latitude" value="">                   
                    <input type="hidden" name="longitude" id="longitude" value="">  
                    <input type="hidden" name="ipaddress" id="ipaddress" value="">                   
                                 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal('#callModal')">Close</button>
                    <button type="submit" class="btn btn-primary updateCallerInfo">Submit</button>
                </div>
            </form>
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
    fetch('https://api.ipify.org?format=json')
    .then(response => response.json())
    .then(data => {
        const ipAddress = data.ip;
        $('#ipaddress').val(ipAddress);
        $('#clientIP').val(ipAddress);
        //console.log(ipAddress);
    })
    .catch(error => {
        console.error('Error fetching IP address:', error);
    });

    getLocation()
    .then((coordinates) => {
        $('#latitude').val(coordinates.latitude);
	    $('#longitude').val(coordinates.longitude);

        var qrCode="<?= $luggage_details->QRCodeText;?>";
        const clientIP =$('#clientIP').val();
        if(qrCode != "" && qrCode.length > 0){
            $.ajax({
                url: "<?= base_url('TravelLuggageController/update_scan_history');?>",
                type: 'post',
                data: {
                    qrCode,
                    Lattitude: `${coordinates.latitude}`, 
                    Longitude: `${coordinates.longitude}`,
                    clientIP:clientIP
                },
                dataType: 'json',
                success: function(response){
                    console.log(response);
                }
            })
        }

    })
    .catch((error) => {
        console.error(error);
    });
})();

function openGoogleLocation(lat, long){
    console.log(lat, long);
}


/*
(function (){ 
    getLocation()
    .then((coordinates) => { 
        // Use coordinates.latitude and coordinates.longitude as needed
       // console.log(`Latitude: ${coordinates.latitude}, Longitude: ${coordinates.longitude}`);
        //const curLocation =window.location.href;
        // Get the current URL
       // var url = new URL(curLocation);
        // Use URLSearchParams to get the value of 'ref_no'
        //var refNo = url.searchParams.get("ref_no");
        var qrCode="<?= $luggage_details->QRCodeText;?>";
        if(qrCode != "" && qrCode.length > 0){
            $.ajax({
                url: "<?= base_url('TravelLuggageController/update_scan_history');?>",
                type: 'post',
                data: {
                    qrCode,
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
        }
    })
    .catch((error) => {
        console.error(error);
    });
})();
*/
</script>