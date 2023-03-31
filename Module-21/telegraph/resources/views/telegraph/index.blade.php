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
            <form class="row g-3" method="POST" action="/telegraph">
                @csrf
                <div class="col-md-6">
                    <label for="title" class="form-label">Title</label>
                    <input
                        class="form-control {{ $errors->has('title') ? 'is-invalid' : ''}}"
                        id="title" type="text" name='title' placeholder="Title" value="{{ old('title') }}" />
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                </div>
                <div class="col-md-6">
                    <label for="author" class="form-label">Autor</label>
                    <input
                        class="form-control {{ $errors->has('author') ? 'is-invalid' : ''}}"
                        id="author" type="text" name='author' placeholder="Author" value="{{ old('author') }}"/>
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
                    >{{ old('text') }}</textarea>
                    <div class="invalid-feedback">
                        {{ $errors->first('text') }}
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Send</button>
                  </div>
            </form>

            <div class="container mt-5">
                @foreach ($messages as $message)
                        <div class="border mb-1 rounded-3 p-2">
                            <div>
                                <div class="d-flex gap-3">
                                    <h6 class="mb-0">Title: {{ $message->title }}</h6>
                                    <h6 class="mb-0">Author: {{ $message->author }}</h6>
                                    <h6 class="mb-0">Date created:</h6>
                                    <small class="">{{ $message->created_at->format('j M Y, g:i a') }}</small>
                                </div>
                            </div>
                            <p class="opacity-75">{{ $message->text }}</p>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('editor', [$message]) }}"><button class="btn btn-primary">{{ __('Edit') }}</button></a>
                                <form method="POST" action="{{ route('delete', [$message->id]) }}">
                                    @csrf
                                    @method('delete')
                                        <button class="btn btn-danger">{{ __('Delete') }}</button>
                                </form>
                        </div>
                        </div>
                @endforeach
            </div>
        </div>
    </body>
</html>
