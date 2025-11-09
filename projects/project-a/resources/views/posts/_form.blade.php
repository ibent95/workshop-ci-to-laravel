@csrf
<label>
    Title
    <input name="title" value="{{ old('title', $post->title ?? '') }}" required maxlength="255">
</label>
@error('title')<small style="color:#b91c1c;">{{ $message }}</small>@enderror

<label>
    Body
    <textarea name="body" required>{{ old('body', $post->body ?? '') }}</textarea>
</label>
@error('body')<small style="color:#b91c1c;">{{ $message }}</small>@enderror

<label>
    Published at
    <input type="datetime-local" name="published_at" value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
</label>
@error('published_at')<small style="color:#b91c1c;">{{ $message }}</small>@enderror

<button type="submit">Save</button>
