<h1>OCR Results</h1>

@foreach ($results as $result)
    <h2>Page {{ $result['page'] }}</h2>
    <img src="{{ $result['image'] }}" style="max-width: 100%; border: 1px solid #ccc;">
    <pre>{{ $result['text'] }}</pre>
@endforeach
