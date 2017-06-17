@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    {!! Html::style('public/admin_assets/js/datepicker/datepicker.css') !!}
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
            
            <?php
			
            $game = trim(app('request')->get('game'));
			$tmp_sdate = trim(app('request')->get('start_date'));
			if($tmp_sdate != ""){
				$tmp_sdate = explode("-", $tmp_sdate);
				$tmp_sdate = $tmp_sdate[2].'-'.$tmp_sdate[0].'-'.$tmp_sdate[1];
			}
			$tmp_edate = trim(app('request')->get('end_date'));
			if($tmp_edate != ""){
				$tmp_edate = explode("-", $tmp_edate);
				$tmp_edate = $tmp_edate[2].'-'.$tmp_edate[0].'-'.$tmp_edate[1];
			}
			//echo $tmp_edate;exit;
            ?>
            
            
            <section class="panel">
                
                <div class="wrapper">
                    <div class="col-sm-4">
                    <span style="font-size:14px; font-weight:bold;"><i class="fa fa-envelope icon-muted"></i>&nbsp;Requested Tickets By Games</span>
                    </div>
                    <?php
					$games = DB::select("SELECT g.id,g.OriginalGameDate,t.Name from game g,team t where t.id=g.team_id And g.id IN (select game_id from request) order by g.OriginalGameDate");
					//$games = DB::select("SELECT id,OriginalGameDate,EventCode from game where id IN (select game_id from request) order by OriginalGameDate");
					?>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/reports/requested/games','class'=>'','role'=>'search'])  !!}
                    
                    <div class="col-sm-3">
                    <select name="game" class="form-control">
                        <option value="">SELECT GAME</option>
                        <?php foreach($games as $t){ ?>
                        <option value="<?php echo $t->id;?>" <?php if($t->id == $game){?> selected="selected" <?php }?>><?php echo $t->Name;?> - <?php echo date('m/d/Y h:i A', strtotime($t->OriginalGameDate));?></option>
                        <?php }?>
                    </select>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm input-s datepicker-input form-control" data-date-format="mm-dd-yyyy" name="start_date" value="{{ app('request')->get('start_date') }}" style="width:45%;">&nbsp;<input type="text" class="input-sm input-s datepicker-input form-control" data-date-format="mm-dd-yyyy" name="end_date" value="{{ app('request')->get('end_date') }}" style="width:45%;">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    {!!Form::open(array('action'=>'AdminController@admin_post_reports_requested_games_download','method'=>'post','onsubmit'=>'return Validation();'))!!}

                    <div class="col-sm-2">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <input type="hidden" name="tmp_game" value="<?php echo $game;?>" />
                            <input type="hidden" name="tmp_start_date" value="<?php echo $tmp_sdate;?>" />
                            <input type="hidden" name="tmp_end_date" value="<?php echo $tmp_edate;?>" />
                            <button class="btn btn-sm btn-default" type="submit">Download</button>
                            </span>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    {!! Form::close() !!}
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" id="example1" align="center" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable text-center">&nbsp;</th>
                        <th class="th-sortable bgtable" data-toggle="class">Requestor</th>
                        <th class="text-center bgtable" data-toggle="class">Game</th>
                        <th class="text-center bgtable" data-toggle="class">Created</th>
                        <th class="th-sortable bgtable" data-toggle="class">Recipient</th>
                        <th class="th-sortable bgtable" data-toggle="class">Company</th>
                        <th class="th-sortable bgtable" data-toggle="class">Department</th>
                        <th class="text-center bgtable" data-toggle="class">Comp</th>
                        <th class="text-center bgtable" data-toggle="class">Purch</th>
                        <th class="text-center bgtable" data-toggle="class">Location</th>
                        <th class="text-center bgtable" data-toggle="class">Delivery</th>
                        <th class="text-center bgtable" data-toggle="class">Used</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
					$sch='';
					if($game != ''){
						$sch=$sch."game_id = '$game' AND ";
					}
					if($tmp_sdate != "" && $tmp_edate != ""){
						$sch=$sch." (DATE(CreateDate) BETWEEN '$tmp_sdate' AND '$tmp_edate') AND ";
					}
					if($tmp_sdate != "" && $tmp_edate == ""){
						$sch=$sch." DATE(CreateDate) >= '$tmp_sdate' AND ";
					}
					if($tmp_sdate == "" && $tmp_edate != ""){
						$sch=$sch." DATE(CreateDate) <= '$tmp_edate' AND ";
					}
					$sch = substr($sch,0,-5); 
					if($sch != ""){
						$str = "select * from request where ".$sch." order by CreateDate desc";
					}else{
						$str = "select * from request where id < 0";
					}
					//echo $str;exit;
					$data = DB::select(DB::raw($str));
					
					$i = 0;
					?>
                    	
                      @foreach ($data as $index=>$tmpdata)
                      	
                        <?php
						$requester = getDataFromTableMultiColumns("useraccount","FirstName,LastName","id", $tmpdata->requestor_id);
						$requester_name = '';
						if(count($requester) > 0){
							$requester_name = $requester->FirstName.' '.$requester->LastName;
						}
						?>
                      <tr style="cursor:pointer;">
                        <td class="text-center">
                        <?php echo ++$i;?>
                        </td>
                        <td>{{ $requester_name }}</td>
                        <td class="text-center">{{ date('m/d/Y', strtotime(getDataFromTable("game","OriginalGameDate","id", $tmpdata->game_id ))) }}</td>
                        <td class="text-center">{{ date('m/d/Y', strtotime($tmpdata->CreateDate)) }}</td>
                        <td>{{ $tmpdata->RecipientFirstName }} {{ $tmpdata->RecipientLastName }}</td>
                        <td>{{ $tmpdata->CompanyName }}</td>
                        <td>{{ getDataFromTable("department","Name","id", $tmpdata->dept_id ) }}</td>
                        <td class="text-center">{{ $tmpdata->Comp }}</td>
                        <td class="text-center">{{ $tmpdata->Purchased }}</td>
                        <td class="text-center">{{ getDataFromTable("locationtype","Name","id", $tmpdata->locationtype_id ) }}</td>
                        <td class="text-center">{{ getDataFromTable("deliverytype","Name","id", $tmpdata->deliverytype_id ) }}</td>
                        <td class="text-center">{{ $tmpdata->Purchased }}/{{ $tmpdata->Comp }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
        </section>
    </section>
</section>

@include('admin.includes.admin_footer')

{!!HTML::script('public/admin_assets/js/datepicker/bootstrap-datepicker.js')!!}