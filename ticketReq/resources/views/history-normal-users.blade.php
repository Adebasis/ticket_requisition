@section('title')
    History
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section class="panel">
                
                <?php
				$user_approver_level = Session::get('ecomps_user_approver_level');
				$is_ticket_department = Session::get('ecomps_user_dept_id');
				$is_approver = Session::get('ecomps_user_approver_level');
				$ecomps_admin_id = Session::get('ecomps_user_id');
				?>
                
                <div class="">
                    <div class="col-sm-12">
                        <div class="row wrapper">
                            
                            {!! Form::open(['method'=>'GET','url'=>'history','class'=>'','role'=>'search'])  !!}
                            
                            <div class="col-lg-3 mb-md-10">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-6">
                                <div style="color:#000;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Pending</strong></div>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-6">
                                <div class="text-success"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Approve</strong></div>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-6">
                                <div class="text-danger"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Reject</strong></div>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-6">
                                <div class="text-warning"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Fulfill</strong></div>
                            </div>
                            <div class="col-lg-1 col-sm-2 col-xs-6">
                                <div class="text-warning" style="color:#F60;text-decoration:line-through;"><i class="fa fa-circle"></i>&nbsp;&nbsp;<strong>Cancel</strong></div>
                            </div>
                            <div class="clearfix hidden-lg"></div>
                            <div class="col-lg-4 mt-md-10">
                                <div class="input-group">
                                    <input type="text" class="input-sm form-control" name="search" placeholder="Search By Recipient" value="{{ app('request')->get('search') }}">
                                    <span class="input-group-btn">
                                    <button class="btn btn-sm btn-default" type="submit">SEARCH</button>
                                    </span>
                                </div>
                            </div>
                            {!! Form::close() !!}
                            
                        </div>
                        <input type="hidden" id="siteurl" value="{{url('/')}}">
                        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                        <style>.ccc{text-decoration:line-through; color:#C30; font-style:italic;}</style>
                        <div class="table-responsive">
                          <table class="table table-striped table-hover b-t b-light" border="1" id="example" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"></th>
                                <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" data-toggle="class">Request Position</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
                                <th class="text-center bgtable" width="80" data-toggle="class">Comp</th>
                                <th class="text-center bgtable" width="80" data-toggle="class">Purch</th>
                                <th class="text-center bgtable" data-toggle="class">Location</th>
                                <th class="text-center bgtable" width="100" data-toggle="class">Delivery</th>
                                <th class="text-center bgtable" data-toggle="class">Approve</th>
                                <th class="text-center bgtable" data-toggle="class">Fulfill</th>
                                <!--<th class="text-center bgtable" data-toggle="class">Used</th>-->                               
                                <th class="text-center bgtable action-width" width="120" data-toggle="class">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
							  if(isset($search)){
								  $data = DB::table('request')->orWhere('RecipientFirstName', 'LIKE', '%' . $search . '%')->orWhere('RecipientLastName', 'LIKE', '%' . $search . '%')->where('requestor_id', '=', $ecomps_admin_id)->orderBy('CreateDate', 'desc')->get();
							  }else{
								  $data = DB::table('request')->where('requestor_id', '=', $ecomps_admin_id)->orderBy('CreateDate', 'desc')->get();
							  }
							  ?>
                              @foreach ($data as $index=>$tmpdata)
                                
                                <?php
								$approver_name = '';
								$approver_level = '';
								
								$res_req = DB::table("useraccount")->select('FirstName', 'LastName')->where("id", $tmpdata->requestor_id)->get();
								if($tmpdata->requestor_id == trim($ecomps_admin_id)){
									$req_name = 'Me';
								}else{
									$req_name = $res_req[0]->FirstName.' '.$res_req[0]->LastName;
								}
								if($tmpdata->req_position == "1" && $tmpdata->first_approver > 0){
									$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->first_approver);
									$approver_level = 'First Level Approver';
									$approver_name = $approver->FirstName.' ('.$approver_level.')';
								}
								if($tmpdata->req_position == "2"){
									//$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->second_approver);
									$approver_level = '';
									$approver_name = 'Second Level Approver';
								}
								if($tmpdata->sent_to_vc == "1"){
									$approver_level = '';
									$approver_name = 'VP';
								}
								
								// 1 = APPROVED
								// 2 = FULFILLED
								// 4 = REJECTED
								$is_fulfil = $tmpdata->is_fulfil;
								
								if($is_fulfil == "1"){
									$approver_name = 'Fulfilled';
								}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
									$approver_name = 'Forwarded to Ticket Department';
								}
								$is_unread_message = DB::table('request_message')->where('request_id', '=', $tmpdata->id)->where('readby_requestor', 0)->count();
								$is_forward_to_fulfil = $tmpdata->is_forward_to_fulfil;
								
								//echo '<pre>';
								//print_r($tmpdata);exit;
								
								
                                ?>
                              <tr style="cursor:pointer;">
                                <td class="text-center"><?php //echo $tmpdata->vc_status;?>
									<?php if($tmpdata->first_approver_status == "2" || $tmpdata->second_approver_status == "2" || $tmpdata->vc_status == "2" || $tmpdata->is_cancel == "1" || $tmpdata->user_cancel=="1"){?>
                                    <i class="fa fa-check-square" style="color:#f00;"></i>
                                    <?php }else if($tmpdata->first_approver_status == "1" || $tmpdata->second_approver_status == "1" || $tmpdata->approve_by_admin == "1"){?>
                                    <i class="fa fa-check-square" style="color:#090;"></i>
                                    <?php }else if($is_fulfil == "1"){?>
                                    <i class="fa fa-check-square" style="color:#F90;"></i>
									<?php }else{?>
                                    <i class="fa fa-check-square" style="color:#000;"></i>
                                    <?php }?>
                                </td>
                                <td <?php if($tmpdata->user_cancel == "1"){?> class="ccc" <?php }?>>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }} (<?php echo $req_name;?>)</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td <?php if($tmpdata->user_cancel == "1"){?> class="ccc" <?php }?>>{{ $approver_name }}</td>
                                <td <?php if($tmpdata->user_cancel == "1"){?> class="ccc" <?php }?>>{{ $tmpdata->CompanyName }}</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ $tmpdata->Comp }}</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                <td class="text-center <?php if($tmpdata->user_cancel == "1"){ echo "ccc"; }?>">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                <td class="text-center">
                                <?php
								if($tmpdata->sent_to_vc == "1"){
								?>
                                	<div style="width:100%; text-align:center; float:left;">
                                        <div class="text-<?php if($tmpdata->vc_status=="1" || $tmpdata->approve_by_admin=="1"){?>success<?php }else if($tmpdata->vc_status=="2" || $tmpdata->is_cancel == "1"){?>danger<?php }?>">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                <?php }else{?>
                                    <div style="width:50%; text-align:center; float:left;">
                                        <div class="text-<?php if($tmpdata->first_approver_status=="1" || $tmpdata->approve_by_admin == "1"){?>success<?php }else if($tmpdata->first_approver_status=="2" || $tmpdata->vc_status=="1" || $tmpdata->approve_by_admin=="1"){?>danger<?php }?>">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                    <div style="width:50%; text-align:center; float:left;">
                                        <div class="text-<?php if($tmpdata->second_approver_status=="1" || $tmpdata->approve_by_admin == "1"){?>success<?php }else if($tmpdata->second_approver_status=="2" || $tmpdata->vc_status=="2" || $tmpdata->approve_by_admin=="2"){?>danger<?php }?>">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                <?php }?>
                                </td>
                                <td class="text-center">
                                <div class="text-<?php if($is_fulfil=="1"){?>warning<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </td>
                                <!--<td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>-->
                                
                                <td class="text-center"><a href="{{url('request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('history/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button><?php if($is_unread_message > 0){?>
                        <span class="badge badge-sm up bg-success count" style="display: inline-block;">!</span>
                        <?php }?></a></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        
					</div>
        		</div>
        </section>
    </section>
</section>

@include('includes.admin_footer')


<style>
.dataTables_length, .dataTables_filter{display:none;}
.table{width:99%;}
</style>
{!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
{!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}

<?php /*?><script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [0,10,11,12,13]}]
	});
} );
</script><?php */?>
<script>
$(document).ready(function() {
    $('#example').DataTable({	
		order: [],
		"pageLength": 50,
		columnDefs: [ { orderable: false, targets: [0,10,11,12]}]
	});
} );
</script>