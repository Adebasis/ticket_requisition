@include('admin.includes.top')

<section class="vbox">
    
    @include('admin.includes.header')
        
    <section>
        <section class="hbox stretch">
            <!-- .aside -->
            @include('admin.includes.left')
            <!-- /.aside -->
        	
            <section class="panel">
                
                <div class="row wrapper">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-3 m-b-xs"></div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/allocationpooltype','class'=>'','role'=>'search'])  !!}
                    
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
                            <a href="{{ url('/adminpanel/allocationpooltype/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th class="th-sortable bgtable" data-toggle="class">Pool Type</th>
                        <th class="th-sortable bgtable" data-toggle="class">UiSort</th>
                        <th class="th-sortable bgtable" data-toggle="class">IsEnabled</th>
                        <th width="150" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->Name }}</td>
                        <td>{{ $tmpdata->UiSort }}</td>
                        @if($tmpdata->IsEnabled == 0)
                        <td>{{ 'No' }}</td>
                        @endif
                        @if($tmpdata->IsEnabled == 1)
                        <td>{{ 'Yes' }}</td>
                        @endif
                        <td class="text-center">
                          <a href="{{url('adminpanel/allocationpooltype')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/allocationpooltype')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
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