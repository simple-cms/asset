@extends('core::Admin/Base')

@section('content')
<aside class="right-side">
  <section class="content-header">
    <h1>
      {{ Lang::get('media::media.plural') }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> {{ Lang::get('core::core.dashboard') }}</a></li>
      <li><a href="{{ route('control.media.index') }}">{{ Lang::get('media::media.plural') }}</a></li>
      <li class="active">{{ isset($media) ? Lang::get('core::core.editing', ['model' => Lang::get('media::media.singular'), 'name' => $media->title]) : Lang::get('core::core.create') .' '. Lang::get('media::media.singular') }}</li>
    </ol>
  </section>

  <section class="content">

    @include('core::Admin/Partials/FlashMessages')

    <div class="row">
      <div class="col-md-12">
        <div class="nav-tabs-custom">
          <ul class="nav nav-tabs pull-right">
            <li><a href="#info" data-toggle="tab">{{ Lang::get('core::core.info')}}</a></li>
            <li><a href="#file" data-toggle="tab">{{ Lang::get('media::media.plural')}}</a></li>
            <li><a href="#seo" data-toggle="tab">{{ Lang::get('core::core.seo')}}</a></li>
            <li class="active"><a href="#basic" data-toggle="tab">{{ Lang::get('core::core.basics')}}</a></li>
            <li class="pull-left header"><i class="fa fa-paperclip"></i> {{ isset($media) ? Lang::get('core::core.editing', ['model' => Lang::get('media::media.singular'), 'name' => $media->title]) : Lang::get('core::core.create') .' '. Lang::get('media::media.singular') }}</li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              {{ Lang::get('core::core.actions')}} <span class="caret"></span>
              </a>
              <ul class="dropdown-menu">
                @if (isset($media))
                <li role="presentation"><a href="{{ route('page.show', [$media->slug]) }}" target="_blank" role="menuitem" tabindex="-1" href="#"><i class="fa fa-eye"></i> {{ Lang::get('core::core.preview')}}</a></li>
                @endif
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-bar-chart-o"></i> {{ Lang::get('core::core.stats')}}</a></li>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><i class="fa fa-trash-o"></i> {{ Lang::get('core::core.destroy')}}</a></li>
              </ul>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="basic">
            @if (isset($media))
              {!! Form::model($media, ['method' => 'PUT', 'route' => ['control.media.update', $media->id], 'role' => 'form']) !!}
              {!! Form::hidden('author_id', '1') !!}
            @else
              {!! Form::open(['method' => 'POST', 'route' => 'control.media.store', 'role' => 'form']) !!}
              {!! Form::hidden('author_id', '1') !!}
            @endif
              <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                {!! Form::label('title', Lang::get('core::core.title')) !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
                {!! $errors->first('title', '<p class="text-red">:message</p>') !!}
              </div>
              <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                  {!! Form::label('image', 'Image*') !!}
                  {!! Form::file('image', ['class' => "form-control"]) !!}
                  {!! $errors->first('image', '<p class="text-red">:message</p>') !!}
              </div>
              <div class="form-group {{ $errors->has('excerpt') ? 'has-error' : '' }}">
                {!! Form::label('excerpt', Lang::get('core::core.excerpt')) !!}
                {!! Form::textarea('excerpt', null, ['class' => 'form-control','rows' => 5]) !!}
                {{ $errors->first('excerpt', '<p class="text-red">:message</p>') }}
              </div>
            </div>
            <div class="tab-pane" id="seo">
              <div class="form-group {{ $errors->has('meta_title') ? 'has-error' : '' }}">
                {!! Form::label('meta_title', Lang::get('core::seo.meta_title')) !!}
                {!! Form::text('meta_title', null, ['class' => 'form-control']) !!}
                {!! $errors->first('meta_title', '<p class="text-red">:message</p>') !!}
              </div>
              <div class="form-group {{ $errors->has('meta_description') ? 'has-error' : '' }}">
                {!! Form::label('meta_description', Lang::get('core::seo.meta_description')) !!}
                {!! Form::text('meta_description', null, ['class' => 'form-control']) !!}
                {!! $errors->first('meta_description', '<p class="text-red">:message</p>') !!}
              </div>
              <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                {!! Form::label('slug', Lang::get('core::core.slug')) !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                {!! $errors->first('slug', '<p class="text-red">:message</p>') !!}
              </div>
            </div>
            <div class="tab-pane" id="file">



              <div class="form-group {{ $errors->has('slug') ? 'has-error' : '' }}">
                {!! Form::label('slug', Lang::get('core::core.slug')) !!}
                {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                {!! $errors->first('slug', '<p class="text-red">:message</p>') !!}
              </div>




            </div>
            <div class="tab-pane" id="info">
              <div class="form-group">
                {!! Form::label('created_at', Lang::get('core::core.created')) !!}
                {!! Form::text('created_at', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('updated_at', Lang::get('core::core.updated')) !!}
                {!! Form::text('updated_at', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
              </div>
            </div>
            {!! Form::submit(Lang::get('core::core.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    </div>
  </section>
</aside>
@stop