@include('admin.includes.top')

<script>
function Validation(){
	
}
</script>

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
                                
                                {!!Form::open(array('action'=>'AdminController@admin_post_users_assign_reports','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                <input type="hidden" name="pk_id" value="<?php echo $data[0]->id;?>" />
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('msg'))
                                            <div class="alert alert-success">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Success !</strong>Report has been assigned successfully.
                                            </div>
                                            @endif
                                            
                                            <?php
											$allow_pages = $data[0]->allow_pages;
											//$pages = array();
											//if($allow_pages != ""){
												$pages = explode(",", $allow_pages);
											//}
											//print_r($pages);
											?>
                                            <header class="panel-heading font-bold">Assign Reports Pages to Access for "<?php echo $data[0]->FirstName.' '.$data[0]->LastName;?>"</header>
                                            <div class="panel-body">                                            	
                                                 
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_users" <?php if(in_array('requested_users', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by users</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" id="users" value="requested_games" <?php if(in_array('requested_games', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by games</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="requested_teams" <?php if(in_array('requested_teams', $pages)){?> checked="checked" <?php }?> ><i></i>Requested tickets by team</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_date" <?php if(in_array('fulfilled_date', $pages)){?> checked="checked" <?php }?> ><i></i>Fulfilled tickets by date</label>
                                                        </div>
                                                        <div class="checkbox i-checks">
                                                        <label><input type="checkbox" name="pages[]" value="fulfilled_games" <?php if(in_array('fulfilled_games', $pages)){?> checked="checked" <?php }?> ><i></i>Fulfilled tickets by game</label>
                                                        </div>
                                                    </div>
                                                </div>   
                                                  <div class="row">
                                                                                   
                                                    <div class="col-sm-6">
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/useraccount', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}                     
                                                    </div>
                                                    <div class="col-sm-6">
                                                    
                                                    </div>
                                                </div>                                       	
                                            </div>
                                            
                                        </section>           
                                    </div>
                                	<div class="col-sm-5">
                                        <section class="panel panel-default">
                                        	
                                        </section>           
                                    </div>
                                </div>
                                
                                {!!Form::close()!!}
                                
                            </section>
                        </section>
                    </section>
                </section>
            	<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen,open" data-target="#nav,html"></a>
            </section>
        </section>
    </section>

@include('admin.includes.admin_footer')