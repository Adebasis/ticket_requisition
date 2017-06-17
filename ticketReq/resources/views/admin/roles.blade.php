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
                    <div class="col-sm-5">
                        <!--<select class="input-sm form-control input-s-sm inline v-middle">
                        <option value="0">Action</option>
                        <option value="1">Delete Selected</option>
                        </select>
                        <button class="btn btn-sm btn-default">Apply</button> -->   
                    </div>
                    <div class="col-sm-3 m-b-xs">
                    
                    </div>
                    
                    {!! Form::open(['method'=>'GET','url'=>'adminpanel/roles','class'=>'','role'=>'search'])  !!}
                    
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
                            <a href="{{ url('/adminpanel/roles/entry') }}"><button class="btn btn-sm btn-default" type="button">ADD NEW</button></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped table-hover b-t b-light" border="1" bordercolor="#ccc" style="border-collapse:collapse; color:#000;">
                    <thead>
                      <tr>
                        <th width="50" class="bgtable"></th>
                        <th class="th-sortable bgtable" data-toggle="class">Role</th>
                        <th width="260" class="text-center bgtable">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($data as $index=>$tmpdata)
                      <tr>
                        <td class="text-center">{{$index + 1}}</td>
                        <td>{{ $tmpdata->Name }}</td>
                        <?php
						$is_assign = DB::table('roletasks')->where('role_id', $tmpdata->id)->count();
						if($is_assign > 0){
							$lable_txt = "Edit Assign Tasks";
						}else{
							$lable_txt = "&nbsp;&nbsp;&nbsp;&nbsp;Assign Tasks&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						?>
                        <td class="text-center">
                          <a href="{{url('adminpanel/roles')}}/{{$tmpdata->id}}/tasks/assign"><button type="button" class="btn btn-default btn-xs">{{ $lable_txt }}</button></a>&nbsp;<a href="{{url('adminpanel/roles')}}/{{$tmpdata->id}}/edit"><button type="button" class="btn btn-default btn-xs">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button></a>&nbsp;<a href="{{url('adminpanel/roles')}}/{{$tmpdata->id}}/delete" onclick="return confirm('Are you sure you want to delete this record ?');"><button type="button" class="btn btn-default btn-xs">Delete</button></a>
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
