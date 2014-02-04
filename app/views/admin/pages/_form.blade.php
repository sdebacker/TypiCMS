@section('head')

	{{ HTML::script(asset('//tinymce.cachefly.net/4.0/tinymce.min.js')) }}
	{{ HTML::script(asset('js/form.js')) }}

@stop

<div class="row">

	@include('admin._buttons-form')

	{{ Former::hidden('id'); }}

	<div class="col-sm-6">
		
		@include('admin._tabs-lang')

		<div class="tab-content">

			@foreach ($locales as $lang)

			<div class="tab-pane fade @if ($locale == $lang)in active@endif" id="{{ $lang }}">
				{{ Former::lg_text($lang.'[title]')->label('title')->autofocus(); }}
				{{ Former::text($lang.'[slug]')->label('slug'); }}
				<span class="text-muted">
					{{ trans('validation.attributes.address') }}: {{ Former::populator($lang.'[uri]')->getContent() }}
				</span>
				{{ Former::checkbox($lang.'[status]')->label('status')->text('Online')->label(''); }}
				{{ Former::hidden($lang.'[uri]'); }}
				{{ Former::textarea($lang.'[body]')->label('body')->class('form-control editor')->value(''); }}

				{{-- Metadata --}}
				{{ Former::text($lang.'[meta_title]')->label('meta_title'); }}
				{{ Former::text($lang.'[meta_keywords]')->label('meta_keywords'); }}
				{{ Former::text($lang.'[meta_description]')->label('meta_description'); }}
			</div>

			@endforeach

		</div>

	</div>

	<div class="col-sm-6">

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#options" data-target="#options" data-toggle="tab">Options</a>
			</li>
			@if(isset($model->files))
			<li>
				<a href="#images" data-target="#images" data-toggle="tab">Images</a>
			</li>
			@endif
		</ul>
		
		<div class="tab-content">
			
			<div class="tab-pane fade in active" id="options">
				{{ Former::checkbox('rss_enabled')->text('rss_enabled')->label(''); }}
				{{ Former::checkbox('comments_enabled')->text('comments_enabled')->label(''); }}
				{{ Former::checkbox('is_home')->text('is_home')->label(''); }}
				{{ Former::text('template'); }}
				{{ Former::textarea('css')->rows(10); }}
				{{ Former::textarea('js')->rows(10); }}
			</div>

			@if(isset($model->files))
			<div class="tab-pane fade" id="images">
				@include('admin.files._list', array('files' => $model->files))
			</div>
			@endif

		</div>

	</div>

</div>
