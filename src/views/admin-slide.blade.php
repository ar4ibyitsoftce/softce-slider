@extends('mage2-ecommerce::admin.layouts.app')

@section('content')
    @include('mage2-ecommerce::admin.lang-triger.triger')
    <div class="box">
        <div class="box-header">
            <h2>
                <i class="fa fa-list-ul"></i>
                <span class="main-title-wrap">Список Брендов</span>
            </h2>
            <form action="{{ route('admin.slider-brand.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <fieldset>
                    <legend>Добавить новый бренд</legend>
                    <input type="file" name="new_slide[]" multiple accept="image/png,image/gif,image/jpeg" >
                    @if($errors->has('new_slide'))
                        <div class="alert alert-danger">{{ $errors->first('new_slide') }}</div>
                    @endif
                    <br >
                    <input class="btn btn-info" type="submit" value="Отправить">
                </fieldset>
            </form>

        </div>
        <div class="box-body">
            <table class="table  table-hover options_table js-data_grid_table">
                <thead>
                    <tr>
                        <th>№</th>
                        <th>Изображение</th>
                        <th>Заголовок</th>
                        <th>Текст</th>
                        <th>Ссылка</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                @if($slides)
                    @foreach($slides as $co => $slide)
                        @php
                            $model = $slide;
                        @endphp
                        <tr>
                            <td>{{ $co + 1 }}</td>
                            <td>
                                <img  style="width: 250px; height: auto;" src="{{ asset($path_slide.'/'.$slide->path) }}" alt="" >
                                <input form="admin-slider-update-{{ $slide->id }}" type="file" name="slide" >
                            </td>
                            <td>
                                @include('mage2-ecommerce::forms.textarea',[
                                    'name' => 'title',
                                    'label' => '',
                                    'attributes' => [
                                        'class' => 'ckeditor js-no_scroll',
                                        'lang' => true,
                                        'form' => 'admin-slider-update-'.$slide->id
                                    ]
                                ])
                            </td>
                            <td>
                                @include('mage2-ecommerce::forms.textarea',[
                                    'name' => 'text',
                                    'label' => '',
                                    'attributes' => [
                                        'class' => 'ckeditor js-no_scroll',
                                        'lang' => true,
                                        'form' => 'admin-slider-update-'.$slide->id
                                    ]
                                ])
                            </td>
                            <td>
                                @include('mage2-ecommerce::forms.text',[
                                    'name' => 'url',
                                    'label' => '',
                                    'attributes' => [
                                        'form' => 'admin-slider-update-'.$slide->id
                                    ]
                                ])
                            </td>

                            <td>
                                {{--update slide info--}}
                                <form id="admin-slider-update-{{ $slide->id }}" class="inline-form" method="POST"
                                    action="{{ route('admin.slider-brand.update', [$slide->id]) }}"
                                    enctype='multipart/form-data'
                                    >
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <input type='submit' class='btn btn-info' value='Изменить'>
                                </form>

                                {{--delete slide--}}
                                <form id="admin-slider-destroy-{{ $slide->id }}" class="inline-form" method="POST"
                                    action="{{ route('admin.slider-brand.destroy', $slide->id) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <a href="#" data-destroy="jQuery('#admin-slider-destroy-{{ $slide->id }}').submit()"  class="btn btn-danger js-delete" >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
@stop