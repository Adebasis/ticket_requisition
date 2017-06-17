@include('admin.includes.top')

<script>
function Validation(){
	if($('#Name').val().trim() == ""){
		$('#Name').focus();
		return false;
	}
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
                                <div class="row">
                                    <div class="col-sm-6">
                                        <section class="panel panel-default">
                                        	
                                            @if(Session::has('errmsg'))
                                            <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">×</button>
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Team code already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Team [Entry]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'TeamController@admin_post_team_entry','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Team Name') }}
                                                        {!!Form::text('Name',null,array('class'=>'form-control','id'=>'Name', 'autofocus', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('TeamCode', 'Team Code') }}
                                                        {!!Form::text('TeamCode',null,array('class'=>'form-control','id'=>'TeamCode', 'maxlength'=>'3', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('ShortName', 'Short Name') }}
                                                        {!!Form::text('ShortName',null,array('class'=>'form-control','id'=>'ShortName', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('NickName', 'Nick Name') }}
                                                        {!!Form::text('NickName',null,array('class'=>'form-control','id'=>'NickName', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('City', 'City') }}
                                                        {!!Form::text('City',null,array('class'=>'form-control','id'=>'City', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('State', 'State') }}
                                                        {!!Form::text('State',null,array('class'=>'form-control','id'=>'State', 'required'))!!}
                                                    </div>
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/teams', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                
                                                {!!Form::close()!!}
                                            	
                                            </div>
                                        </section>           
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