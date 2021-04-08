<p align="center"><img src="/art/social.png" alt="Social Card for laravel view with"></p>

## What is this?

Born from [this discussion](https://twitter.com/capten_masin/status/1380177902419988484), `laravel-view-with` basically mimics the [Route::view()](https://laravel.com/docs/8.x/routing#view-routes) syntax but allows for route model binding when passing data which currnetly isn't possible in base Laravel


## Installation

You can install the package via composer:

```bash
composer require captenmasin/laravel-view-with
```

## Usage

web.php
```php
Route::viewWith('profile/{user}/{post}', 'post', [
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

It has all the same power that normal routes have, so custom model binding and parameters like `{user:uuid}` still work 