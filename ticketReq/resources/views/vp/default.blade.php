@section('title')
    Home
@stop

@include('vp.includes.top')

    <section class="vbox">
        
        @include('vp.includes.header')
        
    <section>
    <section class="hbox stretch">
    	
        <section id="content">
            <section class="hbox stretch">
            	
                <section>
                    <section class="vbox">
                        <section class="scrollable padder">              
                            <section class="row m-b-md" >
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6 text-right text-left-xs m-t-md"></div>
                            </section>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6"><strong>UPCOMING GAMES</strong></div>
                                <div class="col-md-4"><strong>INFO</strong></div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                        <thead>
                                            <tr>
                                            <th width="150" class="bgtable">Game Date</th>
                                            <th class="bgtable">Opponent</th>
                                            <th width="150" class="text-center bgtable">Status</th>
                                            <th width="150" class="text-center bgtable">Deadline</th>
                                            </tr>
                                        </thead>
                                        <?php
										$current_date = date('Y-m-d');
										$allgames = DB::table('game')->where(DB::Raw('DATE(OriginalGameDate)'), '>=' , $current_date)->get();
										?>
                                        <tbody>
                                            <?php
											foreach ($allgames as $index=>$tmpgame){
		
												$game_id = $tmpgame->id;
												$team_id = $tmpgame->team_id;
												$team_code = getDataFromTable("team","TeamCode","id", $team_id);
												$team_name = getDataFromTable("team","Name","id", $team_id);
												$requeststate = getDataFromTable("gamerequeststate","Name","id", $tmpgame->requeststate_id);
												$logo = $team_code.'.png';
												
												$RequestDeadline = 'N/A';
												$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
												if($tmpgame->RequestDeadline != ""){
													$RequestDeadline = date('m/d/Y h:i A', strtotime($tmpgame->RequestDeadline));
												}
											?>
                                            <tr>
                                                <td class="text-center"><?php echo $OriginalGameDate;?></td>
                                                <td><img src="<?php echo url('public/images/logos');?>/<?php echo $logo;?>" alt="" width="20" />&nbsp;<?php echo $team_name;?></td>
                                                <td class="text-center"><?php echo $requeststate;?></td>
                                                <td class="text-center"><?php echo $RequestDeadline;?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if(count($allgames) == 0){?>
                                            <tr>
                                                <td colspan="4" class="text-center">NO GAME FOUND !!!</td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                	<div class="col-md-12" style="border-top:dotted 2px #666;border-bottom:dotted 2px #666;">
                                   	  <strong>Name : </strong>{!! Session::get('ecomps_vp_name') !!}<br />
										Top Level Account on eComps
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6"><strong>RECENT ACTIVITY</strong></div>
                                <div class="col-md-4"><strong>HELP</strong></div>
                                <div class="col-sm-1"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6">
                                    <div class="table-responsive">
                                    <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                        <thead>
                                            <tr>
                                            <th width="150" class="bgtable">Game</th>
                                            <th class="bgtable">Recepient Name</th>
                                            <th width="100" class="text-center bgtable">Type</th>
                                            <th width="50" class="text-center bgtable">Comp</th>
                                            <th width="50" class="text-center bgtable">Purch</th>
                                            <th width="150" class="text-center bgtable">Created</th>
                                            </tr>
                                        </thead>
                                        <?php
										$current_date = date('Y-m-d');
										$reqs = DB::table('request')->orderBy('id', 'desc')->limit(5)->get();
										?>
                                        <tbody>
                                            <?php
											foreach ($reqs as $index=>$tmpreqs){
												
												$requeststate = getDataFromTable("gamerequeststate","Name","id", $tmpgame->requeststate_id);
												$OriginalGameDate = date('m/d/Y h:i A', strtotime($tmpgame->OriginalGameDate));
												$CreateDate = date('m/d/Y h:i A', strtotime($tmpreqs->CreateDate));
												
												$approver_name = '';
												$approver_level = '';
												
												if($tmpreqs->req_position == "1"){
													$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpreqs->first_approver);
													$approver_level = 'First Level Approver';
												}
												if($tmpreqs->req_position == "2"){
													$approver = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpreqs->second_approver);
													$approver_level = 'Second Level Approver';
												}
												$approver_name = $approver->FirstName.' ('.$approver_level.')';
												$is_fulfil = $tmpreqs->is_fulfil;
												
												if($is_fulfil == "1"){
													$approver_name = 'Fulfilled';
												}else if($is_fulfil == "0" && $tmpreqs->is_forward_to_fulfil == "1"){
													$approver_name = 'Forwarded to Ticket Department';
												}
											?>
                                            <tr>
                                                <td class="text-center"><?php echo $OriginalGameDate;?></td>
                                                <td><?php echo $approver_name;?></td>
                                                <td class="text-center"><?php echo $requeststate;?></td>
                                                <td class="text-center"><?php echo $tmpreqs->Comp;?></td>
                                                <td class="text-center"><?php echo $tmpreqs->Purchased;?></td>
                                                <td class="text-center"><?php echo $CreateDate;?></td>
                                            </tr>
                                            <?php }?>
                                            <?php if(count($reqs) == 0){?>
                                            <tr>
                                                <td colspan="6" class="text-center">NO RECENY ACTIVITY FOUND !!!</td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                	<div class="col-md-12" style="border-top:dotted 2px #666;border-bottom:dotted 2px #666;">
                                    	For fulfillment issues, email eComps@nymets.com.<br />
										For user creation issues, contact HR.
                                    </div>
                                    <div class="col-md-12 row" style="margin-top:10px;">
                                    	
                                        <div class="col-md-12 row"><strong>SUMMARY</strong></div>
                                        <div class="col-md-12">
                                            
                                            <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                            <thead>
                                                <tr>
                                                <th colspan="3" class="bgtable">ALLOCATION USE</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td style="vertical-align:middle;">Regular Pool</td>
                                                    <td class="text-center" width="100">COMP<br />0/48</td>
                                                    <td class="text-center" width="100">PURCHASED<br />0/0</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align:middle;">Premium Pool</td>
                                                    <td class="text-center">COMP<br />0/--</td>
                                                    <td class="text-center">PURCHASED<br />0/0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-6">
                                </div>
                                <div class="col-md-4">
                                	
                                </div>
                                <div class="col-sm-1"></div>
                            </div>
                            
                        </section>
                    </section>
                </section>
            
            </section>
        	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
        </section>
        
    </section>

@include('admin.includes.admin_footer')