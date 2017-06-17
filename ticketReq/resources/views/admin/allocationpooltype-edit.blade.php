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
                                            <i class="fa fa-ok-sign"></i><strong>Error !</strong> Allocation Pool Type already exist.<a href="#" class="alert-link">&nbsp;Try again</a>.
                                            </div>
                                            @endif
                                            
                                            <header class="panel-heading font-bold">Allocation Pool Type [Edit]</header>
                                            <div class="panel-body">
                                            
                                                {!!Form::open(array('action'=>'TeamController@admin_post_allocationpooltype_edit','method'=>'post','onsubmit'=>'return Validation()'))!!}
                                                    
                                                    {!!Form::hidden('pk_id',$data[0]->id)!!}
                                                    
                                                     <div class="form-group">
                                                     {{ Form::label('Name', 'Name') }}
                                                     {!!Form::text('Name',$data[0]->Name,array('class'=>'form-control','id'=>'Name', 'autofocus'))!!}
                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('UiSort', 'UiSort') }}
                                                    {!!Form::number('UiSort',$data[0]->UiSort,array('class'=>'form-control','id'=>'UiSort', ''))!!}
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group">
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-sm-6">
                                                    {{ Form::label('IsEnabled', 'IsEnabled') }}
                                                    {{Form::select('IsEnabled',['1'=>'Yes','0'=>'NO'],$data[0]->IsEnabled,['class'=>'form-control','id'=>'IsEnabled'])}}
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="form-group">
                                                    <div class="col-lg-offset-2 col-lg-10">&nbsp;</div>
                                                    </div>
                                                    <div class="form-group">
                                                    <div class="col-sm-6">
                                                    {{Form::submit('Submit',array('class'=>'btn btn-success btn-sm'))}}&nbsp; {{ HTML::link('/adminpanel/allocationpooltype', 'Cancel', array('class' => 'btn btn-default btn-sm'))}}
                                                    </div>
                                                    </div>
                                                    </div>
                                                
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