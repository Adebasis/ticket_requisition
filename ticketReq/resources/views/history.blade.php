@section('title')
    History
@stop

@include('includes.top')

<section class="vbox">
    
    @include('includes.header')
    
    <section>
        <section class="hbox stretch">
            
            <section class="panel">
                
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row wrapper" style="padding-left:2%;">
                            <?php
							$user_approver_level = Session::get('ecomps_user_approver_level');
							$is_ticket_department = Session::get('ecomps_user_dept_id');
							$is_approver = Session::get('ecomps_user_approver_level');
							if($is_approver != "0" || $is_ticket_department == "4"){}else{?>
                            <div class="col-sm-12">
                            	<span style="font-size:14px; font-weight:bold;"><i class="fa fa-search"></i>&nbsp;<u>FILTER</u></span>
                            </div>
                            <?php }?>
                        </div>
                        <div class="row wrapper" style="padding-left:2%;">
                            
                            {!! Form::open(['method'=>'GET','url'=>'history','class'=>'','role'=>'search'])  !!}
                            
                            <div class="col-sm-1">
                                <select name="year" class="form-control">
                                	<option value="">YEAR</option>
                                    <?php foreach($years as $yr){ ?>
                                    <option value="<?php echo $yr->yr;?>"><?php echo $yr->yr;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <?php
							$game_id = "";
							if(isset($_REQUEST['game'])){ $game_id = $_REQUEST['game']; }?>
                            <div class="col-sm-2">
                            	<select name="game" class="form-control">
                                	<option value="">GAME</option>
                                    <?php foreach($team as $t){ ?>
                                    <option value="<?php echo $t->id;?>" <?php if($t->id == $game_id){?> selected="selected" <?php }?>><?php echo date('m/d/Y', strtotime($t->OriginalGameDate));?> - <?php echo $t->Name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                            	{{ Form::select('requester', $useraccount, 0, array('placeholder' => 'REQUESTOR', 'class'=>'form-control')) }}
                            </div>
                            <div class="col-sm-2">
                            	{{ Form::select('dept', $department, 0, array('placeholder' => 'DEPARTMENT', 'class'=>'form-control')) }}
                            </div>
                            <div class="col-sm-2">
                            	{{ Form::select('approval', $requeststatustype, 0, array('placeholder' => 'APPROVAL', 'class'=>'form-control')) }}
                            </div>
                            <div class="col-sm-3">
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
                        
                        <div class="table-responsive" style=" margin-left:2%; margin-right:2%;">
                          <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000; font-size:13px;">
                            <thead>
                              <tr>
                                <th width="50" class="text-center bgtable"><input type="checkbox" id="checkAll" onclick="checkedAll();" /></th>
                                <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                                <th class="text-center bgtable" data-toggle="class">Game</th>
                                <th class="text-center bgtable" data-toggle="class">Created</th>
                                <th class="th-sortable bgtable" data-toggle="class">Request Position</th>
                                <th class="th-sortable bgtable" data-toggle="class">Company</th>
                                <th class="text-center bgtable" data-toggle="class">Comp</th>
                                <th class="text-center bgtable" data-toggle="class">Purch</th>
                                <th class="text-center bgtable" data-toggle="class">Location</th>
                                <th class="text-center bgtable" data-toggle="class">Delivery</th>
                                <th class="text-center bgtable" data-toggle="class">Approve</th>
                                <th class="text-center bgtable" data-toggle="class">Fulfill</th>
                                <!--<th class="text-center bgtable" data-toggle="class">Used</th>-->
                                <th class="text-center bgtable" width="120" data-toggle="class">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                
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
								
								if($tmpdata->req_position == "1"){
									$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->first_approver);
									$approver_level = 'First Level Approver';
								}
								if($tmpdata->req_position == "2"){
									$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->second_approver);
									$approver_level = 'Second Level Approver';
								}
								$approver_name = $approver->FirstName.' ('.$approver_level.')';
								
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
								if($is_ticket_department != "4"){
								?>
									<?php if($tmpdata->first_approver_status == "2" || $tmpdata->second_approver_status == "2"){?>
                                    <i class="fa fa-check-square" style="color:#f00;"></i>
                                    <?php }else if($is_fulfil == "1" || ($tmpdata->first_approver_status == "1" && $user_approver_level == "first") || ($tmpdata->second_approver_status == "1" && $user_approver_level == "second") || ($tmpdata->second_approver_status == "1" && $user_approver_level == "second")){?>
                                    <i class="fa fa-check-square" style="color:#090;"></i>
                                    <?php }else{?>
                                    <input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                    <?php }?>
                                <?php }else if($is_fulfil == "1" && $is_ticket_department == "4"){?>
                                	<i class="fa fa-check-square" style="color:#090;"></i>
                                <?php }else if(($tmpdata->first_approver_status == "2" || $tmpdata->second_approver_status == "2")&& $is_ticket_department == "4"){?>
                                	<i class="fa fa-check-square" style="color:#f00;"></i>
								<?php }else{?>
                                	<input type="checkbox" name="reqIDs" value="{{ $tmpdata->id }}" />
                                <?php }?>
                                </td>
                                <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }} (<?php echo $req_name;?>)</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                                <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                                <td>{{ $approver_name }}</td>
                                <td>{{ $tmpdata->CompanyName }}</td>
                                <td class="text-center">{{ $tmpdata->Comp }}</td>
                                <td class="text-center">{{ $tmpdata->Purchased }}</td>
                                <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                                <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                                <td class="text-center">
                                <?php
								if($is_ticket_department == "4"){
									
									$is_app = $tmpdata->first_approver_status;
									?>
									<div style="width:50%; text-align:center; float:left;">
										<div class="text-<?php if($is_app == "1"){?>success<?php }else if($is_app=="2"){?>danger<?php }?>">
											<i class="fa fa-circle"></i>
										</div>
									</div>
									<?php
									
									$is_app = $tmpdata->second_approver_status;
									?>
									<div style="width:50%; text-align:center; float:left;">
										<div class="text-<?php if($is_app == "1"){?>success<?php }else if($is_app=="2"){?>danger<?php }?>">
											<i class="fa fa-circle"></i>
										</div>
									</div>
									<?php
									
								}else{
								?>
                                    <div style="width:50%; text-align:center; float:left;">
                                        <div class="text-<?php if($tmpdata->first_approver_status=="1" && $tmpdata->first_approver > 0){?>success<?php }else if($tmpdata->first_approver_status=="2" && $tmpdata->first_approver > 0){?>danger<?php }?>">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                    <?php if(Session::get('ecomps_user_no_of_approver_level') > 1){?>
                                    <div style="width:50%; text-align:center; float:left;">
                                        <div class="text-<?php if($tmpdata->second_approver_status=="1" && $tmpdata->second_approver > 0){?>success<?php }else if($tmpdata->second_approver_status=="2" && $tmpdata->second_approver > 0){?>danger<?php }?>">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                    </div>
                                    <?php }?>
                                <?php }?>
                                </td>
                                <td class="text-center">
                                <div class="text-<?php if($is_fulfil=="1"){?>warning<?php }?>">
                                    <i class="fa fa-circle"></i>
                                </div>
                                </td>
                                <!--<td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>-->
                                
                                <td class="text-center"><a href="{{url('request')}}/{{$tmpdata->id}}/view/approver"><button type="button" class="btn btn-default btn-xs">View</button></a>&nbsp;<a href="{{url('history/request')}}/{{$tmpdata->id}}/message/board"><button type="button" class="btn btn-default btn-xs">Message</button></a></td>
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