@section('title')
    Message Board
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <div class="panel-body">
                                <div class="col-sm-3">&nbsp;</div>
                                <div class="col-sm-6">
                                    <section class="vbox">
                                        <section class="scrollable wrapper">
                                          <div class="timeline" id="timeline">
                                            <article class="timeline-item active">
                                                <div class="timeline-caption">
                                                  <div class="panel bg-primary lt no-borders">
                                                    <div class="panel-body text-center">
                                                      <!--<span class="timeline-icon"><i class="fa fa-bell-o time-icon bg-primary"></i></span><br />-->
                                                      <span class="h4 m-r-sm">Notifications</span>
                                                    </div>
                                                  </div>
                                                </div>
                                            </article>
                                            
                                            <?php
                                            $i = 0;
                                            $all = DB::table('request_message')->where('request_id', '=', $request_id)->orderBy('created_date', 'asc')->get();
                                            $count = count($all);
                                            $ses_user_id = Session::get('ecomps_user_id');
                                            $arr = '';
											$last_id = 0;
                                            foreach($all as $index=>$noti){
                                                $dated = date('D, M d Y', strtotime($noti->created_date));
                                                $time = date('h:i A', strtotime($noti->created_date));
                                                
												if($noti->user_type == "admin"){
													$by = 'Admin';
												}elseif($noti->user_type == "vp"){
													$by = 'Vice President';
												}else{
													if($noti->user_id == $ses_user_id){
														$by = 'Me';
													}else{
														$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $noti->user_id );
														$by = $requester->FirstName.' '.$requester->LastName;
													}
												}
                                                $message = $noti->message;
                                                $left_ = 1;
                                                if ($i % 2 == 0) {
                                                    $left_ = 0;
                                                }
												$arr = $left_;
												$last_id = $noti->id;
                                            ?>
                                            <article class="timeline-item <?php if($left_ == 1){?> alt <?php }?>">
                                                <div class="timeline-caption">
                                                  <div class="panel panel-default">
                                                    <div class="panel-body">
                                                      <span class="arrow  <?php if($left_ == 1){?> right <?php }else{?>left<?php }?>"></span>
                                                      <span class="timeline-icon"><i class="fa fa-phone time-icon bg-primary"></i></span>
                                                      <span class="timeline-date"></span></span>
                                                      <div class="text-sm"><?php echo $by;?></div>
                                                      <div class="text-sm"><span style="font-size:10px; font-style:italic;"><?php echo $dated;?>&nbsp;<?php echo $time;?></span></div>
                                                      <h5><?php echo $message;?></h5>
                                                    </div>
                                                  </div>
                                                </div>
                                            </article>
                                            <input type="hidden" id="mid<?php echo $i;?>" />
                                            <?php $i++; }?>
                                            <?php if($arr == ""){ $arr = 0; }?>
                                          </div>
                                        </section>
                                      </section>          
                                </div>
                                <div class="col-sm-3">&nbsp;</div>
                            </div>
                            <div class="panel-body" style="padding:0;" id="focus">
                                <div class="col-sm-3">&nbsp;</div>
                                <div class="col-sm-6">Write Message&nbsp;(<span id="msg_char">0</span> / 250)</div>
                                <div class="col-sm-3">&nbsp;</div>
                            </div>
                            <input type="hidden" id="siteurl" value="{{url('/')}}">
                			<input type="hidden" id="csrf" value="{{ csrf_token() }}">
                            <input type="hidden" id="arr_" value="<?php echo $arr; ?>">
                            <input type="hidden" id="request_id" value="<?php echo $request_id; ?>">
                            <input type="hidden" id="request_msg_count" value="<?php echo $count; ?>">
                            <input type="hidden" id="last_id" value="<?php echo $last_id; ?>">
                            <input type="hidden" id="row_id" value="<?php echo $i; ?>">
                            <div class="panel-body" style="padding:0;">
                                <div class="col-sm-3">&nbsp;</div>
                                <script>
								function countChar(val, res) {																
									var len = val.value.length;
									if (len > 250) {
										val.value = val.value.substring(0, 250);
									} else {
										$('#'+res).text(parseInt(len));
									}
								}
								function send(){
									var message = $('#message').val().trim();
									var request_id = $('#request_id').val();
									//alert(request_id)
									if(message == ""){
										$('#message').focus();
										return false;
									}
									var url = $('#siteurl').val();
									var csrf=$('#csrf').val();
									$.ajax({
										type: "POST",
										url: url + "/Post_RequestPageMessageBoard",
										data: {"message":message ,"_token":csrf,"request_id":request_id},
										success: function (data) {
											//alert(request_id)
											window.location = url +'/history/request/'+ request_id +'/message/board';
										}
									});
								}
								function sendMessage(evt){
									var charCode = (evt.which) ? evt.which : event.keyCode;
									if (evt.ctrlKey && charCode == 13) {
										//send();
								   	}
								}
								</script>
                                <div class="col-sm-6">
                                	<style>textarea {   resize: none;}</style>
                                	<div class="col-sm-12 row text-right">
                                      <textarea class="form-control" style="height:60px;" onkeyup="countChar(this, 'msg_char'),sendMessage(event);" id="message" autofocus></textarea>
                                      <br />
                                    	<input type="button" class="btn btn-default btn-sm text-left" style="margin-top:-30px;" value="SEND" onclick="send();" /><a href="{{ url('/') }}/history"><input type="button" class="btn btn-default btn-sm text-left" style="margin-top:-30px;" value="BACK"  /></a>
                                  	</div>
                                </div>
                                <div class="col-sm-3">&nbsp;</div>
                            </div>
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('includes.admin_footer')

<script>
$(window).load(function(){
	$('html, body').animate({
		scrollTop: $("#focus").offset().top
	}, 1500);							
});

$(document).ready(function(){
	setInterval(function(){
		loadmore();
	}, 5000);
});

function loadmore(){
	//console.log("A");
	//return false;
	var url = $('#siteurl').val();
	var csrf = $('#csrf').val();
	var arr_ = $('#arr_').val();
	var request_id = $('#request_id').val();
	var request_msg_count = $('#request_msg_count').val();
	var last_id = $('#last_id').val();
	var row_id = $('#row_id').val();
	console.log("-"+row_id+"-")
	$.ajax({
		type: "POST",
		url: url + "/RequestPageMessageBoard_loadmore",
		data: {"_token":csrf,"arr_":arr_,"request_id":request_id,"request_msg_count":request_msg_count,"last_id":last_id,"row_id":row_id},
		success: function (data) {
			
			//console.log("-"+data+"-")
			
			if(data != ""){
				$('#timeline').append(data);
				
				request_msg_count = parseInt(request_msg_count) + 1;
				$('#request_msg_count').val(request_msg_count);
				
				$('html, body').animate({
					scrollTop: $("#focus").offset().top
				}, 1500);
				console.log("#"+row_id+"#")
				var row_id = $('#mid'+row_id).val();
				if (typeof row_id === "undefined") {
					row_id = $('.mid').val();
				}
				$('#last_id').val(row_id);
				
			}
		}
	});
}
</script>