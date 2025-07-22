{!! csrf_field() !!}

@if (!$errors->isEmpty())
    <article class="message is-danger">
        <div class="message-body">
            <ul>
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
    </article>
@endif

<div class="field">
    <label class="label" for="title">Title</label>
    <input type="text" class="input" id="title" name="title" value="{{ $model->title }}">
</div>
<div class="field">
    <label class="label" for="url">Url</label>
    <input type="text" class="input" id="url" name="url" value="{{ $model->url }}">
</div>
<div class="field">
    <label class="label" for="content">Content</label>
    <textarea class="textarea" id="content" name="content">{{ $model->content }}</textarea>
</div>
<div class="field">
    <input type="submit" class="button is-primary" value="Submit">
</div>
