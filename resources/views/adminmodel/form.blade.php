<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">
            @if($itemId)
                {{trans('administrator::administrator.edit')}}
            @else
                {{trans('administrator::administrator.createnew')}}
            @endif
        </h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                {!! Form::model($model, [
                        'class'   => 'form-horizontal',
                        'enctype' => 'multipart/form-data',
                        'route'   => ['admin_save_item',$config->getOption('name'),$itemId],
                    ]) !!}
                @foreach($arrayFields as $key => $arrCol)
                    @if($arrCol['visible'] && $arrCol['editable'])
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="{{$arrCol['field_name']}}">
                                {{$arrCol['title']}}:
                            </label>
                            <div class="col-md-10">
                                @include('adminmodel.field',[
                                   'type'         => $arrCol['type'],
                                   'name'         => $arrCol['field_name'],
                                   'id'           => $arrCol['field_name'],
                                   'value'        => $model->{$arrCol['field_name']},
                                   'arrCol'       => $arrCol,
                                   'defaultClass' => 'form-control',
                                   'flagFilter'   => false,
                                ])
                                @if ($errors->has($arrCol['field_name']))
                                    <p style="color:red;">
                                        {!!$errors->first($arrCol['field_name'])!!}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    @endif
                @endforeach
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <a href="{{route('admin_index', $config->getOption('name'))}}" class="btn btn-default ">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">Save & Close</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
