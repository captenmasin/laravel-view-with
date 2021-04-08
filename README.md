It's like Route::view() but with route model binding!

web.php
```php
Route::viewWithData('profile/{user}/{post}', 'post', [
    'user' =>  fn(User $user) => $user,
    'greeting' => 'Hello world',
    'post' =>  fn(Post $post) => $post,
]);
```

resources/views/post.blade.php
```php
{{ $greeting }}, 
{{ $post->title }} by {{ $user->name }}
```

This was thrown together as a proof of concept after [this discussion](https://twitter.com/capten_masin/status/1380177902419988484)

# THIS IS VERY MESSY AND VERY EARLY STAGES 