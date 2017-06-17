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
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row wrapper" style="padding-left:2%;">
                            <div class="row wrapper" style="padding-left:2%;">
                            <div class="col-lg-1">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <div class="clearfix hidden-lg"></div>
                            <div class="col-lg-4">&nbsp;</div>
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
                            <div class="clearfix visible-xs"></div>
                            <div class="col-sm-3 m-b-xs mt-xs-10">
                            {{Form::button('Fulfilled Requisition',array('class'=>'btn btn-success btn-sm','id'=>'btnApr','onclick'=>'StatusChanged(1);'))}}
                            </div>
                        </div>
                        </div>
                        <?php /*?><div class="row wrapper" style="padding-left:2%;">
                            
                            {!! Form::open(['method'=>'GET','url'=>'history','class'=>'','role'=>'search'])  !!}
                                                        
                            {!! Form::close() !!}
                            
                        </div><?php */?>
                        <input type="hidden" id="siteurl" value="{{url('/')}}">
                        <input type="hidden" id="csrf" value="{{ csrf_token() }}">
                        <script>
                        function checkedAll(){
                            $("input:[name=reqIDs]").prop('checked', $('#checkAll')[0].checked);
                        };
                        function StatusChanged(status){
                            var checkValues = $('input[name=reqIDs]:checked').map(function(){
                                                return $(this).val();
                                            }).get();
                            
                            if(checkValues == ""){
                                alert("Select atleast one request to continue..");
                                return false;
                            }
							var result=confirm("Are you sure you want to Fulfilled this Request?");
                            if(result){
								$('#btnApr').html('&nbsp;&nbsp;&nbsp;&nbsp;Processing ...&nbsp;&nbsp;&nbsp;&nbsp;');
								
								// POST Ajax
								var url = $('#siteurl').val();
								var csrf=$('#csrf').val();
								$.ajax({
									type: "POST",
									url: url + "/front_post_requests_multi_fulfiled",
									data: {"checkValues":checkValues ,"_token":csrf,"status":status},
									success: function (data) {
										console.log(data);
										if(data == "success"){
											window.location = url+'/history';
										}
									}
								});
							}
                        }
                        </script>
                        <div class="table-responsive" style=" margin-left:2%; margin-right:2%;">
                          <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"><input type="checkbox" id="checkAll" /></th>
                                <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" data-toggle="class">Requestor</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
                                <th class="text-center bgtable" data-toggle="class">Comp</th>
                                <th class="text-center bgtable" data-toggle="class">Purch</th>
                                <th class="text-center bgtable" data-toggle="class">Location</th>
                                <th class="text-center bgtable" data-toggle="class">Delivery</th>
                                <th class="text-center bgtable" data-toggle="class">Approve</th>
                                <th class="text-center bgtable" data-toggle="class">Fulfill</th>
                                <!--<th class="text-center bgtable" data-toggle="class">Used</th>-->
                                <th class="text-center bgtable" width="160" data-toggle="class">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              
                              <?php
							  $data = DB::table('request')->orWhere('is_forward_to_fulfil', '=', 1)->orderBy('CreateDate', 'desc')->paginate(20);
							  //print_r();exit;
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
												
								// 1 = APPROVED
								// 2 = FULFILLED
								// 4 = REJECTED
								$is_fulfil = $tmpdata->is_fulfil;
								
								if($is_fulfil == "1"){
									$approver_name = 'Fulfilled';
								}else if($is_fulfil == "0" && $tmpdata->is_forward_to_fulfil == "1"){
									$approver_name = 'Forwarded to Ticket Department';
								}
								
                                ?>
                              <tr style="cursor:pointer;">
                                <td class="text-center">
                                <?php
								if($is_fulfil == "1"){?>
                                	<i class="fa fa-check-square" style="color:#090;"></i>
                                <?php }else if(($tmpdata->first_approver_status == "2" || $tmpdata->second_approver_status == "2")){?>
                                	<i class="fa fa-check-square" style="color:#f00;"></i>
								<?php }else{?>
                                	<input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                <?php }?>
                                </td>
                                <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td>{{ $req_name }}</td>
                                <td>{{ $tmpdata->CompanyName }}</td>
                                <td class="text-center">{{ $tmpdata->Comp }}</td>
                                <td class="text-center">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                <td class="text-center">
									<div style="width:50%; text-align:center; float:left;">
										<div class="text-success">
											<i class="fa fa-circle"></i>
										</div>
									</div>
									<div style="width:50%; text-align:center; float:left;">
										<div class="text-success">
											<i class="fa fa-circle"></i>
										</div>
									</div>
                                </td>
                                <td class="text-center">
                                <div class="text-<?php if($is_fulfil=="1"){?>warning<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </td>
                                <!--<td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>-->
                                
                                <td class="text-center"><a href="{{url('request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('history/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message Board</button></a></td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                        <div class="row" style="margin-right:0;">
                            <div class="col-sm-4 hidden-xs"></div>
                            <div class="col-sm-3 text-center"></div>
                            <div class="col-sm-5 text-right text-center-xs">                
                              {{ $data->links() }}
                            </div>
                          </div>
                      </section>
					</div>
        		</div>
        </section>
    </section>
</section>

@include('includes.admin_footer')