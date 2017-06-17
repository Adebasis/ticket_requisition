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
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Team Code already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Team [Edit]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'TeamController@admin_post_team_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                    <div class="form-group">
                                                        {{ Form::label('Name', 'Team Name') }}
                                                        {!!Form::text('Name',$data[0]->Name,array('class'=>'form-control','id'=>'Name', 'autofocus', 'required'))!!}
                                                    </div>
                                                     <div class="form-group">
                                                        {{ Form::label('TeamCode', 'Team Code') }}
                                                        {!!Form::text('TeamCode',$data[0]->TeamCode,array('class'=>'form-control','id'=>'TeamCode', 'required','maxlength'=>'3'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('ShortName', 'Short Name') }}
                                                        {!!Form::text('ShortName',$data[0]->ShortName,array('class'=>'form-control','id'=>'ShortName', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('NickName', 'Nick Name') }}
                                                        {!!Form::text('NickName',$data[0]->NickName,array('class'=>'form-control','id'=>'NickName', 'required'))!!}
                                                    </div>
                                                    <div class="form-group">
                                                        {{ Form::label('City', 'City') }}
                                                        {!!Form::text('City',$data[0]->City,array('class'=>'form-control','id'=>'City', 'required'))!!}
                                                    </div>
                                                     <div class="form-group">
                                                        {{ Form::label('State', 'State') }}
                                                        {!!Form::text('State',$data[0]->State,array('class'=>'form-control','id'=>'State', 'required'))!!}
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