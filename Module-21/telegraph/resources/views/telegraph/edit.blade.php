<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telegraph</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    </head>
    <body>

        <div class="container">
            <form class="row g-3" method="POST" action="{{ route('update', $telegraph) }}">
                @csrf
                @method('patch')
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}"
                        id="title" type="text" name='title' placeholder="Title" value="{{ old('title', $telegraph->title) }}" />
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                </div>
                <div class="col-md-6">
                    <label for="author" class="form-label">Autor</label>
                    <input
                        class="form-control {{ $errors->has('author') ? 'is-invalid' : ''}}"
                        id="author" type="text" name='author' placeholder="Author" value="{{ old('author', $telegraph->author) }}"/>
                    <div class="invalid-feedback">
                        {{ $errors->first('author') }}
                    </div>
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Message</label>
                    <textarea
                        name="text"
                        placeholder="{{ __('What\'s on your mind?') }}"
                        class="form-control {{ $errors->has('text') ? 'is-invalid' : ''}}"
                        rows="5"
                    >{{ old('text', $telegraph->text) }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('text') }}
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    <a href="{{ route('index') }}"><button type="button" class="btn btn-danger">{{ __('Cancel') }}</button></a>
                </div>
            </form>
        </div>
    </body>
</html>
