@include('admin.includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
		return false;
	}
}
</script>

{!!HTML::script('public/ckeditor/ckeditor.js')!!}

<section class="vbox">
    
    @include('admin.includes.header')
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
            <section id="content">
                <section class="hbox stretch">
                    <section>
                        <section class="vbox">
                            <section class="scrollable padder">              
                                <section class="row m-b-md"></section>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('msg'))
                                            <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Success !</strong> Message has been sent<a href="#" class="alert-link"></a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Send Reminders for Todays Games</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'ReminderController@remind_post_send_remider_emails_page','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    <?php
													$timestamp =strtotime("now");
													$dt = new \DateTime("@$timestamp");
													$destinationTimezone = new \DateTimeZone(\Config::get('app.timezone'));
													$dt->setTimeZone($destinationTimezone);
													$CreateDate = $dt->format('m/d/Y');
													
													$today = $dt->format('Y-m-d');
													$allgames = DB::table('game')->where('requeststate_id', 3)->where(DB::Raw('DATE(OriginalGameDate)'), '=' , $today)->get();
													//print_r($allgames);
													$no_of_games = count($allgames);
													$teams = 'No games in this date';
													$tmp_team = '';
													$game_ids = "0";
													if($no_of_games > 0){
														foreach ($allgames as $index=>$tmpgame){
															$res_tm = DB::table('team')->where('id', $tmpgame->team_id)->get();
															$OriginalGameDate = date('h:i A', strtotime($tmpgame->OriginalGameDate));
															if($tmp_team == ""){
																$tmp_team = $res_tm[0]->Name." ".$OriginalGameDate;
															}else{
																$tmp_team = $tmp_team.",".$res_tm[0]->Name." ".$OriginalGameDate;
															}
															if($game_ids == "0"){
																$game_ids = $tmpgame->id;
															}else{
																$game_ids = $game_ids.",".$tmpgame->id;
															}
														}
													}
													
													$allreqs = DB::select("SELECT * from request WHERE game_id IN(".$game_ids.")");				
													$count_reqs = count($allreqs);
													
													$res_email = DB::table('emailtemplate')->where('id',14)->get();
													
													if($no_of_games > 0){
													?>
                                                    
                                                    <div class="form-group">
                                                    	<label style="font-size:14px; font-weight:bold;">Today : <u><?php echo $CreateDate;?></u></label>
                                                    </div>
                                                    <div class="form-group">
                                                    	<label style="font-size:14px; font-weight:bold;">Today Game : <u><?php echo $tmp_team;?></u></label>
                                                    </div>
                                                    <div class="form-group">
                                                    	<label style="font-size:14px; font-weight:bold;">No of Requests : <?php echo $count_reqs;?> of above games</label>
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Preview Email Body') }}
                                                        <textarea id="contents" name="contents"><?php echo $res_email[0]->contents;?></textarea>
														<script type="text/javascript">						 
                                                        CKEDITOR.replace( 'contents', {
                                                        height : 300,
                                                        uiColor :'#CCCCCC',
                                                        filebrowserBrowseUrl :'ckeditor/filemanager/browser/default/browser.html?Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserImageBrowseUrl : 'ckeditor/filemanager/browser/default/browser.html?Type=Image&amp;Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserFlashBrowseUrl :'ckeditor/filemanager/browser/default/browser.html?Type=Flash&amp;Connector=ckeditor/filemanager/connectors/php/connector.php',
                                                        filebrowserUploadUrl  :'ckeditor/filemanager/connectors/php/upload.php?Type=File',
                                                        filebrowserImageUploadUrl : 'ckeditor/filemanager/connectors/php/upload.php?Type=Image',
                                                        filebrowserFlashUploadUrl : 'ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
                                                        });
                                                        </script>
                                                    </div>
                                                	{{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}
                                                	
                                                    <?php }else{?>
                                                    <h1>No games found today !!!</h1>
                                                    <?php }?>
                                                    
                                                {!!Form::close()!!}
                                    
                                            </div>
                                            
                                        </section>
                                        
                                                
                                    </div>
                                    <div class="col-sm-4">
                                        <section class="panel panel-default">
                                        	<script>
											function showVal(){
												if($('#hid_vlist').val() == "0"){
													$('#lbl_vlist').css("display", "block");
													$('#hid_vlist').val(1);
												}else{
													$('#lbl_vlist').css("display", "none");
													$('#hid_vlist').val(0);
												}
											}
											function showLogs(){
												if($('#hid_logs').val() == "0"){
													$('#lbl_logs').css("display", "block");
													$('#hid_logs').val(1);
												}else{
													$('#lbl_logs').css("display", "none");
													$('#hid_logs').val(0);
												}
											}
											</script>
                                            <header class="panel-heading font-bold"><span style="cursor:pointer;" onclick="showVal();">Show Variable Lists</span></header>
                                            <input type="hidden" value="0" id="hid_vlist" />
                                            <div class="panel-body" id="lbl_vlist" style="display:none;">
                                            	<style>.mzero{margin:0px;}</style>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%GAME_DATE%  = Game Date') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%DEMAND_TYPE% = Demand Type') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%OPPONENT% = Team Name') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%REQUESTER% = Request Name') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%RECIPIENT% = Receipient Name') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%TYPE%  = Delivery Type') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%COMP%  = Comp') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%PURCHASED% = Purchased') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%TOTAL%  = Comp + Purchased') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%APPROVER_LEVEL% = Approver Name') }}
                                                </div>
                                                <div class="form-group mzero">
                                                    {{ Form::label('title', '%GAME_NAME% = Game Name') }}
                                                </div>
                                            </div>
                                            
                                            <header class="panel-heading font-bold"><span style="cursor:pointer;" onclick="showLogs();">Show Reminder Logs</span></header>
                                            <input type="hidden" value="0" id="hid_logs" />
                                            <div class="panel-body" id="lbl_logs" style="display:none;">
                                            	<style>.mzero{margin:0px;}</style>
                                                <div class="form-group">
                                                	
                                                    
                                                <div class="table-responsive">
                                                  <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                                                    <thead>
                                                      <tr>
                                                        <th class="th-sortable bgtable" data-toggle="class">Run On</th>
                                                        <th class="th-sortable bgtable" data-toggle="class">Run By</th>
                                                        <th width="50" class="th-sortable bgtable text-center" data-toggle="class">Sent</th>
                                                        <th width="50" class="text-center bgtable">Action</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
													$data = DB::table('reminder_logs')->orderBy('submitted_date', 'DESC')->get();
													?>
                                                      @foreach ($data as $index=>$tmpdata)
                                                      
                                                      <?php
													  if($tmpdata->user_type == "admin"){
														  $run_by = "admin";
													  }else{
														  $res_user = DB::table('useraccount')->select('FirstName', 'LastName')->where('id', $tmpdata->user_id)->get();
														  $run_by = $res_user[0]->FirstName.' '.$res_user[0]->LastName;
													  }
													  ?>
                                                      <tr>
                                                        <td><?php echo date('d/m/y h:i a', strtotime($tmpdata->submitted_date));?></td>
                                                        <td>{{ $run_by }}</td>
                                                        <td class="text-center">{{ $tmpdata->noof_email_sent }}</td>
                                                        <td class="text-center">
                                                          <a href="{{url('adminpanel/send-reminder-emails')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
                                                        </td>
                                                      </tr>
                                                      @endforeach
                                                    </tbody>
                                                  </table>
                                                </div>
                                                
                                                </div>
                                            </div>
                                            
                                        </section>
                                        
                                                
                                    </div>
                                </div>
                            
                            </section>
                            
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')
