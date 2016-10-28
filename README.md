#Klink

A simple way to manage active menu items

## Install

``` bash
composer require kilroyweb/klink
```

In config/app.php 'providers':

```php
KilroyWeb\Klink\KlinkServiceProvider::class,
```

In config/app.php 'facades':

```php
'Klink'=> KilroyWeb\Klink\Facades\Klink::class,
```

## Usage

Klink must start with the "url" method, from there options can be added as needed

### Create menu items
```php
<ul>
    {!! Klink::url('my-account')->label('My Account') !!}
    {!! Klink::url('logout')->label('Logout') !!}
</ul>
```
Results (If on /my-account page)

```php
<ul>
    <li class="active"><a href="http://localhost/my-account">My Account</a></li>
    <li><a href="http://localhost/logout">Logout</a></li>
</ul>
```

### Remove change or remove "li" container element

```php
{!! Klink::url('my-account')->label('My Account')->container(false) !!}
{!! Klink::url('my-account')->label('My Account')->container('h3') !!}
```
Results

```html
<a href="http://localhost/my-account">My Account</a>
<h3><a href="http://localhost/my-account">My Account</a></h3>
```

Or when on the "my-account" page:

```html
<a href="http://localhost/my-account" class="active" >My Account</a>
<h3 class="active"><a href="http://localhost/my-account">My Account</a></h3>
```

### Check Multiple URLs

```php
{!! Klink::url('my-account')->alsoCheck(['/profile', '/'])->label('My Account') !!}
```
Results (when on the /profile, /, or /my-account pages)

```html
<h3 class="active"><a href="http://localhost/my-account">My Account</a></h3>
```

### Output only the active class

Sometimes you have a custom link where you just need to set the class as active:

```html
    <ul>
        <li class="{!! Klink::url('my-account')->showClass() !!}"><a href="http://homestead.app/packages/klink/public/my-account">My Account</a></li>
    </ul>
```

Will return `class="active"` on the my-account page, otherwise will return empty `class=""`