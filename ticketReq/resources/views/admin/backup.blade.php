@include('admin.includes.top')

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
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('msg'))
                                                <div class="alert alert-danger">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <i class="fa fa-ok-sign"></i><strong>Error !</strong> Something wrong in connection</div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Database Backup</header>
                                            <div class="panel-body">
                                            
                                            {!!Form::open(array('action'=>'BackupController@admin_post_backuppage','method'=>'post'))!!}
                                            	
                                                <div class="form-group text-center">
                                                    <img src="{{ url('/') }}/public/admin_assets/images/db_backup.png" alt="" width="15%" />
                                                </div>
                                                <div class="form-group text-center">
                                                    Click on "BACKUP NOW" button to backup the database.
                                                </div>
                                                <div class="form-group text-center">
                                                	{{Form::submit('BACKUP NOW',array('class'=>'btn btn-success btn-sm'))}}
                                                </div>                                                
                                                                                            
                                            {!!Form::close()!!}
                                            
                                            </div>
                                        </section>           
                                    </div>
                                    
                                    <div class="col-sm-5">
                                        <?php /*?><section class="panel panel-default">
                                        	                                            
                                            <header class="panel-heading font-bold">Database Backup</header>
                                            <div class="panel-body">
                                            	<div class="form-group">
                                                	<div class="col-sm-1" style="border-bottom:solid 1px #ccc;"><strong>Sl.</strong></div>
                                                    <div class="col-sm-6" style="border-bottom:solid 1px #ccc;"><strong>Backup Date</strong></div>
                                                    <div class="col-sm-3" style="border-bottom:solid 1px #ccc;"><strong>File Size</strong></div>
                                                    <div class="col-sm-2 text-center" style="border-bottom:solid 1px #ccc;"><strong>Action</strong></div>
                                                </div>
                                                <?php
												function formatBytes($size, $precision = 2){
													if ($size > 0) {
														$size = (int) $size;
														$base = log($size) / log(1024);
														$suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
											
														return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
													} else {
														return $size;
													}
												}
												$directory = storage_path();
												$files = File::allFiles($directory);
												$i = 1;
												foreach (glob(storage_path()."/*.sql") as $file){
													
													$bytes = filesize($file);
													$tmp_file_name = explode("/", $file);
													//print_r($tmp_file_name);
													$tmp_file_name = str_replace("db-backup-","",$tmp_file_name[6]);
													$tmp_file_name = str_replace(".sql","",$tmp_file_name);
													$file_date = str_replace("_", "-", mb_substr($tmp_file_name, 0, 10));
													$file_time = date("H:i A", strtotime(str_replace($file_date, "", $tmp_file_name)));
												?>
                                                <div class="form-group">
                                                	<div class="col-sm-1"><?php echo $i;?>.</div>
                                                    <div class="col-sm-6"><?php echo $file_date;?></div>
                                                    <div class="col-sm-3"><?php echo formatBytes($bytes);?></div>
                                                    <div class="col-sm-2 text-center"><i class="fa fa-download"></i></div>
                                                </div>
                                                <?php $i++; } ?>
                                            </div>
                                            
                                        </section><?php */?>           
                                    </div>
                                </div>
                            
	                            <div class="row"><div>&nbsp;</div></div>
                            
                            </section>
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')