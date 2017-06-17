@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
    
    {!! Html::style('public/admin_assets/js/datatables/datatables.css') !!}
    
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
        	
            <section class="panel">
                
                <div class="row wrapper">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3 m-b-xs"></div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/employeetype','class'=>'','role'=>'search'])  !!}
                    
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search" placeholder="Search" value="{{ app('request')->get('search') }}">
                            <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Go!</button>
                            </span>
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                    
                    <div class="col-sm-1">
                        <div class="input-group">
                            <span class="input-group-btn">
                            <a href="{{ url('/adminpanel/employeetype/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th class="th-sortable bgtable" data-toggle="class">Employee Type</th>
                        <th width="150" class="text-center bgtable">FulfillmentOrder</th>
                        <th width="150" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->Name }}</td>
                        <td class="text-center">{{ $tmpdata->FulfillmentOrder }}</td>
                        <td class="text-center">
                          <a href="{{url('adminpanel/employeetype')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/employeetype')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
                        </td>
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
        
        </section>
    </section>
</section>

@include('admin.includes.admin_footer')

{!!HTML::script('public/admin_assets/js/datatables/jquery.dataTables.min.js')!!}
{!!HTML::script('public/admin_assets/js/datatables/demo.js')!!}
